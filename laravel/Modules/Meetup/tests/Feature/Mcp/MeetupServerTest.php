<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Mcp;

use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Modules\Meetup\Mcp\Prompts\FindMeetupPrompt;
use Modules\Meetup\Mcp\Resources\UpcomingEventsResource;
use Modules\Meetup\Mcp\Servers\MeetupServer;
use Modules\Meetup\Mcp\Tools\JoinEventTool;
use Modules\Meetup\Mcp\Tools\LeaveEventTool;
use Modules\Meetup\Mcp\Tools\MyEventsTool;
use Modules\Meetup\Mcp\Tools\SearchEventsTool;
use Modules\Meetup\Mcp\Tools\ShowEventTool;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Notifications\EventRegistrationConfirmedNotification;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

/*
 * Server MCP: i tool chiamano le stesse Action del sito. Idea dal talk "Apri la tua app agli agenti" (LaravelDay 2026,
 * github.com/datomatic/laravelday-2026). Docs: Modules/Meetup/docs/mcp-server.md
 */

function mcpEvent(array $overrides = []): Event
{
    return Event::query()->create(array_merge([
        'title' => 'Meetup MCP '.uniqid(),
        'slug' => 'meetup-mcp-'.uniqid(),
        'description' => 'Serata su agenti e MCP.',
        'location' => 'Bologna',
        'status' => 'published',
        'max_attendees' => 10,
        'attendees_count' => 0,
        'start_date' => now()->addDays(15),
        'end_date' => now()->addDays(15)->addHours(3),
    ], $overrides));
}

function mcpUser(string $lang = 'it'): User
{
    return User::factory()->create(['lang' => $lang]);
}

test('search_events returns published upcoming events with city filter and free seats', function (): void {
    $bologna = mcpEvent(['location' => 'Bologna', 'title' => 'Serata MCP Bologna']);
    mcpEvent(['location' => 'Palermo', 'title' => 'Serata MCP Palermo']);
    mcpEvent(['location' => 'Bologna', 'title' => 'Bozza MCP', 'status' => 'draft']);

    MeetupServer::tool(SearchEventsTool::class, ['city' => 'Bologna'])
        ->assertOk()
        ->assertSee('Serata MCP Bologna')
        ->assertDontSee('Serata MCP Palermo')
        ->assertDontSee('Bozza MCP')
        ->assertStructuredContent(fn (AssertableJson $json) => $json
            ->where('events.0.slug', $bologna->slug)
            ->where('events.0.spots_left', 10)
            ->where('events.0.is_full', false)
            ->etc());
});

test('search_events rejects invalid filters', function (): void {
    MeetupServer::tool(SearchEventsTool::class, ['timing' => 'tomorrow'])->assertHasErrors();
    MeetupServer::tool(SearchEventsTool::class, ['from' => '2026-12-10', 'until' => '2026-12-01'])->assertHasErrors();
});

test('show_event gives the public details and never the organizer email', function (): void {
    $organizer = User::factory()->create(['email' => 'segreta-'.uniqid().'@example.com']);
    $event = mcpEvent(['organizer_id' => $organizer->id]);

    MeetupServer::actingAs(mcpUser())->tool(ShowEventTool::class, ['slug' => $event->slug])
        ->assertOk()
        ->assertSee('Serata su agenti e MCP.')
        ->assertDontSee((string) $organizer->email)
        ->assertStructuredContent(fn (AssertableJson $json) => $json->where('registered', false)->etc());

    MeetupServer::tool(ShowEventTool::class, ['slug' => 'non-esiste'])->assertHasErrors(['search_events']);
    MeetupServer::tool(ShowEventTool::class, ['slug' => mcpEvent(['status' => 'draft'])->slug])->assertHasErrors();
});

test('join_event registers the user once, sends the confirmation and answers in the user language', function (): void {
    Notification::fake();
    $user = mcpUser('en');
    $event = mcpEvent();

    MeetupServer::actingAs($user)->tool(JoinEventTool::class, ['slug' => $event->slug])
        ->assertOk()->assertSee('confirmed');
    MeetupServer::actingAs($user)->tool(JoinEventTool::class, ['slug' => $event->slug])
        ->assertOk()->assertSee('already registered');

    expect(EventUser::query()->where('event_id', $event->id)->where('user_id', (string) $user->id)->count())->toBe(1)
        ->and($event->fresh()?->attendees_count)->toBe(1);
    Notification::assertSentToTimes($user, EventRegistrationConfirmedNotification::class, 1);

    MeetupServer::actingAs($user)->tool(MyEventsTool::class)
        ->assertOk()
        ->assertStructuredContent(fn (AssertableJson $json) => $json->where('events.0.slug', $event->slug)->etc());
});

test('join_event on a full event is an error and saves nothing', function (): void {
    $event = mcpEvent(['max_attendees' => 1, 'attendees_count' => 1]);

    MeetupServer::actingAs(mcpUser())->tool(JoinEventTool::class, ['slug' => $event->slug])
        ->assertHasErrors(['al completo']);

    expect(EventUser::query()->where('event_id', $event->id)->count())->toBe(0);
});

test('leave_event frees the seat; leaving twice is an error', function (): void {
    Notification::fake();
    $user = mcpUser();
    $event = mcpEvent();
    MeetupServer::actingAs($user)->tool(JoinEventTool::class, ['slug' => $event->slug])->assertOk();

    MeetupServer::actingAs($user)->tool(LeaveEventTool::class, ['slug' => $event->slug])->assertOk()->assertSee('annullata');
    MeetupServer::actingAs($user)->tool(LeaveEventTool::class, ['slug' => $event->slug])->assertHasErrors(['Non risulti iscritto']);

    expect($event->fresh()?->attendees_count)->toBe(0);
});

test('tools that act for a user need an authenticated user', function (): void {
    $event = mcpEvent();

    MeetupServer::tool(JoinEventTool::class, ['slug' => $event->slug])->assertHasErrors(['token']);
    MeetupServer::tool(MyEventsTool::class)->assertHasErrors(['token']);
});

test('the upcoming events resource and the find_meetup prompt', function (): void {
    $event = mcpEvent(['title' => 'Risorsa MCP']);

    MeetupServer::resource(UpcomingEventsResource::class)->assertOk()->assertSee('Risorsa MCP')->assertSee($event->slug);
    MeetupServer::prompt(FindMeetupPrompt::class, ['city' => 'Bologna', 'interests' => 'testing'])
        ->assertOk()->assertSee('Bologna')->assertSee('join_event');
});

test('the HTTP endpoint answers 401 without a token and works with a Passport token', function (): void {
    $initialize = [
        'jsonrpc' => '2.0', 'id' => 1, 'method' => 'initialize',
        'params' => ['protocolVersion' => '2025-06-18', 'capabilities' => new \stdClass, 'clientInfo' => ['name' => 'pest', 'version' => '1']],
    ];

    // Passport firma e verifica i token con le sue chiavi: in CI non ci sono finché non si generano (come in deploy).
    if (! is_file(storage_path('oauth-private.key'))) {
        $this->artisan('passport:keys', ['--no-interaction' => true])->assertSuccessful();
    }

    $this->postJson('/api/mcp', $initialize)->assertUnauthorized();

    Passport::actingAs(mcpUser(), [], 'api');
    $this->postJson('/api/mcp', $initialize)->assertOk()->assertSee('Laravel Pizza Meetups');
});
