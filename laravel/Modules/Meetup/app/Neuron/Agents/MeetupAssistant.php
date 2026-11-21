<?php

declare(strict_types=1);

namespace Modules\Meetup\Neuron\Agents;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\AI\Neuron\Agents\XotBaseAgent;
use Modules\AI\Neuron\Tools\McpToolAdapter;
use Modules\Meetup\Mcp\Tools\JoinEventTool;
use Modules\Meetup\Mcp\Tools\LeaveEventTool;
use Modules\Meetup\Mcp\Tools\MyEventsTool;
use Modules\Meetup\Mcp\Tools\SearchEventsTool;
use Modules\Meetup\Mcp\Tools\ShowEventTool;
use Modules\Meetup\Models\Event;
use NeuronAI\Tools\ToolInterface;

/**
 * Assistente nel sito (story 7-5): risponde in chat sui meetup e iscrive l'utente collegato.
 *
 * Usa gli stessi tool del server MCP (Modules\Meetup\Mcp\Tools) attraverso McpToolAdapter del modulo AI: una sola
 * logica per sito, client MCP e chat. Iscrizione e cancellazione chiedono SEMPRE conferma all'utente (il run va in
 * pausa e la chat mostra "Conferma / Annulla"): la regola sta qui nel codice, non nelle istruzioni del modello.
 * Fornitore, memoria e run in pausa: XotBaseAgent (Groq o OpenRouter, solo modelli gratuiti).
 */
class MeetupAssistant extends XotBaseAgent
{
    protected function instructions(): string
    {
        $language = match (LaravelLocalization::getCurrentLocale()) {
            'en' => 'English',
            'de' => 'German',
            'fr' => 'French',
            'es' => 'Spanish',
            'ru' => 'Russian',
            default => 'Italian',
        };
        $today = now()->timezone('Europe/Rome')->toDateString();

        return <<<PROMPT
            You are the assistant of Laravel Pizza Meetups, in-person Laravel meetups in Italy. Today is {$today} (Europe/Rome).
            Always answer in {$language}, briefly and in a friendly tone.

            - Use the tools for every fact about events: never invent titles, dates, places or seats.
            - search_events finds events (use the "city" filter only with a value from "cities"); show_event gives details;
              my_events lists the registrations of the user.
            - The page shows the events returned by search_events, my_events and show_event as cards: do not repeat every
              field, write one short line on why they fit the request.
            - join_event and leave_event act for the user: call them only when the user asked for it. The page asks the
              user to confirm before they run.
            - If a tool returns an error, explain it in simple words and suggest what to do.
            - Only talk about Laravel Pizza Meetups and its events; for anything else say what you can help with.
            PROMPT;
    }

    /**
     * @return list<ToolInterface>
     */
    protected function tools(): array
    {
        return [
            new McpToolAdapter(app(SearchEventsTool::class)),
            new McpToolAdapter(app(ShowEventTool::class)),
            new McpToolAdapter(app(MyEventsTool::class)),
            (new McpToolAdapter(app(JoinEventTool::class)))
                ->withApprovalPolicy(static fn (ToolInterface $tool): string => self::approvalReason('join', $tool)),
            (new McpToolAdapter(app(LeaveEventTool::class)))
                ->withApprovalPolicy(static fn (ToolInterface $tool): string => self::approvalReason('leave', $tool)),
        ];
    }

    /**
     * Testo della richiesta di conferma: il titolo dell'evento che il modello vuole usare (dallo slug), così l'utente
     * conferma ciò che succederà davvero e non ciò che il modello ha scritto.
     */
    public static function approvalReason(string $action, ToolInterface $tool): string
    {
        $slug = $tool->getInputs()['slug'] ?? null;
        $title = is_string($slug) ? Event::query()->published()->where('slug', $slug)->value('title') : null;

        return (string) __('meetup::assistant.approval.'.$action, [
            'event' => is_string($title) ? $title : (is_string($slug) ? $slug : '—'),
        ]);
    }
}
