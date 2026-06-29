<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;

$service_token = 'YOUR_SERVICE_TOKEN';
$client = new Blog2SocialClient($service_token);

$response = $client->authentication()->authenticateUser();

print_r($response);
