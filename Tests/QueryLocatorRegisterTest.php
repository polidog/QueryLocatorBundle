<?php

namespace Polidog\QueryLocatorBundle\Tests;

use Koriym\QueryLocator\ApcQueryLocator;
use Koriym\QueryLocator\QueryLocator;
use Polidog\QueryLocatorBundle\QueryLocatorRegister;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class QueryLocatorRegisterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerLocators
     */
    public function testQueryLocatorRegister($name, $sqlDir, $useApc, $id, $locatorClass)
    {
        $container = $this->prophesize(ContainerBuilder::class);
        $definition = $this->prophesize(Definition::class);

        $container->hasDefinition($id)
            ->willReturn(false);

        $container->register($id, $locatorClass)
            ->willReturn($definition);

        $queryLocatorRegister = new QueryLocatorRegister($container->reveal());
        $queryLocatorRegister->register($name, $sqlDir, $useApc);

        $container->register($id, $locatorClass)
            ->shouldHaveBeenCalled();

        $definition->setArguments([$sqlDir, $name]);
    }

    /**
     * @expectedException \Polidog\QueryLocatorBundle\Exception\ContainerRegisteredException
     * @dataProvider providerLocators
     */
    public function testException($name, $sqlDir, $useApc, $id, $locatorClass)
    {
        $container = $this->prophesize(ContainerBuilder::class);

        $container->hasDefinition($id)
            ->willReturn(true);

        $queryLocatorRegister = new QueryLocatorRegister($container->reveal());
        $queryLocatorRegister->register($name, $sqlDir, $useApc);
    }

    public function providerLocators()
    {
        return [
            [
                'name' => 'test_no_apc',
                'sqlDir' => './test',
                'useApc' => false,
                'id' => 'polidog_query_locator.locators.test_no_apc',
                'locatorClass' => QueryLocator::class,
            ],
            [
                'name' => 'test_use_apc',
                'sqlDir' => './test2',
                'useApc' => true,
                'id' => 'polidog_query_locator.locators.test_use_apc',
                'locatorClass' => ApcQueryLocator::class,
            ],
        ];
    }
}
