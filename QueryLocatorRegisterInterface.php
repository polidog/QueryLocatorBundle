<?php

namespace Polidog\QueryLocatorBundle;

use Polidog\QueryLocatorBundle\Exception\ContainerRegisteredException;

interface QueryLocatorRegisterInterface
{
    /**
     * @param string $name
     * @param string $sqlDir
     * @param bool $useApc
     *
     * @throws ContainerRegisteredException
     */
    public function register($name, $sqlDir, $useApc);
}
