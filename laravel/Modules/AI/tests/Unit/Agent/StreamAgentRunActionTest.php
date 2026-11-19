<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Agent;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\AI\Actions\Agent\StreamAgentRunAction;
use Modules\AI\Neuron\Agents\XotBaseAgent;
use Modules\AI\Tests\TestCase;
use NeuronAI\Chat\Messages\AssistantMessage;
use NeuronAI\Testing\FakeAIProvider;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

uses(TestCase::class);

/**
 * Le verifiche avvengono prima di chiamare il modello: nessuna richiesta HTTP parte.
 */
function testAgent(): XotBaseAgent
{
    return app(TestXotAgent::class);
}

/** @param  array<string, mixed>  $payload */
function agUiRequest(array $payload): Request
{
    return Request::create('/agent', 'POST', $payload);
}

it('rifiuta il thread di un altro utente', function (): void {
    app(StreamAgentRunAction::class)->execute(
        agUiRequest(['threadId' => 'operator-2-abc', 'runId' => 'r1', 'messages' => [['id' => 'm1', 'role' => 'user', 'content' => 'ciao']]]),
        testAgent(),
        'operator-1-',
    );
})->throws(AccessDeniedHttpException::class);

it('rifiuta un turno senza messaggio e senza decisione', function (): void {
    app(StreamAgentRunAction::class)->execute(
        agUiRequest(['threadId' => 'operator-1-abc', 'runId' => 'r1', 'messages' => [['id' => 'm1', 'role' => 'assistant', 'content' => 'ciao']]]),
        testAgent(),
        'operator-1-',
    );
})->throws(HttpException::class);

it('accetta un turno con il messaggio dell\'utente (role e content non vanno persi nella validazione)', function (): void {
    $agent = testAgent()->setAiProvider(new FakeAIProvider(new AssistantMessage('ok')));

    $response = app(StreamAgentRunAction::class)->execute(
        agUiRequest(['threadId' => 'operator-1-abc', 'runId' => 'r1', 'messages' => [['id' => 'm1', 'role' => 'user', 'content' => 'ciao']]]),
        $agent,
        'operator-1-',
    );

    expect($response->getStatusCode())->toBe(200);
});

it('valida il RunAgentInput', function (): void {
    app(StreamAgentRunAction::class)->execute(agUiRequest(['runId' => 'r1']), testAgent(), 'operator-1-');
})->throws(ValidationException::class);

final class TestXotAgent extends XotBaseAgent
{
    protected function instructions(): string
    {
        return 'test';
    }
}
