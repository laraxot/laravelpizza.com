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
<<<<<<< HEAD
| Run in pausa | `Models\AiAgentRun` (`ai_agent_runs`) | stato del run in attesa di approvazione, letto da `Neuron\Persistence\StrictModeEloquentPersistence` |
| Interfacce generate | `Neuron\Tools\RenderSurfaceTool` | il modello compone KPI, grafici e tabelle A2UI; errori restituiti al modello |
| Controllo A2UI | `Actions\A2ui\ValidateA2uiComponentsAction` | componenti ammessi, proprietà, figli, cicli |
| Superficie A2UI | `Actions\A2ui\BuildA2uiSurfaceAction` | `createSurface` A2UI 1.0 sul catalogo `urn:laraxot:a2ui:panel` |
| Renderer nel browser | `resources/js/a2ui/render-surfaces.js` + `panel-catalog.js` | catalogo base + Stat, Chart (Chart.js), DataTable |
=======
| Run in pausa | `Models\AiAgentRun` (`ai_agent_runs`) | stato del run in attesa di approvazione, letto da `EloquentPersistence` |
>>>>>>> eab1d98 (chore(AI): sync working tree (docs, phpstan fixes, wip))

## Perché tabelle dedicate

`ai_threads`/`ai_messages` restano dell'assistente e della chat del pannello: hanno un altro schema
(utente, pannello, proposte). neuron-ai salva messaggi completi (tool call, risultati, metadati) e
riprende i run dopo un'approvazione: servono le colonne che si aspetta, con le sue regole
(`ai_agent_runs` senza cast, chiave `partition`+`key` univoca, cancellazioni fisiche).

<<<<<<< HEAD
## Binding e strict mode MySQL

`AIServiceProvider::register()` lega `MessageStoreInterface` a `EloquentMessageStore(AiAgentMessage)`
e `PersistenceInterface` a `StrictModeEloquentPersistence(AiAgentRun)`. Senza questi binding
`XotBaseAgent` non si costruisce (`Target [MessageStoreInterface] is not instantiable`).

`EloquentPersistence` di neuron rifiuta di scrivere se la sessione MySQL non è in strict mode
(`Workflow persistence requires MySQL strict SQL mode`): un valore base64 troncato in silenzio
renderebbe il run irrecuperabile. Le connessioni del tenant hanno `strict => false`, quindi
`StrictModeEloquentPersistence` aggiunge `STRICT_TRANS_TABLES` alla sessione solo durante le
scritture dei run e poi rimette la modalità di prima. Le altre query della richiesta non cambiano.

=======
>>>>>>> eab1d98 (chore(AI): sync working tree (docs, phpstan fixes, wip))
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

<<<<<<< HEAD
## Interfacce generate (A2UI)

L'agente può rispondere con un'interfaccia invece che con il solo testo. Si aggiunge
`new RenderSurfaceTool` ai tool e `RenderSurfaceTool::GUIDE` alle istruzioni; il modello scrive
un albero piatto di componenti [A2UI 1.0](https://a2ui.org/specification/v1_0/):

- layout e testo del catalogo base: `Column`, `Row`, `List`, `Card`, `Tabs`, `Divider`, `Text` (Markdown);
- componenti del pannello: `Stat` (KPI con andamento), `Chart` (bar, line, area, pie, doughnut), `DataTable`.

Il server controlla l'albero (`ValidateA2uiComponentsAction`): un errore torna al modello con
l'elenco dei problemi e il modello riprova. Il risultato del tool è `{"a2ui": [...]}`.

Nel browser:

```js
const { createSurfaceRenderer } = await import('../../../AI/resources/js/a2ui/render-surfaces.js');
const render = createSurfaceRenderer((element) => container.append(element));
render(toolResultContent); // false se il contenuto non è A2UI
```

Il renderer si importa **a richiesta** (import dinamico): Lit, Chart.js e il renderer (circa 690 KB)
si scaricano solo alla prima interfaccia. Il catalogo JS e il validatore PHP vanno tenuti allineati
(stessi componenti e proprietà); `weight` divide lo spazio di una `Row` anche per i componenti del pannello.

Il modulo AI non compila JS: il bundle lo fa il modulo che usa il renderer (in Passaparola:
`npm run build`); le dipendenze sono in `package.json`.

## Test

`tests/Unit/Agent`: scelta del fornitore, thread di altri utenti, turni vuoti, validazione, turno
completo con `FakeAIProvider` (passa dalla persistenza del run: copre binding e strict mode).
`tests/Unit/A2ui`: alberi validi e non validi, risultato e messaggi di `render_surface`.
=======
## Test

`tests/Unit/Agent`: scelta del fornitore, thread di altri utenti, turni vuoti, validazione.
>>>>>>> eab1d98 (chore(AI): sync working tree (docs, phpstan fixes, wip))
