<?php

declare(strict_types=1);

namespace App\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent("HeadLogo", template: 'components/head_logo.html.twig')]
class HeadLogo
{
    public bool $isMobile = false;
}
