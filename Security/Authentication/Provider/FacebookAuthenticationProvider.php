<?php

namespace Akuma\Bundle\SocialBundle\Security\Authentication\Provider;

class FacebookAuthenticationProvider extends AbstractAuthenticationProvider
{
    function getName()
    {
        return 'Facebook';
    }
}
