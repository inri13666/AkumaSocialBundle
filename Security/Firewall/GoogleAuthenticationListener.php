<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 10:38 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Security\Firewall;


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
        throw new AuthenticationException("Please provide a complete set of credentials");

        $this->logger->debug('Trying to auth using Facebook Social Service');
        // Get the acess_token from the request
        $code = $request->get('code');
//        // If an empty pcode, return null and the specified error
//        if ($code == NULL) {
//            $request->getSession()->set(SecurityContextInterface::AUTHENTICATION_ERROR,
//                new AuthenticationException("Please provide a complete set of credentials"));
//            return null;
//        }

        // Probably credentials are correct, time to check!
        $this->logger->debug("AkumaUserFacebookLogin: $code");

        // Create a Facebook Token
        $token = new GoogleToken();
        $token->setSocialToken($code);
        $token->setAuthenticated(false);

        // Try to authenticate by retrieving an authenticated token from the manager, catch any authenticationexception
        try {
            $authToken = $this->authenticationManager->authenticate($token);
            $this->logger->debug(sprintf("Facebook authentication succesfull. Token: %s", $authToken));

            // Set the default event_id in the session
            //$request->getSession()->set('event_id', $this->???->getVal('default_event_id'));

            // Return the authenticated token
            return $authToken;

            // Something went wrong in the authentication process
        } catch (AuthenticationException $failed) {
            $this->logger->debug("Facebook Authentication failed.");
            // Set the error in the session so the form can use it
            $request->getSession()->set(SecurityContext::AUTHENTICATION_ERROR, $failed);
            return null;
        }
    }
}