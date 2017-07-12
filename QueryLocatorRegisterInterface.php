<?php

namespace Polidog\QueryLocatorBundle;

interface QueryLocatorRegisterInterface
{
    public function register(string $name, string $sqlDir, bool $useApc);
}
