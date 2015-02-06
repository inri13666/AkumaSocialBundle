<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 10:38 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Security\Firewall;


use Akuma\Bundle\SocialBundle\Api\FacebookApi;
use Akuma\Bundle\SocialBundle\Security\Authentication\Token\FacebookToken;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookSDKException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\SecurityContextInterface;


class FacebookAuthenticationListener extends AbstractAuthenticationListener
{

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
        /** @var FacebookApi $api */
        $api = $this->container->get('akuma_social.facebook.api');

        try {
            $session = $api->getLoginUrlHelper()->getSessionFromRedirect();
            if (!$session->validate()) {
                $request->getSession()->set(SecurityContextInterface::AUTHENTICATION_ERROR,
                    new AuthenticationException("Please provide a complete set of credentials"));
                return null;
            };
        } catch (FacebookAuthorizationException $e) {
//            $request->getSession()->set(SecurityContextInterface::AUTHENTICATION_ERROR,
//                new AuthenticationException($e->getMessage()));
//            return null;
            throw new AuthenticationException($e->getMessage());
        } catch (FacebookSDKException $e) {
//            $request->getSession()->set(SecurityContextInterface::AUTHENTICATION_ERROR,
//                new AuthenticationException($e->getMessage()));
//            return null;
            throw new AuthenticationException($e->getMessage());
        }
        // Create a Facebook Token
        $token = new FacebookToken();
        $token->setSocialToken($session->getToken());
        $token->setAuthenticated(false);

        $authToken = $this->authenticationManager->authenticate($token);
        $this->logger->debug(sprintf("Facebook authentication succesfull. Token: %s", $authToken));

        // Set the default event_id in the session
        //$request->getSession()->set('event_id', $this->???->getVal('default_event_id'));

        // Return the authenticated token
        return $authToken;

//
//        // Try to authenticate by retrieving an authenticated token from the manager, catch any authenticationexception
//        try {
//            $authToken = $this->authenticationManager->authenticate($token);
//            $this->logger->debug(sprintf("Facebook authentication succesfull. Token: %s", $authToken));
//
//            // Set the default event_id in the session
//            //$request->getSession()->set('event_id', $this->???->getVal('default_event_id'));
//
//            // Return the authenticated token
//            return $authToken;
//
//            // Something went wrong in the authentication process
//        } catch (AuthenticationException $failed) {
//            $this->logger->debug("Facebook Authentication failed.");
//            // Set the error in the session so the form can use it
//            $request->getSession()->set(SecurityContext::AUTHENTICATION_ERROR, $failed);
//            return null;
//        }
    }
}