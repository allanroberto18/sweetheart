<?php

use API\DB\UserDB;
use API\User;
use PHPUnit\Framework\TestCase;

class UserDBTest extends TestCase
{
    private $db;

    protected function setUp()
    {
        $this->db = getPDO();
    }

    public function test_user_db_class_exist() {
        $db = $this->db;
        $userDB = new UserDB($db);

        $this->assertInstanceOf(UserDB::class, $userDB);
    }

    private function createEntity() : User{
        $db = $this->db;

        $obj = new UserDB($db);

        return $obj->save([
            'facebook_id' => '123',
            'name' => 'User Test',
            'email' => 'user@test.com',
            'image' => 'img.png',
            'is_active' => true
        ]);
    }

    public function test_if_entity_is_saved() : int {
        $obj = $this->createEntity();

        $this->assertEquals(1, $obj->getId());
        $this->assertEquals('123', $obj->getFacebookId());
        $this->assertEquals('User Test', $obj->getName());
        $this->assertEquals('user@test.com', $obj->getEmail());
        $this->assertEquals('img.png', $obj->getImage());
        $this->assertEquals(true, $obj->getIsActive());

        return $obj->getId();
    }

    /**
     * @depends test_if_entity_is_saved
     */
    public function test_if_entity_is_updated($id) : int
    {
        $this->createEntity();

        $db = $this->db;

        $obj = new UserDB($db);

        $result = $obj->save([
            'id' => $id,
            'facebook_id' => '1231',
            'name' => 'User1 Test',
            'email' => 'user1@test.com',
            'image' => 'img1.png',
            'is_active' => false
        ]);

        $this->assertEquals($id, $result->getId());
        $this->assertEquals('1231', $result->getFacebookId());
        $this->assertEquals('User1 Test', $result->getName());
        $this->assertEquals('user1@test.com', $result->getEmail());
        $this->assertEquals('img1.png', $result->getImage());
        $this->assertEquals(false, $result->getIsActive());

        return $id;
    }

    /**
     * @depends test_if_entity_is_saved
     */
    public function test_if_entity_can_be_recover($id)
    {
        $data = $this->createEntity();

        $db = $this->db;

        $obj = new UserDB($db);

        $result = $obj->find($data->getFacebookId());
        $this->assertEquals($id, $result->getId());
        $this->assertEquals('123', $result->getFacebookId());
        $this->assertEquals('User Test', $result->getName());
        $this->assertEquals('user@test.com', $result->getEmail());
        $this->assertEquals('img.png', $result->getImage());
        $this->assertEquals(true, $result->getIsActive());
    }
}