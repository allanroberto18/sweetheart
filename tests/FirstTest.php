<?php

use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    public function test_hello_world() {
        $expect = "Hello world";
        $this->assertEquals($expect, "Hello world");
    }
}