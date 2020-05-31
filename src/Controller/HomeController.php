<?php

namespace App\Controller;

use App\Entity\Recette;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        

        $donnees = $this->getDoctrine()->getRepository(Recette::class)->findBy([],
        ['created_at' => 'desc']);

        $recettes = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('home/index.html.twig', [
            "recettes" => $recettes,
            "nav_activ" => 'home',
            'footer_activ' => 'yes'
        ]);
    }

    /**
     * @Route("/mention-legale", name="mention")
     */
    public function mention()
    {
        return $this->render('mention-legale.html.twig', [
            'footer_activ' => 'yes'
        ]);
    }
}
