---
title: "Assistente clienti (base di conoscenza + passaggio a una persona)"
type: guide
module: AI
tags: [ai, assistant, knowledge-base, handoff, report]
created: 2026-11-16
updated: 2026-11-17
qmd: "assistant knowledge base handoff report"
issues: [25, 26]
discussions: []
related:
  - ./stories/assistant-knowledge-base.story.md
  - ../ARCHITECTURE.md
---

# Assistente clienti

Mattoni **agnostici** per costruire un assistente che risponde alle domande dei clienti
usando solo risposte ufficiali e passa a una persona tutto il resto.

Il modulo AI non conosce nessun progetto: è il **modulo principale del progetto**
(Fixcity, Restaurant, ...) che chiama queste Action con la propria `collection`,
le proprie parole sensibili e, se serve, il proprio handler di presa in carico.

## Per chi parte da zero

1. **Base di conoscenza**: un elenco di coppie *domanda tipo → risposta ufficiale*,
   gestite dal pannello Filament del modulo AI (*Assistente AI → Base di conoscenza*)
   o dal modulo del progetto tramite il modello `AiKnowledgeEntry`.
2. **Risposta**: quando arriva una domanda, l'assistente cerca le voci pertinenti e chiede
   al modello di rispondere **solo** con quelle.
3. **Passaggio a una persona**: se la domanda è sensibile, se non ci sono voci pertinenti,
   se il modello è incerto o non risponde, nasce una proposta `assistant_handoff` nella coda
   *Proposte di azione AI*. Confermarla = "presa in carico".
4. **Report**: per un periodo, quante domande, quante risolte, quali voci usate di più,
   quali domande non hanno risposta (da aggiungere alla base di conoscenza).

## Tipi di utente

| Utente | Cosa fa |
|---|---|
| **Sviluppatore del progetto** | Chiama le Action dal modulo principale, sceglie `collection` e parole sensibili, decide dove mostrare chat e report |
| **Gestore / proprietario** | Scrive e aggiorna le risposte nella base di conoscenza, legge il report |
| **Operatore** | Lavora la coda *Proposte di azione AI* filtrando il tipo `assistant_handoff` |
| **Cliente finale** | Fa domande; riceve una risposta oppure il messaggio di passaggio a una persona |

## Uso dal modulo del progetto

```php
use Modules\AI\Actions\Assistant\AnswerQuestionAction;
use Modules\AI\Actions\Assistant\BuildAssistantReportAction;

// 1. Domanda del cliente (il thread lo crea/riusa il progetto)
$answer = app(AnswerQuestionAction::class)->execute(
    thread: $thread,                 // Modules\AI\Models\AiThread
    collection: 'fixcity-faq',       // base di conoscenza del progetto
    question: $request->string('question')->toString(),
    userId: auth()->id(),            // null per visitatori anonimi; intero o UUID (salvato come stringa)
    handoffKeywords: ['allerg'],     // opzionale: parole sensibili di questa chiamata (es. per attività); null = config
);

$answer->answer;        // testo da mostrare
$answer->needsHuman;    // true = passato a una persona
$answer->handoffReason; // no_knowledge | sensitive_topic:<parola> | ai_unavailable | invalid_model_response | <motivo del modello>
$answer->sourceIds;     // id delle AiKnowledgeEntry usate

// 2. Report (pianificazione e invio li decide il progetto)
$report = app(BuildAssistantReportAction::class)->execute('fixcity-faq', now()->subWeek(), now());
```

### Parole sensibili (opzionale)

Di default la lista è **vuota**: il modulo AI non decide cosa è sensibile per un progetto.
Si possono passare per singola chiamata (`handoffKeywords`, es. diverse per ogni attività) oppure
impostarle per tutto il progetto nella configurazione:

```php
config(['ai.assistant.handoff_keywords' => ['rimbors', 'reclam', 'avvocat', 'denunc']]);
```

Sono radici: `rimbors` copre *rimborso, rimborsi*. Maiuscole e accenti vengono ignorati.

### Presa in carico personalizzata (opzionale)

Il modulo registra `AssistantHandoffHandler` (conferma = presa in carico). Un progetto può
sostituirlo registrando un proprio handler con lo stesso tipo, per esempio per aprire un ticket:

```php
app(\Modules\AI\Adapters\AiActionHandlerRegistry::class)->register(new MyTicketHandoffHandler);
```

## Fornitori del modello

L'assistente chiede la risposta in cascata (`Assistant\RequestAssistantCompletionAction`):

