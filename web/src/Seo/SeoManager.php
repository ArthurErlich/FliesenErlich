<?php

namespace App\Seo;

class SeoManager
{
    private array $data;

    public function __construct(array $defaults)
    {
        $this->data = $defaults;
    }

    public function set(string $key, ?string $value): void
    {
        if ($value !== null) {
            $this->data[$key] = $value;
        }
    }

    public function setMany(array $values): void
    {
        foreach ($values as $k => $v) {
            $this->set($k, $v);
        }
    }

    public function get(string $key): ?string
    {
        return $this->data[$key] ?? null;
    }

    public function all(): array
    {
        return $this->data;
    }
}
