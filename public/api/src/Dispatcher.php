<?php

declare(strict_types=1);

namespace App\Api;

use App\Api\Contracts\FormHandlerInterface;

final class Dispatcher
{
    /** @param array<string, FormHandlerInterface> $handlers keyed by the request's "key" field */
    public function __construct(private readonly array $handlers)
    {
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function dispatch(string $key, array $data): array
    {
        $handler = $this->handlers[$key] ?? null;
        if ($handler === null) {
            throw new \InvalidArgumentException("unknown form key: {$key}");
        }

        return $handler->handle($data);
    }
}
