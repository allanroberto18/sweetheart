<?php

namespace API\DB;

use API\User;

class UserDB {

    private $pdo;

    /**
     * UserDB constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(array $data) : User {
        if (!isset($data['id'])) {
            $query = "INSERT INTO users (`facebook_id`, `name`, `email`, `image`, `is_active`) VALUES (:facebook_id, :name, :email, :image, :is_active)";
            $stmt = $this->pdo->prepare($query);
        } else {
            $query = "UPDATE users set `facebook_id` = :facebook_id, `name` = :name, `email` = :email, `image` = :image, `is_active` = :is_active WHERE `id` = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(":id", $data['id']);
        }

        $stmt->bindValue(":facebook_id", "{$data['facebook_id']}");
        $stmt->bindValue(":name", "{$data['name']}");
        $stmt->bindValue(":email", "{$data['email']}");
        $stmt->bindValue(":image", "{$data['image']}");
        $stmt->bindValue(":is_active", $data['is_active']);
        $stmt->execute();

        $data['id'] = $data['id'] ?? $this->pdo->lastInsertId();

        $user = new User();
        $user->hydrate($data);

        return $user;
    }

    public function find(string $facebookId) : User
    {
        $query = "SELECT * FROM users WHERE `facebook_id` = :facebook_id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":facebook_id", "{$facebookId}");
        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data)
        {
            throw new \Exception('Produto inexistente');
        }
        $user = new User();
        $user->hydrate($data);

        return $user;
    }
}