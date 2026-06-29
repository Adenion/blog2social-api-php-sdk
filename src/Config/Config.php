<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Config;

use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class Config
{
    public const DEFAULT_BASE_URL = 'https://api.blog2social.com/rest/v1.0';
    public const DEFAULT_TIMEOUT_SECONDS = 30;
    public const DEFAULT_CONNECT_TIMEOUT_SECONDS = 10;
    public const DEFAULT_USER_AGENT = 'adenion/blog2social-sdk-php';

    private string $base_url;
    private int $timeout_seconds;
    private int $connect_timeout_seconds;
    private bool $verify_ssl;
    private string $user_agent;

    public function __construct(
        string $base_url = self::DEFAULT_BASE_URL,
        int $timeout_seconds = self::DEFAULT_TIMEOUT_SECONDS,
        int $connect_timeout_seconds = self::DEFAULT_CONNECT_TIMEOUT_SECONDS,
        bool $verify_ssl = true,
        string $user_agent = self::DEFAULT_USER_AGENT
    ) {
        if (trim($base_url) === '') {
            throw ValidationException::forField('base_url', 'The base URL must not be empty.');
        }

        if ($timeout_seconds < 1) {
            throw ValidationException::forField('timeout_seconds', 'The timeout must be greater than zero.');
        }

        if ($connect_timeout_seconds < 1) {
            throw ValidationException::forField(
                'connect_timeout_seconds',
                'The connection timeout must be greater than zero.'
            );
        }

        $this->base_url = rtrim($base_url, '/');
        $this->timeout_seconds = $timeout_seconds;
        $this->connect_timeout_seconds = $connect_timeout_seconds;
        $this->verify_ssl = $verify_ssl;
        $this->user_agent = $user_agent;
    }

    public function getBaseUrl(): string
    {
        return $this->base_url;
    }

    public function getTimeoutSeconds(): int
    {
        return $this->timeout_seconds;
    }

    public function getConnectTimeoutSeconds(): int
    {
        return $this->connect_timeout_seconds;
    }

    public function shouldVerifySsl(): bool
    {
        return $this->verify_ssl;
    }

    public function getUserAgent(): string
    {
        return $this->user_agent;
    }
}
