<?php

namespace App\DTO;

class ClientDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone = null,
        public readonly ?string $notes = null,
        public readonly ?string $avatar = null,
        public readonly ?int $user_id = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'] ?? null,
            notes: $data['notes'] ?? null,
            avatar: $data['avatar'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'notes' => $this->notes,
            'avatar' => $this->avatar,
            'user_id' => $this->user_id,
        ], fn($value) => $value !== null);
    }
}
