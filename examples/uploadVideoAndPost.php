<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
$config = require __DIR__ . '/config.php';
$client = new Blog2SocialClient($config['service_token'], $config['access_token']);
$client_user_network_id = (int) $config['client_user_network_id'];
$video_path = __DIR__ . '/files/video.mp4';
$chunk_size = 4 * 1024 * 1024;

try {
    $properties = $client->network()->listProperties();
    $property = null;

    foreach ($properties as $entry) {
        if ((int) ($entry['network_id'] ?? 0) === 1 && (int) ($entry['network_type'] ?? -1) === 1) {
            $property = $entry;
            break;
        }
    }

    if ((int) ($property['video_upload_type'] ?? 0) !== 1) {
        throw new RuntimeException('A video token is generated only when video_upload_type is 1.');
    }

    $token_response = $client->video()->createVideoPost($client_user_network_id, [[
        'client_user_network_id' => $client_user_network_id,
        'title' => 'Local Video Upload',
        'message' => 'Uploaded using the Blog2Social PHP SDK.',
        'postFormat' => 2,
    ]]);

    $video_token = (string) ($token_response[0]['video_token'] ?? '');
    if ($video_token === '') {
        throw new RuntimeException('The API did not return a video_token.');
    }

    $file_size = filesize($video_path);
    if ($file_size === false) {
        throw new RuntimeException('Could not read the video file size.');
    }

    $max_count_chunks = (int) ceil($file_size / $chunk_size);
    $handle = fopen($video_path, 'rb');
    if ($handle === false) {
        throw new RuntimeException('Could not open the video file.');
    }

    for ($current_chunk = 1; $current_chunk <= $max_count_chunks; $current_chunk++) {
        $chunk = fread($handle, $chunk_size);
        if ($chunk === false) {
            fclose($handle);
            throw new RuntimeException('Could not read a video chunk.');
        }

        $chunk_path = tempnam(sys_get_temp_dir(), 'b2s-video-');
        if ($chunk_path === false) {
            fclose($handle);
            throw new RuntimeException('Could not create a temporary chunk file.');
        }

        file_put_contents($chunk_path, $chunk);
        print_r($client->videoUpload()->uploadChunk($video_token, $max_count_chunks, $current_chunk, $chunk_path));
        unlink($chunk_path);
    }

    fclose($handle);
    print_r($client->videoStatus()->check($video_token));
} catch (Throwable $exception) {
    print_r($exception);
}
