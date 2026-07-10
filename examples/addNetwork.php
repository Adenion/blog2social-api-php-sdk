<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;

$config = require __DIR__ . '/config.php';
$client = new Blog2SocialClient($config['service_token'], $config['access_token']);

try {
    $response = $client->connection()->addNetwork(1, 1, 'en');
    echo urldecode((string) $response['auth_link']) . PHP_EOL;
} catch (Throwable $exception) {
    print_r($exception);
}
