---
issues: []
discussions: []
title: "LangServiceProvider"
module: "Lang"
type: concept
tags: [REDUNDANCY, ANALYSIS]
created: 2026-07-14
updated: 2026-07-14
qmd: "redundancy analysis"
related:
  - "./italian-text-refined-audit-report.md"
---
# LangServiceProvider

## Panoramica

Il LangServiceProvider è un componente fondamentale di <nome progetto> che gestisce automaticamente le traduzioni per i componenti Filament senza richiedere l'uso esplicito del metodo `->label()`.

## Documentazione Dettagliata

La documentazione completa del LangServiceProvider è disponibile nel modulo Lang:

- [Analisi e Proposte di Miglioramento](../laravel/Modules/Lang/docs/lang-service-provider.md)
- [Analisi e Proposte di Miglioramento](../laravel/modules/lang/docs/lang-service-provider.md)
- [Analisi e Proposte di Miglioramento](../laravel/modules/lang/docs/lang-service-provider.md)

## Caratteristiche Principali

- Gestione automatica delle etichette dei componenti Filament
- Centralizzazione delle traduzioni nei file di lingua
- Creazione automatica delle chiavi di traduzione mancanti
- Supporto per diversi tipi di componenti Filament

## Utilizzo Corretto

```php
// CORRETTO: Non specificare label, viene gestito automaticamente
TextInput::make('name')
    ->required()
    ->maxLength(255)

// ERRATO: Non utilizzare ->label() nei componenti
TextInput::make('name')
    ->label('Nome')  // ❌ Non fare questo!
    ->required()
    ->maxLength(255)
```

## Struttura Chiavi di Traduzione

- **Campi form**: `modulo::risorsa.fields.nome_campo.label`
- **Azioni**: `modulo::risorsa.actions.nome_azione.label`
- **Passi wizard**: `modulo::risorsa.steps.nome_passo.label`
- **Altri attributi**: `.placeholder`, `.helperText`, `.description`
- **Altri attributi**: `.placeholder`, `.helperText`, `.description`
- **Altri attributi**: `.placeholder`, `.helperText`, `.description`
- **Altri attributi**: `.placeholder`, `.helperText`, `.description`
- **Altri attributi**: `.placeholder`, `.helperText`, `.description`
