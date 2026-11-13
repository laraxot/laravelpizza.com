<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Mail;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Notify\Models\InboundEmail;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Symfony\Component\Mime\Address;
use ZBateson\MailMimeParser\IMessage;
use ZBateson\MailMimeParser\MailMimeParser;

use function Safe\base64_decode;
use function Safe\preg_match;

/**
 * Riceve webhook inbound email dai provider (Postmark, Mailgun, payload MIME raw).
 *
 * Endpoint: POST /api/inbound/{provider}/{token}
 * Il token deve coincidere con config('notify.notify.inbound_token').
 *
 * Payload supportati:
 * - Postmark JSON: From, To, Subject, TextBody, HtmlBody, MessageID, Headers
 * - Mailgun form: sender, recipient, subject, body-plain, body-html, body-mime
 * - Raw MIME: request content-type message/rfc822 o body che inizia con "From:"
 *
 * @phpstan-type InboundMailData array{
 *     message_id: string|null,
 *     from_email: string|null,
 *     from_name: string|null,
 *     to_email: string|null,
 *     subject: string|null,
 *     text_body: string|null,
 *     html_body: string|null,
 *     headers: array<array-key, mixed>|null,
 *     payload: array<array-key, mixed>|null
 * }
 */
class ProcessInboundMailAction
{
    public function __invoke(Request $request, string $provider): JsonResponse
    {
        $routeToken = $request->route('token');
        $token = SafeStringCastAction::cast(config('notify.notify.inbound_token', ''));
        if ($token === '' || ! is_string($routeToken) || ! hash_equals($token, $routeToken)) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        try {
            $email = $this->extract($request, $provider);
        } catch (\Throwable $e) {
            Log::warning('notify.inbound.parse_failed', [
                'provider' => $provider,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'unparseable'], 422);
        }

        $rawPath = $this->storeRaw($provider, $request);

        InboundEmail::updateOrCreate(
            [
                'provider' => $provider,
                'message_id' => $email['message_id'],
            ],
            [
                'from_email' => $email['from_email'],
                'from_name' => $email['from_name'],
                'to_email' => $email['to_email'],
                'subject' => $email['subject'],
                'text_body' => $email['text_body'],
                'html_body' => $email['html_body'],
                'headers' => $email['headers'],
                'raw_path' => $rawPath,
                'payload' => $email['payload'],
                'received_at' => now(),
                'status' => 'received',
            ]
        );

        return response()->json(['ok' => true], 200);
    }

    /** @return InboundMailData */
    private function extract(Request $request, string $provider): array
    {
        // Postmark JSON
        if ($request->has('MessageID') || $request->has('FromFull')) {
            return $this->fromPostmark($request);
        }

        // Mailgun form fields
        if ($request->has('sender') || $request->has('body-mime')) {
            return $this->fromMailgun($request);
        }

        // Raw MIME nel body
        $raw = $request->getContent();
        $contentType = SafeStringCastAction::cast($request->header('Content-Type', ''));
        if (str_contains($contentType, 'message/rfc822') || str_starts_with(ltrim($raw), 'From:')) {
            return $this->fromMime($raw, $provider);
        }

        throw new \RuntimeException('Unsupported inbound payload for provider '.$provider);
    }

    /** @return InboundMailData */
    private function fromPostmark(Request $request): array
    {
        $from = SafeStringCastAction::cast($request->input('From', ''));
        $fromName = null;
        if ($request->filled('FromFull.email')) {
            $fromName = $request->input('FromFull.name');
            $fromName = is_string($fromName) && $fromName !== '' ? $fromName : null;
            $from = SafeStringCastAction::cast($request->input('FromFull.email'));
        }
        [$fromEmail, $fromName] = $this->splitAddress($from, $fromName);

        $headers = $request->input('Headers');
        $headersArr = is_array($headers) ? $headers : null;

        return [
            'message_id' => $this->firstString(
                $request->input('MessageID'),
                $headersArr,
                'Message-ID'
            ),
            'from_email' => $fromEmail,
            'from_name' => $fromName,
            'to_email' => $this->extractEmail(SafeStringCastAction::cast($request->input('To', ''))),
            'subject' => $this->nullableString($request->input('Subject')),
            'text_body' => $this->nullableString($request->input('TextBody')),
            'html_body' => $this->nullableString($request->input('HtmlBody')),
            'headers' => $headersArr,
            'payload' => $request->except(['body-mime']),
        ];
    }

