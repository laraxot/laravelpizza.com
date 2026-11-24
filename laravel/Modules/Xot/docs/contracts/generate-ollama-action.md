---
title: "GenerateOllamaAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\AI\\Ollama\\GenerateOllamaAction"
qmd: "GenerateOllamaAction generate Ollama api generate prompt risposta token Guzzle RuntimeException"
---

# GenerateOllamaAction

Genera testo da un prompt tramite `/api/generate` di Ollama. Codice: `app/Actions/AI/Ollama/GenerateOllamaAction.php` (classe a riga 20, `execute()` a riga 51). `executeOptimized` e `executeMinimal` usano opzioni fisse.

## Input

- `string $prompt`.
- `array $options`: `model`, `stream`, `options`.

## Output

- `array{response: string, done: bool, tokens{prompt, generated}}`.

## Invarianti

- `OLLAMA-GEN-INV-1` — Richiesta `POST /api/generate` con `prompt`; opzioni = default uniti agli override. Test: nessuno.
- `OLLAMA-GEN-INV-2` — Modello, timeout (120 s) e URL come in `ChatOllamaAction`. Test: nessuno.
- `OLLAMA-GEN-INV-3` — Errori Guzzle o JSON: `Log::error` e `RuntimeException`. Test: nessuno.

## Effetti collaterali

Una richiesta HTTP verso Ollama. Log in caso di errore.

## Errori

- `RuntimeException` per errori Guzzle.

## Non fa

- Stesse limitazioni di `ChatOllamaAction`: streaming non gestito, `JsonException` mai lanciata.
- `executeOptimized` non imposta `num_ctx`, a differenza del default.
