<?php

declare(strict_types=1);

namespace Adenion\Blog2Social\Sdk\DTO;

use Adenion\Blog2Social\Sdk\Exception\ValidationException;

class Network
{
    private int $network_id;
    private string $name;

    public function __construct(int $network_id, string $name)
    {
        if ($network_id < 1) {
            throw ValidationException::forField(
                'network_id',
                'The network_id must be a positive integer.'
            );
        }

        $this->network_id = $network_id;
        $this->name = $name;
    }

    public static function fromArray(array $data): self
    {
        if (!isset($data['network_id'], $data['name'])) {
            throw ValidationException::forField(
                'network',
                'The network data must contain network_id and name.'
            );
        }

        return new self((int) $data['network_id'], (string) $data['name']);
    }

    public function getNetworkId(): int
    {
        return $this->network_id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
