<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Repository\CategoryPartnerRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PartenairesController extends AbstractController
{
    /**
     * @Route("/partenaires", name="partenaires", methods={"GET"})
     */
    public function index(PartnerRepository $partnerRepository, CategoryPartnerRepository $categoryPartnerRepository)
    {
        return $this->render('partenaires/index.html.twig', [
            'partners' => $partnerRepository->findAll(),
            'categories' => $categoryPartnerRepository->findAll(),

        ]);
    }
}
