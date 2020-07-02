<?php


namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;


class Mailer
{
    public function __construct(MailerInterface $mailer, ParameterBagInterface $param) {
        $this->mailer = $mailer;
        $this->param = $param;
    }

    public function contactMail($entity)
    {
        $email = (new TemplatedEmail())
            ->from($this->param->get('mailer_from'))
            ->to($entity->getEmail())
            ->subject("Nous avons bien reçu votre message !")
            ->htmlTemplate('emails/notification_email.html.twig')
            ->context([
                'contact' => $entity,
            ]);

        $this->mailer->send($email);
    }

    public function adminContactEmail($entity)
    {
        $email = (new TemplatedEmail())
            ->from($this->param->get('mailer_from'))
            ->to($entity->getEmail())
            ->subject("Réponse suite à votre demande")
            ->htmlTemplate('emails/contact_email.html.twig')
            ->context([
                'contact' => $entity,
            ]);

        $this->mailer->send($email);
    }
}