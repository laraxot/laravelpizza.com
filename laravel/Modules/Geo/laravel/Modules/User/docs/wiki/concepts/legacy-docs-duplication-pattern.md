---
title: "pattern duplicazione documentazione legacy modulo user"
module: User
type: concept
confidence: high
created: 2026-05-21
updated: 2026-05-22
tags: [legacy, documentation, duplication, drift, User]
related:
  - ../../redundancy-report.md
  - ../../../../docs/redundancy-report.md
sources: []
---

# Pattern ridondanza in `Modules/User/docs/legacy`

## Business reason

Cartella **`docs/legacy`** conserva **storia progettuale**: decisioni Volt/Filament/widget, fix translation, refactor routing. Nel tempo più agenti/note hanno prodotto **varianti nominative dello stesso argomento** (`auth-performance` vs `AUTHENTICATION_PERFORMANCE_OPTIMIZATION.md`, `-1`, snake_case vs kebab-case), generando migliaia di file sovrapposti.

## Rischi operativi

1. Ricerca inconsistente (“quale nome è canonico?”).
2. Contenuti **contraddittori** se solo uno dei twin viene aggiornato.
3. Tempo lettura LLM/umano sprecato quando il concetto vivo è stato spostato in **wiki/concepts** più recente.

## Fonti “vive” da preferire

- **`docs/wiki/concepts/`** per policy attuali modulo User.
- **`docs/redundancy-report.md`** modulo per ridondanza **codice**.
- Inventario tecnico trasversale: [`Modules/docs/redundancy-report.md`](../../../../docs/redundancy-report.md).

## Gestione suggerita (senza purge massiccia)

Quando tocchi legacy per un refactor:

1. Individua **un** documento migliore (più aggiornato / meno rumoroso).
2. Aggiorna quel file con somma tecnica aggiornata.
3. Nei twin ovvi aggiungi in cima un blocco: “**Canonical:** link a …”.
4. Se il contenuto è obsoleto o duplicato 1:1, preferire deprecazione nella wiki tramite pagina stub unica che punta alla fonte vivente (evitare più stub).

## Aggiorna anche

Ridondanza **Filament/oauth** codice nel modulo è trattata in [`../redundancy-report.md`](../../redundancy-report.md) (sezione Oauth).

