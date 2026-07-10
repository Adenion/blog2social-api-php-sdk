<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;

$config = require __DIR__ . '/config.php';
$client = new Blog2SocialClient($config['service_token'], $config['access_token']);

try {
    print_r($client->user()->deleteUserAuthentication((int) $config['client_user_network_id']));
} catch (Throwable $exception) {
    print_r($exception);
}
