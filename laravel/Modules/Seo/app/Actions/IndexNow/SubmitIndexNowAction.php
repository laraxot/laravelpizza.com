<?php

declare(strict_types=1);

namespace Modules\Seo\Actions\IndexNow;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Seo\Datas\SeoConfigData;
use Spatie\QueueableAction\QueueableAction;

use function Safe\parse_url;

/**
 * Avvisa i motori IndexNow (Bing, Yandex, Seznam, Naver…) che delle URL del sito sono nuove o cambiate.
 *
 * Un solo invio a `api.indexnow.org` basta: i motori aderenti se lo condividono. Bing alimenta anche la ricerca di
 * ChatGPT e Copilot, quindi una pagina nuova arriva li' senza aspettare il crawler. Google non aderisce: per Google
 * restano sitemap e Search Console.
 *
 * @contract docs/contracts/submit-index-now-action.md
 *
 * @see Modules/Seo/docs/adr/search-engine-presence.md
 */
final class SubmitIndexNowAction
{
    use QueueableAction;

    /** Limite del protocollo per una singola richiesta. */
    public const int MAX_URLS_PER_REQUEST = 10000;

    public const string DEFAULT_ENDPOINT = 'https://api.indexnow.org/indexnow';

    /**
     * @param  list<string>  $urls  URL assolute; quelle di un altro host si scartano
     * @return array{submitted: int, skipped: int, statuses: list<int>}
     */
    public function execute(array $urls): array
    {
        $key = SeoConfigData::make()->indexNowKey();
        $host = $this->siteHost();
        if ($key === null || $host === null) {
            return ['submitted' => 0, 'skipped' => count($urls), 'statuses' => []];
        }

        $valid = [];
        foreach ($urls as $url) {
            if (filter_var($url, FILTER_VALIDATE_URL) !== false && $this->hostOf($url) === $host) {
                $valid[$url] = true;
            }
        }
        $valid = array_keys($valid);

        $statuses = [];
        $submitted = 0;
        foreach (array_chunk($valid, self::MAX_URLS_PER_REQUEST) as $chunk) {
            $status = $this->post($host, $key, $chunk);
            $statuses[] = $status;
            // 200 = ricevute; 202 = ricevute, chiave in verifica (primo invio).
            if ($status === 200 || $status === 202) {
                $submitted += count($chunk);
            }
        }

        return ['submitted' => $submitted, 'skipped' => count($urls) - count($valid), 'statuses' => $statuses];
    }

    /**
     * @param  list<string>  $urls
     * @return int codice HTTP della risposta; 0 se il servizio non e' raggiungibile
     */
    private function post(string $host, string $key, array $urls): int
    {
        try {
            $response = Http::timeout(15)
                ->acceptJson()
                ->asJson()
                ->post($this->endpoint(), [
                    'host' => $host,
                    'key' => $key,
                    // Stesso schema e host delle URL inviate: dietro un proxy `url()` puo' restituire http.
                    'keyLocation' => $this->schemeOf($urls[0]).'://'.$host.'/'.$key.'.txt',
                    'urlList' => $urls,
                ]);
        } catch (ConnectionException $exception) {
            Log::warning('IndexNow unreachable', ['error' => $exception->getMessage(), 'urls' => count($urls)]);

            return 0;
        }

        if (! in_array($response->status(), [200, 202], true)) {
            Log::warning('IndexNow refused the submission', ['status' => $response->status(), 'urls' => count($urls)]);
        }

        return $response->status();
    }

    private function siteHost(): ?string
    {
        return $this->hostOf(url('/'));
    }

    private function hostOf(string $url): ?string
    {
        $host = parse_url($url, PHP_URL_HOST);

        return is_string($host) && $host !== '' ? strtolower($host) : null;
    }

    private function schemeOf(string $url): string
    {
        return parse_url($url, PHP_URL_SCHEME) === 'http' ? 'http' : 'https';
    }

    private function endpoint(): string
    {
        return self::DEFAULT_ENDPOINT;
    }
}
