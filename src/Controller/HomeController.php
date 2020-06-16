<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Tag;
use App\Form\ContactType;
use App\Form\SearchByTagType;
use App\Repository\BannerRepository;
use App\Repository\FeedbackRepository;
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
     */
    public function index(BannerRepository $bannerRepository, TalkRepository $talkRepository, FeedbackRepository $feedbackRepository, PartnerRepository $partnerRepository)
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'banner' => $bannerRepository->findAll(),
            'talks' => $talkRepository->findAll(),
            'feedback' => $feedbackRepository->findAll(),
            'partners' => $partnerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/partenaires", name="partenaires")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function partners(PartnerRepository $partnerRepository, CategoryPartnerRepository $categoryPartnerRepository, Request $request, MailerInterface $mailer)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $contact->setCreatedAt(new \DateTime());
            $entityManager->persist($contact);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from($this->getParameter('mailer_from'))
                ->to($contact->getEmail())
                ->subject("Nous avons bien reçu votre message !")
                ->htmlTemplate('emails/notification.html.twig')
                ->context([
                    'contact' => $contact,
                ]);

            $mailer->send($email);

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
     */
    public function speakers(SpeakerRepository $SpeakerRepository)
    {
        return $this->render('home/speakers.html.twig',[
            'speakers'=> $SpeakerRepository->findAll()
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $contact->setCreatedAt(new \DateTime());
            $entityManager->persist($contact);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from($this->getParameter('mailer_from'))
                ->to($contact->getEmail())
                ->subject("Nous avons bien reçu votre message !")
                ->htmlTemplate('emails/notification.html.twig')
                ->context([
                    'contact' => $contact,
                ]);

            $mailer->send($email);

            return $this->redirectToRoute('home');
        }

        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
          ]);
    }

    /**
     * @Route("/talks", name="talks")
     * @param Request $request
     * @return Response
     */
    public function talks(Request $request) :Response
    {
        $tag = new Tag();
        $form = $this->createForm(SearchByTagType::class, $tag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('name')->getData();
            $tag = $this->getDoctrine()->getRepository(Tag::class)->findOneBy(['name' => $data]);
            if ($tag === null) {
                $talk = $this->getDoctrine()->getRepository(Talk::class)->findOneBy(['title' => $data]);
            } else {
                $talk = $tag->getTalks();
            }
        } else {
            $talk = $this->getDoctrine()->getRepository(Talk::class)->findAll();
        }

        return $this->render('home/talk.html.twig', [
            'talks' => $talk,
            'form' => $form->createView(),
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
