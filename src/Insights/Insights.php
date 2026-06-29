<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Insights;

use Adenion\Blog2Social\Sdk\Client\Blog2SocialClient;
use Adenion\Blog2Social\Sdk\DTO\InsightRequest;
use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class Insights
{
    protected Blog2SocialClient $client;

    public function __construct(Blog2SocialClient $client)
    {
        $this->client = $client;
    }

    public function total(array $insights_request): array
    {
        return $this->client->requestQuery(
            '/network/post/insights/total',
            [],
            $this->normalizeInsightRequests($insights_request)
        );
    }

    public function graph(
        array $network_post_data,
        ?array $range = null,
        array $fields = []
    ): array {
        $payload = [
            'network_post_data' => $this->normalizeInsightRequests(
                $network_post_data
            ),
        ];

        if ($range !== null) {
            if (!isset($range['from'], $range['to'])) {
                throw ValidationException::forField(
                    'range',
                    'The range must contain "from" and "to".'
                );
            }

            $payload['range'] = [
                'from' => (string) $range['from'],
                'to' => (string) $range['to'],
            ];
        }

        $query_params = [];

        if ($fields !== []) {
            foreach ($fields as $field) {
                if (!is_string($field) || trim($field) === '') {
                    throw ValidationException::forField(
                        'fields',
                        'Every insights field must be a non-empty string.'
                    );
                }
            }

            $query_params['fields'] = array_values($fields);
        }

        return $this->client->requestQuery(
            '/network/post/insights/graph',
            $query_params,
            $payload
        );
    }

    public function enableStatus(array $insights_request): array
    {
        return $this->client->requestQuery(
            '/network/post/insights/status/enable',
            [],
            $this->normalizeInsightRequests($insights_request)
        );
    }

    public function disableStatus(array $insights_request): array
    {
        return $this->client->requestQuery(
            '/network/post/insights/status/disable',
            [],
            $this->normalizeInsightRequests($insights_request)
        );
    }

    protected function normalizeInsightRequests(
        array $insights_request
    ): array {
        if ($insights_request === []) {
            throw ValidationException::forField(
                'insights_request',
                'At least one insights request is required.'
            );
        }

        $normalized_requests = [];

        foreach ($insights_request as $request) {
            if ($request instanceof InsightRequest) {
                $normalized_requests[] = $request->toArray();
                continue;
            }

            if (is_array($request)) {
                $normalized_requests[] = $request;
                continue;
            }

            throw ValidationException::forField(
                'insights_request',
                'Every insights request must be an array or InsightRequest instance.'
            );
        }

        return $normalized_requests;
    }
}
