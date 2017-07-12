<?php

namespace Polidog\QueryLocatorBundle\Tests\DependencyInjection;

use Koriym\QueryLocator\ApcQueryLocator;
use Koriym\QueryLocator\QueryLocator;
use Polidog\QueryLocatorBundle\DependencyInjection\PolidogQueryLocatorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PolidogQueryLocatorExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyLocator()
    {
        $container = new ContainerBuilder();
        $loader = new PolidogQueryLocatorExtension();
        $config = [];
        $loader->load([$config], $container);
        $providerDefinition = $container->hasDefinition('polidog_query_locator.locators.test');
        $this->assertFalse($providerDefinition);
    }

    public function testTestLocator()
    {
        $container = new ContainerBuilder();
        $loader = new PolidogQueryLocatorExtension();

        $expectsClasses = [
            'test' => QueryLocator::class,
            'test_apc' => ApcQueryLocator::class,
        ];

        $config = [
            'locators' => [
                'test' => [
                    'use_apc' => false,
                    'sql_dir' => './hoge',
                ],
                'test_apc' => [
                    'use_apc' => true,
                    'sql_dir' => './fuga',
                ],
            ],
        ];
        $loader->load([$config], $container);

        foreach (array_keys($config['locators']) as $key) {
            $this->assertTrue($container->hasDefinition("polidog_query_locator.locators.{$key}"));
            $definition = $container->getDefinition("polidog_query_locator.locators.{$key}");

            $this->assertEquals($expectsClasses[$key], $definition->getClass());

            $this->assertEquals([
                0 => $config['locators'][$key]['sql_dir'],
                1 => $key,
            ], $definition->getArguments());
        }
    }
}
