<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Network;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;

class Network
{
    protected Blog2SocialClient $client;

    public function __construct(Blog2SocialClient $client)
    {
        $this->client = $client;
    }

    public function listNetwork(): array
    {
        return $this->client->requestBody('/network/list');
    }

    public function addNetwork(
        int $network_id,
        int $network_type_id,
        string $language = 'en',
        ?int $service_conditions_id = null
    ): array {
        return (new Connection($this->client))->addNetwork(
            $network_id,
            $network_type_id,
            $language,
            $service_conditions_id
        );
    }

    public function updateNetwork(
        int $client_user_network_id,
        int $network_id,
        int $network_type_id,
        string $language = 'en'
    ): array {
        return (new Connection($this->client))->updateNetwork(
            $client_user_network_id,
            $network_id,
            $network_type_id,
            $language
        );
    }

    public function listCategories(int $client_user_network_id): array
    {
        return (new Categories($this->client))->listCategories(
            $client_user_network_id
        );
    }
}
