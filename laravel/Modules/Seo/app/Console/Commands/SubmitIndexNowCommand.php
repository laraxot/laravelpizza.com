<?php

declare(strict_types=1);

namespace Modules\Seo\Console\Commands;

use DateTimeInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Modules\Seo\Actions\IndexNow\SubmitIndexNowAction;
use Modules\Seo\Actions\Sitemap\BuildSitemapAction;
use Modules\Seo\Datas\SeoConfigData;

use function Safe\json_decode;
use function Safe\json_encode;
use function Safe\preg_match;
use function Safe\preg_match_all;
use function Safe\strtotime;

/**
 * `php artisan seo:indexnow`: invia a IndexNow le URL della sitemap nuove o cambiate (`<lastmod>` piu' recente del
 * loro ultimo invio, #736). `--all` reinvia tutto, `--url=` invia URL precise, `--dry-run` conta senza inviare.
 *
 * Gira a ogni deploy (deploy.sh): IndexNow vuole URL nuove o cambiate, non la sitemap intera ogni volta. Lo stato e'
 * `storage/app/seo/indexnow-submitted.json`: URL => data dell'ultimo invio riuscito. Senza chiave non fa nulla.
 *
 * @see Modules/Seo/docs/adr/search-engine-presence.md
 * @see Modules/Seo/docs/contracts/submit-index-now-action.md
 */
final class SubmitIndexNowCommand extends Command
{
    public const string STATE_FILE = 'seo/indexnow-submitted.json';

    /** @var string */
    protected $signature = 'seo:indexnow {--all : reinvia tutte le URL della sitemap} {--url=* : URL da inviare} {--dry-run : conta senza inviare}';

    /** @var string */
    protected $description = 'Invia a IndexNow (Bing, Yandex, Seznam, Naver) le URL nuove della sitemap';

    public function handle(SubmitIndexNowAction $submit): int
    {
        if (SeoConfigData::make()->indexNowKey() === null) {
            $this->info('IndexNow spento: nessuna chiave in seo.indexnow_key.');

            return self::SUCCESS;
        }

        $explicit = $this->explicitUrls();
        $state = $this->submittedState();
        $urls = $explicit !== [] ? $explicit : $this->pendingUrls($this->option('all') === true ? [] : $state);

        if ($urls === []) {
            $this->info('Nessuna URL nuova o cambiata da inviare.');

            return self::SUCCESS;
        }
        if ($this->option('dry-run') === true) {
            $this->info(count($urls).' URL da inviare (dry run).');

            return self::SUCCESS;
        }

        $sentAt = now()->format(DateTimeInterface::ATOM);
        $result = $submit->execute($urls);
        $this->info($result['submitted'].' URL inviate, '.$result['skipped'].' scartate, risposte: '.implode(', ', $result['statuses']));

        if ($explicit === [] && $result['submitted'] === count($urls)) {
            $this->rememberSubmitted([...$state, ...array_fill_keys($urls, $sentAt)]);
        }

        return $result['submitted'] === count($urls) - $result['skipped'] ? self::SUCCESS : self::FAILURE;
    }

    /**
     * @return list<string>
     */
    private function explicitUrls(): array
    {
        $option = $this->option('url');

        return is_array($option) ? array_values(array_filter($option, is_string(...))) : [];
    }

    /**
     * URL della sitemap mai inviate o con `<lastmod>` successivo all'ultimo invio.
     *
     * @param  array<string, string>  $state  URL => data ATOM dell'ultimo invio
     * @return list<string>
     */
    private function pendingUrls(array $state): array
    {
        $pending = [];
        foreach ($this->sitemapEntries() as $url => $lastModified) {
            $sentAt = $state[$url] ?? null;
            if ($sentAt === null || ($lastModified !== null && strtotime($lastModified) > strtotime($sentAt))) {
                $pending[] = $url;
            }
        }

        return $pending;
    }

    /**
     * @return array<string, string|null> URL => `<lastmod>` (null se la pagina non ha una data vera)
     */
    private function sitemapEntries(): array
    {
        $blocks = [];
        preg_match_all('#<url>(.*?)</url>#s', app(BuildSitemapAction::class)->execute(), $blocks);

        $entries = [];
        foreach ($blocks[1] as $block) {
            $loc = [];
            $lastmod = [];
            if (preg_match('#<loc>([^<]+)</loc>#', $block, $loc) !== 1 || ! isset($loc[1])) {
                continue;
            }
            $url = html_entity_decode($loc[1], ENT_XML1 | ENT_QUOTES, 'UTF-8');
            $entries[$url] = preg_match('#<lastmod>([^<]+)</lastmod>#', $block, $lastmod) === 1 && isset($lastmod[1]) ? $lastmod[1] : null;
        }

        return $entries;
    }

    /**
     * @return array<string, string> URL => data ATOM dell'ultimo invio riuscito
     */
    private function submittedState(): array
    {
        $disk = Storage::disk('local');
        if (! $disk->exists(self::STATE_FILE)) {
            return [];
        }
        $data = json_decode((string) $disk->get(self::STATE_FILE), true);

        $state = [];
        foreach (is_array($data) ? $data : [] as $url => $sentAt) {
            if (is_string($url) && is_string($sentAt)) {
                $state[$url] = $sentAt;
            }
        }

        return $state;
    }

    /**
     * @param  array<string, string>  $state
     */
    private function rememberSubmitted(array $state): void
    {
        ksort($state);
        Storage::disk('local')->put(self::STATE_FILE, json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
