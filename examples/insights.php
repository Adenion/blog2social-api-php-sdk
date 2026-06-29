<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\DTO\InsightRequest;
use Adenion\Blog2Social\Sdk\Enum\NetworkType;

$client = new Blog2SocialClient(
    'YOUR_SERVICE_TOKEN',
    'USER_ACCESS_TOKEN'
);

$request = new InsightRequest(
    1,
    NetworkType::PROFILE,
    3241,
    123456789
);

$response = $client->insights()->total([$request]);

print_r($response);
