<?php

use API\AccessToken;
use PHPUnit\Framework\TestCase;

class AccessTokenTest extends TestCase
{
    private function getEntity() : AccessToken {
        return new AccessToken();
    }

    public function test_user_class_exist() {
        $expect = AccessToken::class;
        $this->assertInstanceOf($expect, $this->getEntity());
    }

    public function test_set_get_Id() {
        $entity = $this->getEntity();

        $entity->setId(1);
        $expect = 1;

        $this->assertEquals($expect, $entity->getId());
    }

    public function test_set_get_UserId() {
        $entity = $this->getEntity();

        $entity->setUserId(1);
        $expect = 1;

        $this->assertEquals($expect, $entity->getUserId());
    }

    public function test_set_get_Token() {
        $entity = $this->getEntity();

        $entity->setToken('MyToken');
        $expect = 'MyToken';

        $this->assertEquals($expect, $entity->getToken());
    }

    public function test_set_get_IsActive() {
        $entity = $this->getEntity();

        $entity->setIsActive(true);
        $expect = true;

        $this->assertEquals($expect, $entity->getIsActive());
    }
}