<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Actions\Event\SearchPublicEventsAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

/*
 * PRD FR-5 (prossimi eventi), FR-6 (eventi passati), FR-8 (filtri per citta' e data).
 */

function listedEvent(string $title, string $city, string $start, string $status = 'published'): Event
{
    return Event::query()->create([
        'title' => $title,
        'location' => $city,
        'start_date' => now()->modify($start),
        'end_date' => now()->modify($start)->addHours(2),
        'status' => $status,
    ]);
}

test('the public list shows only published upcoming events, nearest first', function (): void {
    $tag = uniqid();
    $later = listedEvent("Dopo $tag", 'Milano', '+20 days');
    $sooner = listedEvent("Prima $tag", 'Roma', '+3 days');
    listedEvent("Bozza $tag", 'Roma', '+5 days', 'draft');
    listedEvent("Passato $tag", 'Roma', '-5 days');

    $titles = app(SearchPublicEventsAction::class)->execute('upcoming')
        ->filter(fn (Event $e): bool => str_contains($e->title, $tag))
        ->pluck('title')->values()->all();

    expect($titles)->toBe([$sooner->title, $later->title]);
});

test('past events are listed most recent first and never include drafts', function (): void {
    $tag = uniqid();
    $old = listedEvent("Vecchio $tag", 'Torino', '-60 days');
    $recent = listedEvent("Recente $tag", 'Torino', '-2 days');
    listedEvent("Bozza passata $tag", 'Torino', '-10 days', 'draft');
    listedEvent("Futuro $tag", 'Torino', '+10 days');

    $titles = app(SearchPublicEventsAction::class)->execute('past')
        ->filter(fn (Event $e): bool => str_contains($e->title, $tag))
        ->pluck('title')->values()->all();

    expect($titles)->toBe([$recent->title, $old->title]);
});

test('events can be filtered by city and by date range, invalid values are ignored', function (): void {
    $tag = uniqid();
    $city = 'Citta '.$tag;
    $inRange = listedEvent("In range $tag", $city, '+10 days');
    listedEvent("Fuori range $tag", $city, '+40 days');
    listedEvent("Altra citta $tag", 'Bari', '+10 days');
    $search = app(SearchPublicEventsAction::class);

    $byCity = $search->execute('upcoming', ['city' => $city])->pluck('title')->all();
    $byRange = $search->execute('upcoming', [
        'city' => $city,
        'from' => now()->addDays(5)->format('Y-m-d'),
        'until' => now()->addDays(15)->format('Y-m-d'),
    ])->pluck('title')->all();
    $garbage = $search->execute('upcoming', ['city' => $city, 'from' => 'ieri', 'until' => ['x']])->pluck('title')->all();

    expect($byCity)->toHaveCount(2)
        ->and($byRange)->toBe([$inRange->title])
        ->and($garbage)->toHaveCount(2)
        ->and($search->cities('upcoming'))->toContain($city);
});

test('the events pages render with filters, and the past page links back', function (): void {
    $tag = uniqid();
    $city = 'Paginopoli '.$tag;
    listedEvent("Meetup filtrato $tag", $city, '+7 days');
    listedEvent("Meetup altrove $tag", 'Altrove '.$tag, '+7 days');

    $this->get('/it/events?city='.urlencode($city))
        ->assertOk()
        ->assertSee('name="city"', false)
        ->assertSee("Meetup filtrato $tag")
        ->assertDontSee("Meetup altrove $tag")
        ->assertSee('/it/events-past', false);

    $this->get('/en/events-past')->assertOk()->assertSee('/en/events', false);
});

test('a filter with no matches explains it and offers to clear the filters', function (): void {
    $this->get('/it/events?city='.urlencode('Nessuna-'.uniqid()))
        ->assertOk()
        ->assertSee(__('pub_theme::events.search.no_results', [], 'it'))
        ->assertSee(__('pub_theme::events.search.reset', [], 'it'));
});
