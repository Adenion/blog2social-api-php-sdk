<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;

$client = new Blog2SocialClient(
    'YOUR_SERVICE_TOKEN',
    'USER_ACCESS_TOKEN'
);

$client_user_network_id = (int) 'YOUR_CLIENT_USER_NETWORK_ID';
$response = $client->share()->removePost(
    $client_user_network_id,
    9876
);

print_r($response);
