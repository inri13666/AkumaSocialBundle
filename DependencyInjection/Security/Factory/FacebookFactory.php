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
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;

class FacebookFactory extends AbstractFactory
{
    public function __construct()
    {
        $this->addOption('create_user_if_not_exists', false);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {

        return 'akuma_social_facebook';
    }

    protected function getListenerId()
    {

        return 'akuma_social.facebook.security.authentication.listener';
    }

    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {

        $authProviderId = 'akuma_social.facebook.auth.' . $id;
        $definition = $container
            ->setDefinition($authProviderId, new DefinitionDecorator('akuma_social.facebook.auth'))
            ->addArgument($id);

        // with user provider
        if (isset($config['provider'])) {
            $definition
                ->addArgument(new Reference($userProviderId))
                ->addArgument(new Reference('security.user_checker'))
                ->addArgument($config['create_user_if_not_exists']);
        }
        return $authProviderId;
    }

    protected function createEntryPoint($container, $id, $config, $defaultEntryPointId)
    {

        $entryPointId = 'akuma_social.facebook.security.authentication.entry_point.' . $id;
        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('akuma_social.facebook.security.authentication.entry_point'))
            ->addMethodCall('setOptions', array($config));
        // set options to container for use by other classes
        $container->setParameter('akuma_social.facebook.options.' . $id, $config);

        return $entryPointId;
    }
}