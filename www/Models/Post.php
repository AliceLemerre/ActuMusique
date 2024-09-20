<?php

namespace App\Models;

use App\Core\DB;

class Post extends DB
{

    protected int $id = 0;
    protected string $title = "";
    protected int $category = 0;
    protected string $date = "";
    protected string $place = "";
    protected string $city = "";
    protected string $content = "";
    protected string $image = "";
    protected int $userId = 0; 
    protected \DateTime $createdAt;
    protected \DateTime $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->title = $category;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }
    
    public function getDate(): string
    {
        return $this->date;
    }

    public function setPlace(string $place): void
    {
        $this->place = $place;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }
 
    public function getCity(): string
    {
        return $this->city;
    } 

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }   

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }


 
}