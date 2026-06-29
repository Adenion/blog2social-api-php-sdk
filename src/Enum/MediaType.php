<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Enum;

class MediaType
{
    public const IMAGE = 'IMAGE';
    public const VIDEO = 'VIDEO';

    public static function values(): array
    {
        return [
            self::IMAGE,
            self::VIDEO,
        ];
    }
}
