<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
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
            'title' => 'Link Post',
            'message' => 'Hello from the Blog2Social API',
            'postFormat' => PostFormat::LINK,
            'customUrl' => 'https://example.com',
        ],
    ]
);

print_r($response);
