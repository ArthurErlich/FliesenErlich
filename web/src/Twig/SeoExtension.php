<?php

namespace App\Twig;

use App\Seo\SeoManager;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class SeoExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(private SeoManager $seo) {}

    public function getGlobals(): array
    {
        return [
            'seo' => $this->seo->all(),
        ];
    }
}
