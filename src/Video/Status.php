<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Video;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class Status
{
    private const CHECK_ENDPOINT = 'https://api-upload.blog2social.com/api/rest/v1.0/video/check';

    public function __construct(private readonly Blog2SocialClient $client)
    {
    }

    public function check(string $video_token): array
    {
        if (trim($video_token) === '') {
            throw ValidationException::forField('video_token', 'The video_token must not be empty.');
        }

        return $this->client->requestBody(self::CHECK_ENDPOINT, [
            'video_token' => $video_token,
        ], false);
    }

    public function checkStatus(string $video_token): array
    {
        return $this->check($video_token);
    }
}
