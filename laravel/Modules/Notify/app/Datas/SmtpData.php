<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Exception;
use Illuminate\Support\Arr;
use Modules\Tenant\Services\TenantService;
use Spatie\LaravelData\Data;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Webmozart\Assert\Assert;

/**
 * Class Modules\Notify\Datas\SmtpData.
 */
class SmtpData extends Data
{
    public string $transport = 'smtp';

    public null|string $url = null;

    public string $host = '127.0.0.1';

    public int $port = 2525;

    public null|string $encryption = null; // 'tls';

    public null|bool $tls = null;

    public null|string $username = null;

    public null|string $password = null;

    public null|string $timeout = null;

    public null|string $local_domain = null;

    private static array $instance = [];

    public static function make(string $name = 'smtp'): self
    {
        if (!isset(self::$instance[$name]) || !(self::$instance[$name] instanceof self)) {
            // $data = TenantService::getConfig('mail');
            Assert::isArray($data = config('mail'));
            $data_name = Arr::get($data, 'mailers.' . $name);
            self::$instance[$name] = self::from($data_name);
        }

        return self::$instance[$name];
    }

    public function toArray(): array
    {
        return [
            'transport' => $this->transport,
            'host' => $this->host,
            'port' => $this->port,
            'encryption' => $this->encryption,
            'username' => $this->username,
            'password' => $this->password,
            'timeout' => $this->timeout,
            'local_domain' => $this->local_domain,
        ];
    }

    public function getTransport(): EsmtpTransport
    {
        $transport = new EsmtpTransport($this->host, $this->port, $this->tls);
        if ($this->username !== null && $this->password !== null) {
            $transport->setUsername($this->username);
            $transport->setPassword($this->password);
        }

        return $transport;
    }

    public function getMailer(): Mailer
    {
        $transport = $this->getTransport();
        try {
            $transport->start();
        } catch (Exception $e) {
            throw new Exception('Errore durante la connessione SMTP: ' . $e->getMessage());
        }
        $mailer = new Mailer($transport);

        return $mailer;
    }

    public function send(EmailData $emailData): void
    {
        $mailer = $this->getMailer();
        $mimeEmail = $emailData->getMimeEmail();
        try {
            $mailer->send($mimeEmail);
        } catch (Exception $e) {
            throw new Exception("Errore durante l'invio dell'email: " . $e->getMessage());
        }
    }
}
