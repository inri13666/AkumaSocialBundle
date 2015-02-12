<?php
/**
 * User  : Nikita.Makarov
 * Date  : 1/9/15
 * Time  : 10:57 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\DependencyInjection\Security\Factory;

class GoogleFactory extends AbstractFactory
{
    public function getName()
    {
        return 'Google';
    }
}