<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Network;

use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class Categories extends Network
{
    public function listCategories(int $client_user_network_id): array
    {
        if ($client_user_network_id < 1) {
            throw ValidationException::forField(
                'client_user_network_id',
                'The client_user_network_id must be a positive integer.'
            );
        }

        return $this->client->requestQuery('/network/categories', [
            'client_user_network_id' => $client_user_network_id,
        ]);
    }

    public function listBoards(int $client_user_network_id): array
    {
        return $this->listCategories($client_user_network_id);
    }
}
