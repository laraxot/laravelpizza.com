<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Mail\Mailjet;

use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Datas\MailDeliveryEventData;
use Modules\Notify\Events\MailDeliveryEventReceived;

/**
 * Webhook Mailjet (Event API): POST /api/notify/mailjet/events/{token}.
 *
 * Mailjet manda un evento per richiesta oppure, se nel pannello e' attivo il raggruppamento, una lista.
 * Si accettano entrambi. Per ogni evento valido parte `MailDeliveryEventReceived`; quelli definitivi
 * (hard bounce, bloccato, spam, disiscrizione) finiscono anche nel log come warning.
 *
 * Risposta 200 anche per eventi sconosciuti: con un errore Mailjet riprova ogni 30 secondi per 24 ore
 * e poi sospende l'URL. 401 solo se il token non coincide con `notify.notify.mailjet_webhook_token`.
 *
 * @see docs/contracts/handle-mailjet-events-action.md
 *
 * @contract docs/contracts/handle-mailjet-events-action.md
 */
final class HandleMailjetEventsAction
{
    private const array TYPES = ['sent', 'delivered', 'open', 'click', 'bounce', 'blocked', 'spam', 'unsub'];

    public function __invoke(Request $request, string $token): JsonResponse
    {
        $expected = config('notify.notify.mailjet_webhook_token');
        if (! \is_string($expected) || $expected === '' || ! \hash_equals($expected, $token)) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        $body = $request->json()->all();
        /** @var list<mixed> $items */
        $items = \array_is_list($body) ? $body : [$body];

        $handled = 0;
        foreach ($items as $item) {
            if (! \is_array($item)) {
                continue;
            }
            /** @var array<string, mixed> $item */
            $event = $this->toData($item);
            if ($event === null) {
                continue;
            }
            if ($event->permanent) {
                Log::warning('notify.mailjet.permanent_failure', [
                    'type' => $event->type,
                    'email' => $event->email,
                    'reason' => $event->reason,
                    'custom_id' => $event->customId,
                ]);
            }
            MailDeliveryEventReceived::dispatch($event);
            $handled++;
        }

        return response()->json(['handled' => $handled]);
    }

    /**
     * @param  array<string, mixed>  $item
     */
    public function toData(array $item): ?MailDeliveryEventData
    {
        $type = $item['event'] ?? null;
        $email = $item['email'] ?? null;
        if (! \is_string($type) || ! \in_array($type, self::TYPES, true) || ! \is_string($email) || $email === '') {
            return null;
        }

        $time = $item['time'] ?? null;
        $at = \is_int($time) || (\is_string($time) && \ctype_digit($time))
            ? CarbonImmutable::createFromTimestamp((int) $time)
            : CarbonImmutable::now();

        $messageId = $item['MessageID'] ?? $item['Message_GUID'] ?? null;
        $permanent = match ($type) {
            'bounce' => ($item['hard_bounce'] ?? false) === true,
            'blocked', 'spam', 'unsub' => true,
            default => false,
        };

        return new MailDeliveryEventData(
            provider: 'mailjet',
            type: $type,
            email: $email,
            at: $at,
            messageId: \is_scalar($messageId) ? (string) $messageId : null,
            customId: $this->nonEmpty($item['CustomID'] ?? null),
            payload: $this->nonEmpty($item['Payload'] ?? null),
            reason: $this->nonEmpty($item['smtp_reply'] ?? null)
                ?? $this->nonEmpty(\trim(($this->nonEmpty($item['error_related_to'] ?? null) ?? '').' '.($this->nonEmpty($item['error'] ?? null) ?? ''))),
            permanent: $permanent,
            raw: $item,
        );
    }

    private function nonEmpty(mixed $value): ?string
    {
        return \is_string($value) && \trim($value) !== '' ? $value : null;
    }
}
