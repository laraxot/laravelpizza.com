---
title: "best practices"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "best practices"
issues: []
discussions: []
---

# Best Practices – AI

## Principi DRY/KISS
- **DRY**: Centralizza logica AI in `AIService`. Usa metodi statici solo per costanti.
- **KISS**: Mantieni i prompt brevi e parametrizzati; evita prompt concatenati dinamicamente.
- **Clean Code**: Usa `enum` per i tipi di modello, non stringhe hard‑coded.

## Componenti
- Usa classi `PromptBuilder` per costruire richieste.
- Usa `HttpClient` configurato con timeout e retries.

## Test
- Mocka il client HTTP con `Http::fake()`.
- Testa la generazione di prompt con unit test.

## Documentazione
- Aggiorna `docs/INDEX.md` quando aggiungi nuove funzioni.
- Inserisci link a OpenAI/Anthropic SDK docs.
