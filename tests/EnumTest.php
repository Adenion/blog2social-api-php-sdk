<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Tests;

use Adenion\Blog2Social\Sdk\Enum\MediaType;
use Adenion\Blog2Social\Sdk\Enum\NetworkType;
use Adenion\Blog2Social\Sdk\Enum\PostFormat;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testNetworkTypeValues(): void
    {
        $this->assertSame([0, 1, 2], NetworkType::values());
    }

    public function testPostFormatValues(): void
    {
        $this->assertSame([0, 1, 2], PostFormat::values());
    }

    public function testMediaTypeValues(): void
    {
        $this->assertSame(['IMAGE', 'VIDEO'], MediaType::values());
    }
}
