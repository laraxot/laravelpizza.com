<?php

/**
 * @see https://smsvi-docs.web.app/docs/restful/send-batch/
 */

declare(strict_types=1);

namespace Modules\Notify\Services\MailEngines;

use InvalidArgumentException;
use ErrorException;
use Exception;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Webmozart\Assert\Assert;

// ---------CSS------------

/**
 * Class SmsService.
 */
class MailtrapEngine
{
    public null|string $from = null;

    public string $to;

    public string $driver;

    public null|string $body = null;

    private static null|self $instance = null;

    public static function getInstance(): self
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function make(): self
    {
        return static::getInstance();
    }

    public function setLocalVars(array $vars): self
    {
        foreach ($vars as $k => $v) {
            $this->{$k} = $v;
        }

        return $this;
    }

    public function send(): self
    {
        dddx('WIP');

        return $this;
    }

    public function try(): void
    {
        // dddx($this);

        // Mail::raw('Hello World!', function($msg) {$msg->to('vair81@gmail.com')->subject('Test Email'); });

        // try {
        Assert::string($this->body, __FILE__ . ':' . __LINE__ . ' - ' . class_basename(__CLASS__));
        Mail::raw($this->body, function (Message $msg): void {
            // Verifichiamo che $this->to sia valido
            $to = $this->to;

            // Utilizziamo una condizione più appropriata
            if (!$to) {
                throw new InvalidArgumentException('Il destinatario email non è valido');
            }

            $msg->to($to)->subject('Test Email');
        });

        // Dead catch - ErrorException is never thrown in the try block.
        // } catch (ErrorException $e) {
        //    throw new Exception('['.__LINE__.']['.class_basename($this).']');
        // }
    }
}
