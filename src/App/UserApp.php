<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\App;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class UserApp
{
    protected Blog2SocialClient $client;

    public function __construct(Blog2SocialClient $client)
    {
        $this->client = $client;
    }

    public function addApp(
        int $network_id,
        string $app_key,
        string $app_secret,
        string|int|null $app_name = null
    ): array {
        if ($network_id < 1) {
            throw ValidationException::forField(
                'network_id',
                'The network_id must be a positive integer.'
            );
        }

        if (trim($app_key) === '') {
            throw ValidationException::forField(
                'app_key',
                'The app_key must not be empty.'
            );
        }

        if (trim($app_secret) === '') {
            throw ValidationException::forField(
                'app_secret',
                'The app_secret must not be empty.'
            );
        }

        $query_params = [
            'network_id' => $network_id,
            'app_key' => $app_key,
            'app_secret' => $app_secret,
        ];

        if ($app_name !== null) {
            $query_params['app_name'] = $app_name;
        }

        return $this->client->requestQuery('/app/add', $query_params);
    }

    public function add(
        int $network_id,
        string $app_key,
        string $app_secret,
        string|int|null $app_name = null
    ): array {
        return $this->addApp(
            $network_id,
            $app_key,
            $app_secret,
            $app_name
        );
    }

    public function listApps(): array
    {
        return $this->client->requestQuery('/app/list');
    }

    public function list(): array
    {
        return $this->listApps();
    }

    public function modifyApp(
        int $user_app_id,
        ?string $app_name = null,
        ?string $app_key = null,
        ?string $app_secret = null
    ): array {
        if ($user_app_id < 1) {
            throw ValidationException::forField(
                'user_app_id',
                'The user_app_id must be a positive integer.'
            );
        }

        $query_params = ['user_app_id' => $user_app_id];

        if ($app_name !== null) {
            $query_params['app_name'] = $app_name;
        }

        if ($app_key !== null) {
            $query_params['app_key'] = $app_key;
        }

        if ($app_secret !== null) {
            $query_params['app_secret'] = $app_secret;
        }

        return $this->client->requestQuery('/app/modify', $query_params);
    }

    public function modify(
        int $user_app_id,
        ?string $app_name = null,
        ?string $app_key = null,
        ?string $app_secret = null
    ): array {
        return $this->modifyApp(
            $user_app_id,
            $app_name,
            $app_key,
            $app_secret
        );
    }

    public function deleteApp(int $user_app_id): array
    {
        if ($user_app_id < 1) {
            throw ValidationException::forField(
                'user_app_id',
                'The user_app_id must be a positive integer.'
            );
        }

        return $this->client->requestQuery('/app/delete', [
            'user_app_id' => $user_app_id,
        ]);
    }

    public function delete(int $user_app_id): array
    {
        return $this->deleteApp($user_app_id);
    }
}
