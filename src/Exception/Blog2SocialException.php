<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Exception;

use RuntimeException;
use Throwable;

class Blog2SocialException extends RuntimeException
{
    private array $context;

    public function __construct(
        string $message,
        int $code = 0,
        ?Throwable $previous = null,
        array $context = []
    ) {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
