<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Feature\IndexNow;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Modules\Seo\Actions\IndexNow\ServeIndexNowKeyAction;
use Modules\Seo\Actions\IndexNow\SubmitIndexNowAction;
use Modules\Seo\Console\Commands\SubmitIndexNowCommand;
use Modules\Seo\Contracts\SitemapLastModifiedContract;
use Modules\Seo\Contracts\SitemapPathsContract;
use Modules\Seo\Tests\Support\FakeTenantSeoConfig;
use Modules\Seo\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Safe\DateTimeImmutable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use function Safe\json_encode;
use function Safe\preg_match;

uses(TestCase::class);

/*
 * IndexNow: file di verifica e invio delle URL. Contratto: Modules/Seo/docs/contracts/submit-index-now-action.md
 *
 * @see Modules/Seo/docs/adr/search-engine-presence.md
 */

const INDEXNOW_TEST_KEY = 'a1b2c3d4e5f60718293a4b5c6d7e8f90';

beforeEach(function (): void {
    config(['app.url' => 'https://civic.example']);
    url()->useOrigin('https://civic.example');
    url()->forceScheme('https');
    Storage::fake('local');
});

it('serves the key file only for the configured key', function (): void {
    FakeTenantSeoConfig::bind(['indexnow_key' => INDEXNOW_TEST_KEY]);

    $response = (new ServeIndexNowKeyAction)(INDEXNOW_TEST_KEY);
    Assert::assertSame(200, $response->getStatusCode());
    Assert::assertSame(INDEXNOW_TEST_KEY, $response->getContent());

    expect(fn () => (new ServeIndexNowKeyAction)('ffffffffffffffff'))->toThrow(NotFoundHttpException::class);
});

it('serves no key file when IndexNow is off or the key is malformed', function (?string $key): void {
    FakeTenantSeoConfig::bind(['indexnow_key' => $key]);

    expect(fn () => (new ServeIndexNowKeyAction)('a1b2c3d4'))->toThrow(NotFoundHttpException::class);
})->with([
    'no key' => [null],
    'too short' => ['a1b2c3'],
    'bad characters' => ['a1b2c3d4 e5f6/../'],
]);

it('submits only urls of the site host, once each, to the shared endpoint', function (): void {
    FakeTenantSeoConfig::bind(['indexnow_key' => INDEXNOW_TEST_KEY]);
    Http::fake(['api.indexnow.org/*' => Http::response('', 202)]);

    $result = app(SubmitIndexNowAction::class)->execute([
        'https://civic.example/it/tickets/1',
        'https://civic.example/it/tickets/1',
        'https://other.example/it/tickets/2',
        'not a url',
    ]);

    Assert::assertSame(['submitted' => 1, 'skipped' => 3, 'statuses' => [202]], $result);
    Http::assertSent(static fn (Request $request): bool => $request->url() === SubmitIndexNowAction::DEFAULT_ENDPOINT
        && $request['host'] === 'civic.example'
        && $request['key'] === INDEXNOW_TEST_KEY
        && $request['keyLocation'] === 'https://civic.example/'.INDEXNOW_TEST_KEY.'.txt'
        && $request['urlList'] === ['https://civic.example/it/tickets/1']);
});

it('sends nothing without a key and reports a refused submission', function (): void {
    Http::fake(['api.indexnow.org/*' => Http::response('', 403)]);

    FakeTenantSeoConfig::bind([]);
    Assert::assertSame(['submitted' => 0, 'skipped' => 1, 'statuses' => []], app(SubmitIndexNowAction::class)->execute(['https://civic.example/it']));
    Http::assertNothingSent();

    FakeTenantSeoConfig::bind(['indexnow_key' => INDEXNOW_TEST_KEY]);
    Assert::assertSame(['submitted' => 0, 'skipped' => 0, 'statuses' => [403]], app(SubmitIndexNowAction::class)->execute(['https://civic.example/it']));
});

it('splits large submissions at the protocol limit', function (): void {
    FakeTenantSeoConfig::bind(['indexnow_key' => INDEXNOW_TEST_KEY]);
    Http::fake(['api.indexnow.org/*' => Http::response('', 200)]);

    $urls = array_map(static fn (int $id): string => 'https://civic.example/it/tickets/'.$id, range(1, SubmitIndexNowAction::MAX_URLS_PER_REQUEST + 1));
    $result = app(SubmitIndexNowAction::class)->execute($urls);

    Assert::assertSame(SubmitIndexNowAction::MAX_URLS_PER_REQUEST + 1, $result['submitted']);
    Assert::assertSame([200, 200], $result['statuses']);
});

it('keeps the sitemap state untouched when urls are passed by hand', function (): void {
    FakeTenantSeoConfig::bind(['indexnow_key' => INDEXNOW_TEST_KEY]);
    Http::fake(['api.indexnow.org/*' => Http::response('', 200)]);
    $state = '{"https://civic.example/it/a":"2026-01-01T00:00:00+00:00"}';
    Storage::disk('local')->put(SubmitIndexNowCommand::STATE_FILE, $state);

    Assert::assertSame(0, Artisan::call('seo:indexnow', ['--url' => ['https://civic.example/it/b']]));
    Assert::assertSame($state, Storage::disk('local')->get(SubmitIndexNowCommand::STATE_FILE));
    Http::assertSentCount(1);
});

it('resends a sitemap url only when its lastmod is newer than its last submission', function (): void {
    FakeTenantSeoConfig::bind(['indexnow_key' => INDEXNOW_TEST_KEY]);
    app()->instance(IndexNowProbeSource::class, new IndexNowProbeSource);
    app()->tag([IndexNowProbeSource::class], SitemapPathsContract::TAG);

    $pending = static function (string $sentAt): int {
        $state = [];
        foreach (['it', 'en', 'de', 'es'] as $locale) {
            $state['https://civic.example/'.$locale.'/zz-probe/1'] = $sentAt;
        }
        Storage::disk('local')->put(SubmitIndexNowCommand::STATE_FILE, json_encode($state));
        Artisan::call('seo:indexnow', ['--dry-run' => true]);
        $matches = [];
        preg_match('/(\d+) URL da inviare/', Artisan::output(), $matches);

        return isset($matches[1]) ? (int) $matches[1] : 0;
    };

    // Inviate prima della modifica (2026-03-01): tornano da inviare; inviate dopo: no.
    $before = $pending('2026-02-01T00:00:00+00:00');
    $after = $pending('2026-04-01T00:00:00+00:00');
    Assert::assertSame(4, $before - $after);
});

it('does nothing when IndexNow is off', function (): void {
    FakeTenantSeoConfig::bind([]);
    Http::fake();

    Assert::assertSame(0, Artisan::call('seo:indexnow'));
    Assert::assertStringContainsString('IndexNow spento', Artisan::output());
    Http::assertNothingSent();
});

/** Fonte di prova: una pagina con data di modifica nota. */
final class IndexNowProbeSource implements SitemapLastModifiedContract, SitemapPathsContract
{
    /** @return list<string> */
    public function execute(): array
    {
        return ['zz-probe/1'];
    }

    /** @return array<string, \DateTimeInterface> */
    public function lastModified(): array
    {
        return ['zz-probe/1' => new DateTimeImmutable('2026-03-01T00:00:00+00:00')];
    }
}
