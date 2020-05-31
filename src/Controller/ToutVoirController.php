<?php

namespace App\Controller;

use App\Entity\Recette;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ToutVoirController extends AbstractController
{
    /**
     * @Route("/toute-les-recettes", name="tout_voir")
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

        return $this->render('tout_voir/index.html.twig', [
            "recettes" => $recettes,
            "nav_activ" => 'toutVoir',
            'footer_activ' => 'yes'
        ]);
    }
}
