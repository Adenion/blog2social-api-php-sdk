<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Http;

use Adenion\Blog2Social\Sdk\Config\Config;
use Adenion\Blog2Social\Sdk\Exception\ApiException;
use Adenion\Blog2Social\Sdk\Exception\Blog2SocialException;
use CurlHandle;
use JsonException;

class HttpClient
{
    private Config $config;

    public function __construct(?Config $config = null)
    {
        $this->config = $config ?? new Config();
    }

    public function post(string $endpoint, array $payload = [], array $query_params = []): array
    {
        return $this->postJson($endpoint, $payload, $query_params);
    }

    public function postJson(string $endpoint, array $payload = [], array $query_params = []): array
    {
        return $this->postJsonResponse($endpoint, $payload, $query_params)->getData();
    }

    public function postJsonResponse(
        string $endpoint,
        array $payload = [],
        array $query_params = []
    ): Response {
        $curl = $this->initializeCurl($endpoint, $query_params);
        $headers = ['Accept: application/json'];

        if ($payload !== []) {
            try {
                $json_payload = json_encode($payload, JSON_THROW_ON_ERROR);
            } catch (JsonException $exception) {
                throw new Blog2SocialException(
                    'Could not encode request payload: ' . $exception->getMessage(),
                    0,
                    $exception
                );
            }

            $headers[] = 'Content-Type: application/json';
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json_payload);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        return $this->execute($curl);
    }

    public function postMultipart(
        string $endpoint,
        array $form_data = [],
        array $query_params = []
    ): array {
        return $this->postMultipartResponse($endpoint, $form_data, $query_params)->getData();
    }

    public function postMultipartResponse(
        string $endpoint,
        array $form_data = [],
        array $query_params = []
    ): Response {
        $curl = $this->initializeCurl($endpoint, $query_params);

        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $form_data);

        return $this->execute($curl);
    }

    private function initializeCurl(string $endpoint, array $query_params): CurlHandle
    {
        $url = $this->buildUrl($endpoint, $query_params);
        $curl = curl_init($url);

        if (!$curl instanceof CurlHandle) {
            throw new Blog2SocialException('Could not initialize cURL.');
        }

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => $this->config->getTimeoutSeconds(),
            CURLOPT_CONNECTTIMEOUT => $this->config->getConnectTimeoutSeconds(),
            CURLOPT_SSL_VERIFYPEER => $this->config->shouldVerifySsl(),
            CURLOPT_SSL_VERIFYHOST => $this->config->shouldVerifySsl() ? 2 : 0,
            CURLOPT_USERAGENT => $this->config->getUserAgent(),
        ]);

        return $curl;
    }

    private function execute(CurlHandle $curl): Response
    {
        $raw_response = curl_exec($curl);
        $status_code = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($curl);

        curl_close($curl);

        if ($raw_response === false) {
            throw new Blog2SocialException(
                $curl_error !== '' ? $curl_error : 'Unknown cURL error.'
            );
        }

        if ($raw_response === '') {
            $response = new Response($status_code, [], $raw_response);

            if (!$response->isSuccessful()) {
                throw new ApiException('API request failed with an empty response.', $status_code);
            }

            return $response;
        }

        try {
            $decoded_response = json_decode($raw_response, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new ApiException(
                'Invalid JSON response: ' . $exception->getMessage(),
                $status_code,
                ['raw_body' => $raw_response]
            );
        }

        if (!is_array($decoded_response)) {
            throw new ApiException(
                'The API response must be a JSON object or array.',
                $status_code,
                ['raw_body' => $raw_response]
            );
        }

        $response = new Response($status_code, $decoded_response, $raw_response);

        if (!$response->isSuccessful()) {
            $message = $decoded_response['message']
                ?? $decoded_response['error_description']
                ?? $decoded_response['error']
                ?? 'API request failed.';

            if (is_array($message)) {
                $message = json_encode($message) ?: 'API request failed.';
            }

            throw new ApiException((string) $message, $status_code, $decoded_response);
        }

        return $response;
    }

    private function buildUrl(string $endpoint, array $query_params = []): string
    {
        $url = preg_match('#^https?://#i', $endpoint) === 1
            ? $endpoint
            : $this->config->getBaseUrl() . '/' . ltrim($endpoint, '/');

        if ($query_params !== []) {
            $url .= '?' . http_build_query(
                $query_params,
                '',
                '&',
                PHP_QUERY_RFC3986
            );
        }

        return $url;
    }
}
