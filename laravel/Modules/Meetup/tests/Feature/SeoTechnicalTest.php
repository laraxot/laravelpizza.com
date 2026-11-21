<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

/*
 * SEO tecnico (issue #584): dati strutturati degli eventi secondo Google Search Central, sitemap con le pagine evento,
 * robots.txt dinamico, home con Organization/WebSite e immagine social. Doc: docs/seo/.
 */

function seoEvent(array $overrides = []): Event
{
    return Event::query()->create(array_merge([
        'title' => 'Serata SEO '.uniqid(),
        'slug' => 'serata-seo-'.uniqid(),
        'description' => 'Talk su Laravel e pizza per i test SEO.',
        'location' => 'Bologna',
        'status' => 'published',
        'max_attendees' => 30,
        'attendees_count' => 0,
        'start_date' => now()->addDays(15)->setTime(19, 0),
        'end_date' => now()->addDays(15)->setTime(22, 0),
    ], $overrides));
}

/** @return list<array<string, mixed>> */
function seoJsonLd(string $html): array
{
    preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches);

    return array_values(array_filter(array_map(static fn (string $json): mixed => json_decode($json, true), $matches[1]), 'is_array'));
}

test('an event page publishes one complete Event, linked to the page by @id', function (): void {
    $event = seoEvent();
    $html = (string) $this->get('/it/events/'.$event->slug)->assertOk()->getContent();
    $blocks = collect(seoJsonLd($html));

    $events = $blocks->where('@type', 'Event')->values();
    $page = $blocks->firstWhere('@type', 'ItemPage');
    $markup = $events->first();
    $host = isset($markup['organizer']['@type']) ? $markup['organizer'] : $markup['organizer'][0];

    expect($events)->toHaveCount(1)
        ->and($markup['name'])->toBe($event->title)
        ->and($markup['startDate'])->toStartWith($event->start_date->format('Y-m-d\TH:i'))
        ->and($markup['location']['@type'])->toBe('Place')
        ->and($markup['location']['address']['@type'])->toBe('PostalAddress')
        ->and($markup['location']['address']['addressLocality'])->toBe('Bologna')
        ->and($markup['offers']['price'])->toBe(0)
        ->and($markup['offers']['priceCurrency'])->toBe('EUR')
        ->and($markup['offers']['availability'])->toBe('https://schema.org/InStock')
        ->and($host['@type'])->toBe('Organization')
        ->and($host['url'])->toBe(url('/'))
        ->and($page['mainEntity'])->toBe(['@id' => $markup['@id']]);
});

test('a full event is marked sold out', function (): void {
    $event = seoEvent(['max_attendees' => 2, 'attendees_count' => 2]);
    $markup = collect(seoJsonLd((string) $this->get('/it/events/'.$event->slug)->getContent()))->firstWhere('@type', 'Event');

    expect($markup['offers']['availability'])->toBe('https://schema.org/SoldOut');
});

test('the sitemap lists published events and not drafts', function (): void {
    $published = seoEvent();
    $draft = seoEvent(['status' => 'draft']);

    $xml = (string) $this->get('/sitemap.xml')->assertOk()->getContent();

    expect($xml)->toContain('<loc>'.url('/it/events/'.$published->slug).'</loc>')
        ->toContain('<loc>'.url('/en/events/'.$published->slug).'</loc>')
        ->not->toContain($draft->slug);
});

test('robots.txt points to the sitemap and keeps private areas out', function (): void {
    $robots = (string) $this->get('/robots.txt')->assertOk()->getContent();

    expect($robots)->toContain('Sitemap: '.url('/sitemap.xml'))
        ->toContain('Disallow: /*/admin')
        ->toContain('Disallow: /it/auth');
});

test('the home describes the site for search engines and social networks', function (string $locale, string $title): void {
    $html = (string) $this->get('/'.$locale)->assertOk()->getContent();
    $types = collect(seoJsonLd($html))->pluck('@type')->all();

    expect($html)->toContain('<title>'.$title.' — Laravel Pizza Meetups</title>')
        ->toContain('<meta property="og:site_name" content="Laravel Pizza Meetups">')
        ->toContain('images/social-share.jpg')
        ->toContain('<meta name="twitter:card" content="summary_large_image">')
        ->and($types)->toContain('Organization', 'WebSite');
})->with([
    'italiano' => ['it', 'Meetup Laravel gratuiti in Italia'],
    'inglese' => ['en', 'Free Laravel meetups in Italy'],
]);

test('anonymous visitors get the light stylesheet without Filament, login pages the full one', function (): void {
    $public = (string) $this->get('/it/events')->assertOk()->getContent();
    $login = (string) $this->get('/it/auth/login')->assertOk()->getContent();

    // Prestazioni = segnale di ranking: CSS e JS di Filament solo dove ci sono componenti Filament.
    expect($public)->toMatch('#themes/Meetup/assets/site-[^"]+\.css#')
        ->not->toContain('js/filament/support')
        ->and($login)->toMatch('#themes/Meetup/assets/app-[^"]+\.css#')
        ->toContain('js/filament/support');
});