| Ordine | Fornitore | Modello predefinito | Chiave in `.env` |
|---|---|---|---|
| 1 | Groq | `openai/gpt-oss-120b` (modello di testo di produzione; i Llama sono stati ritirati nel 2026) | `GROQ_API_KEY` |
| 2 | OpenRouter | `openrouter/free` (router dei modelli gratuiti; `free_models_only` scarta i modelli a pagamento) | `OPENROUTER_API_KEY` |
| 3 | OpenAI (`MakeAIRequestAction`) | impostazione esistente | `OPENAI_API_KEY` |

Un fornitore senza chiave o che risponde con un errore passa la mano al successivo. Se nessuno risponde,
la domanda passa a una persona (`ai_unavailable`). Ordine, modelli e timeout si cambiano in `AIConfigData`
(`assistant_providers`, `assistant_models`, `assistant_timeout`). Le chiavi si leggono da `config/services.php`
del progetto (`services.groq.key`, `services.openrouter.key`).

Il progetto dichiara le due chiavi in `config/services.php` (`'groq' => ['key' => env('GROQ_API_KEY')]`, idem `openrouter`)
e le valorizza solo in `.env`, mai in git. La risposta e' chiesta con `response_format: json_object`: Groq e OpenAI
rispondono 400 se nessun messaggio contiene la parola «json», quindi l'Action aggiunge `JSON_INSTRUCTION` al prompt di
sistema quando manca.

## Regole fisse dell'assistente

Valgono per tutti i progetti (`BuildAssistantPromptAction::SYSTEM_PROMPT`):
risponde solo con le fonti, non inventa, non promette rimborsi o eccezioni,
nessun consiglio legale o medico, passa a una persona se il cliente è arrabbiato
o la richiesta è complessa, risponde nella lingua della domanda, risponde solo in JSON.

## Componenti

| Componente | Ruolo |
|---|---|
| `Models\AiKnowledgeEntry` | Voce della base di conoscenza (`collection`, `question`, `answer`, `tags`, `is_active`) |
| `Actions\Assistant\TokenizeTextAction` | Normalizza il testo (minuscolo, senza accenti, parole ≥ 3 caratteri) |
| `Actions\Assistant\RankKnowledgeEntriesAction` | Ordina le voci per pertinenza (sovrapposizione di parole) |
| `Actions\Assistant\SaveKnowledgeEntryAction` | Crea o corregge una voce di una `collection` (mai di un'altra; stessa domanda = aggiornamento, non duplicato) |
| `Actions\Assistant\SearchKnowledgeEntriesAction` | Carica le voci attive della `collection` e le ordina |
| `Actions\Assistant\DetectHandoffTriggerAction` | Guardrail deterministico sulle parole sensibili del progetto |
| `Actions\Assistant\BuildAssistantPromptAction` | Prompt di sistema e prompt con fonti |
| `Actions\Assistant\RequestAssistantCompletionAction` | Risposta del modello in cascata: Groq, OpenRouter, OpenAI |
| `Actions\Assistant\AnswerQuestionAction` | Flusso completo, salva i messaggi, crea la proposta di passaggio |
| `Actions\Assistant\BuildAssistantReportAction` | Report del periodo per una `collection`; filtra nel database sui percorsi JSON `payload->kind` e `payload->collection` |
| `Datas\AssistantAnswerData` / `Datas\AssistantReportData` | Risultati tipizzati |
| `Adapters\AssistantHandoffHandler` | Handler di default di `assistant_handoff` |
| `Actions\CreateAiThreadAction` | Crea un thread (anche anonimo) con `panel_id` scelto dal chiamante |
| `Actions\AppendAiMessageAction` | Aggiunge un messaggio senza chiamare il modello (es. risposta di un operatore) |
| `Filament\Resources\AiKnowledgeEntryResource` | Gestione della base di conoscenza |

## Limiti noti ed evoluzioni

- **Ricerca per parole, non semantica**: va bene per decine/centinaia di voci. Per basi
  più grandi o sinonimi si sostituisce solo `RankKnowledgeEntriesAction` (embeddings).
- **Triage email**: non incluso. Si costruisce sopra `ClassifyTicketAction` + una proposta
  `send_reply` con la bozza nel `preview`, quando un progetto ne avrà bisogno.
- **Privacy**: le domande vengono salvate in `ai_messages`. Il progetto che usa l'assistente
  deve indicarlo nell'informativa e comunicare all'utente che sta parlando con un'AI.
- `MakeAIRequestAction` ha ancora un prompt di sistema di default specifico dei ticket PA
  (mantenuto per compatibilità); l'assistente passa il proprio.
