<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Controller\DefaultSeoOptions;

class MainController extends AbstractController
{

    private const PATH = "/";
    private const TITLE = "Startseite";

    #[Route(self::PATH, name: 'frontend.home')]
    public function base(): Response
    {

        return $this->render('@app/pages/index.html.twig', [

            "page" => [
                "seo" => array_replace(DefaultSeoOptions::SEO_DEFAULTS, [
                    "keywords" => "",
                    "description"  => "",
                    "url" => self::PATH . DefaultSeoOptions::BASE_URL,
                    "siteName" => self::TITLE,
                    "title" => self::TITLE,
                    "revisitAfter" => ""
                ]),
            ]

        ]);
    }
}
