<?php

namespace Akuma\Bundle\SocialBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class AkumaSocialExtension extends Extension
{
    protected function createConfigEntries(array $config, ContainerBuilder $container, $parent = null)
    {
        $isScalar = true;
        foreach ($config as $key => $value) {
            if (!is_numeric($key)) {
                $isScalar = false;
                break;
            }
        }
        if ($isScalar) {
            if (!is_null($parent)) {
                $container->setParameter($parent, $config);
            }
        } else {
            foreach ($config as $key => $value) {
                if (is_array($value)) {
                    $keys = array_keys($value);
                    $this->createConfigEntries($value, $container, $parent ? $parent . '.' . $key : $key);
                } else {
                    $container->setParameter($parent ? $parent . '.' . $key : $key, $value);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        /**
         * Inject All Params To Global Config
         */
        $this->createConfigEntries($config, $container, $this->getAlias());

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('twig.yml');

        $socials = array('facebook', 'google', 'microsoft');

        foreach ($socials as $social) {
            if (isset($config[$social]) && (false != $config[$social])) {
                $loader->load("{$social}/services.yml");
            }
        }
    }
}
