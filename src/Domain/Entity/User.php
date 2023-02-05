<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(
    name: 'user',
    options: ["collation" => "utf8mb4_unicode_ci", "charset" => "utf8mb4"]
)]
#[ORM\UniqueConstraint(name: 'users_email_uindex', columns: ['email'])]
#[ORM\UniqueConstraint(name: 'users_name_uindex', columns: ['name'])]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 64)]
    private string $name;

    #[ORM\Column(type: 'string', length: 256)]
    private string $email;

    #[ORM\Column(type: 'datetime')]
    private DateTime $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $deleted;

    #[ORM\Column(type: 'text', length: 65535, nullable: true)]
    private ?string $notes;

    public function __construct(
        string $name,
        string $email,
        ?string $notes,
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->notes = $notes;
        $this->created = new DateTime();
        $this->deleted = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function getDeleted(): ?DateTime
    {
        return $this->deleted;
    }

    public function isActive(): bool
    {
        return !$this->getDeleted();
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function update(string $name, string $email, ?string $notes): void
    {
        $this->name = $name;
        $this->email = $email;
        $this->notes = $notes;
    }
}
