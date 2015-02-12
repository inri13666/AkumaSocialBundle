<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 10:15 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Security\Authentication\Provider;


class FacebookAuthenticationProvider extends AbstractAuthenticationProvider
{
    function getName()
    {
        return 'Facebook';
    }
}