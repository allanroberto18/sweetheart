<?php

namespace API;

class AccessToken
{
    private $id;
    private $userId;
    private $token;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return (int) $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function hydrate(array $data): AccessToken
    {
        $this->id = $data['id'];
        $this->userId = $data['user_id'];
        $this->token = $data['token'];

        return $this;
    }
}