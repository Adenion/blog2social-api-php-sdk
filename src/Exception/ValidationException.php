<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Exception;

class ValidationException extends Blog2SocialException
{
    private ?string $field;

    public function __construct(string $message, ?string $field = null)
    {
        parent::__construct($message, 0, null, ['field' => $field]);
        $this->field = $field;
    }

    public static function forField(string $field, string $message): self
    {
        return new self($message, $field);
    }

    public function getField(): ?string
    {
        return $this->field;
    }
}
