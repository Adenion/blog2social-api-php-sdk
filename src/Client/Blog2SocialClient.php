<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Client;

use Adenion\Blog2Social\Sdk\App\UserApp;
use Adenion\Blog2Social\Sdk\Authentication\Authentication;
use Adenion\Blog2Social\Sdk\Config\Config;
use Adenion\Blog2Social\Sdk\Exception\AuthenticationException;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;
use Adenion\Blog2Social\Sdk\Http\HttpClient;
use Adenion\Blog2Social\Sdk\Insights\Insights;
use Adenion\Blog2Social\Sdk\Network\Categories;
use Adenion\Blog2Social\Sdk\Network\Connection;
use Adenion\Blog2Social\Sdk\Network\Network;
use Adenion\Blog2Social\Sdk\Post\Insights as PostInsights;
use Adenion\Blog2Social\Sdk\Post\Post;
use Adenion\Blog2Social\Sdk\Post\Share;
use Adenion\Blog2Social\Sdk\User\User;
use Adenion\Blog2Social\Sdk\User\UserApps;
use Adenion\Blog2Social\Sdk\Video\Status;
use Adenion\Blog2Social\Sdk\Video\Upload;
use Adenion\Blog2Social\Sdk\Video\Video;

class Blog2SocialClient
{
    private string $service_token;
    private ?string $access_token;
    private HttpClient $http_client;

    public function __construct(
        string $service_token,
        ?string $access_token = null,
        ?Config $config = null,
        ?HttpClient $http_client = null
    ) {
        if (trim($service_token) === '') {
            throw ValidationException::forField(
                'service_token',
                'The service_token must not be empty.'
            );
        }

        $this->service_token = $service_token;
        $this->access_token = $access_token;
        $this->http_client = $http_client ?? new HttpClient($config);
    }

    public function setAccessToken(string $access_token): self
    {
        if (trim($access_token) === '') {
            throw ValidationException::forField(
                'access_token',
                'The access_token must not be empty.'
            );
        }

        $this->access_token = $access_token;

        return $this;
    }

    public function clearAccessToken(): self
    {
        $this->access_token = null;

        return $this;
    }

    public function getServiceToken(): string
    {
        return $this->service_token;
    }

    public function getAccessToken(): ?string
    {
        return $this->access_token;
    }

    public function request(
        string $endpoint,
        array $payload = [],
        bool $requires_access_token = true,
        array $query_params = []
    ): array {
        if ($query_params !== []) {
            return $this->requestQuery(
                $endpoint,
                $query_params,
                $payload,
                $requires_access_token
            );
        }

        return $this->requestBody($endpoint, $payload, $requires_access_token);
    }

    public function requestBody(
        string $endpoint,
        array $payload = [],
        bool $requires_access_token = true
    ): array {
        $request_payload = array_merge(
            $payload,
            ['service_token' => $this->service_token]
        );

        if ($requires_access_token) {
            $request_payload['access_token'] = $this->requireAccessToken();
        }

        return $this->http_client->postJson($endpoint, $request_payload);
    }

    public function requestWithQuery(
        string $endpoint,
        array $query_params = [],
        array $payload = [],
        bool $requires_access_token = true
    ): array {
        return $this->requestQuery(
            $endpoint,
            $query_params,
            $payload,
            $requires_access_token
        );
    }

    public function requestQuery(
        string $endpoint,
        array $query_params = [],
        array $payload = [],
        bool $requires_access_token = true
    ): array {
        $request_query_params = array_merge(
            $query_params,
            ['service_token' => $this->service_token]
        );

        if ($requires_access_token) {
            $request_query_params['access_token'] = $this->requireAccessToken();
        }

        return $this->http_client->postJson(
            $endpoint,
            $payload,
            $request_query_params
        );
    }

    public function requestMultipart(
        string $endpoint,
        array $form_data,
        array $query_params = [],
        bool $requires_service_token = false,
        bool $requires_access_token = false
    ): array {
        $request_query_params = $query_params;

        if ($requires_service_token) {
            $request_query_params['service_token'] = $this->service_token;
        }

        if ($requires_access_token) {
            $request_query_params['access_token'] = $this->requireAccessToken();
        }

        return $this->http_client->postMultipart(
            $endpoint,
            $form_data,
            $request_query_params
        );
    }

    public function authentication(): Authentication
    {
        return new Authentication($this);
    }

    public function network(): Network
    {
        return new Network($this);
    }

    public function connection(): Connection
    {
        return new Connection($this);
    }

    public function categories(): Categories
    {
        return new Categories($this);
    }

    public function user(): User
    {
        return new User($this);
    }

    public function post(): Post
    {
        return new Post($this);
    }

    public function share(): Share
    {
        return new Share($this);
    }

    public function insights(): Insights
    {
        return new Insights($this);
    }

    public function postInsights(): PostInsights
    {
        return new PostInsights($this);
    }

    public function video(): Video
    {
        return new Video($this);
    }

    public function videoUpload(): Upload
    {
        return new Upload($this);
    }

    public function videoStatus(): Status
    {
        return new Status($this);
    }

    public function app(): UserApp
    {
        return new UserApp($this);
    }

    public function userApps(): UserApps
    {
        return new UserApps($this);
    }

    private function requireAccessToken(): string
    {
        if ($this->access_token === null || trim($this->access_token) === '') {
            throw AuthenticationException::missingAccessToken();
        }

        return $this->access_token;
    }
}
