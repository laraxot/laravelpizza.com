<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Mail;
use Modules\Notify\Actions\Mail\Mailjet\CreateMailjetTransportAction;
use Modules\Notify\Tests\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\Mailer\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Email;

use function Safe\json_decode;
use function Safe\json_encode;

uses(TestCase::class);

it('sends through the Mailjet Send API v3.1 with sandbox, CustomID and basic auth', function (): void {
    $captured = [];
    $client = new MockHttpClient(function (string $method, string $url, array $options) use (&$captured): MockResponse {
        $captured = ['method' => $method, 'url' => $url, 'options' => $options];

        return new MockResponse(json_encode(['Messages' => [['Status' => 'success', 'To' => [['Email' => 'cliente@example.com', 'MessageID' => 1152921500000000001]]]]]), ['http_code' => 200]);
    });

    $transport = app(CreateMailjetTransportAction::class)->execute('pub', 'priv', sandbox: true, client: $client);

    $email = (new Email)
        ->from('Trattoria <prenotazioni@example.com>')
        ->to('cliente@example.com')
        ->subject('Prenotazione confermata')
        ->text('A presto')
        ->html('<p>A presto</p>');
    $email->getHeaders()->addTextHeader('X-MJ-CustomID', 'reservation-42');

    $sent = $transport->send($email);

    expect((string) $transport)->toBe('mailjet+api://api.mailjet.com?sandbox=true')
        ->and(data_get($captured, 'method'))->toBe('POST')
        ->and(data_get($captured, 'url'))->toBe('https://api.mailjet.com/v3.1/send')
        ->and($sent?->getMessageId())->toBe('1152921500000000001');

    expect(data_get($captured, 'options.headers'))->toContain('Authorization: Basic '.base64_encode('pub:priv'));

    $rawBody = data_get($captured, 'options.body');
    expect($rawBody)->toBeString();
    $body = json_decode(is_string($rawBody) ? $rawBody : '{}', true);
    expect(data_get($body, 'SandBoxMode'))->toBeTrue()
        ->and(data_get($body, 'Messages.0.From'))->toBe(['Email' => 'prenotazioni@example.com', 'Name' => 'Trattoria'])
        ->and(data_get($body, 'Messages.0.To.0.Email'))->toBe('cliente@example.com')
        ->and(data_get($body, 'Messages.0.CustomID'))->toBe('reservation-42')
        ->and(data_get($body, 'Messages.0.HTMLPart'))->toBe('<p>A presto</p>');
});

it('refuses to build a transport without keys or with an unknown scheme', function (): void {
    expect(fn () => app(CreateMailjetTransportAction::class)->execute('', 'x'))->toThrow(InvalidArgumentException::class, 'MAILJET_APIKEY_PUBLIC');
    expect(fn () => app(CreateMailjetTransportAction::class)->execute('a', 'b', scheme: 'ftp'))->toThrow(InvalidArgumentException::class, 'ftp');
});

it('builds the SMTP relay variant', function (): void {
    $transport = app(CreateMailjetTransportAction::class)->execute('a', 'b', scheme: 'smtp');

    expect((string) $transport)->toContain('in-v3.mailjet.com');
});

it('exposes the Laravel mailer "mailjet" configured from services.mailjet', function (): void {
    config([
        'mail.mailers.mailjet' => ['transport' => 'mailjet'],
        'services.mailjet' => ['key' => 'pub', 'secret' => 'priv', 'sandbox' => 'true', 'scheme' => 'api'],
    ]);

    $transport = Mail::mailer('mailjet')->getSymfonyTransport();

    expect((string) $transport)->toBe('mailjet+api://api.mailjet.com?sandbox=true');
});
