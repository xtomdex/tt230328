<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "test_users")]
#[ORM\Index(columns: ["is_active"], name: "is_active_idx")]
final class User
{
    public const TYPE_1 = 1;
    public const TYPE_2 = 2;
    public const TYPE_3 = 3;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: "integer")]
    #[JMS\Groups(['users_list'])]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 20)]
    #[JMS\Groups(['users_list'])]
    private string $username = '';

    #[ORM\Column(type: "string", length: 75)]
    #[JMS\Groups(['users_list'])]
    private string $email = '';

    #[ORM\Column(type: "string")]
    private string $password;

    #[ORM\Column(type: "boolean")]
    #[JMS\Groups(['users_list'])]
    private bool $isMember = false;

    #[ORM\Column(type: "boolean", nullable: true)]
    #[JMS\Groups(['users_list'])]
    private ?bool $isActive = null;

    #[ORM\Column(type: "integer")]
    #[JMS\Groups(['users_list'])]
    private int $userType;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    #[JMS\Groups(['users_list'])]
    private ?\DateTimeImmutable $lastLoginAt = null;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->createdAt = $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function isMember(): bool
    {
        return $this->isMember;
    }

    public function setIsMember(bool $isMember): self
    {
        $this->isMember = $isMember;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getUserType(): int
    {
        return $this->userType;
    }

    public function setUserType(int $userType): self
    {
        $this->userType = $userType;

        return $this;
    }

    public function getLastLoginAt(): ?\DateTimeImmutable
    {
        return $this->lastLoginAt;
    }

    public function setLastLoginAt(?\DateTimeImmutable $lastLoginAt): self
    {
        $this->lastLoginAt = $lastLoginAt;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public static function getTypes(): array
    {
        return [
            self::TYPE_1 => 'Type 1',
            self::TYPE_2 => 'Type 2',
            self::TYPE_3 => 'Type 3'
        ];
    }
}
