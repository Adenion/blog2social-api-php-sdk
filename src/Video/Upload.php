<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Video;

class Upload extends Video
{
    public function uploadChunk(
        string $video_token,
        int $max_count_chunks,
        int $current_chunk,
        string $chunk_path
    ): array {
        return parent::uploadChunk(
            $video_token,
            $max_count_chunks,
            $current_chunk,
            $chunk_path
        );
    }

    public function upload(
        string $video_token,
        int $max_count_chunks,
        int $current_chunk,
        string $chunk_path
    ): array {
        return parent::upload(
            $video_token,
            $max_count_chunks,
            $current_chunk,
            $chunk_path
        );
    }

    public function createPost(
        int $client_user_network_id,
        array $b2s_posts
    ): array {
        return parent::createPost($client_user_network_id, $b2s_posts);
    }
}
