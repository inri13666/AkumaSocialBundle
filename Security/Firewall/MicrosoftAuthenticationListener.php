<?php

namespace Akuma\Bundle\SocialBundle\Security\Firewall;

use Akuma\Bundle\SocialBundle\Api\AbstractApi;
use Akuma\Bundle\SocialBundle\Api\MicrosoftApi;
use Akuma\Bundle\SocialBundle\Security\Authentication\Token\MicrosoftToken;
use League\OAuth2\Client\Exception\IDPException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\SecurityContextInterface;

class MicrosoftAuthenticationListener extends AbstractAuthenticationListener
{
    protected function getName()
    {
        return 'microsoft';
    }
}
