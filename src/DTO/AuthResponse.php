<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\DTO;

use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class AuthResponse
{
    private string $access_token;
    private ?string $refresh_token;

    public function __construct(string $access_token, ?string $refresh_token = null)
    {
        if (trim($access_token) === '') {
            throw ValidationException::forField(
                'access_token',
                'The access_token must not be empty.'
            );
        }

        $this->access_token = $access_token;
        $this->refresh_token = $refresh_token;
    }

    public static function fromArray(array $data): self
    {
        if (!isset($data['access_token']) || !is_string($data['access_token'])) {
            throw ValidationException::forField(
                'access_token',
                'The response does not contain a valid access_token.'
            );
        }

        $refresh_token = isset($data['refresh_token'])
            ? (string) $data['refresh_token']
            : null;

        return new self($data['access_token'], $refresh_token);
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refresh_token;
    }
}
