<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Mail;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Invia email raw via Mailtrap / driver SMTP configurato.
 */
class SendMailtrapMailAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $vars
     */
    public function execute(string $to, string $body, array $vars = [], ?string $from = null): void
    {
        foreach ($vars as $key => $value) {
            if (\is_string($key)) {
                $this->{$key} = $value;
            }
        }

        $this->to = $to;
        $this->body = $body;
        $this->from = $from;

        Assert::string($this->body, __FILE__.':'.__LINE__.' - '.class_basename(self::class));

        Mail::raw($this->body, function (Message $msg): void {
            if (! $this->to) {
                throw new InvalidArgumentException('Il destinatario email non è valido');
            }

            $msg->to($this->to)->subject('Test Email');
        });
    }

    public ?string $from = null;

    public string $to = '';

    public ?string $body = null;
}
