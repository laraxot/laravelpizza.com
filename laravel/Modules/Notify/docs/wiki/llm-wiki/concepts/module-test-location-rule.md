---
title: "Module Test Location Rule"
type: concept
sources: ["raw/articles/module-test-location-rule.md"]
confidence: high
created: 2026-04-21
updated: 2026-04-21
tags: [testing, architecture, laraxot, bounded-context, ddd, modules]
related:
  - concepts/laraxot-architecture.md
---

# Regola: I Test Appartengono al Modulo

## Principio Fondamentale

In Laraxot, ogni modulo è un **bounded context autonomo**. I test di un modulo devono stare
**dentro** il modulo, non nell'applicazione host.

```
✅ CORRETTO
laravel/Modules/Notify/tests/Feature/ContactTest.php
laravel/Modules/Notify/tests/Unit/Actions/SendEmailTest.php

❌ SBAGLIATO
tests/Feature/ContactTest.php          ← root del progetto (conductor)
laravel/tests/Feature/ContactTest.php  ← Laravel app host
```

## Struttura Corretta

```
laravel/Modules/<Name>/
├── app/           ← codice PHP
├── tests/         ← test del modulo ← QUI
│   ├── Feature/
│   ├── Unit/
│   ├── Pest.php
│   └── TestCase.php
├── docs/          ← documentazione
├── lang/          ← traduzioni
└── config/        ← configurazione
```

## Tre Livelli, Tre Destinatari

| Directory | Destinatario | Usare per |
|-----------|-------------|-----------|
| `tests/` (root progetto) | Conductor/monorepo | Test del sistema di conduzione |
| `laravel/tests/` | Laravel app host | Test dell'applicazione host |
| `laravel/Modules/<X>/tests/` | Modulo X | Test del modulo X ← QUESTO |

## Anti-Pattern Documentato

**Incidente 2026-04-21:** I test del modulo Notify sono stati creati in `tests/Feature/` e
`tests/Unit/` alla root del progetto. Causa: uso acritico della skill `pest-testing` (che indica
`tests/Feature` come path generico) senza contestualizzarla per l'architettura Laraxot modulare.

La skill `pest-testing` dice `tests/Feature` per applicazioni monolitiche. In Laraxot va letto
come `laravel/Modules/<CurrentModule>/tests/Feature/`.

## Regola Mnemonica

> "I test di un modulo seguono il modulo, non l'host."

## Relazioni

- [[../../docs/wiki/concepts/laraxot-architecture]] — architettura DDD del progetto
- [[concepts/laraxot-architecture]] — (quando disponibile a livello modulo)
- Vedi `testing-rules.md` in `docs/` per le regole di testing specifiche del modulo Notify
