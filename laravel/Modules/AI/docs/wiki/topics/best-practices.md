---
title: "Topic best-practices"
type: digest
status: active
qmd: "digest ceiling 100 best-practices"
---

# Topic best-practices

Sintesi automatica di 3 documenti (chiave `best-practices`).

## Best Practices – AI

_Fonte: `best-practices-2.md`_

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
- Aggiorna `docs/index-2.md` quando aggiungi nuove funzioni.
- Inserisci link a OpenAI/Anthropic SDK docs.

## Best Practices – AI

_Fonte: `best-practices.md`_

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
- Aggiorna `docs/index.md` quando aggiungi nuove funzioni.
- Inserisci link a OpenAI/Anthropic SDK docs.

## Best Practices per l'Utilizzo dei Server MCP

_Fonte: `mcp/best-practices.md`_

# Best Practices per l'Utilizzo dei Server MCP

## Panoramica

Questa guida fornisce le migliori pratiche per l'utilizzo dei server MCP (Model Context Protocol) in progetti Laravel, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila5.

## ⚠️ SICUREZZA DEL DATABASE

### Comandi Pericolosi da Evitare

**MAI** eseguire i seguenti comandi in produzione o in ambienti con dati critici:

```bash
php artisan migrate:fresh       # ELIMINA TUTTE LE TABELLE E I DATI
php artisan migrate:fresh --seed # ELIMINA TUTTO E RICARICA I DATI DI PROVA
php artisan db:wipe             # ELIMINA TUTTE LE TABELLE
```

### Best Practice per le Migrazioni

1. **Sempre** eseguire il backup del database prima di applicare migrazioni
2. Utilizzare `php artisan migrate` per applicare nuove migrazioni in modo sicuro
3. In sviluppo, verificare sempre l'ambiente prima di eseguire comandi distruttivi
4. Utilizzare transazioni per migrazioni complesse
5. Testare sempre le migrazioni in un ambiente di staging prima della produzione

### In Caso di Errore

Se hai eseguito accidentalmente un comando di migrazione pericoloso:
