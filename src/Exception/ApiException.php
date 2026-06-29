<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Exception;

class ApiException extends Blog2SocialException
{
    private int $status_code;
    private array $response_data;

    public function __construct(string $message, int $status_code = 0, array $response_data = [])
    {
        parent::__construct(
            $message,
            $status_code,
            null,
            ['status_code' => $status_code, 'response_data' => $response_data]
        );

        $this->status_code = $status_code;
        $this->response_data = $response_data;
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    public function getResponseData(): array
    {
        return $this->response_data;
    }
}
