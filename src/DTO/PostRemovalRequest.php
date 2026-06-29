<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\DTO;

use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class PostRemovalRequest
{
    private int $client_user_network_id;
    private int $post_id;
    private ?string $publish_link;

    public function __construct(
        int $client_user_network_id,
        int $post_id,
        ?string $publish_link = null
    ) {
        if ($client_user_network_id < 1) {
            throw ValidationException::forField(
                'client_user_network_id',
                'The client_user_network_id must be a positive integer.'
            );
        }

        if ($post_id < 1) {
            throw ValidationException::forField(
                'post_id',
                'The post_id must be a positive integer.'
            );
        }

        $this->client_user_network_id = $client_user_network_id;
        $this->post_id = $post_id;
        $this->publish_link = $publish_link;
    }

    public function toArray(): array
    {
        $data = [
            'client_user_network_id' => $this->client_user_network_id,
            'post_id' => $this->post_id,
        ];

        if ($this->publish_link !== null) {
            $data['publish_link'] = $this->publish_link;
        }

        return $data;
    }
}
