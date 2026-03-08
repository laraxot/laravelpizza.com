<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Exception;
use Illuminate\Support\Arr;
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

    public ?string $url = null;

    public string $host = '127.0.0.1';

    public int $port = 2525;

    public ?string $encryption = null; // 'tls';

    public ?bool $tls = null;

    public ?string $username = null;

    public ?string $password = null;

    public ?string $timeout = null;

    public ?string $local_domain = null;

    private static array $instance = [];

    public static function make(string $name = 'smtp'): self
    {
        if (! isset(self::$instance[$name]) || ! (self::$instance[$name] instanceof self)) {
            // $data = TenantService::getConfig('mail');
            Assert::isArray($data = config('mail'));
            $data_name = Arr::get($data, 'mailers.'.$name);
            self::$instance[$name] = self::from($data_name);
        }

        return self::$instance[$name];
    }

    public function toArray(): array
    {
        return [
            'transport' => // @var mixed transport,
            'host' => // @var mixed host,
            'port' => // @var mixed port,
            'encryption' => // @var mixed encryption,
            'username' => // @var mixed username,
            'password' => // @var mixed password,
            'timeout' => // @var mixed timeout,
            'local_domain' => // @var mixed local_domain,
        ];
    }

    public function getTransport(): EsmtpTransport
    {
        $transport = new EsmtpTransport(// @var mixed host, $this->port, $this->tls;
        if (// @var mixed username !== null && $this->password !== null
            $transport->setUsername(// @var mixed username;
            $transport->setPassword(// @var mixed password;
        }

        return $transport;
    }

    public function getMailer(): Mailer
    {
        $transport = // @var mixed getTransport(;
        try {
            $transport->start();
        } catch (Exception $e) {
            throw new Exception('Errore durante la connessione SMTP: '.$e->getMessage());
        }

        return new Mailer($transport);
    }

    public function send(EmailData $emailData): void
    {
        $mailer = // @var mixed getMailer(;
        $mimeEmail = $emailData->getMimeEmail();
        try {
            $mailer->send($mimeEmail);
        } catch (Exception $e) {
            throw new Exception("Errore durante l'invio dell'email: ".$e->getMessage());
        }
    }
}
