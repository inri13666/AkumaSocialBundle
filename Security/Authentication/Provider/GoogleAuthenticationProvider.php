<?php

namespace Akuma\Bundle\SocialBundle\Security\Authentication\Provider;

class GoogleAuthenticationProvider extends AbstractAuthenticationProvider
{
    function getName()
    {
        return 'Google';
    }

}
