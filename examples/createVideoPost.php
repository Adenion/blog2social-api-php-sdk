<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;

$config = require __DIR__ . '/config.php';
$client = new Blog2SocialClient($config['service_token'], $config['access_token']);
$client_user_network_id = (int) $config['client_user_network_id'];

try {
    print_r($client->share()->createPost($client_user_network_id, [[
        'client_user_network_id' => $client_user_network_id,
        'title' => 'Video Post',
        'message' => 'This video was published using the Blog2Social PHP SDK.',
        'postFormat' => 2,
        'mediaObjects' => [[
            'type' => 'VIDEO',
            'url' => 'https://example.com/video.mp4',
        ]],
    ]]));
} catch (Throwable $exception) {
    print_r($exception);
}
