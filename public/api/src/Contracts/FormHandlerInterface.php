<?php

declare(strict_types=1);

namespace App\Api\Contracts;

// Implemented once per form key routed through the dispatcher (see
// public/api/index.php) — new forms add a new handler + map entry, never a
// new API endpoint.
interface FormHandlerInterface
{
    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed> extra payload merged into the response
     * @throws \InvalidArgumentException on invalid input (caught by the
     *         front controller and turned into a 400 JSON error)
     */
    public function handle(array $data): array;
}
