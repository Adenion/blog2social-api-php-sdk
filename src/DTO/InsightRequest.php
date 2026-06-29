<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\DTO;

use Adenion\Blog2Social\Sdk\Enum\NetworkType;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class InsightRequest
{
    private int $network_id;
    private int $network_type;
    private int $client_user_network_id;
    private int $extern_post_id;

    public function __construct(
        int $network_id,
        int $network_type,
        int $client_user_network_id,
        int $extern_post_id
    ) {
        if ($network_id < 1) {
            throw ValidationException::forField(
                'network_id',
                'The network_id must be a positive integer.'
            );
        }

        if (!in_array($network_type, NetworkType::values(), true)) {
            throw ValidationException::forField(
                'network_type',
                'The network_type must be 0, 1, or 2.'
            );
        }

        if ($client_user_network_id < 1) {
            throw ValidationException::forField(
                'client_user_network_id',
                'The client_user_network_id must be a positive integer.'
            );
        }

        if ($extern_post_id < 1) {
            throw ValidationException::forField(
                'extern_post_id',
                'The extern_post_id must be a positive integer.'
            );
        }

        $this->network_id = $network_id;
        $this->network_type = $network_type;
        $this->client_user_network_id = $client_user_network_id;
        $this->extern_post_id = $extern_post_id;
    }

    public function toArray(): array
    {
        return [
            'network_id' => $this->network_id,
            'network_type' => $this->network_type,
            'client_user_network_id' => $this->client_user_network_id,
            'extern_post_id' => $this->extern_post_id,
        ];
    }
}
