<?php

namespace Akuma\Bundle\SocialBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('akuma_social');

        /**
         * Create Users If Not Exists
         */
        $rootNode->children()->booleanNode('auto_create')->defaultFalse()->end();

        $this->addFacebookSection($rootNode);
        $this->addGoogleSection($rootNode);

        return $treeBuilder;
    }

    private function addFacebookSection(ArrayNodeDefinition $rootNode)
    {
        /** @var ArrayNodeDefinition $facebook */
        $facebook = $rootNode->children()->arrayNode('facebook')->cannotBeOverwritten();
        $facebook->children()->scalarNode('app_id')->isRequired()->cannotBeEmpty()->cannotBeOverwritten()->end();
        $facebook->children()->scalarNode('app_secret')->isRequired()->cannotBeEmpty()->cannotBeOverwritten()->end();
        /** @var ArrayNodeDefinition $scopes */
        $scopes = $facebook->children()->arrayNode('app_scopes');
        $scopes->cannotBeEmpty()->cannotBeOverwritten();
        $scopes->prototype('scalar')->end();
        $scopes->defaultValue(array(
            'email',
        ))->end();
        $facebook->end();
    }

    private function addGoogleSection(ArrayNodeDefinition $rootNode)
    {
        /** @var ArrayNodeDefinition $google */
        $google = $rootNode->children()->arrayNode('google')->cannotBeOverwritten();
        $google->children()->scalarNode('app_id')->isRequired()->cannotBeEmpty()->cannotBeOverwritten()->end();
        $google->children()->scalarNode('app_secret')->isRequired()->cannotBeEmpty()->cannotBeOverwritten()->end();
        $google->end();
    }
}
