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

$response = $client->share()->createPost(
    $client_user_network_id,
    [
        [
            'client_user_network_id' => $client_user_network_id,
            'title' => 'Image Post',
            'message' => 'Hello with image',
            'postFormat' => PostFormat::IMAGE,
            'mediaObjects' => [
                [
                    'type' => MediaType::IMAGE,
                    'url' => 'https://example.com/image.jpg',
                    'alt' => 'Example image',
                ],
            ],
        ],
    ]
);

print_r($response);
