<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Tests;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\Tests\Support\RecordingHttpClient;
use PHPUnit\Framework\TestCase;

class ClientStructureTest extends TestCase
{
    public function testClientCanBeCreated(): void
    {
        $http_client = new RecordingHttpClient();
        $client = new Blog2SocialClient(
            'service_token',
            null,
            null,
            $http_client
        );

        $this->assertSame('service_token', $client->getServiceToken());
        $this->assertNull($client->getAccessToken());
    }

    public function testComposerNamespaceClassesCanBeResolved(): void
    {
        $http_client = new RecordingHttpClient();
        $client = new Blog2SocialClient(
            'service_token',
            'access_token',
            null,
            $http_client
        );

        $this->assertSame(
            'Adenion\Blog2Social\Sdk\Network\Connection',
            $client->connection()::class
        );

        $this->assertSame(
            'Adenion\Blog2Social\Sdk\Video\Upload',
            $client->videoUpload()::class
        );
    }
}
