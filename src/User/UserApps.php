<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\User;

use Adenion\Blog2Social\Sdk\App\UserApp;

class UserApps extends UserApp
{
    public function addApp(
        int $network_id,
        string $app_key,
        string $app_secret,
        string|int|null $app_name = null
    ): array {
        return parent::addApp(
            $network_id,
            $app_key,
            $app_secret,
            $app_name
        );
    }

    public function listApps(): array
    {
        return parent::listApps();
    }

    public function add(int $network_id, string $app_key, string $app_secret, string|int|null $app_name = null): array
    {
        return parent::add($network_id, $app_key, $app_secret, $app_name);
    }

    public function list(): array
    {
        return parent::list();
    }

    public function modifyApp(
        int $user_app_id,
        ?string $app_name = null,
        ?string $app_key = null,
        ?string $app_secret = null
    ): array {
        return parent::modifyApp(
            $user_app_id,
            $app_name,
            $app_key,
            $app_secret
        );
    }

    public function deleteApp(int $user_app_id): array
    {
        return parent::deleteApp($user_app_id);
    }

    public function modify(int $user_app_id, ?string $app_name = null, ?string $app_key = null, ?string $app_secret = null): array
    {
        return parent::modify($user_app_id, $app_name, $app_key, $app_secret);
    }

    public function delete(int $user_app_id): array
    {
        return parent::delete($user_app_id);
    }
}
