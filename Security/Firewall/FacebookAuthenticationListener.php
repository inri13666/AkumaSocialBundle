<?php

namespace Akuma\Bundle\SocialBundle\Security\Firewall;

class FacebookAuthenticationListener extends AbstractAuthenticationListener
{
    protected function getName()
    {
        return 'Facebook';
    }
}
