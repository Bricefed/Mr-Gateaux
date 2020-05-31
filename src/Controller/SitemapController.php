<?php

namespace App\Controller;

use App\Entity\Recette;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request)
    {
        $hostname = $request->getSchemeAndHttpHost();

        $urls = [];

        $urls[] = ['loc' => $this->generateUrl('home')];
        $urls[] = ['loc' => $this->generateUrl('inscription')];
        $urls[] = ['loc' => $this->generateUrl('login')];
        $urls[] = ['loc' => $this->generateUrl('mention')];
        $urls[] = ['loc' => $this->generateUrl('categorie')];
        $urls[] = ['loc' => $this->generateUrl('gout')];

        foreach($this->getDoctrine()->getRepository(Recette::class)->findAll() as $recette){
            $images = [
                'loc' => '/imgs/photos/'. $recette->getImg(),
                'title' => $recette->getNom()
            ];

            $urls[] = [
                'loc' => $this->generateUrl('single_page', [
                    'id' => $recette->getId()
                ]),
                'image' => $images,
                'lastmod' => $recette->getUpdatedAt()->format('Y-m-d')
            ];
        }

        $reponse = new Response(
            $this->renderView('sitemap/index.html.twig', [
                'urls' => $urls,
                'hostname' => $hostname
            ]),
            200
        );

        $reponse->headers->set('Content-Type', 'text/xml');

        return $reponse;
    }
}
