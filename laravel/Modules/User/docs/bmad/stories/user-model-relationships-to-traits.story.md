---
title: "Relazioni dei modelli User nei trait dedicati"
type: story
module: User
status: in-progress
created: 2026-11-05
updated: 2026-11-05
tags: [bmad, user, eloquent, relationships, traits]
qmd: "User modelli Eloquent relazioni relationship traits estrazione BaseTeam Role Profile"
related:
  - ../../../../Xot/docs/bmad/stories/accessor-twin-contract-audit.story.md
  - ../../wiki/concepts/model-relationship-traits.md
references:
  - ../../wiki/architecture.md
---

# Relazioni dei modelli User nei trait dedicati

## Obiettivo

Spostare nei trait dedicati del modulo User le relazioni Eloquent dichiarate
direttamente nelle classi modello, mantenendo firme, PHPDoc, attributi, chiavi,
pivot e comportamento. Le relazioni già organizzate in trait restano nel loro
owner. `BaseUser.php`, i file `BaseUser*` e i file con lock attivo sono esclusi.

## Criteri di accettazione

- [ ] Inventario AST delle relazioni dichiarate direttamente nei modelli User,
  escludendo file lockati e `BaseUser*`.
- [ ] Ogni relazione libera è trasferita in un trait dedicato per modello; helper
  locali sono trasferiti insieme solo se necessari alla relazione.
- [ ] Collisioni tra trait, override e priorità di composizione sono gestiti
  esplicitamente; nessuna relazione viene duplicata o rinominata.
- [ ] Architecture/wiki User descrive il pattern e l’indice QMD lo collega.
- [ ] PHPStan User e Pest mirato eseguiti; ogni blocco ambientale o concorrenziale
  è documentato qui e in `docs/sprint-status.yaml`.

## Claim

Scope iniziale: `laravel/Modules/User/app/Models/` eccetto `BaseUser.php`, tutti
i file `BaseUser*` e i file che risultano lockati al momento dell’edit.

## Esito

In corso: l’inventario AST individua 24 metodi relazionali in 13 classi; `Team.php`
è lockato e i file `BaseUser*` sono fuori perimetro. I metodi in trait esistenti
non sono candidati.
