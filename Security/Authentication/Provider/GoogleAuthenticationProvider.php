<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 10:15 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Security\Authentication\Provider;


use Akuma\Bundle\SocialBundle\Security\Authentication\Token\GoogleToken;
use Symfony\Component\Intl\Exception\MethodNotImplementedException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

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
        throw new MethodNotImplementedException(__METHOD__);
    }
}