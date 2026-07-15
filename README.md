# Blog2Social API PHP SDK
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://www.php.net/)
[![Composer](https://img.shields.io/badge/Composer-ready-orange.svg)](https://getcomposer.org/)

Official PHP SDK for the Blog2Social API v1.0.

The SDK provides an object-oriented interface for authentication, network connections, publishing, user apps, and video uploads.

## Installation

```bash
composer require adenion/blog2social-api-php-sdk
```

## Requirements

- PHP 8.1 or higher
- Composer
- PHP cURL extension
- PHP JSON extension
- A Blog2Social API `service_token` ([Create a free Blog2Social API account and get your token to get started.](https://console.blog2social.com/))
- An Blog2Socail API  `access_token` (required for authenticated endpoints)

## Architecture

```text
┌──────────────────────────────┐
│      Your PHP Application    │
└──────────────┬───────────────┘
              │
              ▼
┌──────────────────────────────┐
│     Blog2Social PHP SDK      │
└──────────────┬───────────────┘
              │
              ▼
┌──────────────────────────────┐
│       Blog2Social API        │
└──────────────┬───────────────┘
              │
  ┌───────────┼───────────┐
  ▼           ▼           ▼
Facebook   LinkedIn   Instagram
     ▼           ▼           ▼
  Threads   Pinterest   TikTok

... additional supported networks ...
```

## Initialization

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;

$client = new Blog2SocialClient(
    $_ENV['BLOG2SOCIAL_SERVICE_TOKEN'],
    $_ENV['BLOG2SOCIAL_ACCESS_TOKEN'] ?? null
);
```

Do not commit API tokens. Use environment variables or a secrets manager in production.

## Authenticate a User

```php
$response = $client
    ->authentication()
    ->authenticateUser();

$access_token = $response['access_token'];
```

The `access_token` can then be assigned to the existing client:

```php
$client->setAccessToken($access_token);
```

## List Users

This service-level endpoint requires only the `service_token`.

```php
$client = new Blog2SocialClient($service_token);
$users = $client->user()->listUsers();
```

## List Available Networks

```php
$networks = $client->network()->listNetwork();
```

## List Network Properties

Network properties describe content limits, media formats, instant sharing, and video requirements.

```php
$properties = $client->network()->listProperties();
```

For video publishing, inspect `video_support` and `video_upload_type` for the matching `network_id` and `network_type`.

A video token is generated only when `video_upload_type` is `1`:

- `0`: publish with a public video URL
- `1`: request a video token and upload the local file in chunks
- `2`: publish with a public video URL; no video token is generated

## Connect a Social Media Account

```php
$response = $client
    ->connection()
    ->addNetwork(
        1,
        1,
        'en'
    );

$auth_link = urldecode($response['auth_link']);
```

Network type values:

```text
0 = Profile
1 = Page
2 = Group
```

Some networks may require a user app. Register its credentials first with `$client->userApps()->add()`.

## List Connected Accounts

```php
$connections = $client
    ->user()
    ->listUserAuthentications();
```

The returned `client_user_network_id` identifies the publishing destination.

## Publish a Link Post

```php
$client_user_network_id = XXX;

$response = $client
    ->share()
    ->createPost(
        $client_user_network_id,
        [[
            'client_user_network_id' => $client_user_network_id,
            'title' => 'My first API post',
            'message' => 'Hello from the Blog2Social PHP SDK.',
            'postFormat' => 0,
            'customUrl' => 'https://example.com',
        ]]
    );
```

Post formats:

```text
0 = Link
1 = Image
2 = Video
```

## Publish an Image Post

```php
$response = $client
    ->share()
    ->createPost(
        $client_user_network_id,
        [[
            'client_user_network_id' => $client_user_network_id,
            'title' => 'Image Post',
            'message' => 'This is an image post.',
            'postFormat' => 1,
            'mediaObjects' => [[
                'type' => 'IMAGE',
                'url' => 'https://example.com/image.jpg',
            ]],
        ]]
    );
```

## Publish a Video by URL

Use this workflow when the matching network property has `video_upload_type` equal to `0` or `2`.

```php
$response = $client
    ->share()
    ->createPost(
        $client_user_network_id,
        [[
            'client_user_network_id' => $client_user_network_id,
            'title' => 'Video Post',
            'message' => 'This is a video post.',
            'postFormat' => 2,
            'mediaObjects' => [[
                'type' => 'VIDEO',
                'url' => 'https://example.com/video.mp4',
            ]],
        ]]
    );
```

## Upload a Local Video

Use this workflow only when the matching network property has `video_upload_type = 1`.

1. Request a video token with `$client->video()->createVideoPost()`.
2. Upload the file in chunks with `$client->videoUpload()->uploadChunk()`.
3. Check the result with `$client->videoStatus()->check()`.

A complete example is available in `examples/uploadVideoAndPost.php`.

## User Apps

```php
$user_app = $client
    ->userApps()
    ->add(
        6,
        'YOUR_APP_KEY',
        'YOUR_APP_SECRET',
        'My Pinterest App'
    );
```

Available methods:

```php
$client->userApps()->add();
$client->userApps()->list();
$client->userApps()->modify();
$client->userApps()->delete();
```

## Error Handling

API request errors are thrown as `ApiException` and include the HTTP status and parsed response data.

```php
use Adenion\Blog2Social\Sdk\Exception\ApiException;

try {
    $client->network()->listNetwork();
} catch (ApiException $exception) {
    echo $exception->getStatusCode();
    print_r($exception->getResponseData());
}
```

Publishing endpoints may return one result per destination. Check every result object individually.

```php
foreach ($response as $result) {
    if ((int) ($result['error'] ?? 1) === 0) {
        continue;
    }

    echo $result['b2s_error_code'] ?? 'DEFAULT';
}
```

## Examples

Copy the configuration template:

```bash
cp examples/config.example.php examples/config.php
```

Then run an example:

```bash
php examples/listNetwork.php
```

## Development

```bash
composer install
composer test
```

## License

MIT
