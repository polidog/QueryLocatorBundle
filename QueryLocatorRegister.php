<?php

namespace Polidog\QueryLocatorBundle;

use Koriym\QueryLocator\ApcQueryLocator;
use Koriym\QueryLocator\QueryLocator;
use Polidog\QueryLocatorBundle\Exception\ContainerRegisteredException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class QueryLocatorRegister implements QueryLocatorRegisterInterface
{
    const BASE_ID_NAME = 'polidog_query_locator.locators';

    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @param ContainerBuilder $container
     */
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     * @param string $sqlDir
     * @param bool   $useApc
     *
     * @throws ContainerRegisteredException
     */
    public function register(string $name, string $sqlDir, bool $useApc)
    {
        $id = $this->getId($name);
        $class = $this->getQueryLoaderName($useApc);

        if ($this->container->hasDefinition($id)) {
            throw ContainerRegisteredException::createException($id);
        }

        $definition = $this->container->register($id, $class);
        $definition->setArguments([$sqlDir, $name]);
    }

    private function getId($name)
    {
        return sprintf('%s.%s', static::BASE_ID_NAME, $name);
    }

    private function getQueryLoaderName($useApc)
    {
        if ($useApc) {
            return ApcQueryLocator::class;
        } else {
            return QueryLocator::class;
        }
    }
}
