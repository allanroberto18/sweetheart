<?php

use API\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private function getEntity(): User
    {
        return new User();
    }

    public function test_user_class_exist()
    {
        $expect = User::class;
        $this->assertInstanceOf($expect, $this->getEntity());
    }

    public function test_set_get_Id()
    {
        $entity = $this->getEntity();

        $entity->setId(1);
        $expect = 1;

        $this->assertEquals($expect, $entity->getId());
    }

    public function test_set_get_FacebookId()
    {
        $entity = $this->getEntity();

        $entity->setFacebookId('foo123');
        $expect = 'foo123';

        $this->assertEquals($expect, $entity->getFacebookId());
    }

    public function test_set_get_Name()
    {
        $entity = $this->getEntity();

        $entity->setName('User Test');
        $expect = 'User Test';

        $this->assertEquals($expect, $entity->getName());
    }

    public function test_set_get_Email()
    {
        $entity = $this->getEntity();

        $entity->setEmail('user@teste.com');
        $expect = 'user@teste.com';

        $this->assertEquals($expect, $entity->getEmail());
    }

    public function test_set_get_Image()
    {
        $entity = $this->getEntity();

        $entity->setImage('img.png');
        $expect = 'img.png';

        $this->assertEquals($expect, $entity->getImage());
    }

    public function test_set_get_IsActive()
    {
        $entity = $this->getEntity();

        $entity->setIsActive(true);
        $expect = true;

        $this->assertEquals($expect, $entity->getIsActive());
    }

    public function test_hydrate()
    {
        $arr = [
            'id' => 1,
            'facebook_id' => '123',
            'name' => 'User Test',
            'email' => 'user@test.com',
            'image' => 'img.png',
            'is_active' => true
        ];

        $obj = new User();
        $obj->hydrate($arr);

        $this->assertEquals(1, $obj->getId());
        $this->assertEquals('123', $obj->getFacebookId());
        $this->assertEquals('User Test', $obj->getName());
        $this->assertEquals('user@test.com', $obj->getEmail());
        $this->assertEquals('img.png', $obj->getImage());
        $this->assertEquals(true, $obj->getIsActive());
    }
}