<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Exception;

class AuthenticationException extends Blog2SocialException
{
    public static function missingAccessToken(): self
    {
        return new self('Missing access_token.');
    }
}
