<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Tests\Support;

use Adenion\Blog2Social\Sdk\Http\HttpClient;

class RecordingHttpClient extends HttpClient
{
    public string $last_endpoint = '';
    public array $last_payload = [];
    public array $last_query_params = [];
    public array $last_form_data = [];
    public string $last_transport = '';

    public function postJson(
        string $endpoint,
        array $payload = [],
        array $query_params = []
    ): array {
        $this->last_endpoint = $endpoint;
        $this->last_payload = $payload;
        $this->last_query_params = $query_params;
        $this->last_transport = 'json';

        return ['ok' => true];
    }

    public function postMultipart(
        string $endpoint,
        array $form_data = [],
        array $query_params = []
    ): array {
        $this->last_endpoint = $endpoint;
        $this->last_form_data = $form_data;
        $this->last_query_params = $query_params;
        $this->last_transport = 'multipart';

        return ['ok' => true];
    }
}
