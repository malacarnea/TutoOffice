<?php

namespace App\Services;

use App\Entity\Users;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Description of MailerService
 *
 * @author alicia
 */
class MailerService {

    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function sendEmail($user) {
        $email = (new TemplatedEmail())
                ->from('alicia.malacarne@josselinbalde.local')
                ->to(new Address($user->getEmail()))
                ->subject('Accès Tutoriels josselinbalde.fr')

                // path of the Twig template to render
                ->htmlTemplate('emails/register.html.twig')

                // pass variables (name => value) to the template
                ->context([
            'user' => $user,
        ]);

        $this->mailer->send($email);
    }

}
