<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/5/15
 * Time  : 10:38 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\Security\Firewall;


class GoogleAuthenticationListener extends AbstractAuthenticationListener
{
    protected function getName()
    {
        return 'Google';
    }
}