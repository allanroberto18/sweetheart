<?php

use API\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function test_configuration_class_exist() {
        $obj = new Configuration();
        $expected = Configuration::class;

        $this->assertInstanceOf($expected, $obj);
    }

    public function test_get_configuration_api() {
        $obj = new Configuration();
        $api = $obj->getApi();

        $this->assertArrayHasKey('app_id', $api);
        $this->assertArrayHasKey('app_secret', $api);
    }

    public function test_configuration_data() {
        $obj = new Configuration();
        $api = $obj->getApi();
        $expect = [
            'app_id' => '115716112423039',
            'app_secret' => '2d42f999600aaa28d7834ed4e263a466'
        ];

        $this->assertArraySubset($expect, $api);
    }
}