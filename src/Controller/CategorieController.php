<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categories", name="categorie")
     */
    public function index(CategorieRepository $repo)
    {   
        $categories = $repo->findAll();
        return $this->render('categorie/index.html.twig', [
            "categories" => $categories,
            "nav_activ" => 'categories',
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="categories")
     */
    public function categorie(Categorie $categories)
    {
        return $this->render('categorie/categorie.html.twig', [
            "categories" => $categories,
           'footer_activ' => 'yes'
        ]);
    }
}
