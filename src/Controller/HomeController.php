<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\BannerRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Speaker;
use App\Entity\Talk;
use App\Repository\CategoryPartnerRepository;
use App\Repository\SpeakerRepository;
use App\Repository\TalkRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PartnerRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(BannerRepository $bannerRepository)
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'banner' => $bannerRepository->findAll(),
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
     * @Route("/talks", name="talks", methods={"GET"})
     */
    public function talks(TalkRepository $talkRepository)
    {
        return $this->render('home/talk.html.twig', [
            'talks' => $talkRepository->findAll(),
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
