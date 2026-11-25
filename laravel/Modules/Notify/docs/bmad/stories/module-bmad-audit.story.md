---
title: "Module BMAD audit — Notify"
type: story
status: review
updated: 2026-11-23
module: Notify
bmad: true
qmd: "story BMAD audit modulo Notify inventario finding P1 gate PHPStan Pest"
created: 2026-11-23
---

# Story: audit BMAD del modulo Notify

## Perché

Notify è il canale con cui la piattaforma raggiunge le persone. Va verificato che
non esponga dati dei destinatari e che nessun canale fallisca in silenzio.

## Acceptance

- [x] Inventario source-first misurato (2026-11-16), incluso `Gate::getPolicyFor` a runtime.
- [x] Audit approfondito + sintesi in `docs/bmad/`.
- [x] Pack ECC in `docs/ecc/`.
- [x] PHPStan `Modules/Notify`: 0 errori.
- [ ] P1-1 `NotificationLogPolicy` + test negativo.
- [ ] P1-2 webhook inbound: firma/throttle/whitelist provider + test.
- [ ] P1-3 matrice capability canali; stub con eccezione esplicita.
- [ ] Pest modulo verde (richiede DB testing raggiungibile; MySQL `10.100.200.53` oggi no).

## Riferimenti

- [audit sintesi](../audit.md) · [audit approfondito](../audits/notify-audit.md)
- [ECC](../../ecc/notify-ecc-audit.md) · [piano](../piano-miglioramento.md)

## Esito

Baseline 2026-11-16: 0 finding P0, 3 P1, 4 P2. Nessun codice applicativo modificato
da questo audit; i fix partono da story figlie con lock.
