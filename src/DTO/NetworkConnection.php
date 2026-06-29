<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\DTO;

use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class NetworkConnection
{
    private int $client_user_network_id;
    private int $network_id;
    private string $name;
    private string $type;
    private string $display_name;

    public function __construct(
        int $client_user_network_id,
        int $network_id,
        string $name,
        string $type,
        string $display_name = ''
    ) {
        if ($client_user_network_id < 1) {
            throw ValidationException::forField(
                'client_user_network_id',
                'The client_user_network_id must be a positive integer.'
            );
        }

        $this->client_user_network_id = $client_user_network_id;
        $this->network_id = $network_id;
        $this->name = $name;
        $this->type = $type;
        $this->display_name = $display_name;
    }

    public static function fromArray(array $data): self
    {
        if (!isset($data['client_user_network_id'], $data['network_id'])) {
            throw ValidationException::forField(
                'network_connection',
                'The connection data is incomplete.'
            );
        }

        return new self(
            (int) $data['client_user_network_id'],
            (int) $data['network_id'],
            (string) ($data['name'] ?? ''),
            (string) ($data['type'] ?? ''),
            (string) ($data['display_name'] ?? '')
        );
    }

    public function getClientUserNetworkId(): int
    {
        return $this->client_user_network_id;
    }

    public function getNetworkId(): int
    {
        return $this->network_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDisplayName(): string
    {
        return $this->display_name;
    }
}
