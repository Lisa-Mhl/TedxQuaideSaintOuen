<?php

namespace App\Controller;

use App\Entity\Speaker;
use App\Entity\Talk;
use App\Repository\CategoryPartnerRepository;
use App\Repository\SpeakerRepository;
use App\Repository\TalkRepository;
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
     * @Route("/talks", name="talks", methods={"GET"})
     */
    public function talks(TalkRepository $talkRepository)
    {

        return $this->render('home/talk.html.twig', [
            'talks' => $talkRepository->findAll(),
        ]);
    }
}
