<?php

namespace Akuma\Bundle\SocialBundle\Security\Firewall;

class GoogleAuthenticationListener extends AbstractAuthenticationListener
{
    protected function getName()
    {
        return 'Google';
    }
}
