---
title: "Negare per default le abilità Filament non dichiarate dalle policy"
type: story
module: Xot
status: in-progress
created: 2026-11-05
updated: 2026-11-05
tags: [bmad, filament, policy, authorization, security]
qmd: "Filament policy ability default deny undeclared deleteAny restoreAny reorder replicate XotBasePolicy"
related:
  - ../filament-blueprint.md
  - ../../../../Incentivi/docs/bmad/stories/filament-undeclared-policy-abilities.story.md
---
# Negare per default le abilità Filament non dichiarate dalle policy

## Scopo

Filament può considerare consentita un'abilità non dichiarata quando una policy
esistente ritorna `null` dal callback `before()`. `XotBasePolicy` concede il
bypass solo ai super-admin; per gli altri utenti le operazioni bulk, relation e
replicate devono restare negate finché una policy concreta non le abilita.

## Criteri di accettazione

- [x] La trait condivisa nega le abilità Filament non dichiarate e viene usata da `XotBasePolicy`.
- [x] Il bypass `before()` per i super-admin resta attivo.
- [x] Gli override `replicate` rispettano il parametro `Model` della policy base e negano modelli di tipo diverso.
- [ ] Pest Xot e test policy Incentivi verdi.
- [ ] PHPStan Modules senza finding `trait.unused` o incompatibilità di firma.

## Revisione indipendente

Audit read-only: il trait aveva zero consumer; integrarlo nella base richiede
allargare i due override Incentivi da `Project`/`Activity` a `Model`, con guardia
`instanceof`, altrimenti la firma figlia restringe il contratto. Il callback
Filament conferma che una policy esistente con un'abilità mancante può consentire
l'accesso ordinario in modalità non strict.

## Esito

In corso: integrazione alla base e test unitari aggiunti. Il gate Pest è ancora
impedito dal conflitto `HasSlug`/`HasUuids` in `User\Models\BaseTenant`; vedere
la story User collegata e completare entrambi i gate prima della chiusura.
