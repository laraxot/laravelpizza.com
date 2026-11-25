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

## Interfacce generate (A2UI)

Fase C dell'integrazione laravelday-2026 (Passaparola, epic 2): l'agente mostra KPI, grafici e tabelle invece di elenchi di numeri. Parte agnostica nel modulo AI, usata dall'assistente operatore di Passaparola (story 2.4).

- `ValidateA2uiComponentsAction`: componenti ammessi, proprieta' dei componenti del pannello, un valore per etichetta, una cella per colonna, figli esistenti, un solo genitore, niente cicli sulla radice.
- `BuildA2uiSurfaceAction`: `createSurface` A2UI 1.0 sul catalogo `urn:laraxot:a2ui:panel`.
- `RenderSurfaceTool` con `GUIDE` per le istruzioni; JSON non valido ed errori restituiti al modello.
- Catalogo JS (Stat, Chart, DataTable, `weight` applicato) e renderer caricabile a richiesta. Test Pest in `tests/Unit/A2ui`.
- Verifica: validatore e tool eseguiti fuori da Pest con laravel/framework 13.x e neuron-ai (13 controlli); rendering verificato (KPI, grafico, tabella).

## Binding e strict mode MySQL

`StrictModeEloquentPersistence` estende `EloquentPersistence` di neuron-ai. neuron rifiuta di scrivere un run in pausa se la sessione MySQL non e' in strict mode (un valore base64 troncato in silenzio renderebbe il run irrecuperabile). Le connessioni del tenant hanno `strict => false` per il resto dell'applicazione, quindi lo strict mode si accende solo per la durata della scrittura e poi si rimette la modalita' di prima: la garanzia di neuron vale, e le altre query della richiesta non cambiano.
