<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Video;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;
use CURLFile;

class Upload
{
    private const UPLOAD_ENDPOINT = 'https://api-upload.blog2social.com/api/rest/v1.0/video/upload/';

    public function __construct(private readonly Blog2SocialClient $client)
    {
    }

    public function uploadChunk(string $video_token, int $max_count_chunks, int $current_chunk, string $chunk_path): array
    {
        if (trim($video_token) === '') {
            throw ValidationException::forField('video_token', 'The video_token must not be empty.');
        }
        if ($max_count_chunks < 1) {
            throw ValidationException::forField('max_count_chunks', 'The max_count_chunks must be greater than zero.');
        }
        if ($current_chunk < 1 || $current_chunk > $max_count_chunks) {
            throw ValidationException::forField('current_chunk', 'The current_chunk must be between 1 and max_count_chunks.');
        }
        if (!is_file($chunk_path) || !is_readable($chunk_path)) {
            throw ValidationException::forField('chunk_path', 'The chunk file does not exist or is not readable.');
        }

        return $this->client->requestMultipart(self::UPLOAD_ENDPOINT, [
            'video_token' => $video_token,
            'max_count_chunks' => $max_count_chunks,
            'current_chunk' => $current_chunk,
            'chunk' => new CURLFile($chunk_path),
        ]);
    }

    public function upload(string $video_token, int $max_count_chunks, int $current_chunk, string $chunk_path): array
    {
        return $this->uploadChunk($video_token, $max_count_chunks, $current_chunk, $chunk_path);
    }
}
