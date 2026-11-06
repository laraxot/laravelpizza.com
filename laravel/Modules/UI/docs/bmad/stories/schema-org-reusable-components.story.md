---
title: "Story: componenti riutilizzabili schema.org"
type: story
status: active
bmad_status: active
scope: ui-docs
updated: 2026-10-23
tags: [docs, ui, bmad]
qmd: "story: componenti riutilizzabili schema.org ui"
---

# Story: componenti riutilizzabili schema.org

## Obiettivo

Fornire componenti Filament riutilizzabili per dati strutturati comuni,
senza legare il modulo UI a un dominio specifico.

## Criteri di accettazione

- `PersonSection`, `AddressField` e `OrganizationSection` coprono i dati già presenti.
- `EventSection` espone i principali campi di `schema.org/Event`.
- `PersonColumn`, `AddressColumn`, `OrganizationColumn` ed `EventColumn` sono proiezioni tabellari configurabili.
- Le basi applicative Xot restano l'unico punto di estensione Filament.
- Ogni colonna supporta una lista ridotta di campi tramite `fields()`.
- PHPStan e Pest del modulo UI passano.

## Decisioni

I valori dello stato e della modalità di partecipazione evento usano i
vocabolari schema.org come chiavi persistibili. Location, organizer e
performer restano campi testuali per non imporre relazioni o modelli che il
modulo UI non può conoscere.
