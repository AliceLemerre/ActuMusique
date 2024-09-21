<?php
namespace App\Models;

use App\Core\DB;
use App\Core\Verificator;

class User extends DB
{
    protected int $id = 0;
    protected string $email = "";
    protected string $password = "";
    protected string $username = "";
    protected int $emailconfirmation = 0;
    protected int $resetpassword = 0;
    protected string $verificationcode = "";
    protected int $role = 0;
    protected \DateTime $createdAt;
    protected int $isdeleted = 0;


    public function isFirstUser(): bool
    {
        $sql = "SELECT COUNT(*) FROM " . $this->table;
        $stmt = $this->pdo->query($sql);
        $count = $stmt->fetchColumn();
        return $count == 0;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmailConfirmation(): int
    {
        return $this->emailconfirmation;
    }

    public function setEmailConfirmation(int $emailconfirmation): void
    {
        $this->emailconfirmation = $emailconfirmation;
    }

    public function getResetPassword(): int
    {
        return $this->resetpassword;
    }

    public function setResetPassword(int $resetpassword): void
    {
        $this->resetpassword = $resetpassword;
    }

    public function getVerificationCode(): string
    {
        return $this->verificationcode;
    }

    public function setVerificationCode(string $verificationcode): void
    {
        $this->verificationcode = $verificationcode;
    }

   
    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getIsDeleted(): int
    {
        return $this->isdeleted;
    }

    public function setIsDeleted(int $isdeleted): void
    {
        $this->isdeleted = $isdeleted;
    }


}