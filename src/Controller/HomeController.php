<?php

namespace App\Controller;

use App\Repository\CategoryPartnerRepository;
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
     * @Route("/apropos", name="apropos_de_nous")
     */
    public function about()
    {
        return $this->render('apropos_de_nous/index.html.twig', [
            'controller_name' => 'AproposDeNousController',
        ]);
    }


    /**
     * @Route("/footer", name="footer")
     */
    public function footer()
    {
        return $this->render('footer/footer.html.twig', [
            'controller_name' => 'HomeController'
        ]);
    }

}
