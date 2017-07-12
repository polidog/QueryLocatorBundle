<?php

namespace Polidog\QueryLocatorBundle\DependencyInjection;

use Polidog\QueryLocatorBundle\QueryLocatorRegister;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class PolidogQueryLocatorExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $locatorRegister = new QueryLocatorRegister($container);
        foreach ($config['locators'] as $name => $data) {
            $locatorRegister->register($name, $data['sql_dir'], $data['use_apc']);
        }
    }
}
