<?php

declare(strict_types=1);

namespace App\Api\Security;

// Rejects anything that isn't a same-origin browser request. Fetch POSTs
// always carry an Origin header (per the Fetch spec, regardless of
// same/cross-origin) — no Origin at all means it's not a browser fetch from
// this site, so it's rejected too. Everything external is ignored on purpose.
final class SameOriginGuard
{
    public static function isSameOrigin(): bool
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        if ($origin === '') {
            return false;
        }

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $expected = $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? '');

        return $origin === $expected;
    }
}
