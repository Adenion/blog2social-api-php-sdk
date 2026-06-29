<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Post;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\DTO\PostRemovalRequest;
use Adenion\Blog2Social\Sdk\DTO\PostRequest;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class Post
{
    protected Blog2SocialClient $client;

    public function __construct(Blog2SocialClient $client)
    {
        $this->client = $client;
    }

    public function createPost(
        int $client_user_network_id,
        array $b2s_posts
    ): array {
        $this->validateClientUserNetworkId($client_user_network_id);

        if ($b2s_posts === []) {
            throw ValidationException::forField(
                'b2s_posts',
                'At least one post is required.'
            );
        }

        return $this->client->requestBody('/network/post/create', [
            'client_user_network_id' => $client_user_network_id,
            'b2s_posts' => array_values($b2s_posts),
        ]);
    }

    public function createPostFromRequests(
        int $client_user_network_id,
        array $post_requests
    ): array {
        return $this->createPost(
            $client_user_network_id,
            $this->normalizePostRequests($post_requests)
        );
    }

    public function removePosts(
        int $client_user_network_id,
        array $removal_requests
    ): array {
        $this->validateClientUserNetworkId($client_user_network_id);

        if ($removal_requests === []) {
            throw ValidationException::forField(
                'b2s_posts',
                'At least one removal request is required.'
            );
        }

        return $this->client->requestBody('/network/post/remove', [
            'client_user_network_id' => $client_user_network_id,
            'b2s_posts' => $this->normalizeRemovalRequests($removal_requests),
        ]);
    }

    public function removePost(
        int $client_user_network_id,
        int $post_id,
        ?string $publish_link = null
    ): array {
        return $this->removePosts(
            $client_user_network_id,
            [
                new PostRemovalRequest(
                    $client_user_network_id,
                    $post_id,
                    $publish_link
                ),
            ]
        );
    }

    protected function normalizePostRequests(array $post_requests): array
    {
        $b2s_posts = [];

        foreach ($post_requests as $post_request) {
            if ($post_request instanceof PostRequest) {
                $b2s_posts[] = $post_request->toArray();
                continue;
            }

            if (is_array($post_request)) {
                $b2s_posts[] = $post_request;
                continue;
            }

            throw ValidationException::forField(
                'post_requests',
                'Every post request must be an array or PostRequest instance.'
            );
        }

        return $b2s_posts;
    }

    protected function normalizeRemovalRequests(array $removal_requests): array
    {
        $b2s_posts = [];

        foreach ($removal_requests as $removal_request) {
            if ($removal_request instanceof PostRemovalRequest) {
                $b2s_posts[] = $removal_request->toArray();
                continue;
            }

            if (is_array($removal_request)) {
                $b2s_posts[] = $removal_request;
                continue;
            }

            throw ValidationException::forField(
                'removal_requests',
                'Every removal request must be an array or PostRemovalRequest instance.'
            );
        }

        return $b2s_posts;
    }

    private function validateClientUserNetworkId(
        int $client_user_network_id
    ): void {
        if ($client_user_network_id < 1) {
            throw ValidationException::forField(
                'client_user_network_id',
                'The client_user_network_id must be a positive integer.'
            );
        }
    }
}
