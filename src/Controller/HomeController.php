<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Feedback;
use App\Entity\Newsletter;
use App\Entity\Speaker;
use App\Form\ContactType;
use App\Form\FeedBackType;
use App\Form\NewsLetterType;
use App\Form\SearchByTagSpeakerType;
use App\Repository\ArticleRepository;
use App\Repository\BannerRepository;
use App\Repository\CategoryTeamRepository;
use App\Repository\FeedbackRepository;
use App\Repository\LegalMentionsRepository;
use App\Repository\StatsRepository;
use App\Service\Mailer;
use App\Service\Searcher;
use App\Entity\Talk;
use App\Repository\CategoryPartnerRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        # SEND THE DATA TO THE DATABASE ON SUBMIT FOR FEEDBACK ON INDEX #
        $feedback = new Feedback();
        $form = $this->createForm(FeedBackType::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feedback);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        # SEND THE DATA TO THE DATABASE ON SUBMIT FOR NEWSLETTER ON INDEX #
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
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
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/partenaires", name="partenaires")
     * @return Response
     */
    public function partners(PartnerRepository $partnerRepository, CategoryPartnerRepository $categoryPartnerRepository, Request $request, Mailer $mailer): Response
    {
        # SEND THE DATA TO THE DATABASE ON SUBMIT FOR CONTACT FORM ON PARTNER #
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $contact->setCreatedAt(new \DateTime());
            $entityManager->persist($contact);
            $entityManager->flush();
            // CALL METHOD IN MAILER.PHP SERVICE TO SEND MAIL
            $mailer->contactMail($contact);

            return $this->redirectToRoute('home');
        }

        # SEND THE DATA TO THE DATABASE ON SUBMIT FOR NEWSLETTER ON PARTNERS #
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('home/partners.html.twig', [
            'partners' => $partnerRepository->findAll(),
            'categories' => $categoryPartnerRepository->findAll(),
            'form' => $form->createView(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/speakers", name="speakers")
     * @return Response
     */
    public function speakers(SpeakerRepository $SpeakerRepository, Request $request): Response
    {
        # SEND THE DATA TO THE DATABASE ON SUBMIT FOR NEWSLETTER ON SPEAKERS #
        $newsletter = new Newsletter();

        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);
        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('home/speakers.html.twig', [
            'speakers' => $SpeakerRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/speakers/{id}", name="info")
     * @return Response
     */
    public function info(Speaker $speaker, Request $request): Response
    {
        # SEND THE DATA TO THE DATABASE ON SUBMIT FOR NEWSLETTER ON SPEAKERS DETAILS #
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('home/speakers.details.html.twig', [
            'speaker' => $speaker,
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }


    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact(Request $request, Mailer $mailer): Response
    {
        # SEND THE DATA TO THE DATABASE ON SUBMIT FOR CONTACT ON CONTACT #
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $contact->setCreatedAt(new \DateTime());
            $entityManager->persist($contact);
            $entityManager->flush();
            // CALL METHOD IN MAILER.PHP SERVICE TO SEND MAIL
            $mailer->contactMail($contact);

            return $this->redirectToRoute('home');
        }

        # SEND THE DATA TO THE DATABASE ON SUBMIT FOR NEWSLETTER ON CONTACT #
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);
        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/talks", name="talks")
     * @return Response
     */
    public function talks(Request $request, Searcher $searcher): Response
    {
        # CALL SEARCH FORM TYPE FOR AUTOCOMPLETE #
        $form = $this->createForm(SearchByTagSpeakerType::class);
        $form->handleRequest($request);

        # ON SUBMIT GIVE TALKS RESULT(S) BY TAG OR SPEAKER #
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('name')->getData();
            // CALL METHOD IN SEARCHER.PHP SERVICE TO SEARCH TAG AND SPEAKER
            $talk = $searcher->searchByTagSpeaker($data);
        } else {
            # IF FORM SUBMITTED BLANK, RETURN ALL RESULTS #
            $talk = $this->getDoctrine()->getRepository(Talk::class)->findAll();
        }

        # SEND THE DATA TO THE DATABASE ON SUBMIT FOR NEWSLETTER ON TALKS #
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('home/talk.html.twig', [
            'talks' => $talk,
            'form' => $form->createView(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/equipes", name="equipes")
     * @return Response
     */
    public function teams(TeamRepository $teamRepository, CategoryTeamRepository $categoryTeamRepository, Request $request): Response
    {
        # SEND THE DATA TO THE DATABASE ON SUBMIT FOR NEWSLETTER ON TEAMS #
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('home/teams.html.twig', [
            'teams' => $teamRepository->findAll(),
            'categories' => $categoryTeamRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }

    /**
     * @Route("/mentions-legales", name="mentions")
     * @return Response
     */
    public function legalMentions(LegalMentionsRepository $legalMentionsRepository, Request $request): Response
    {
        # SEND THE DATA TO THE DATABASE ON SUBMIT FOR NEWSLETTER ON LEGAL MENTIONS #
        $newsletter = new Newsletter();
        $formNewsLetter = $this->createForm(NewsLetterType::class, $newsletter);
        $formNewsLetter->handleRequest($request);

        if ($formNewsLetter->isSubmitted() && $formNewsLetter->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('home/legal_mentions.html.twig', [
            'legalMentions' => $legalMentionsRepository->findAll(),
            'formNewsLetter' => $formNewsLetter->createView(),
        ]);
    }
}
