<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Enum;

class PostFormat
{
    public const LINK = 0;
    public const IMAGE = 1;
    public const VIDEO = 2;

    public static function values(): array
    {
        return [
            self::LINK,
            self::IMAGE,
            self::VIDEO,
        ];
    }
}
