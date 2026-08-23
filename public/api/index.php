<?php

declare(strict_types=1);

// Single JSON API endpoint for all forms on the site. Every request looks
// like {"key": "<form name>", "data": {...}} — the "key" selects a handler
// below, so adding a new form means adding a handler + map entry here, not a
// new API file. See src/lib/api/ (TypeScript) for the matching client side.

use App\Api\Dispatcher;
use App\Api\Handlers\ContactHandler;
use App\Api\Security\CapVerifier;
use App\Api\Security\SameOriginGuard;

require __DIR__ . '/vendor/autoload.php';

// Loads KEY=VALUE lines from a .env file that must live outside public/
// (this file's built copy is web-servable, so anything web-servable is
// public — the .env stays one level above the site root and is never
// deployed into it). No-op if the file doesn't exist, so real server env
// vars still work as a fallback in production.
$dotenvPath = __DIR__ . '/../../.env';
if (is_file($dotenvPath)) {
    foreach (file($dotenvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$envKey, $envValue] = explode('=', $line, 2);
        putenv(trim($envKey) . '=' . trim($envValue, " \t\"'"));
    }
}

header('Content-Type: application/json');

if (!SameOriginGuard::isSameOrigin()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'forbidden']);
    exit;
}

$body = json_decode((string) file_get_contents('php://input'), true);
$key = (string) ($body['key'] ?? '');
$data = (array) ($body['data'] ?? []);

$capVerifier = new CapVerifier((string) getenv('CAP_SECRET_KEY'));
if (!$capVerifier->verify((string) ($data['cap-token'] ?? ''))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'captcha_failed']);
    exit;
}

$dispatcher = new Dispatcher([
    'contact' => new ContactHandler(),
]);

try {
    $result = $dispatcher->dispatch($key, $data);
    echo json_encode(['success' => true, 'data' => $result]);
} catch (\InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
