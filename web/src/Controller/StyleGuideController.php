<?php

declare(strict_types=1);

namespace App\Controller;

use App\Seo\SeoManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StyleGuideController extends AbstractController
{

    private const string PATH = "/style-guide";
    private const string TITLE = "Style Guide";
    private const string PATH_NAME = "frontend.styl_guide";

    #[Route(self::PATH, name: self::PATH_NAME)]
    public function base(SeoManager $seo): Response
    {
        $seo->setMany([
            'title' => self::TITLE,
            'siteName' => self::TITLE,
            'url' => $this->generateUrl(self::PATH_NAME, [],UrlGeneratorInterface::ABSOLUTE_URL),
            'description' => '',
            'keywords' => '',
        ]);

        return $this->render('@app/pages/style_guide.html.twig');
    }
}
