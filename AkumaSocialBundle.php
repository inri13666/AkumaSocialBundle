<?php

namespace Akuma\Bundle\SocialBundle;

use Akuma\Bundle\SocialBundle\DependencyInjection\Security\Factory\FacebookFactory;
use Akuma\Bundle\SocialBundle\DependencyInjection\Security\Factory\GoogleFactory;
use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AkumaSocialBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        /** @var SecurityExtension $extension */
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new FacebookFactory());
        $extension->addSecurityListenerFactory(new GoogleFactory());
    }
}
