<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Form\CommentaireFormType;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SinglePageController extends AbstractController
{
    /**
     * @Route("/ficheRecette/{id}", name="single_page")
     */
    public function index(RecetteRepository $repo, $id, Request $request)
    {
        $recette = $repo->find($id);

        $commentaire = new Commentaires();

        $form = $this->createForm(CommentaireFormType::class, $commentaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $commentaire->setRecette($recette);
            $commentaire->setCreatedAt(new \DateTime('now'));
            $commentaire->setEmail('');

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($commentaire);

            $doctrine->flush();
            $this->addFlash('success', 'Votre message a bien été envoyer et doit être valider avant sont ajout.');
        }

        return $this->render('single_page/index.html.twig',[
            "recette" => $recette,
            "formComment" => $form->createView(),
            'footer_activ' => 'yes'
        ]);
    }
}
