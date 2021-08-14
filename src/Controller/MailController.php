<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     * @param MailerInterface $mailer
     * @return bool
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function send(MailerInterface $mailer)
    {
        $destinataire = 'karl.remy@hotmail.com';
        $sujet = 'Nouveau message.';

        $message = '<html>';
        $message .= '<head><title>Vous avez reçu un nouveau message depuis le site.</title></head>';
        $message .= '<body>
                          <p><b>Nom du destinataire :</b>' . htmlspecialchars($_POST['name']) . '</p>
                          <p><b>Email :</b>' . htmlspecialchars($_POST['email']) . '</p>
                          <p><b>Tel :</b>' . htmlspecialchars($_POST['tel']) . '</p>
                          <p><b>Message :</b>' . htmlspecialchars($_POST['message']) . '</p>
                      </body>';
        $message .= '</html>'
        ;


        $email = (new Email())
            ->from(new Address('karl.remy@hotmail.com', 'karl'))
            ->to($destinataire)
            ->subject($sujet)
            ->html($message)
        ;

        $mailer->send($email);
        $this->addFlash(
            'success',
            'Your changes were saved!'
        );
        return $this->redirectToRoute('home');
    }
}