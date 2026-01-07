<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use GuzzleHttp\Client;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SMS\AgiletelecomData;
use Modules\Notify\Datas\SmsData;
use Override;

/**
 * Azione per l'invio di SMS tramite Agile Telecom.
 *
 * @see https://account.agiletelecom.com/public/resources/HTTP_POST_IT.pdf
 */
class SendAgiletelecomSMSv1Action implements SmsActionContract
{
    #[Override]
    public function execute(SmsData $data): array
    {
        $agile = AgiletelecomData::make();
        $url = 'https://secure.agiletelecom.com/securesend_v1.aspx';
        $recipient = app(NormalizePhoneNumberAction::class)->execute($data->recipient);

        $payload = [
            'smsTEXT' => $data->body,
            'smsNUMBER' => $recipient,
            'smsSENDER' => $agile->sender,
            'smsGATEWAY' => 'H', // M = Qualità standard, H = Qualità Alta
            'smsUSER' => $agile->username,
            'smsPASSWORD' => $agile->password,
        ];

        $headers = [
            'Accept-Encoding' => 'gzip, deflate',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ];

        $client = new Client([
            'timeout' => 2.0,
            'headers' => $headers,
        ]);

        $client->post($url, ['form_params' => $payload]);

        return [];
    }
}
