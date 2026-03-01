<?php

declare(strict_types=1);

namespace ErlichFliesen\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent("MainNavigation", template: 'components/navigation/top_bar.html.twig')]
class HeadLogo
{
    public bool $isMobile = false;
}
