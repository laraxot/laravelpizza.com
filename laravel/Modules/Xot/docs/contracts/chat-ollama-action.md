---
title: "ChatOllamaAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\AI\\Ollama\\ChatOllamaAction"
qmd: "ChatOllamaAction chat Ollama api chat messaggio opzioni think token durata Guzzle RuntimeException"
---

# ChatOllamaAction

Invia un messaggio a un'istanza Ollama tramite `/api/chat` e restituisce testo, ragionamento, token e durate. Codice: `app/Actions/AI/Ollama/ChatOllamaAction.php` (classe a riga 20, `execute()` a riga 54). `executeOptimized` e `executeMinimal` sono varianti con opzioni fisse.

## Input

- `string $message`: messaggio utente.
- `array $options`: `model`, `stream`, `think`, `options` (sovrascrive i default).

## Output

- `array{content, thinking, done, tokens{prompt, generated, total}, duration{total, prompt, generation}}`.

## Invarianti

- `OLLAMA-CHAT-INV-1` — La richiesta è `POST /api/chat` con un solo messaggio `user`; le opzioni sono i default uniti agli override (gli override vincono). Test: nessuno.
- `OLLAMA-CHAT-INV-2` — Il modello è `options.model` o `services.ollama.model`, default `qwen2.5`. Test: nessuno.
- `OLLAMA-CHAT-INV-3` — Il timeout del client è 120 secondi e l'URL base viene da `services.ollama.url`. Test: nessuno.
- `OLLAMA-CHAT-INV-4` — Un errore Guzzle o JSON è loggato con `Log::error` e rilanciato come `RuntimeException`. Test: nessuno.

## Effetti collaterali

Una richiesta HTTP verso Ollama. Log in caso di errore. Nessuna persistenza.

## Errori

- `RuntimeException` per errori Guzzle.

## Non fa

- Non gestisce lo streaming: con `stream: true` il corpo è NDJSON e `json_decode` non lo legge; il risultato è vuoto, senza errore.
- `json_decode` è senza `JSON_THROW_ON_ERROR`: `JsonException` non viene mai lanciata, e un JSON non valido produce un risultato vuoto.
- Non mantiene lo storico della conversazione.
