<?php

namespace Akuma\Bundle\SocialBundle\Security\Authentication\Provider;

class MicrosoftAuthenticationProvider extends AbstractAuthenticationProvider
{
    function getName()
    {
        return 'Microsoft';
    }
}
