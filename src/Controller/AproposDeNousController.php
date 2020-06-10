<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AproposDeNousController extends AbstractController
{
    /**
     * @Route("/apropos", name="apropos_de_nous")
     */
    public function index()
    {
        return $this->render('apropos_de_nous/index.html.twig', [
            'controller_name' => 'AproposDeNousController',
        ]);
    }
}
