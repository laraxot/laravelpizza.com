<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Illuminate\Support\Facades\Http;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SMS\AgiletelecomData;
use Modules\Notify\Datas\SmsData;
use Override;

/**
 * Azione per l'invio di SMS tramite Agile Telecom.
 *
 * @see https://agiletelecom.com/docs/protocollo-http-post-e-get/
 */
class SendAgiletelecomSMSv2Action implements SmsActionContract
{
    #[Override]
    public function execute(SmsData $data): array
    {
        $agile = AgiletelecomData::make();

        $url = 'https://secure.agiletelecom.com/services/sms/send';
        $recipient = app(NormalizePhoneNumberAction::class)->execute($data->recipient);

        $payload = [
            // 'globalId' => $data->reference ?? uniqid('sms_', true),
            // 'maxIdLen' => 64,
            // 'enableConcatenated' => true,
            // 'enableUnicode' => true,
            // 'enableDelivery' => $config['enable_delivery'] ?? true,
            // 'simulation' => app()->environment('local', 'testing'),
            'messages' => [
                [
                    'destinations' => [$recipient],
                    // 'ids' => [$data->reference ?? uniqid('msg_', true)],
                    // 'sender' => $config['sender'],
                    'sender' => $agile->sender,
                    'body' => $data->body,
                    // 'hexBody' => false,
                ],
            ],
        ];

        // "{"globalId":"5a56f05b-a48c-41db-8fc2-063b53368e89","processedMessages":1,"processedSmsParts":1,"credit":9530.73}

        Http::withHeaders($agile->getAuthHeaders())->timeout($agile->timeout)->post($url, $payload);

        // dddx($response->body());

        return [];
    }
}
