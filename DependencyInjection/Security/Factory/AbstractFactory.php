<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/12/15
 * Time  : 10:15 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\SocialBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory as ParentAbstractFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

abstract class AbstractFactory extends ParentAbstractFactory
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

        return 'akuma_social_' . strtolower($this->getName());
    }

    protected function getListenerId()
    {
        return 'akuma_social.' . strtolower($this->getName()) . '.security.authentication.listener';
    }

    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {

        $authProviderId = 'akuma_social.' . strtolower($this->getName()) . '.auth.' . $id;
        $definition = $container
            ->setDefinition($authProviderId, new DefinitionDecorator('akuma_social.' . strtolower($this->getName()) . '.auth'));
        // with user provider
        if (isset($config['provider'])) {
            $definition
                ->addArgument(new Reference($userProviderId))
                ->addArgument(new Reference('security.user_checker'))
                ->addArgument($config['create_user_if_not_exists']);
        }
        return $authProviderId;
    }

    abstract public function getName();
} 