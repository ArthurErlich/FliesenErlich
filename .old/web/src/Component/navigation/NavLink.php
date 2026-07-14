<?php

namespace ErlichFliesen\Component\navigation;


use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent("NavLink", template: 'components/navigation/nav_link.html.twig')]
class NavLink
{
    public string $route;
    public string $text = "link";
}
