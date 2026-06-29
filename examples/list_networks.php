<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;

$client = new Blog2SocialClient(
    'YOUR_SERVICE_TOKEN',
    'USER_ACCESS_TOKEN'
);

$response = $client->network()->listNetwork();

print_r($response);
