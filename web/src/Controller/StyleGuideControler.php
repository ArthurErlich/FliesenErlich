<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StyleGuideControler extends AbstractController
{

    private const PATH = "/style-guide";
    private const TITLE = "Style Guide";

    #[Route(self::PATH, name: 'frontend.styl_guide')]
    public function base(): Response
    {

        return $this->render('@app/pages/style_guide.html.twig', [

            "page" => [
                "seo" => array_replace(DefaultSeoOptions::SEO_DEFAULTS, [
                    "keywords" => "",
                    "description" => "",
                    "url" => self::PATH . DefaultSeoOptions::BASE_URL,
                    "siteName" => self::TITLE,
                    "title" => self::TITLE,
                    "revisitAfter" => ""
                ]),
            ]

        ]);
    }
}
