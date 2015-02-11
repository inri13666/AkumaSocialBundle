<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 10:15 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Security\Authentication\Provider;


use Akuma\Bundle\SocialBundle\Api\GoogleApi;
use Akuma\Bundle\SocialBundle\Security\Authentication\Token\AbstractToken;
use Akuma\Bundle\SocialBundle\Security\Authentication\Token\GoogleToken;
use FOS\UserBundle\Model\UserManager;
use Symfony\Component\Intl\Exception\MethodNotImplementedException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class GoogleAuthenticationProvider extends AbstractAuthenticationProvider{

    /**
     * Checks whether this provider supports the given token.
     *
     * @param TokenInterface $token A TokenInterface instance
     *
     * @return bool true if the implementation supports the Token, false otherwise
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof GoogleToken;
    }

    public function authenticate(TokenInterface $token)
    {
        /** @var AbstractToken $token */
        if (!$this->supports($token)) {
            throw new AuthenticationException('Unsupported token given');
        }

        $this->logger->debug("Facebook Provider Login: user load started");

        /** @var GoogleApi $api */
        $api = $this->container->get('akuma_social.google.api');

        $socialToken = $token->getSocialToken();

        if ($socialUser = $api->getUserObject($socialToken)) {
            if (!$socialUser->getEmail()) {
                throw new AuthenticationException("Your credentials are not correct...");
            }
            /** @var UserManager $userManager */
            $userManager = $this->container->get('fos_user.user_manager');
            $realUser = $userManager->findUserBy(array('email' => $socialUser->getEmail()));
            if (!$realUser) {
                /**
                 * TODO: Add Custom UserManager
                 */
                $realUser = $userManager->createUser();
                $realUser->setEmail($socialUser->getEmail());
                $realUser->setUsername(trim($socialUser->getFirstName() . ' ' . $socialUser->getLastName()));
                $realUser->setPlainPassword('password');
                $realUser->addRole('ROLE_GOOGLE');
                $userManager->updateUser($realUser);
            }
            /**
             * TODO : Find User By Social ID, if not found create him
             */
            $authenticatedToken = new GoogleToken($realUser->getRoles());
            $authenticatedToken->setAuthenticated(true);
            $authenticatedToken->setUser($realUser);
            return $authenticatedToken;
        };

        throw new AuthenticationException("Your credentials are not correct...");    }
}