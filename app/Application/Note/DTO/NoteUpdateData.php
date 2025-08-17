<?php

namespace App\Application\Note\DTO;

class NoteUpdateData
{
    private const TITLE       = 'title';
    private const DESCRIPTION = 'description';
    private const STATUS      = 'status';

    private array $data = [];

    public function __construct(
        private readonly int $id,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->data[self::TITLE];
    }

    public function setTitle(string $title): static
    {
        $this->data[self::TITLE] = $title;

        return $this;
    }

    public function hasTitle(): bool
    {
        return array_key_exists(self::TITLE, $this->data);
    }

    public function getDescription(): string
    {
        return $this->data[self::DESCRIPTION];
    }

    public function setDescription(string $description): static
    {
        $this->data[self::DESCRIPTION] = $description;

        return $this;
    }

    public function hasDescription(): bool
    {
        return array_key_exists(self::DESCRIPTION, $this->data);
    }

    public function getStatus(): string
    {
        return $this->data[self::STATUS];
    }

    public function setStatus(string $status): static
    {
        $this->data[self::STATUS] = $status;

        return $this;
    }

    public function hasStatus(): bool
    {
        return array_key_exists(self::STATUS, $this->data);
    }
}
