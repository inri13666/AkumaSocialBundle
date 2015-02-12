<?php
/**
 * User  : Nikita.Makarov
 * Date  : 1/9/15
 * Time  : 10:57 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class MicrosoftFactory extends AbstractFactory
{
    public function getName()
    {
        return 'Microsoft';
    }
}