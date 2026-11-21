<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Assistant;

use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use Modules\AI\Models\AiAgentMessage;
use Modules\Meetup\Actions\Assistant\GetAssistantThreadIdAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Neuron\Agents\MeetupAssistant;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;
use NeuronAI\Chat\Messages\AssistantMessage;
use NeuronAI\Chat\Messages\Message;
use NeuronAI\Chat\Messages\ToolCallMessage;
use NeuronAI\Testing\FakeAIProvider;
use NeuronAI\Tools\ToolCall;

uses(TestCase::class);

/*
 * Assistente nel sito (story 7-5): endpoint AG-UI con il modello finto di neuron-ai. Schema dei test dalla demo
 * datomatic/laravelday-2026 (MIT). I tool sono quelli del server MCP, già coperti da Feature/Mcp.
 */

function fakeAssistant(Message ...$responses): FakeAIProvider
{
    $provider = new FakeAIProvider(...$responses);
    app()->instance(MeetupAssistant::class, app(MeetupAssistant::class)->setAiProvider($provider));

    return $provider;
}

function assistantToolCall(string $name, array $inputs): ToolCallMessage
{
    return new ToolCallMessage(null, [ToolCall::make(name: $name, callId: 'call_1', inputs: $inputs)]);
}

function assistantRun(User $user, array $overrides = []): TestResponse
{
    return test()->actingAs($user)->postJson('/meetup/assistant', [
        'threadId' => 'meetup-'.$user->id.'-thread',
        'runId' => 'run-'.uniqid(),
        'messages' => [['id' => 'm1', 'role' => 'user', 'content' => 'Che meetup ci sono a Bologna?']],
        'tools' => [],
        'context' => [],
        ...$overrides,
    ]);
}

/** @return list<array<string, mixed>> */
function assistantEvents(TestResponse $response): array
{
    return collect(explode("\n\n", trim((string) $response->streamedContent())))
        ->map(fn (string $frame): mixed => json_decode(str($frame)->after('data: ')->toString(), true))
        ->filter()
        ->values()
        ->all();
}

function assistantEvent(string $slugPrefix = 'assistente', array $overrides = []): Event
{
    return Event::query()->create(array_merge([
        'title' => 'Meetup assistente '.uniqid(),
        'slug' => $slugPrefix.'-'.uniqid(),
        'location' => 'Bologna',
        'status' => 'published',
        'max_attendees' => 20,
        'attendees_count' => 0,
        'start_date' => now()->addDays(12),
        'end_date' => now()->addDays(12)->addHours(3),
    ], $overrides));
}

test('the assistant endpoint requires a logged-in user', function (): void {
    $this->postJson('/meetup/assistant', [])->assertUnauthorized();
});

test('a user cannot talk in the thread of another user', function (): void {
    $provider = fakeAssistant(new AssistantMessage('mai'));
    [$owner, $intruder] = User::factory()->count(2)->create();

    assistantRun($intruder, ['threadId' => 'meetup-'.$owner->id.'-thread'])->assertForbidden();

    $provider->assertNothingSent();
});

test('a run without a message or a decision is rejected', function (): void {
    $provider = fakeAssistant();

    assistantRun(User::factory()->create(), ['messages' => []])->assertUnprocessable();

    $provider->assertNothingSent();
});

test('the assistant streams the answer and keeps the conversation on the server', function (): void {
    fakeAssistant(new AssistantMessage('Ciao! Posso aiutarti a trovare un meetup.'));
    $user = User::factory()->create();

    $response = assistantRun($user)->assertOk()->assertHeader('Content-Type', 'text/event-stream; charset=utf-8');
    $events = collect(assistantEvents($response));

    expect($events->pluck('type'))->toContain('RUN_STARTED', 'TEXT_MESSAGE_CONTENT', 'RUN_FINISHED')
        ->and($events->where('type', 'TEXT_MESSAGE_CONTENT')->pluck('delta')->implode(''))->toBe('Ciao! Posso aiutarti a trovare un meetup.')
        ->and(AiAgentMessage::query()->where('thread_id', 'meetup-'.$user->id.'-thread')->count())->toBe(2);
});

test('search_events runs without confirmation and returns the events for the cards', function (): void {
    $event = assistantEvent();
    fakeAssistant(assistantToolCall('search_events', ['city' => 'Bologna']), new AssistantMessage('Ecco cosa ho trovato.'));

    $result = collect(assistantEvents(assistantRun(User::factory()->create())))->firstWhere('type', 'TOOL_CALL_RESULT');

    expect($result['content'])->toContain($event->slug)->toContain('spots_left');
});

test('join_event waits for confirmation and registers only once approved', function (): void {
    Notification::fake();
    $user = User::factory()->create();
    $event = assistantEvent();
    $provider = fakeAssistant(assistantToolCall('join_event', ['slug' => $event->slug]), new AssistantMessage('Fatto, sei iscritto!'));

    $finished = collect(assistantEvents(assistantRun($user, ['runId' => 'run-1'])))->last();

    expect($finished['outcome']['type'])->toBe('interrupt')
        ->and($finished['outcome']['interrupts'][0]['message'])->toContain((string) $event->title)
        ->and(EventUser::query()->where('event_id', $event->id)->count())->toBe(0);

    $resume = ['resume' => [['interruptId' => 'call_1', 'status' => 'resolved', 'payload' => ['approved' => true]]]];
    $events = assistantEvents(assistantRun($user, ['runId' => 'run-2', ...$resume])->assertOk());

    expect(collect($events)->last()['type'])->toBe('RUN_FINISHED')
        ->and(EventUser::query()->where('event_id', $event->id)->where('user_id', (string) $user->id)->exists())->toBeTrue();
    $provider->assertCallCount(2);
});

test('a refused confirmation registers nothing', function (): void {
    $user = User::factory()->create();
    $event = assistantEvent();
    fakeAssistant(assistantToolCall('join_event', ['slug' => $event->slug]), new AssistantMessage('Va bene, non ti iscrivo.'));

    // Lo stream va letto, come fa il browser: il run salva la pausa solo quando lo stream arriva in fondo.
    $first = collect(assistantEvents(assistantRun($user, ['runId' => 'run-1'])))->last();
    expect($first['outcome']['type'])->toBe('interrupt');

    $resume = ['resume' => [['interruptId' => 'call_1', 'status' => 'resolved', 'payload' => ['approved' => false]]]];
    $events = assistantEvents(assistantRun($user, ['runId' => 'run-2', ...$resume])->assertOk());

    expect(collect($events)->last()['type'])->toBe('RUN_FINISHED')
        ->and(EventUser::query()->where('event_id', $event->id)->count())->toBe(0);
});

test('the thread id is minted by the server, bound to the user and renewable', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);
    $action = app(GetAssistantThreadIdAction::class);

    $first = $action->execute((string) $user->id);

    expect($first)->toStartWith('meetup-'.$user->id.'-')
        ->and($action->execute((string) $user->id))->toBe($first)
        ->and($action->execute((string) $user->id, fresh: true))->not->toBe($first)
        ->and($action->execute('altro-utente'))->toStartWith('meetup-altro-utente-');
});
