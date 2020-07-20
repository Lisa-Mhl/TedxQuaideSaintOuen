<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Contact;
use App\Entity\Speaker;
use App\Entity\Talk;
use App\Entity\Team;
use App\Form\ContactAdminType;
use App\Repository\NewsletterRepository;
use App\Service\Mailer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin/youtube_talk", name="youtube_talk")
     */
    public function getYoutubeVideoTalk(Request $request)
    {
        # GET THE YOUTUBE LINK FOR EACH ROW IN EASY-ADMIN #
        $repository = $this->getDoctrine()->getRepository(Talk::class);
        $id = $request->query->get('id');
        $talk = $repository->find($id);

        return $this->redirect($talk->getVideo());
    }

    /**
     * @Route("/admin/youtube_article", name="youtube_article")
     */
    public function getYoutubeVideoArticle(Request $request)
    {
        # GET THE YOUTUBE LINK FOR EACH ROW IN EASY-ADMIN #
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $id = $request->query->get('id');
        $article = $repository->find($id);

        return $this->redirect($article->getVideo());
    }

    /**
     * @Route("/admin/linkedin_speaker", name="linkedin_speaker")
     */
    public function getLinkedinSpeaker(Request $request)
    {
        # GET THE SOCIAL LINK FOR EACH ROW IN EASY-ADMIN #
        $repository = $this->getDoctrine()->getRepository(Speaker::class);
        $id = $request->query->get('id');
        $speaker = $repository->find($id);

        return $this->redirect($speaker->getLink());
    }

    /**
     * @Route("/admin/linkedin_team", name="linkedin_team")
     */
    public function getLinkedinTeam(Request $request)
    {
        # GET THE SOCIAL LINK FOR EACH ROW IN EASY-ADMIN #
        $repository = $this->getDoctrine()->getRepository(Team::class);
        $id = $request->query->get('id');
        $team = $repository->find($id);

        return $this->redirect($team->getLink());
    }

    /**
     * @Route("/admin/email_contact", name="email_contact")
     */
    public function sendEmailContact(Request $request, Mailer $mailer)
    {
        # SEND AN EMAIL USING THE TEMPLATE TO THE CONTACT IN EASY-ADMIN #
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $id = $request->query->get('id');
        $contact = $repository->find($id);

        $form = $this->createForm(ContactAdminType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // CALL METHOD IN MAILER.PHP SERVICE TO SEND MAIL
            $mailer->adminContactEmail($contact);

            return $this->redirectToRoute('easyadmin', ['entity' => 'Contact']);
        }

        return $this->render('admin/mail_to_contact.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/newsletter_email", name="newsletter_email")
     */
    public function getNewsLetterEmails(NewsletterRepository $newsletterRepository)
    {
        # GET ALL THE EMAIL ON A BLANK PAGE FOR NEWSLETTER IN EASY-ADMIN #
        return $this->render('admin/newsletter_email.html.twig', [
            'newsletters' => $newsletterRepository->findAll(),
        ]);
    }

}