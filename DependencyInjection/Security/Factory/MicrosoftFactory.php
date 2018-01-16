<?php

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
