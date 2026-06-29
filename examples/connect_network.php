<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\Enum\NetworkType;

$client = new Blog2SocialClient(
    'YOUR_SERVICE_TOKEN',
    'USER_ACCESS_TOKEN'
);

$response = $client->connection()->addNetwork(
    1,
    NetworkType::PROFILE,
    'en'
);

print_r($response);
