<?php

declare(strict_types=1);

namespace ErlichFliesen\Controller;

use ErlichFliesen\Seo\SeoManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MainController extends AbstractController
{

    const string TITLE_PREFIX = "Erlich Fliesen | ";
    const string PAGE_PREFIX = "@ErlichFliesen/pages/";

    #[Route("/", name: "frontend.home")]
    public function home(SeoManager $seo, Request $request): Response
    {
        $title = self::TITLE_PREFIX . "Startseite";
        $seo->setMany([
            'title' => $title,
            'siteName' => $title,
            'image' => '',
            'imgAlt' => '',
            'url' => $this->generateUrl($request->attributes->get('_route'), [], UrlGeneratorInterface::ABSOLUTE_URL),
            'description' => '',
            'keywords' => '',
        ]);

        return $this->render(self::PAGE_PREFIX . 'index.html.twig', []);
    }

    #[Route("/impressum", name: "frontend.imprint")]
    public function imprint(SeoManager $seo, Request $request): Response
    {

        $title = self::TITLE_PREFIX . "Impressum";
        $seo->setMany([
            'title' => $title,
            'siteName' => $title,
            'image' => '',
            'imgAlt' => '',
            'url' => $this->generateUrl($request->attributes->get('_route'), [], UrlGeneratorInterface::ABSOLUTE_URL),
            'description' => '',
            'keywords' => '',
        ]);

        return $this->render(self::PAGE_PREFIX . 'imprint.html.twig', []);
    }

    #[Route("/kontakt", name: "frontend.contact")]
    public function contact(SeoManager $seo, Request $request): Response
    {

        $title = self::TITLE_PREFIX . "Kontakt";
        $seo->setMany([
            'title' => $title,
            'siteName' => $title,
            'image' => '',
            'imgAlt' => '',
            'url' => $this->generateUrl($request->attributes->get('_route'), [], UrlGeneratorInterface::ABSOLUTE_URL),
            'description' => '',
            'keywords' => '',
        ]);

        return $this->render(self::PAGE_PREFIX . 'contact.html.twig', []);
    }

    #[Route("/style-guide", name: "frontend.styl_guide")]
    public function styleGuide(SeoManager $seo, Request $request): Response
    {

        $title = self::TITLE_PREFIX . "Style Guide";
        $seo->setMany([
            'title' => $title,
            'siteName' => $title,
            'image' => '',
            'imgAlt' => '',
            'url' => $this->generateUrl($request->attributes->get('_route'), [], UrlGeneratorInterface::ABSOLUTE_URL),
            'description' => '',
            'keywords' => '',
        ]);

        return $this->render(self::PAGE_PREFIX . 'style_guide.html.twig', []);
    }
}
