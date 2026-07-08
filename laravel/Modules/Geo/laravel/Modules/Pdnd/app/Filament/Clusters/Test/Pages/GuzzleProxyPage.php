<?php

declare(strict_types=1);

namespace Modules\Pdnd\Filament\Clusters\Test\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Filament\Clusters\Test;
use Modules\User\Models\User;
use Modules\Xot\Filament\Pages\XotBasePage;

/**
 * @property Schema $emailForm
 */
class GuzzleProxyPage extends XotBasePage
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'test' => TextInput::make('test'),
        ];
    }

    #[\Override]
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->submit('save'),
        ];
    }

    //     public function executeTest()
    //     {

    //         $url = 'https://auth.uat.interop.pagopa.it/token.oauth2';
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $url);
    //         // /////// PROXY
    //         curl_setopt($ch, CURLOPT_PROXY, 'http://proxy04:8080');
    //         curl_setopt($ch, CURLOPT_PROXYPORT, 8080);
    //         // curl_setopt ($ch, CURLOPT_PROXYUSERPWD, "sottanamarco:Strada07");
    //         curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'Administrator:pluto-1');
    //         // ////////////////////////////////
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    //         curl_setopt($ch, CURLOPT_HEADER, 1);
    //         curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)');
    //         // if ($usecookie) {
    //         //     curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);  // da controllare
    //         //     curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); // da controllare
    //         // }
    //         // @phpstan-ignore notEqual.alwaysFalse
    //         // if ($refer != '') {
    //         //     curl_setopt($ch, CURLOPT_REFERER, $refer);
    //         // }

    //         // ///////////////////////////////////////////////////////////////////////////////////////
    //         $fields_string = '';
    //         $fields = [
    //         //     'user' => $params['sigma_user'],
    //         //     'pwd' => $params['sigma_passwd'],
    //         ];

    // $fields_string = http_build_query($fields);

    //         curl_setopt($ch, CURLOPT_POST, \count($fields));
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

    //         $res = curl_exec($ch);

    //         dddx('test');
    //         dddx($res);
    //         // //////////////////////////////
    //         // if (! isset($filename)) {
    //         //     throw new Exception('!isset($filename)');
    //         // }
    //     }

    public function executeTest(): void
    {
        $client = new Client([
            'proxy' => 'http://Administrator:pluto-1@proxy04:8080',
            'verify' => false, // Disabilita verifica SSL (come in curl -k)
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'User-Agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)',
            ],
        ]);

        try {
            $response = $client->post('https://auth.uat.interop.pagopa.it/token.oauth2', [
                'form_params' => [
                    'client_id' => '6993a2cb-7cbe-45f0-bb26-1373b891f845',
                    'client_assertion' => 'eyJ0eXAiOiJKV1QiLCJraWQiOiJ2cmZLUWR4azM5cUlpZjBMUkpJWmNEMmc0cGwxY1hEYUoyVEE0Z29IdjhVIiwiYWxnIjoiUlMyNTYifQ.eyJpc3MiOiI2OTkzYTJjYi03Y2JlLTQ1ZjAtYmIyNi0xMzczYjg5MWY4NDUiLCJzdWIiOiI2OTkzYTJjYi03Y2JlLTQ1ZjAtYmIyNi0xMzczYjg5MWY4NDUiLCJhdWQiOiJhdXRoLnVhdC5pbnRlcm9wLnBhZ29wYS5pdC9jbGllbnQtYXNzZXJ0aW9uIiwicHVycG9zZUlkIjoiZjY3ZWI5NzEtZjhiZS00ZWE1LThjMjktZjI1MWU4M2FmOTI2IiwianRpIjoiZDg1ODg5ODcxODYwNDM2N2Q4YWE5YWE3NDgxYWZmNmEiLCJpYXQiOjE3NTI4Mjk2MjgsImV4cCI6MTc1NTQyMTYyOH0.tGLdAnGAqaJuBu8VENggMiG643Q2NQIEaIfk8AeNJtapp7v20K2XkicNDUAdSUziEjWN2nEt6QwJzsYVA76DbtYgqt-u22FKheOPARURmRnlvrTxZR-3Oj5VwZGEsC8juHKZgVTqPlS2bl_9Il72weGNHFSAJEwT0y4snCAUjfiyu3tbOCJYKeSkSmIr9U-sQxh1KCPeh9QiKoZ50ZCeJMloexcOxDjVwkN2IIqUFYGk5DJE92Pggx1nNLqY6A3U4s7FnIdf8AiFXcsujhFoYWGmQ-bt1rpsoAV-7oQnzXQ8qqeNMtHu1yEwSACiJEqcF1Yj0L4yOKR-e00DXPd5HA',
                    'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
                    'grant_type' => 'client_credentials',
                ],
                'debug' => true, // Equivalente a curl -vvv
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            Log::info('Response Status: '.$statusCode);
            Log::info('Response Body: '.$body);

            Notification::make()
                ->title('Success')
                ->body('Request completed with status: '.$statusCode)
                ->success()
                ->send();

            dddx([
                'status' => $statusCode,
                'response' => $body,
            ]);
        } catch (RequestException $e) {
            Log::error('Request failed: '.$e->getMessage());

            Notification::make()
                ->title('Error')
                ->body('Request failed: '.$e->getMessage())
                ->danger()
                ->send();

            $responseContent = null;
            if ($e->hasResponse()) {
                $errorResponse = $e->getResponse();
                if ($errorResponse !== null) {
                    $responseContent = $errorResponse->getBody()->getContents();
                }
            }

            dddx([
                'error' => $e->getMessage(),
                'response' => $responseContent,
            ]);
        }
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        if (! $user instanceof User) {
            return false;
        }

        return $user->hasRole('super-admin');
    }
}
