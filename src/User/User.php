<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\User;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class User
{
    private Blog2SocialClient $client;

    public function __construct(Blog2SocialClient $client)
    {
        $this->client = $client;
    }

    public function listUsers(): array
    {
        return $this->client->requestBody('/user/list', [], false);
    }

    public function listUserAuthentications(): array
    {
        return $this->client->requestBody('/user/auth/list');
    }

    public function listAuth(): array
    {
        return $this->listUserAuthentications();
    }

    public function deleteUserAuthentication(int $client_user_network_id): array
    {
        if ($client_user_network_id < 1) {
            throw ValidationException::forField(
                'client_user_network_id',
                'The client_user_network_id must be a positive integer.'
            );
        }

        return $this->client->requestBody('/user/auth/delete', [
            'client_user_network_id' => $client_user_network_id,
        ]);
    }

    public function deleteUserAuthentications(array $client_user_network_ids): array
    {
        if ($client_user_network_ids === []) {
            throw ValidationException::forField(
                'client_user_network_ids',
                'At least one client_user_network_id is required.'
            );
        }

        $responses = [];

        foreach ($client_user_network_ids as $client_user_network_id) {
            if (!is_int($client_user_network_id)) {
                throw ValidationException::forField(
                    'client_user_network_ids',
                    'Every client_user_network_id must be an integer.'
                );
            }

            $responses[] = $this->deleteUserAuthentication(
                $client_user_network_id
            );
        }

        return $responses;
    }
}
