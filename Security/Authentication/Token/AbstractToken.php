<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 10:10 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Security\Authentication\Token;


use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken as AbstractTokenParent;

abstract class AbstractToken extends AbstractTokenParent{

    /**
     * @var AccessToken
     */
    protected $socialToken;

    public function setSocialToken(AccessToken $socialToken)
    {
        $this->socialToken = $socialToken;
    }

    public function getSocialToken()
    {
        return $this->socialToken;
    }

    /**
     * Returns the user credentials.
     *
     * @return mixed The user credentials
     */
    public function getCredentials()
    {
        return $this->getSocialToken();

    }
}