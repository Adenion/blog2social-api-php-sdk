<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Video;

class Status extends Video
{
    public function check(string $video_token): array
    {
        return parent::check($video_token);
    }

    public function checkStatus(string $video_token): array
    {
        return parent::checkStatus($video_token);
    }
}
