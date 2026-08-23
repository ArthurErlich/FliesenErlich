<?php

declare(strict_types=1);

namespace App\Api\Security;

// Verifies a Cap CAPTCHA token server-to-server. Docs: https://trycap.dev/guide/
final class CapVerifier
{
    private const API_ENDPOINT = 'https://captcha.arthurerlich.de/cd95f97050/';

    public function __construct(private readonly string $secretKey)
    {
    }

    public function verify(string $token): bool
    {
        if ($this->secretKey === '') {
            // ponytail: fail closed if the secret isn't configured, never skip verification
            error_log('CAP_SECRET_KEY is not set');
            return false;
        }

        if ($token === '') {
            return false;
        }

        $ch = curl_init(self::API_ENDPOINT . 'siteverify');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode(['secret' => $this->secretKey, 'response' => $token]),
            CURLOPT_TIMEOUT => 5,
        ]);
        $body = curl_exec($ch);
        $failed = curl_errno($ch) !== 0;
        curl_close($ch);

        if ($failed || $body === false) {
            return false;
        }

        $data = json_decode($body, true);
        return ($data['success'] ?? false) === true;
    }
}
