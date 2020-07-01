<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Feedback;
use App\Entity\Speaker;
use App\Entity\Tag;
use App\Form\ContactType;
use App\Form\FeedBackType;
use App\Form\SearchByTagType;
use App\Repository\ArticleRepository;
use App\Repository\BannerRepository;
use App\Repository\CategoryTeamRepository;
use App\Repository\FeedbackRepository;
use App\Repository\StatsRepository;
use App\Service\Mailer;
use App\Service\Searcher;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Talk;
use App\Repository\CategoryPartnerRepository;
use App\Repository\TalkRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PartnerRepository;
use App\Repository\SpeakerRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(BannerRepository $bannerRepository, ArticleRepository $articleRepository, Request $request, FeedbackRepository $feedbackRepository, PartnerRepository $partnerRepository, StatsRepository $statsRepository): Response
    {
        $feedback = new Feedback();
        $form = $this->createForm(FeedBackType::class, $feedback);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feedback);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'banner' => $bannerRepository->findAll(),
            'articles' => $articleRepository->findAll(),
            'feedback' => $feedbackRepository->findAll(),
            'partners' => $partnerRepository->findAll(),
            'stats' => $statsRepository->findOneBy([]),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/partenaires", name="partenaires")
     * @return Response
     */
    public function partners(PartnerRepository $partnerRepository, CategoryPartnerRepository $categoryPartnerRepository, Request $request, Mailer $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $contact->setCreatedAt(new \DateTime());
            $entityManager->persist($contact);
            $entityManager->flush();
            // CALL METHOD IN SERVICE TO SEND MAIL
            $mailer->contactMail($contact);

            return $this->redirectToRoute('home');
        }
        return $this->render('home/partners.html.twig', [
            'partners' => $partnerRepository->findAll(),
            'categories' => $categoryPartnerRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/speakers", name="speakers")
     * @return Response
     */
    public function speakers(SpeakerRepository $SpeakerRepository): Response
    {
        return $this->render('home/speakers.html.twig', [
            'speakers' => $SpeakerRepository->findAll()
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact(Request $request, Mailer $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $contact->setCreatedAt(new \DateTime());
            $entityManager->persist($contact);
            $entityManager->flush();
            // CALL METHOD IN SERVICE TO SEND MAIL
            $mailer->contactMail($contact);

            return $this->redirectToRoute('home');
        }

        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/talks", name="talks")
     * @return Response
     */
    public function talks(Request $request, Searcher $searcher): Response
    {
        $form = $this->createForm(SearchByTagType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('name')->getData();
            // CALL METHOD IN SERVICE TO SEARCH TAG AND SPEAKER
            $talk = $searcher->searchByTagSpeaker($data);
        } else {
            $talk = $this->getDoctrine()->getRepository(Talk::class)->findAll();
        }

        return $this->render('home/talk.html.twig', [
            'talks' => $talk,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/equipes", name="equipes")
     * @return Response
     */
    public function teams(TeamRepository $teamRepository, CategoryTeamRepository $categoryTeamRepository): Response
    {
        return $this->render('home/teams.html.twig', [
            'teams' => $teamRepository->findAll(),
            'categories' => $categoryTeamRepository->findAll(),
        ]);
    }
}
