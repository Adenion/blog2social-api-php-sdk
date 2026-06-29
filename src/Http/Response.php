<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Http;

class Response
{
    private int $status_code;
    private array $data;
    private string $raw_body;

    public function __construct(int $status_code, array $data, string $raw_body)
    {
        $this->status_code = $status_code;
        $this->data = $data;
        $this->raw_body = $raw_body;
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getRawBody(): string
    {
        return $this->raw_body;
    }

    public function isSuccessful(): bool
    {
        return $this->status_code >= 200 && $this->status_code < 300;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }
}
