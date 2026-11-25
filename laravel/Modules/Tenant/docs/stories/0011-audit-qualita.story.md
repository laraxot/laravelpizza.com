---
title: "Audit qualita' — modulo Tenant"
type: story
module: Tenant
status: review
created: 2026-11-19
updated: 2026-11-19
issues: ["https://github.com/laraxot/base_techplanner_fila5/issues/64"]
qmd: "audit qualita story tenant"
---
# Story: audit qualita' del modulo Tenant

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Contesto

Audit parallelo (7 agenti, issue #64). Scope: solo `Modules/Tenant` (e `Modules/User`, story separata).
Comportamento da **non toccare**: `GetTenantNameAction` (host invertito → `config/<path>`) e l'alias delle
connessioni di modulo sulla connessione default in `TenantServiceProvider::registerDB()`.

## Fatto

### Documentazione
- [x] Rimossi i duplicati esatti (stesso contenuto byte per byte): tenuta la copia con il nome piu' pulito,
      fuori da `legacy/`, `archive/`, `raw/`; i link interni al modulo sono stati riscritti.
- [x] Nessuna data nei nomi dei `.md` (es. `phpstan-fixes-2025-10-13.md` → `phpstan-fixes.md`, data in `created:`).
      Le collisioni sono state unite nel file senza data (contenuti quasi identici scartati).
- [x] Un solo indice: `docs/README.md`. Rimossi `index.md`, `INDEX.md`, `00-index.md`, `index-generated.md`,
      `index_generated.md`; i link verso di essi puntano ora al README.
- [x] README: corrette affermazioni non vere rispetto al codice (`BaseTenant` sta nel modulo User, `users()` e'
      `HasMany`, il pivot e' `TenantUser` del modulo User senza colonna `permissions`); aggiunta la sezione
      "Come funziona (verificato sul codice)" e l'indice.

### Codice (`app/`, comportamento invariato)
- [x] `Actions/Domains/GetDomainsArrayAction`: tolti `use` commentati e un `@var` fuori posto.
- [x] `Providers/TenantServiceProvider`: tolto codice commentato in `boot()`/`register()`.
- `mixed` in `app/`: 117 → 116. I restanti sono quasi tutti `array<string, mixed>` di config/righe Sushi
  (tipo reale non noto a priori) o firme vendor.

## Verifiche
- PHPStan `Modules/Tenant`: 0 errori prima e dopo.
- Pest `Modules/Tenant/tests`: 61 passati / 223 falliti prima e dopo (nessuna regressione).
- Rimossi i `.gitignore` di `docs/wiki/troubleshooting/` che ignoravano nomi file datati non piu' esistenti.

## Rimasto da fare (proposte)
- [ ] I 223 test falliti sono per la maggior parte di `SushiToJson*` (LogicException "may not be called while
      being booted", classi inesistenti, `Unknown format`): test scritti contro un'API vecchia. Vanno riscritti
      o eliminati in una story dedicata, non e' un problema del codice applicativo.
- [ ] `Contracts/SushiToJsonContract` e `SushiToJsonsContract` non sono usati in questo progetto: il modulo e'
      condiviso (`laraxot/module_tenant_fila5`), verificare gli altri progetti prima di rimuoverli.
- [ ] `docs/` contiene ancora molte cartelle storiche (`raw/`, `legacy/`, `bmad/` con copie della root):
      consolidarle richiede lettura dei contenuti, non solo dedup.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
