<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Enum;

class NetworkType
{
    public const PROFILE = 0;
    public const PAGE = 1;
    public const GROUP = 2;

    public static function values(): array
    {
        return [
            self::PROFILE,
            self::PAGE,
            self::GROUP,
        ];
    }
}
