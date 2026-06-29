<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Authentication;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class Authentication
{
    private Blog2SocialClient $client;

    public function __construct(Blog2SocialClient $client)
    {
        $this->client = $client;
    }

    public function authenticateUser(): array
    {
        return $this->client->requestBody('/user/auth', [], false);
    }

    public function listUsers(): array
    {
        return $this->client->requestBody('/user/list', [], false);
    }

    public function deleteUsers(array $users): array
    {
        if ($users === []) {
            throw ValidationException::forField(
                'users',
                'At least one user ID is required.'
            );
        }

        foreach ($users as $user_id) {
            if (!is_int($user_id) || $user_id < 1) {
                throw ValidationException::forField(
                    'users',
                    'Every user ID must be a positive integer.'
                );
            }
        }

        return $this->client->requestBody(
            '/user/delete',
            ['users' => array_values($users)],
            false
        );
    }
}
