<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendDemandEmail(string $recipient, string $message): void
    {
        $email = (new Email())
            ->from('jihedzeiri3@gmail.com')
            ->to($recipient)
            ->subject('Vérification d\'e-mail')
            ->html($message);

        $this->mailer->send($email);
    }
}
