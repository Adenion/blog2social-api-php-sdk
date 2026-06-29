<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\DTO;

use Adenion\Blog2Social\Sdk\Enum\PostFormat;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class PostRequest
{
    private int $client_user_network_id;
    private string $title;
    private string $message;
    private int $post_format;
    private ?string $custom_url;
    private array $media_objects;
    private array $additional_data;

    public function __construct(
        int $client_user_network_id,
        string $title,
        string $message,
        int $post_format,
        ?string $custom_url = null,
        array $media_objects = [],
        array $additional_data = []
    ) {
        if ($client_user_network_id < 1) {
            throw ValidationException::forField(
                'client_user_network_id',
                'The client_user_network_id must be a positive integer.'
            );
        }

        if (!in_array($post_format, PostFormat::values(), true)) {
            throw ValidationException::forField(
                'postFormat',
                'The postFormat must be 0, 1, or 2.'
            );
        }

        $this->client_user_network_id = $client_user_network_id;
        $this->title = $title;
        $this->message = $message;
        $this->post_format = $post_format;
        $this->custom_url = $custom_url;
        $this->media_objects = $media_objects;
        $this->additional_data = $additional_data;
    }

    public static function fromArray(array $data): self
    {
        foreach (['client_user_network_id', 'title', 'message', 'postFormat'] as $field) {
            if (!array_key_exists($field, $data)) {
                throw ValidationException::forField(
                    $field,
                    sprintf('The field "%s" is required.', $field)
                );
            }
        }

        $known_fields = [
            'client_user_network_id',
            'title',
            'message',
            'postFormat',
            'customUrl',
            'mediaObjects',
        ];

        return new self(
            (int) $data['client_user_network_id'],
            (string) $data['title'],
            (string) $data['message'],
            (int) $data['postFormat'],
            isset($data['customUrl']) ? (string) $data['customUrl'] : null,
            isset($data['mediaObjects']) && is_array($data['mediaObjects'])
                ? $data['mediaObjects']
                : [],
            array_diff_key($data, array_flip($known_fields))
        );
    }

    public function toArray(): array
    {
        $data = array_merge([
            'client_user_network_id' => $this->client_user_network_id,
            'title' => $this->title,
            'message' => $this->message,
            'postFormat' => $this->post_format,
        ], $this->additional_data);

        if ($this->custom_url !== null) {
            $data['customUrl'] = $this->custom_url;
        }

        if ($this->media_objects !== []) {
            $data['mediaObjects'] = $this->media_objects;
        }

        return $data;
    }

    public function getClientUserNetworkId(): int
    {
        return $this->client_user_network_id;
    }

    public function getPostFormat(): int
    {
        return $this->post_format;
    }
}
