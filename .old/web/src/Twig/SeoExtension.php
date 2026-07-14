<?php

namespace ErlichFliesen\Twig;

use ErlichFliesen\Seo\SeoManager;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class SeoExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(private readonly SeoManager $seo) {}

    public function getGlobals(): array
    {
        return [
            'seo' => $this->seo->all(),
        ];
    }
}
