<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdherentController extends AbstractController
{

    
    /**
     * @Route("/adherent", name="app_adherent")
     */
    public function index(): Response
    {
      
     
        return $this->render('adherent/index.html.twig', [
            'controller_name' => 'AdherentController',
        ]);
    }
}
