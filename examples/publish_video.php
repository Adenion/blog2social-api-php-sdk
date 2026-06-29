<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\Enum\MediaType;
use Adenion\Blog2Social\Sdk\Enum\PostFormat;

$client = new Blog2SocialClient(
    'YOUR_SERVICE_TOKEN',
    'USER_ACCESS_TOKEN'
);

$client_user_network_id = (int) 'YOUR_CLIENT_USER_NETWORK_ID';

$response = $client->video()->createPost(
    $client_user_network_id,
    [
        [
            'client_user_network_id' => $client_user_network_id,
            'title' => 'Video Post',
            'message' => 'Hello with video',
            'postFormat' => PostFormat::VIDEO,
            'mediaObjects' => [
                [
                    'type' => MediaType::VIDEO,
                    'url' => 'https://example.com/video.mp4',
                ],
            ],
        ],
    ]
);

print_r($response);
