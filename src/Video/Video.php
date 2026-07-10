<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Video;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class Video
{
    protected Blog2SocialClient $client;

    public function __construct(Blog2SocialClient $client)
    {
        $this->client = $client;
    }

    public function createVideoPost(int $client_user_network_id, array $b2s_posts): array
    {
        if ($client_user_network_id < 1) {
            throw ValidationException::forField('client_user_network_id', 'The client_user_network_id must be a positive integer.');
        }

        if ($b2s_posts === []) {
            throw ValidationException::forField('b2s_posts', 'At least one video post is required.');
        }

        return $this->client->requestBody('/network/post/create/', [
            'client_user_network_id' => $client_user_network_id,
            'b2s_posts' => array_values($b2s_posts),
        ]);
    }

    public function createPost(int $client_user_network_id, array $b2s_posts): array
    {
        return $this->createVideoPost($client_user_network_id, $b2s_posts);
    }
}
