<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;

uses(TestCase::class);

/*
 * Test di accettazione del PRD (_bmad-output/planning-artifacts/prds/.../prd.md, §4.4–4.6): ogni test verifica una
 * "Consequence (testable)" scritta nel PRD, sulle pagine pubbliche vere.
 */

/** Pagine pubbliche core (slug senza lingua). */
const PRD_CORE_PAGES = ['', 'events', 'events/past', 'about', 'contact', 'privacy', 'terms', 'cookie-policy'];

function prdEvent(): Event
{
    return Event::query()->create([
        'title' => 'Serata PRD '.uniqid(),
        'slug' => 'serata-prd-'.uniqid(),
        'description' => 'Evento per i test di accettazione del PRD.',
        'location' => 'Torino',
        'status' => 'published',
        'max_attendees' => 30,
        'attendees_count' => 0,
        'start_date' => now()->addDays(20),
        'end_date' => now()->addDays(20)->addHours(2),
    ]);
}

/** @return array{title: string, description: string, canonical: string, lang: string} */
function prdHead(string $html): array
{
    preg_match('#<title>(.*?)</title>#s', $html, $title);
    preg_match('#<meta name="description" content="([^"]*)"#', $html, $description);
    preg_match('#<link rel="canonical" href="([^"]*)"#', $html, $canonical);
    preg_match('#<html lang="([^"]*)"#', $html, $lang);

    return [
        'title' => html_entity_decode(trim($title[1] ?? '')),
        'description' => trim($description[1] ?? ''),
        'canonical' => $canonical[1] ?? '',
        'lang' => $lang[1] ?? '',
    ];
}

// FR-15 — ogni pagina pubblica su /it/{slug} e /en/{slug}, nella lingua corrispondente.
test('FR-15: every core page answers in Italian and in English', function (string $locale): void {
    foreach ([...PRD_CORE_PAGES, 'events/'.prdEvent()->slug] as $slug) {
        $response = $this->get(rtrim('/'.$locale.'/'.$slug, '/'));
        $response->assertOk();
        expect(prdHead((string) $response->getContent())['lang'])->toBe($locale, "/{$locale}/{$slug}");
    }
})->with(['it', 'en']);

// FR-15 — URL senza prefisso: redirect alla lingua del browser se supportata, altrimenti a quella di default.
test('FR-15: a URL without locale redirects to the browser language or to the default one', function (): void {
    $this->withHeader('Accept-Language', 'it-IT,it;q=0.9')->get('/events?city=Torino')->assertRedirect('/it/events?city=Torino');
    $this->withHeader('Accept-Language', 'en-GB,en;q=0.9')->get('/about')->assertRedirect('/en/about');
    $this->withHeader('Accept-Language', 'ja')->get('/contact')->assertRedirect('/it/contact');
    // Un percorso che non esiste come pagina resta 404: niente rimbalzi.
    $this->get('/questa/pagina/non/esiste')->assertNotFound();
});

// FR-16 — cambiare lingua dal selettore mantiene la stessa pagina (stesso slug), non riporta alla home.
test('FR-16: the language selector points to the same page in every language', function (): void {
    foreach (['events', 'about', 'events/'.prdEvent()->slug] as $slug) {
        $html = (string) $this->get('/it/'.$slug)->getContent();
        foreach (['en', 'de', 'fr', 'es', 'ru'] as $other) {
            expect($html)->toContain('href="'.url('/'.$other.'/'.$slug).'"');
        }
    }
});

// FR-20 — title univoco, meta description non vuota, canonical sull'URL localizzato corrente.
test('FR-20: every core page has a unique title, a description and a localized canonical', function (string $locale): void {
    $titles = [];
    foreach ([...PRD_CORE_PAGES, 'events/'.prdEvent()->slug] as $slug) {
        $url = rtrim('/'.$locale.'/'.$slug, '/');
        $head = prdHead((string) $this->get($url)->getContent());

        expect($head['title'])->not->toBe('', $url)
            ->and($head['description'])->not->toBe('', $url)
            ->and($head['canonical'])->toBe(url($url), $url);
        $titles[$head['title']][] = $url;
    }

    $duplicates = array_filter($titles, static fn (array $urls): bool => count($urls) > 1);
    expect($duplicates)->toBe([], 'Titoli uguali su più pagine: '.json_encode($duplicates, JSON_UNESCAPED_SLASHES));
})->with(['it', 'en']);

test('FR-20: each page links its versions in the other languages (hreflang), without query string', function (): void {
    $html = (string) $this->get('/it/events?city=Torino')->getContent();

    foreach (['it', 'en', 'de', 'fr', 'es', 'ru'] as $code) {
        expect($html)->toContain('<link rel="alternate" hreflang="'.$code.'" href="'.url('/'.$code.'/events').'">');
    }
    expect($html)->toContain('<link rel="alternate" hreflang="x-default" href="'.url('/it/events').'">');
});

// FR-14 — una modifica al JSON di una pagina è visibile senza build, migrazioni o riavvii.
test('FR-14: editing the JSON of a CMS page is visible on the next request', function (): void {
    // Il percorso lo decide il tenant; nei test è una copia sotto storage, quindi niente file nuovi in config/.
    $path = app(GetTenantFilePathAction::class)->execute('database/content/pages/prd-fr14-check.json');
    $write = static function (string $title) use ($path): void {
        $block = ['type' => 'hero', 'slug' => 'hero', 'data' => ['view' => 'pub_theme::components.blocks.hero.main', 'title' => $title]];
        File::put($path, (string) json_encode([
            'id' => 'prd-fr14-check',
            'slug' => 'prd-fr14-check',
            'title' => ['it' => 'Controllo FR-14', 'en' => 'FR-14 check'],
            'content_blocks' => ['it' => [$block], 'en' => [$block]],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    };

    // Page (Sushi) legge i JSON quando il modello si avvia, una volta per processo PHP: con PHP-FPM a ogni richiesta.
    // Qui tutte le richieste girano nello stesso processo, quindi si azzera lo stato come farebbe un processo nuovo.
    // Con Octane o worker persistenti servirebbe la stessa invalidazione (docs/deploy/runbook.md).
    $newProcess = static fn () => Model::clearBootedModels();

    try {
        $write('Prima versione del titolo');
        $newProcess();
        $this->get('/it/prd-fr14-check')->assertOk()->assertSee('Prima versione del titolo');

        $write('Seconda versione del titolo');
        $newProcess();
        $this->get('/it/prd-fr14-check')->assertOk()->assertSee('Seconda versione del titolo')->assertDontSee('Prima versione del titolo');
    } finally {
        File::delete($path);
        $newProcess();
    }
});

// FR-18 — nessun cookie non essenziale prima del consenso: solo sessione e token CSRF.
test('FR-18: a first visit sets only the technical cookies', function (): void {
    $response = $this->get('/it/events');

    $names = array_map(static fn ($cookie): string => $cookie->getName(), $response->headers->getCookies());
    $technical = ['XSRF-TOKEN', (string) config('session.cookie')];

    expect(array_values(array_diff($names, $technical)))->toBe([]);
});
