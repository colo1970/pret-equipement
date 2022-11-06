<?php

namespace App\Controller;

use App\Entity\Pret;
use App\Entity\Adherent;
use App\Repository\PretRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AdherentController extends AbstractController
{

    
    /**
     * @Route("/api/nombre/pret/adherent/{id}", name="app_count_nb_pret_by_adherent", methods={"GET"})
     */
    public function index(TokenStorageInterface $token,  PretRepository $pretRepo, $id): Response
    {
        
        $nbPretParAdherent=  $pretRepo->countByAdherentId($id);
        return $this->json($nbPretParAdherent);
    }

}
