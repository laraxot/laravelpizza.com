<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Modules\Notify\Datas\EmailData;
use Modules\Notify\Datas\SmtpData;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Webmozart\Assert\Assert;

class SmtpMailSendAction
{
    public function execute(string $_to, string $_subject, string $_body): void
    {
        dddx('WIP');

        /*
         * $smtpData = SmtpData::make();
         * $transport = $smtpData->getTransport();
         *
         * // Start the SMTP transport
         * try {
         * $transport->start();
         * } catch (\Exception $e) {
         * throw new \Exception('Errore durante la connessione SMTP: '.$e->getMessage());
         * }
         *
         * $emailData = EmailData::from($data);
         *
         * // Verifica i dati di input e crea l'oggetto Email
         * Assert::string($email_from_address = $data['email_from_address'] ?? '');
         * Assert::string($email_from_name = $data['email_from_name'] ?? '');
         * Assert::string($email_to = $data['email_to'] ?? '');
         *
         * $from = new Address($email_from_address, $email_from_name);
         * $mailer = new Mailer($transport);
         *
         * $email = (new Email())
         * ->from($from)
         * ->to($email_to)
         * ->subject($emailData->subject)
         * ->text(strip_tags($emailData->body))
         * ->html($emailData->body);
         *
         * // Invio dell'email
         * try {
         * $mailer->send($email);
         * } catch (\Exception $e) {
         * throw new \Exception("Errore durante l'invio dell'email: ".$e->getMessage());
         * }
         */
    }
}
