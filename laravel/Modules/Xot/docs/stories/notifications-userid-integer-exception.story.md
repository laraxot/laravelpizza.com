---
title: Eccezione Expected an integer su userId nelle notifiche
status: todo
module: Xot
created: 2026-10-21
---

# Eccezione Expected an integer su userId nelle notifiche

## Sintomo
`local.ERROR: Expected an integer. Got: string` con `userId` in UUID
(`5e5d8e9e-...`), lanciata dal middleware `Filament\Notifications\Http\Middleware\PublishNotifications`.

## Causa probabile (da verificare)
Il middleware si aspetta un id numerico, ma l'utente o il guard usa UUID. Chiamata con `Webmozart\Assert::integer`.

## Passi
1. Trovare dove il middleware legge l'id utente (vendor Filament notifications) e quale modello/guard lo fornisce.
2. Capire lo scopo: le notifiche di sessione devono essere pubblicate per l'utente autenticato, a prescindere dal tipo di chiave.
3. Correzione alla fonte (modello utente / provider), non un cast nel vendor.
4. Test di regressione con utente a chiave UUID.

## Verifica
- Nessun nuovo `Expected an integer` nel log dopo una richiesta autenticata.
