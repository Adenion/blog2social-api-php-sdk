<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Video;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;
use CURLFile;

class Video
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
        if ($client_user_network_id < 1) {
            throw ValidationException::forField(
                'client_user_network_id',
                'The client_user_network_id must be a positive integer.'
            );
        }

        if ($b2s_posts === []) {
            throw ValidationException::forField(
                'b2s_posts',
                'At least one video post is required.'
            );
        }

        return $this->client->requestQuery(
            '/network/post/create/',
            ['client_user_network_id' => $client_user_network_id],
            array_values($b2s_posts)
        );
    }

    public function uploadChunk(
        string $video_token,
        int $max_count_chunks,
        int $current_chunk,
        string $chunk_path
    ): array {
        if (trim($video_token) === '') {
            throw ValidationException::forField(
                'video_token',
                'The video_token must not be empty.'
            );
        }

        if ($max_count_chunks < 1) {
            throw ValidationException::forField(
                'max_count_chunks',
                'The max_count_chunks must be greater than zero.'
            );
        }

        if ($current_chunk < 0) {
            throw ValidationException::forField(
                'current_chunk',
                'The current_chunk must not be negative.'
            );
        }

        if (!is_file($chunk_path) || !is_readable($chunk_path)) {
            throw ValidationException::forField(
                'chunk_path',
                'The chunk file does not exist or is not readable.'
            );
        }

        return $this->client->requestMultipart('/video/upload', [
            'video_token' => $video_token,
            'max_count_chunks' => $max_count_chunks,
            'current_chunk' => $current_chunk,
            'chunk' => new CURLFile($chunk_path),
        ]);
    }

    public function upload(
        string $video_token,
        int $max_count_chunks,
        int $current_chunk,
        string $chunk_path
    ): array {
        return $this->uploadChunk(
            $video_token,
            $max_count_chunks,
            $current_chunk,
            $chunk_path
        );
    }

    public function check(string $video_token): array
    {
        if (trim($video_token) === '') {
            throw ValidationException::forField(
                'video_token',
                'The video_token must not be empty.'
            );
        }

        return $this->client->requestQuery(
            '/video/check',
            ['video_token' => $video_token],
            [],
            false
        );
    }

    public function checkStatus(string $video_token): array
    {
        return $this->check($video_token);
    }
}
