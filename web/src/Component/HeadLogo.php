<?php

declare(strict_types=1);

namespace ErlichFliesen\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent("HeadLogo", template: 'components/head_logo.html.twig')]
class HeadLogo
{
}
