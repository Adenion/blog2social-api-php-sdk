<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\Post;

use Adenion\Blog2Social\Sdk\Insights\Insights as BaseInsights;

class Insights extends BaseInsights
{
    public function total(array $insights_request): array
    {
        return parent::total($insights_request);
    }

    public function graph(
        array $network_post_data,
        ?array $range = null,
        array $fields = []
    ): array {
        return parent::graph($network_post_data, $range, $fields);
    }

    public function enable(array $insights_request): array
    {
        return parent::enableStatus($insights_request);
    }

    public function enableStatus(array $insights_request): array
    {
        return parent::enableStatus($insights_request);
    }

    public function disable(array $insights_request): array
    {
        return parent::disableStatus($insights_request);
    }

    public function disableStatus(array $insights_request): array
    {
        return parent::disableStatus($insights_request);
    }
}
