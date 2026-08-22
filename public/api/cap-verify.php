<?php
// Verifies a Cap CAPTCHA token server-to-server before processing a form.
// Docs: https://trycap.dev/guide/
//
// Usage from a form handler:
//   $ok = cap_verify($_POST['cap-token'] ?? '');
//   if (!$ok) { http_response_code(400); exit('captcha failed'); }

const CAP_API_ENDPOINT = 'https://captcha.arthurerlich.de/cd95f97050/';

// Loads KEY=VALUE lines from a .env file that must live outside public/
// (this file's built copy is web-servable, so anything web-servable is
// public — the .env stays one level above the site root and is never
// deployed into it). No-op if the file doesn't exist, so real server env
// vars still work as a fallback in production.
function load_dotenv(string $path): void
{
    if (!is_file($path)) {
        return;
    }
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        putenv(trim($key) . '=' . trim($value, " \t\"'"));
    }
}

load_dotenv(__DIR__ . '/../../.env');

function cap_verify(string $token): bool
{
    if ($token === '') {
        return false;
    }

    $secret = getenv('CAP_SECRET_KEY');
    if (!$secret) {
        // ponytail: fail closed if the secret isn't configured, never skip verification
        error_log('CAP_SECRET_KEY is not set');
        return false;
    }

    $ch = curl_init(CAP_API_ENDPOINT . 'siteverify');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode(['secret' => $secret, 'response' => $token]),
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

// No form exists yet, so this file has no HTTP entry point of its own —
// it's included by the future form handler. Once a real endpoint is
// needed (e.g. public/api/contact.php), require_once this file and call
// cap_verify().
