<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Livewire\Livewire;
use Modules\Meetup\Actions\Profile\CreateOwnAssistantTokenAction;
use Modules\Meetup\Actions\Profile\RevokeOwnAssistantTokenAction;
use Modules\Meetup\Http\Livewire\AssistantTokens;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

/*
 * "Collega un assistente AI" (story 7-5, AC6): CMS pages/profile/assistants.json -> /{lingua}/profile/assistants.
 * L'utente crea e revoca da solo i token personali Passport con cui i client MCP usano /api/mcp a suo nome.
 */

beforeEach(function (): void {
    // Passport firma i token con le sue chiavi: in CI non ci sono finché non si generano (come in deploy).
    if (! is_file(storage_path('oauth-private.key'))) {
        $this->artisan('passport:keys', ['--no-interaction' => true])->assertSuccessful();
    }
});

test('the page is a CMS sub-page that requires login and is linked from the edit page', function (): void {
    $this->get('/it/profile/assistants')->assertRedirect('/it/auth/login');

    $user = User::factory()->create();
    $this->actingAs($user)->get('/it/profile/assistants')
        ->assertOk()
        ->assertSee('<title>Collega un assistente AI - Laravel Pizza Meetups</title>', false)
        ->assertSee(url('/api/mcp'))
        ->assertSee('Non hai ancora nessun token');
    $this->actingAs($user)->get('/en/profile/assistants')->assertOk()->assertSee('Connect an AI assistant');
    $this->actingAs($user)->get('/it/profile/edit')->assertOk()->assertSee('/it/profile/assistants');
});

test('a user creates a token, sees it once and it works on the MCP endpoint', function (): void {
    $user = User::factory()->create();

    $component = Livewire::actingAs($user)->test(AssistantTokens::class)
        ->set('name', 'Claude sul portatile')
        ->call('create')
        ->assertHasNoErrors()
        ->assertSee('Token creato: copialo adesso')
        ->assertSee('Claude sul portatile');

    $plain = $component->get('plainToken');
    expect($plain)->toBeString()->not->toBeEmpty()
        ->and($user->tokens()->where('revoked', false)->count())->toBe(1);

    $initialize = ['jsonrpc' => '2.0', 'id' => 1, 'method' => 'initialize', 'params' => ['protocolVersion' => '2025-06-18', 'capabilities' => new \stdClass, 'clientInfo' => ['name' => 'pest', 'version' => '1']]];
    $this->withHeader('Authorization', 'Bearer '.$plain)->postJson('/api/mcp', $initialize)->assertOk();

    // Dopo "Fatto" il token in chiaro sparisce: nel database c'è solo l'identificativo.
    $component->call('dismiss')->assertDontSee($plain)->assertSee('Claude sul portatile');
});

test('the token name is required', function (): void {
    Livewire::actingAs(User::factory()->create())->test(AssistantTokens::class)
        ->set('name', '   ')
        ->call('create')
        ->assertHasErrors(['name' => 'required']);
});

test('revoking a token stops the MCP access immediately', function (): void {
    $user = User::factory()->create();
    $component = Livewire::actingAs($user)->test(AssistantTokens::class)->set('name', 'Cursor')->call('create');
    $plain = $component->get('plainToken');
    $id = (string) $user->tokens()->firstOrFail()->getKey();

    $component->call('revoke', $id)->assertSee('Token revocato.')->assertSee('Non hai ancora nessun token');

    expect($user->tokens()->where('revoked', false)->count())->toBe(0);
    app('auth')->forgetGuards();
    $this->withHeader('Authorization', 'Bearer '.$plain)->postJson('/api/mcp', [])->assertUnauthorized();
});

test('a user cannot revoke the token of someone else', function (): void {
    [$owner, $other] = User::factory()->count(2)->create();
    $id = app(CreateOwnAssistantTokenAction::class)->execute($owner, 'Claude')['id'];

    expect(app(RevokeOwnAssistantTokenAction::class)->execute($other, $id))->toBeFalse()
        ->and($owner->tokens()->where('revoked', false)->count())->toBe(1);
});
