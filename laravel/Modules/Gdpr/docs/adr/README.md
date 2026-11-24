---
title: "ADR del modulo Gdpr"
type: index
tags: [adr, decisioni, gdpr]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Gdpr

Il **perché** delle forme di codice del modulo Gdpr che un agente rischia di "semplificare": come si conserva la prova dei
consensi (GDPR art. 7), cosa fa la cancellazione dell'account (art. 17) e dove si attacca il banner dei cookie.

Quando leggerli: prima di toccare `consents`/`treatments`, le Action di `app/Actions/Consent` e `app/Actions/Account`, oppure
`GdprServiceProvider` e `InjectCookieBanner`. Formato e regole (cinque sezioni, `## Verifica`, nomi senza date):
`Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Decisioni

- [La prova del consenso è una riga per scelta, mai sovrascritta](consent-proof-is-append-only.md) — solo INSERT alla registrazione, revoca con `revoked_at`, nessun DELETE.
- [La cancellazione dell'account disattiva l'utente e conserva la prova](account-deletion-deactivates-and-keeps-proof.md) — `deleted_at` + revoca consensi e token; anonimizzare è compito del progetto.
- [Il banner cookie è cablato dal provider del modulo](cookie-banner-wired-by-the-module.md) — traduzioni, vista e middleware sopra statikbe, flag del tenant valutato a ogni richiesta.
