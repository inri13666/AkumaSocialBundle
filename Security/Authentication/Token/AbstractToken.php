<?php

namespace Akuma\Bundle\SocialBundle\Security\Authentication\Token;

use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken as AbstractTokenParent;

abstract class AbstractToken extends AbstractTokenParent
{
    /**
     * @var AccessToken
     */
    protected $socialToken;

    /**
     * @param AccessToken $socialToken
     *
     * @return $this
     */
    public function setSocialToken(AccessToken $socialToken)
    {
        $this->socialToken = $socialToken;

        return $this;
    }

    /**
     * @return AccessToken
     */
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
