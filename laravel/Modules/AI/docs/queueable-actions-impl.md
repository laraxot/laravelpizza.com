---
qmd: "queueable-actions-impl"
title: "Implementazione Queueable Actions — AI Service Conversion (2026-10-20)"
type: outcome
updated: 2026-10-20
status: completed
tags: [docs, ai]
---

# Queueable Actions — AI Service Conversion (2026-10-20)

## Modifica

Conversione dei casi d'uso AI in azioni Spatie Queueable. Il precedente riferimento
ad `AIService` è storico: `Modules/AI/app/Services/AIService.php` non è un percorso
produttivo corrente.

## File creati

- `Modules/AI/app/Actions/Support/MakeAIRequestAction.php` — HTTP AI + retry (identico a `AIService::makeAIRequest()`)
- `Modules/AI/app/Actions/Prompt/AIPromptTemplates.php` — template prompt `classification`, `solutions`
- `Modules/AI/app/Actions/Prompt/BuildAIPromptAction.php` — dispatcher prompt
- `Modules/AI/app/Actions/ClassifyTicketAction.php` — classificazione ticket (cache 3600, decodifica difensiva)
- `Modules/AI/app/Actions/SuggestSolutionsAction.php` — suggerimenti soluzioni (cache 1800, decodifica difensiva)

## File modificati (no cancellazione funzionalità)

- Nessun `Modules/AI/app/Services/AIService.php`: non reintrodurre un wrapper Service per compatibilità presunta.
- `Modules/AI/docs/queueable-actions.md` — stato aggiornato da draft; elenco file implementato, note di manutenzione.
- `CHANGELOG.md` — non modificato (minimo necessario per questa conversione specifica).

## Logica preservata

- **Cache**: chiavi `ai:classification:<md5>` e `ai:solutions:<md5>` con TTL originali (3600 / 1800) tramite `Cache::remember()`.
- **Prompt**: identici ai template originali (`buildClassificationPrompt`, `buildSolutionPrompt`) ora in `AIPromptTemplates`.
- **Retry / backoff**: `MakeAIRequestAction` replica `while ($attempt < $retryAttempts)` con `sleep(pow(2, $attempt))`.
- **Decodifica**: `AiJsonResponseDecoderAction::decodeObject()` con default di flusso su JSON non valido.
- **Log**: `Log::warning` / `Log::error` mantenuti con `array_merge($context)`.

## Qualità

- PHPStan: 0 errori (`phpstan analyse Modules/AI --no-progress`)
- Pint: passato (7 fix applicati su file esistenti, 0 errori nuovi)
- Pattern: `declare(strict_types=1)`, `use QueueableAction;`, metodo pubblico `execute()`, `final class`
- Documentazione: `queueable-actions.md` aggiornata con stato e roadmap (migrazione altre azioni in futuro)

## Uso

```php
// Sincrono
$app = app(ClassifyTicketAction::class)->execute('Titolo', 'Descrizione');

// Su coda
ClassifyTicketAction::dispatch('Titolo', 'Descrizione');
```

## Nessuna cancellazione

`AIService.php` non è stato rimosso; i metodi pubblici `classifyTicket()` e `suggestSolutions()` continuano a funzionare tramite delega (backward compatibility). Funzionalità esistenti (sentiment, routing, pattern, improvements) intatte.
