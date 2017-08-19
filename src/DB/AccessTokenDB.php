<?php

namespace API\DB;

use API\AccessToken;

class AccessTokenDB {

    private $pdo;

    /**
     * UserDB constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(array $data) : AccessToken {
        $query = "INSERT INTO access_token (`user_id`, `token`) VALUES (:user_id, :token)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(":user_id", $data['user_id']);
        $stmt->bindValue(":token", "{$data['token']}");
        $stmt->execute();

        $data['id'] = $this->pdo->lastInsertId();

        $aToken = new AccessToken();
        $aToken->hydrate($data);

        return $aToken;
    }
}