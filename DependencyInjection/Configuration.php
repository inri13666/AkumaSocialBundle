<?php

namespace Akuma\Bundle\SocialBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

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
         * Create Users If Not Exists Global
         */
        $rootNode->children()->booleanNode('auto_create')->defaultFalse()->end();

        $this->addFacebookSection($rootNode);
        $this->addGoogleSection($rootNode);
        $this->addMicrosoftSection($rootNode);

        return $treeBuilder;
    }

    private function addFacebookSection(ArrayNodeDefinition $rootNode)
    {
        $name = 'facebook';
        /** @var ArrayNodeDefinition $social */
        $social = $rootNode->children()->arrayNode($name)->cannotBeOverwritten();
        $social->children()->booleanNode('auto_create')->cannotBeOverwritten()->defaultFalse()->end();
        $social->children()->scalarNode('id')->isRequired()->cannotBeEmpty()->cannotBeOverwritten()->end();
        $social->children()->scalarNode('secret')->isRequired()->cannotBeEmpty()->cannotBeOverwritten()->end();
        $social->children()
            ->scalarNode('redirect_route')
            ->cannotBeEmpty()
            ->cannotBeOverwritten()
            ->defaultValue('akuma_social_'. $name . '_connect')
            ->end();

        /** @var ArrayNodeDefinition $scopes */
        $scopes = $social->children()->arrayNode('scopes');
        $scopes->cannotBeEmpty()->cannotBeOverwritten();
        $scopes->prototype('scalar')->end();
        $scopes->defaultValue(array(
            'email',
        ))->end();
        $social->end();
    }

    private function addGoogleSection(ArrayNodeDefinition $rootNode)
    {
        $name = 'google';
        /** @var ArrayNodeDefinition $social */
        $social = $rootNode->children()->arrayNode($name)->cannotBeOverwritten();
        $social->children()->booleanNode('auto_create')->cannotBeOverwritten()->defaultFalse()->end();
        $social->children()->scalarNode('id')->isRequired()->cannotBeEmpty()->cannotBeOverwritten()->end();
        $social->children()->scalarNode('secret')->isRequired()->cannotBeEmpty()->cannotBeOverwritten()->end();
        $social->children()
            ->scalarNode('redirect_route')
            ->cannotBeEmpty()
            ->cannotBeOverwritten()
            ->defaultValue('akuma_social_'. $name . '_connect')
            ->end();
        /** @var ArrayNodeDefinition $scopes */
        $scopes = $social->children()->arrayNode('scopes');
        $scopes->cannotBeEmpty()->cannotBeOverwritten();
        $scopes->prototype('scalar')->end();
        $scopes->defaultValue(array(
            'email',
        ))->end();
        $social->end();
    }

    private function addMicrosoftSection(ArrayNodeDefinition $rootNode)
    {
        $name = 'microsoft';
        /** @var ArrayNodeDefinition $social */
        $social = $rootNode->children()->arrayNode($name)->cannotBeOverwritten();
        $social->children()->booleanNode('auto_create')->cannotBeOverwritten()->defaultFalse()->end();
        $social->children()->scalarNode('id')->isRequired()->cannotBeEmpty()->cannotBeOverwritten()->end();
        $social->children()->scalarNode('secret')->isRequired()->cannotBeEmpty()->cannotBeOverwritten()->end();
        $social->children()
            ->scalarNode('redirect_route')
            ->cannotBeEmpty()
            ->cannotBeOverwritten()
            ->defaultValue('akuma_social_'. $name . '_connect')
            ->end();

        /** @var ArrayNodeDefinition $scopes */
        $scopes = $social->children()->arrayNode('scopes');
        $scopes->cannotBeEmpty()->cannotBeOverwritten();
        $scopes->prototype('scalar')->end();
        $scopes->defaultValue(['wl.basic', 'wl.emails'])->end();
        $social->end();
    }
}
