<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;
use Modules\Notify\Datas\SmsData;
use Spatie\QueueableAction\QueueableAction;

class NetfunSendAction
{
    use QueueableAction;

    public string $token;

    public array $vars = [];

    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
        $token = config('services.netfun.token');
        if (!is_string($token)) {
            throw new Exception('put [NETFUN_TOKEN] variable to your .env and config [services.netfun.token] ');
        }
        $this->token = $token;
    }

    /**
     * Execute the action.
     */
    public function execute(SmsData $smsData): array
    {
        $endpoint = 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json';
        $headers = [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json',
        ];

        // dddx([ord($this->body[0]), $this->body]);

        $smsData->to .= '';
        if (Str::startsWith($smsData->to, '00')) {
            $smsData->to = '+39' . mb_substr($smsData->to, 2);
        }

        if (!Str::startsWith($smsData->to, '+')) {
            $smsData->to = '+39' . $smsData->to;
        }

        $body = [
            'api_token' => $this->token,
            // "gateway"=> 99,
            'sender' => $smsData->from,
            'text_template' => $smsData->body, // .'  '.rand(1, 100),
            /*
             * 'delivery_callback' => 'https://www.google.com?code={{code}}',
             * 'default_placeholders' => [
             * 'code' => '0000',
             * ],
             */
            'async' => true,
            // 'max_sms_length' => 1,
            'utf8_enabled' => true,
            'destinations' => [
                [
                    'number' => $smsData->to,
                    /*
                     * 'placeholders' => [
                     * 'fullName' => 'Santi',
                     * 'body' => 'Ciao, hai vinto il premio',
                     * 'code' => '1234',
                     * ],
                     */
                ],
            ],
        ];

        // dddx($body);

        $client = new Client($headers);
        try {
            $response = $client->post($endpoint, ['json' => $body]);
        } catch (ClientException $clientException) {
            throw new Exception(
                $clientException->getMessage() . '[' . __LINE__ . '][' . class_basename($this) . ']',
                $clientException->getCode(),
                $clientException,
            );
        }

        /*
         * echo '<hr/>';
         * echo '<pre>to: '.$this->to.'</pre>';
         * echo '<pre>body: '.$this->body.'</pre>';
         * echo '<pre>'.var_export($response->getStatusCode(), true).'</pre>';
         * echo '<pre>'.var_export($response->getBody()->getContents(), true).'</pre>';
         */

        $this->vars['status_code'] = $response->getStatusCode();
        $this->vars['status_txt'] = $response->getBody()->getContents();

        return $this->vars;
    }
}
