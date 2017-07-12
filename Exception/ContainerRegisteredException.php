<?php

namespace Polidog\QueryLocatorBundle\Exception;

class ContainerRegisteredException extends \RuntimeException
{
    private $containerId;

    public static function createException($id, $code = 0, \Throwable $previous = null)
    {
        $message = "container registered id = {$id}";
        $e = new self($message, $code, $previous);
        $e->setContainerId($id);

        return $e;
    }

    /**
     * @return mixed
     */
    public function getContainerId()
    {
        return $this->containerId;
    }

    /**
     * @param mixed $containerId
     *
     * @return $this
     */
    public function setContainerId($containerId)
    {
        $this->containerId = $containerId;

        return $this;
    }
}
