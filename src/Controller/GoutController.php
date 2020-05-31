<?php

namespace App\Controller;

use App\Entity\Gout;
use App\Repository\GoutRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GoutController extends AbstractController
{
    /**
     * @Route("/gouts", name="gout")
     */
    public function index(GoutRepository $repo)
    {
        $gouts = $repo->findAll();
        return $this->render('gout/index.html.twig', [
            "gouts" => $gouts,
            "nav_activ" => 'gouts',
        ]);
    }

    /**
    * @Route("/gout/{id}", name="gouts")
    */
   public function categorie(Gout $gout)
   {
        return $this->render('gout/gout.html.twig', [
           "gout" => $gout,
           'footer_activ' => 'yes'
       ]);
   }
}
