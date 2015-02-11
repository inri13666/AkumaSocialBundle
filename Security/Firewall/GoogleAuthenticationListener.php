<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 10:38 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Security\Firewall;


use Akuma\Bundle\SocialBundle\Api\GoogleApi;
use Akuma\Bundle\SocialBundle\Security\Authentication\Token\GoogleToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;

class GoogleAuthenticationListener extends AbstractAuthenticationListener{

    /**
     * Performs authentication.
     *
     * @param Request $request A Request instance
     *
     * @return TokenInterface|Response|null The authenticated token, null if full authentication is not possible, or a Response
     *
     * @throws AuthenticationException if the authentication fails
     */
    protected function attemptAuthentication(Request $request)
    {
        $this->logger->debug('Trying to auth using Facebook Social Service');

        /**
         * TODO: Add support for clean Token
         */
        /** @var GoogleApi $api */
        $api = $this->container->get('akuma_social.google.api');

        try {
            $client = $api->getClient();
            if(!$client->authenticate($request->get('code'))){
                throw new \Exception('Not Valid Code Provided');
            };
        } catch (\Exception $e) {
            throw new AuthenticationException($e->getMessage());
        }

        // Create a Social Token
        $token = new GoogleToken();
        $token->setSocialToken($client->getAccessToken());
        $token->setAuthenticated(false);

        $authToken = $this->authenticationManager->authenticate($token);
        $this->logger->debug(sprintf("Google authentication succesfull. Token: %s", $authToken));

        // Set the default event_id in the session
        //$request->getSession()->set('event_id', $this->???->getVal('default_event_id'));

        // Return the authenticated token
        return $authToken;

    }
}