---
title: Agenti neuron-ai e protocollo AG-UI
module: AI
updated: 2026-11-19
---

# Agenti neuron-ai e protocollo AG-UI

Il modulo AI offre la base agnostica per gli **agenti con tool** che parlano col browser tramite
[AG-UI](https://docs.ag-ui.com). Il progetto scrive solo istruzioni e tool; tutto il resto è qui.
Il pattern viene dalla demo [datomatic/laravelday-2026](https://github.com/datomatic/laravelday-2026) (MIT).

| Pezzo | Classe | Cosa fa |
|---|---|---|
| Agente base | `Modules\AI\Neuron\Agents\XotBaseAgent` | fornitore, memoria, run in pausa, errori dei tool |
| Fornitore | `Actions\Agent\ResolveAgentProviderAction` | primo fornitore con chiave fra `assistant_providers` (Groq, poi OpenRouter), via `OpenAILike` |
| Endpoint AG-UI | `Actions\Agent\StreamAgentRunAction` | valida il RunAgentInput, controlla il thread, risponde in SSE |
| Tool MCP come tool dell'agente | `Neuron\Tools\McpToolAdapter` | avvolge un `Laravel\Mcp\Server\Tool`: stessa logica e stessi permessi del server MCP |
| Conversazioni | `Models\AiAgentMessage` (`ai_agent_messages`) | cronologia per thread, letta da `EloquentMessageStore` |
| Run in pausa | `Models\AiAgentRun` (`ai_agent_runs`) | stato del run in attesa di approvazione, letto da `EloquentPersistence` |

## Perché tabelle dedicate

`ai_threads`/`ai_messages` restano dell'assistente e della chat del pannello: hanno un altro schema
(utente, pannello, proposte). neuron-ai salva messaggi completi (tool call, risultati, metadati) e
riprende i run dopo un'approvazione: servono le colonne che si aspetta, con le sue regole
(`ai_agent_runs` senza cast, chiave `partition`+`key` univoca, cancellazioni fisiche).

## Come si usa in un progetto

```php
final class OperatorAssistant extends XotBaseAgent
{
    protected function instructions(): string { return '...'; }

    protected function tools(): array
    {
        return [
            new McpToolAdapter(app(ListWaitingConversationsTool::class)),
            (new McpToolAdapter(app(ReplyToConversationTool::class)))
                ->withApprovalPolicy(fn (): string => 'Invia una risposta al cliente'),
        ];
    }
}

// Action invocabile della rotta (web + auth):
return app(StreamAgentRunAction::class)->execute($request, app(OperatorAssistant::class), 'operator-'.$user->getKey().'-');
```

- Il **prefisso del thread** lega la conversazione all'utente: il browser genera
  `operator-{id}-{uuid}`, l'azione rifiuta con 403 un thread che non inizia col prefisso.
- Un tool con **approvazione** mette in pausa il run: il browser riceve l'interrupt, l'utente
  approva o rifiuta e il client rimanda il run con `resume`.
- Un tool che lancia un'eccezione risponde al modello con `Errore: ...` invece di fermare il run;
  `McpToolAdapter` trasforma già validazioni e autorizzazioni in errori del tool.

## Test

`tests/Unit/Agent`: scelta del fornitore, thread di altri utenti, turni vuoti, validazione.
