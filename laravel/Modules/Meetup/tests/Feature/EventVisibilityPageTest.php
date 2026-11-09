<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

/*
 * PRD FR-5 / FR-7 e security-audit S-01: bozze e pending non sono pubblici,
 * un evento inesistente risponde 404, il proprietario vede la propria bozza.
 */

function makeEvent(string $status, array $overrides = []): Event
{
    return Event::factory()->upcoming()->create(array_merge([
        'title' => ucfirst($status).' visibility event '.uniqid(),
        'slug' => $status.'-visibility-'.uniqid(),
        'status' => $status,
        'cover_image' => null,
        'url' => null,
        'offers' => null,
        'meta_data' => null,
        'keywords' => null,
    ], $overrides));
}

test('a draft event detail page is not public', function (): void {
    $event = makeEvent('draft');

    $this->get('/it/events/'.$event->slug)->assertNotFound();
});

test('a pending event detail page is not public', function (): void {
    $event = makeEvent('pending');

    $this->get('/it/events/'.$event->slug)->assertNotFound();
});

test('an unknown event slug returns 404', function (): void {
    $this->get('/it/events/does-not-exist-'.uniqid())->assertNotFound();
});

test('the owner can preview their own draft event', function (): void {
    $owner = User::factory()->create();
    $event = makeEvent('draft', ['user_id' => $owner->getKey()]);

    $this->actingAs($owner)
        ->get('/it/events/'.$event->slug)
        ->assertOk()
        ->assertSee($event->title);
});

test('the public events list shows only published upcoming events', function (): void {
    $published = makeEvent('published');
    $draft = makeEvent('draft');
    $past = makeEvent('published', [
        'start_date' => now()->subMonth(),
        'end_date' => now()->subMonth()->addHours(2),
    ]);

    $this->get('/it/events')
        ->assertOk()
        ->assertSee($published->title)
        ->assertDontSee($draft->title)
        ->assertDontSee($past->title);
});

test('event json-ld cannot break out of the script tag', function (): void {
    $event = makeEvent('published', ['title' => 'Pizza </script><script>alert(1)</script>']);

    $this->get('/it/events/'.$event->slug)
        ->assertOk()
        ->assertDontSee('</script><script>alert(1)</script>', false);
});

test('a CMS page that requires login sends guests to the login in their language', function (): void {
    // events-my.json dichiara middleware ["auth"]: prima non veniva applicato (rotta fallback di Folio).
    $this->get('/it/events-my')->assertRedirect('/it/auth/login');
});
