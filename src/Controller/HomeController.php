<?php

namespace App\Controller;

use App\Repository\CategoryPartnerRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PartnerRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/partenaires", name="partenaires", methods={"GET"})
     */
    public function partners(PartnerRepository $partnerRepository, CategoryPartnerRepository $categoryPartnerRepository)
    {
        return $this->render('home/partners.html.twig', [
            'partners' => $partnerRepository->findAll(),
            'categories' => $categoryPartnerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/equipes", name="equipes", methods={"GET"})
     */
    public function teams(TeamRepository $teamRepository)
    {
        return $this->render('home/teams.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

}
