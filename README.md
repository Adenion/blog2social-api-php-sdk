# Blog2Social API PHP SDK

Official PHP SDK for the Blog2Social API v1.0.

The SDK provides an object-oriented interface for authentication, social account management, publishing workflows, video uploads, insights, and application management.

## Installation

Install the SDK with Composer:

```bash
composer require adenion/blog2social-api-php-sdk
```

## Repository

GitHub repository:

```text
https://github.com/adenion/blog2social-api-php-sdk
```

## Requirements

- PHP 8.1 or higher
- Composer
- PHP cURL extension
- PHP JSON extension

## Namespace

```php
Adenion\Blog2Social\Sdk\
```

The Composer PSR-4 configuration maps this namespace to `src/`.

## Basic Usage

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;

$service_token = 'YOUR_SERVICE_TOKEN';

$client = new Blog2SocialClient(
    $service_token
);
```

## Authenticate a User

Most API requests require both a `service_token` and an `access_token`.

```php
$auth_response = $client
    ->authentication()
    ->authenticateUser();

$access_token = $auth_response['access_token'];
```

Store the returned `access_token` securely and use it for future requests:

```php
$client = new Blog2SocialClient(
    $service_token,
    $access_token
);
```

## List Available Networks

```php
$networks = $client
    ->network()
    ->listNetwork();

print_r($networks);
```

## Connect a Social Media Account

Create an authorization link for a social media account.

Example: Connect a Facebook Page.

```php
$response = $client
    ->connection()
    ->addNetwork(
        1,
        1,
        'en'
    );

header(
    'Location: ' . urldecode(
        $response['auth_link']
    )
);

exit;
```

Network type values:

```text
0 = Profile
1 = Page
2 = Group
```

## List Connected Accounts

```php
$connections = $client
    ->user()
    ->listUserAuthentications();

print_r($connections);
```

The returned `client_user_network_id` is required for publishing posts.

## Publish a Link Post

```php
$client_user_network_id = 3241;

$response = $client
    ->share()
    ->createPost(
        $client_user_network_id,
        [
            [
                'client_user_network_id' => $client_user_network_id,
                'title' => 'My first API post',
                'message' => 'Hello from the Blog2Social PHP SDK.',
                'postFormat' => 0,
                'customUrl' => 'https://example.com',
            ],
        ]
    );

print_r($response);
```

Post format values:

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
        [
            [
                'client_user_network_id' => $client_user_network_id,
                'title' => 'Image Post',
                'message' => 'This is an image post.',
                'postFormat' => 1,
                'mediaObjects' => [
                    [
                        'type' => 'IMAGE',
                        'url' => 'https://example.com/image.jpg',
                    ],
                ],
            ],
        ]
    );
```

## Publish a Video Post

```php
$response = $client
    ->share()
    ->createPost(
        $client_user_network_id,
        [
            [
                'client_user_network_id' => $client_user_network_id,
                'title' => 'Video Post',
                'message' => 'This is a video post.',
                'postFormat' => 2,
                'mediaObjects' => [
                    [
                        'type' => 'VIDEO',
                        'url' => 'https://example.com/video.mp4',
                    ],
                ],
            ],
        ]
    );
```

## Error Handling

The Blog2Social API returns one result object per publication target. Always evaluate every response item individually.

```php
foreach ($response as $result) {
    if ((int) $result['error'] === 0) {
        echo 'Published successfully.';
        continue;
    }

    echo $result['b2s_error_code'] ?? 'UNKNOWN_ERROR';
}
```

Example exception handling:

```php
try {
    $response = $client
        ->share()
        ->createPost(
            $client_user_network_id,
            $posts
        );

    print_r($response);
} catch (Throwable $exception) {
    echo '<pre>';
    print_r($exception);
    echo '</pre>';
}
```

Common API error codes:

```text
TOKEN
CONTENT
RIGHT
LOGIN
LIMIT
RATE_LIMIT
NO_DATA
```

## Available Services

```php
$client->authentication();
$client->network();
$client->connection();
$client->categories();
$client->user();
$client->post();
$client->share();
$client->insights();
$client->postInsights();
$client->video();
$client->videoUpload();
$client->videoStatus();
$client->app();
$client->userApps();
```

## Development

Install development dependencies:

```bash
composer install
```

Run the test suite:

```bash
composer test
```

`phpunit/phpunit` is only required for development and automated tests. It is listed under `require-dev` and is not installed for production consumers when Composer is run with `--no-dev`.

## License

This SDK is released under the MIT License.
