<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Post;

class Share extends Post
{
    public function create(
        int $client_user_network_id,
        array $b2s_posts
    ): array {
        return parent::createPost($client_user_network_id, $b2s_posts);
    }

    public function createPost(
        int $client_user_network_id,
        array $b2s_posts
    ): array {
        return parent::createPost($client_user_network_id, $b2s_posts);
    }

    public function createPostFromRequests(
        int $client_user_network_id,
        array $post_requests
    ): array {
        return parent::createPostFromRequests(
            $client_user_network_id,
            $post_requests
        );
    }

    public function remove(
        int $client_user_network_id,
        array $removal_requests
    ): array {
        return parent::removePosts(
            $client_user_network_id,
            $removal_requests
        );
    }

    public function removePosts(
        int $client_user_network_id,
        array $removal_requests
    ): array {
        return parent::removePosts(
            $client_user_network_id,
            $removal_requests
        );
    }

    public function removePost(
        int $client_user_network_id,
        int $post_id,
        ?string $publish_link = null
    ): array {
        return parent::removePost(
            $client_user_network_id,
            $post_id,
            $publish_link
        );
    }
}
