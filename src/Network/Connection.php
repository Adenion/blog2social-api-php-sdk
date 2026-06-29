<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Network;

use Adenion\Blog2Social\Sdk\Enum\NetworkType;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class Connection extends Network
{
    public function addNetwork(
        int $network_id,
        int $network_type_id,
        string $language = 'en',
        ?int $service_conditions_id = null
    ): array {
        $this->validateConnectionData(
            $network_id,
            $network_type_id,
            $language
        );

        $query_params = [
            'network_id' => $network_id,
            'network_type_id' => $network_type_id,
            'language' => $language,
        ];

        if ($service_conditions_id !== null) {
            if ($service_conditions_id < 1) {
                throw ValidationException::forField(
                    'service_conditions_id',
                    'The service_conditions_id must be a positive integer.'
                );
            }

            $query_params['service_conditions_id'] = $service_conditions_id;
        }

        return $this->client->requestQuery('/network/add', $query_params);
    }

    public function add(
        int $network_id,
        int $network_type_id,
        string $language = 'en',
        ?int $service_conditions_id = null
    ): array {
        return $this->addNetwork(
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
        if ($client_user_network_id < 1) {
            throw ValidationException::forField(
                'client_user_network_id',
                'The client_user_network_id must be a positive integer.'
            );
        }

        $this->validateConnectionData(
            $network_id,
            $network_type_id,
            $language
        );

        return $this->client->requestQuery('/network/update', [
            'client_user_network_id' => $client_user_network_id,
            'network_id' => $network_id,
            'network_type_id' => $network_type_id,
            'language' => $language,
        ]);
    }

    public function update(
        int $client_user_network_id,
        int $network_id,
        int $network_type_id,
        string $language = 'en'
    ): array {
        return $this->updateNetwork(
            $client_user_network_id,
            $network_id,
            $network_type_id,
            $language
        );
    }

    private function validateConnectionData(
        int $network_id,
        int $network_type_id,
        string $language
    ): void {
        if ($network_id < 1) {
            throw ValidationException::forField(
                'network_id',
                'The network_id must be a positive integer.'
            );
        }

        if (!in_array($network_type_id, NetworkType::values(), true)) {
            throw ValidationException::forField(
                'network_type_id',
                'The network_type_id must be 0, 1, or 2.'
            );
        }

        if (!in_array($language, ['en', 'de'], true)) {
            throw ValidationException::forField(
                'language',
                'The language must be "en" or "de".'
            );
        }
    }
}
