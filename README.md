# PHP SDK for Social Media API Integration (Blog2Social API v1.0)

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://www.php.net/)
[![Composer](https://img.shields.io/badge/Composer-ready-orange.svg)](https://getcomposer.org/)

Build social media publishing directly into your PHP applications using one unified Social Media API.

Instead of integrating and maintaining multiple platform-specific APIs, the Blog2Social PHP SDK provides one consistent interface to authenticate users, connect social media accounts, and publish content across multiple social networks.

Designed for SaaS platforms, CMS solutions, AI applications, marketing tools, enterprise software and custom business applications.

### Why use the SDK?

* Authenticate users securely
* Connect social media accounts via OAuth
* Publish text, links, images and videos
* Support multiple social media platforms through one API
* Composer-ready
* PSR-4 compliant
* PHP 8.1+

---

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

---

## Features

* Authenticate Blog2Social API users
* Connect and manage social media accounts
* Publish link, image, and video posts
* Manage applications and API integrations
* PSR-4 compliant
* Composer-ready installation
* PHP 8.1+ support

---

## Typical Use Cases

The SDK is designed for PHP applications that need to create, schedule, or publish social media content without maintaining separate integrations for every platform.

### SaaS platforms

Add social media publishing to your product so users can share updates, reports, listings, achievements, or announcements directly from your application.

### Content Management Systems

Turn articles, pages, product updates, or editorial content into social media posts and publish them to connected social accounts.

### AI-powered applications

Generate captions, campaign messages, summaries, or content variations with AI and publish approved content through one API workflow.

### Marketing automation platforms

Trigger social media publishing from campaigns, workflows, CRM events, ecommerce actions, or scheduled content plans.

### Agency tools

Manage multiple clients, brands, connected accounts, and publishing targets from one application layer.

### Enterprise software

Distribute company news, product updates, employer branding content, or internal announcements to approved social media channels.

### Internal communication systems

Allow teams to share selected updates, events, milestones, or knowledge base content across company-managed social accounts.

---

## Installation

Install the SDK via Composer:

```bash
composer require adenion/blog2social-api-php-sdk:dev-main
```

---

## Requirements

* PHP 8.1 or higher
* Composer
* PHP cURL extension
* PHP JSON extension

---

## Namespace

```php
Adenion\Blog2Social\Sdk\
```

The Composer PSR-4 configuration maps this namespace to `src/`.

---

## Repository

GitHub repository:

```text
https://github.com/adenion/blog2social-api-php-sdk
```

---

## Quick Start

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

---

## Authentication

Most API requests require both a `service_token` and an `access_token`.

Authenticate the user:

```php
$auth_response = $client
    ->authentication()
    ->authenticateUser();

$access_token = $auth_response['access_token'];
```

Store the returned access token securely and use it for future requests:

```php
$client = new Blog2SocialClient(
    $service_token,
    $access_token
);
```

---

## List Available Networks

Retrieve all supported social networks:

```php
$networks = $client
    ->network()
    ->listNetwork();

print_r($networks);
```

---

## Connect a Social Media Account

Generate an authorization URL to connect a social media account.

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

### Network Type Values

```text
0 = Profile
1 = Page
2 = Group
```

---

## List Connected Accounts

```php
$connections = $client
    ->user()
    ->listUserAuthentications();

print_r($connections);
```

The returned `client_user_network_id` is required for publishing posts.

---

## Publish a Link Post

```php
$client_user_network_id = (int) 'YOUR_CLIENT_USER_NETWORK_ID';

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

### Post Format Values

```text
0 = Link
1 = Image
2 = Video
```

---

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

---

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

---

## Error Handling

The Blog2Social API returns one result object per publication target.

Always evaluate every response item individually.

```php
foreach ($response as $result) {

    if ((int) $result['error'] === 0) {
        echo 'Published successfully.';
        continue;
    }

    echo $result['b2s_error_code'] ?? 'UNKNOWN_ERROR';
}
```

### Exception Handling

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

### Common API Error Codes

```text
TOKEN
CONTENT
RIGHT
LOGIN
LIMIT
RATE_LIMIT
NO_DATA
```

---

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

---

## Documentation

Complete API documentation is available at:

[https://en.blog2social.com/social-media-api/](https://en.blog2social.com/social-media-api/)

The documentation includes:

* Authentication
* OAuth
* Account Management
* Publishing
* Media Uploads
* Insights
* Error Codes
* API Reference

---

## Frequently Asked Questions

### Why should I use a unified Social Media API instead of integrating individual platform APIs?

Building your own integration means maintaining separate APIs, OAuth flows, publishing endpoints, media formats, and API updates for every supported social media platform.

The Blog2Social API provides one unified interface for authentication, account management, and content publishing. Instead of implementing multiple platform-specific integrations, your application communicates with a single API while the Blog2Social platform handles network-specific differences in the background.

This reduces development effort, simplifies maintenance, and allows your application to support multiple social media platforms through one consistent implementation.

### Is there a PHP SDK for publishing to multiple social media platforms?

Yes.

The Blog2Social PHP SDK is an open-source client library that wraps the Blog2Social API in an object-oriented interface.

Instead of manually creating HTTP requests, handling authentication, and processing responses for every endpoint, developers can work with reusable PHP service classes that simplify authentication, account management, content publishing, media uploads, and application management.

The SDK is Composer-ready, PSR-4 compliant, supports PHP 8.1+, and is designed for production applications.

### How does user authentication work?

Authentication consists of two steps.

First, your application authenticates itself using its `service_token`. This identifies your application to the Blog2Social API.

Second, the SDK authenticates the user and returns an `access_token`, which is used for all subsequent API requests.

When a user connects a social media account, the Blog2Social API manages the OAuth authorization process. After successful authorization, the connected account receives a unique `client_user_network_id`, which is required when publishing content.

### Can users connect multiple social media accounts?

Yes.

Each authenticated user can connect multiple accounts across all supported social media platforms.

After authorization, the SDK retrieves all connected accounts together with their corresponding `client_user_network_id`. Your application can then select the appropriate publishing target for every request.

This makes the SDK suitable for applications that manage multiple brands, customers, workspaces, or publishing destinations.

### What types of content can I publish?

The SDK provides one consistent publishing interface for different content types.

Depending on the capabilities of the connected social network, applications can publish:

* Link posts
* Text posts
* Image posts
* Video posts

The Blog2Social API validates requests and automatically handles platform-specific publishing requirements while your application uses one consistent publishing workflow.

### How should my application handle publishing errors?

A successful HTTP response does not necessarily mean that every publication succeeded.

Publishing requests may contain multiple target accounts, and each target returns its own publishing result. Applications should therefore always evaluate the individual response objects instead of relying solely on the HTTP status code.

The SDK includes examples for response evaluation and exception handling, allowing applications to detect authentication issues, permission errors, validation failures, or platform-specific publishing errors.

### What's the difference between the PHP SDK and the Blog2Social API?

The Blog2Social API is the underlying REST interface that provides authentication, account management, publishing, media handling, analytics, and other services.

The PHP SDK is a lightweight client library built on top of the API. It wraps REST endpoints in reusable PHP classes, reducing boilerplate code and simplifying integration into PHP applications.

Applications written in PHP will typically use the SDK, while applications written in other programming languages can integrate directly with the REST API.

### Where can I find the complete API documentation?

The SDK simplifies implementation, while the Blog2Social API documentation provides the complete technical reference for all available endpoints, request parameters, authentication methods, response formats, supported services, and API error codes.

API Documentation:

[https://en.blog2social.com/social-media-api/](https://en.blog2social.com/social-media-api/)

---

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

---

## Contributing

Contributions are welcome.

If you would like to contribute:

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Open a pull request

For larger changes, please open an issue first to discuss the proposed implementation.

---

## Security

If you discover a security vulnerability, please report it privately and do not create a public GitHub issue.

Please contact:

```text
customer-service@blog2social.com
```

---

## Support

For support, bug reports, and feature requests:

* GitHub Issues
* Blog2Social Support Team

---

## License

This SDK is released under the MIT License.

See the LICENSE file for details.
