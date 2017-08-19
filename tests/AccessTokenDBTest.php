<?php

use API\DB\AccessTokenDB;
use API\AccessToken;
use PHPUnit\Framework\TestCase;

class AccessTokenDBTest extends TestCase
{
    private $db;

    protected function setUp()
    {
        $this->db = getPDO();
    }

    public function test_accessToken_db_class_exist() {
        $db = $this->db;
        $accessTokenDB = new AccessTokenDB($db);

        $this->assertInstanceOf(AccessTokenDB::class, $accessTokenDB);
    }

    private function createEntity() : AccessToken{
        $db = $this->db;

        $obj = new AccessTokenDB($db);

        return $obj->save([
            'user_id' => '1',
            'token' => 'mytoken',
        ]);
    }

    public function test_if_entity_is_saved() : int {
        $obj = $this->createEntity();

        $this->assertEquals(1, $obj->getId());
        $this->assertEquals('1', $obj->getUserId());
        $this->assertEquals('mytoken', $obj->getToken());

        return $obj->getId();
    }
}