    /** @return InboundMailData */
    private function fromMailgun(Request $request): array
    {
        $rawMime = $request->input('body-mime');
        if (is_string($rawMime) && $rawMime !== '') {
            return $this->fromMime(base64_decode($rawMime), 'mailgun');
        }

        [$fromEmail, $fromName] = $this->splitAddress(
            SafeStringCastAction::cast($request->input('sender', $request->input('from', '')))
        );

        return [
            'message_id' => $this->firstString(
                $request->input('Message-Id'),
                $request->input('Message-ID')
            ),
            'from_email' => $fromEmail,
            'from_name' => $fromName,
            'to_email' => $this->extractEmail(SafeStringCastAction::cast($request->input('recipient', ''))),
            'subject' => $this->nullableString($request->input('subject')),
            'text_body' => $this->nullableString($request->input('body-plain')),
            'html_body' => $this->nullableString($request->input('body-html')),
            'headers' => null,
            'payload' => $request->except(['body-mime']),
        ];
    }

    /** @return InboundMailData */
    private function fromMime(string $raw, string $provider): array
    {
        /** @var IMessage $message */
        $message = (new MailMimeParser)->parse($raw, true);

        $from = $message->getHeaderValue('from');
        $to = $message->getHeaderValue('to');
        $messageId = $message->getHeaderValue('message-id');
        $subject = $message->getHeaderValue('subject');
        [$fromEmail, $fromName] = $this->splitAddress(is_string($from) ? $from : '');

        $headers = [];
        foreach ($message->getAllHeaders() as $header) {
            $headers[$header->getName()] = $header->getValue();
        }

        return [
            'message_id' => is_string($messageId) ? $messageId : null,
            'from_email' => $fromEmail,
            'from_name' => $fromName,
            'to_email' => is_string($to) ? $this->extractEmail($to) : null,
            'subject' => is_string($subject) ? $subject : null,
            'text_body' => $message->getTextContent(),
            'html_body' => $message->getHtmlContent(),
            'headers' => $headers !== [] ? $headers : null,
            'payload' => ['provider' => $provider, 'mime_length' => strlen($raw)],
        ];
    }

    private function storeRaw(string $provider, Request $request): ?string
    {
        $rawMime = $request->input('body-mime');
        $content = is_string($rawMime) && $rawMime !== ''
            ? $rawMime
            : $request->getContent();

        if ($content === '') {
            return null;
        }

        $path = 'inbound/'.$provider.'/'.now()->format('Y/m/d').'/'.Str::uuid().'.eml';
        Storage::disk('local')->put($path, $content);

        return $path;
    }

    /** @return array{0: ?string, 1: ?string} */
    private function splitAddress(string $address, ?string $name = null): array
    {
        if ($address === '') {
            return [null, $name];
        }
        try {
            $parsed = new Address($address);
            $email = filter_var($parsed->getAddress(), FILTER_VALIDATE_EMAIL) ? $parsed->getAddress() : null;
        } catch (\Throwable) {
            $email = $this->extractEmail($address);
        }

        if ($name === null && preg_match('/^(.*?)\s*<([^>]+)>$/', $address, $m) === 1) {
            $candidate = trim($m[1] ?? '', " \t\"'");
            $name = $candidate !== '' ? $candidate : null;
        }

        return [$email ?? $this->extractEmail($address), $name];
    }

    private function extractEmail(string $value): ?string
    {
        if (preg_match('/[A-Za-z0-9._%+\'-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/', $value, $m) === 1) {
            return $m[0] ?? null;
        }

        return null;
    }

    private function nullableString(mixed $value): ?string
    {
        if (! is_string($value) || $value === '') {
            return null;
        }

        return $value;
    }

    private function firstString(mixed ...$candidates): ?string
    {
        foreach ($candidates as $candidate) {
            if (is_string($candidate) && $candidate !== '') {
                return $candidate;
            }
            if (is_array($candidate)) {
                foreach ($candidate as $h) {
                    if (is_array($h)
                        && isset($h['Name'], $h['Value'])
                        && strcasecmp(SafeStringCastAction::cast($h['Name']), 'Message-ID') === 0
                    ) {
                        return SafeStringCastAction::cast($h['Value']);
                    }
                }
            }
        }

        return null;
    }
}
