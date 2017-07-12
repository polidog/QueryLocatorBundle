<?php

namespace Polidog\QueryLocatorBundle\Tests\DependencyInjection;

use Polidog\QueryLocatorBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConfigTests
     *
     * @param array $startingConfig
     * @param       $expectedConfig
     */
    public function testDefaultConfig(array $startingConfig, $expectedConfig)
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(
            new Configuration(true), [$startingConfig]
        );
        $this->assertEquals(
            $expectedConfig,
            $config
        );
    }

    public function providerConfigTests()
    {
        $tests = [];
        $tests[] = [
            [],
            ['locators' => []],
        ];

        $locatorConfig = [
            'sql_dir' => '../hoge',
            'use_apc' => false,
        ];

        $locatorApcConfig = [
            'sql_dir' => '../fuga',
            'use_apc' => true,
        ];

        $tests[] = [
            ['locators' => [
                'locator_non_apc' => $locatorConfig,
                'locator_use_apc' => $locatorApcConfig,
            ]],
            ['locators' => [
                'locator_non_apc' => $locatorConfig,
                'locator_use_apc' => $locatorApcConfig,
            ]],
        ];

        return $tests;
    }
}
