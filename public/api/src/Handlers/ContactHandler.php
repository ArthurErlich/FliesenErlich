<?php

declare(strict_types=1);

namespace App\Api\Handlers;

use App\Api\Contracts\FormHandlerInterface;

// Registered under the "contact" key in public/api/index.php.
final class ContactHandler implements FormHandlerInterface
{
    public function handle(array $data): array
    {
        $name = trim((string) ($data['name'] ?? ''));
        $email = trim((string) ($data['email'] ?? ''));
        $message = trim((string) ($data['message'] ?? ''));

        if ($name === '' || $email === '' || $message === '') {
            throw new \InvalidArgumentException('missing required field');
        }

        // ponytail: no mail transport wired up yet, just logs — add mail()/SMTP
        // once the real contact form UI and delivery requirements exist.
        error_log("contact form submission from {$email}: {$message}");

        return [];
    }
}
