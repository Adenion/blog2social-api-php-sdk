<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Tests;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\Enum\NetworkType;
use Adenion\Blog2Social\Sdk\Tests\Support\RecordingHttpClient;
use PHPUnit\Framework\TestCase;

class EndpointRequestTest extends TestCase
{
    private RecordingHttpClient $http_client;
    private Blog2SocialClient $client;
    private int $client_user_network_id = 0;

    protected function setUp(): void
    {
        $this->http_client = new RecordingHttpClient();
        $this->client = new Blog2SocialClient(
            'service_token',
            'access_token',
            null,
            $this->http_client
        );
    }

    public function testNetworkAddUsesQueryParameters(): void
    {
        $this->client->connection()->addNetwork(
            1,
            NetworkType::PROFILE,
            'en',
            99
        );

        $this->assertSame('/network/add', $this->http_client->last_endpoint);
        $this->assertSame([], $this->http_client->last_payload);
        $this->assertSame('service_token', $this->http_client->last_query_params['service_token']);
        $this->assertSame('access_token', $this->http_client->last_query_params['access_token']);
        $this->assertSame(99, $this->http_client->last_query_params['service_conditions_id']);
    }

    public function testPostRemoveUsesDocumentedBody(): void
    {
        $this->client->share()->removePost($this->client_user_network_id, 9876);

        $this->assertSame('/network/post/remove', $this->http_client->last_endpoint);
        $this->assertSame($this->client_user_network_id, $this->http_client->last_payload['client_user_network_id']);
        $this->assertSame(9876, $this->http_client->last_payload['b2s_posts'][0]['post_id']);
    }

    public function testInsightsUsesQueryAuthenticationAndBodyArray(): void
    {
        $request = [
            [
                'network_id' => 1,
                'network_type' => 0,
                'client_user_network_id' => $this->client_user_network_id,
                'extern_post_id' => 123456,
            ],
        ];

        $this->client->insights()->total($request);

        $this->assertSame('/network/post/insights/total', $this->http_client->last_endpoint);
        $this->assertSame($request, $this->http_client->last_payload);
        $this->assertSame('service_token', $this->http_client->last_query_params['service_token']);
        $this->assertSame('access_token', $this->http_client->last_query_params['access_token']);
    }

    public function testVideoCheckDoesNotInjectApiTokens(): void
    {
        $this->client->videoStatus()->check('video_token');

        $this->assertSame('/video/check', $this->http_client->last_endpoint);
        $this->assertSame(['video_token' => 'video_token'], $this->http_client->last_query_params);
    }

    public function testUserAppAddUsesQueryParameters(): void
    {
        $this->client->userApps()->addApp(
            1,
            'app_key',
            'app_secret',
            'My App'
        );

        $this->assertSame('/app/add', $this->http_client->last_endpoint);
        $this->assertSame('My App', $this->http_client->last_query_params['app_name']);
        $this->assertSame([], $this->http_client->last_payload);
    }
}
