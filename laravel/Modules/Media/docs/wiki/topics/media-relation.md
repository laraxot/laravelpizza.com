---
title: "Topic media-relation"
type: digest
status: active
qmd: "digest ceiling 100 media-relation"
---

# Topic media-relation

Sintesi automatica di 3 documenti (chiave `media-relation`).

## MediaRelationManager Documentation

_Fonte: `filament/relation-managers/media-relation-manager.md`_

# MediaRelationManager Documentation

## Overview
Il `MediaRelationManager` è un gestore di relazioni Filament che gestisce le relazioni media seguendo le convenzioni Laraxot.

## Caratteristiche

### Relazioni
- `media`: Relazione principale con i media
- `model`: Relazione inversa con il modello associato

### Azioni
- `AddAttachmentAction`: Azione per aggiungere nuovi allegati
  - Accessibile dall'header della tabella
  - Integrata con Spatie Media Library

### Funzionalità
- Gestione polimorfiche dei media
- Supporto per upload multipli
- Integrazione con Spatie Media Library
- Interfaccia utente Filament standard

## Utilizzo

### Configurazione Base
```php
use Modules\Media\Filament\Resources\HasMediaResource\RelationManagers\MediaRelationManager;

class YourResource extends Resource
{

## MediaRelationManager

_Fonte: `relation_managers/media-relation-manager.md`_

# MediaRelationManager

## Descrizione
Questo file gestisce la relazione media all'interno del sistema Filament, seguendo le best practices di Laraxot.

## Modifiche Effettuate
- Risoluzione dei conflitti di merge
- Implementazione corretta delle azioni della tabella secondo le convenzioni Filament
- Aggiunta di tipizzazione stretta per i metodi
- Rimozione di codice duplicato

## Struttura
- Namespace: `Modules\Media\Filament\Resources\HasMediaResource\RelationManagers`
- Classe Base: `XotBaseRelationManager`
- Relazione: `media`
- Relazione Inversa: `model`

## Azioni della Tabella
Le azioni sono implementate seguendo le convenzioni documentate in `filament_table_actions.md`:
- Chiavi in snake_case
- Tipizzazione stretta
- Documentazione PHPDoc completa

## Collegamenti
- [Convenzioni Table Actions](../filament_table_actions.md)
- [Documentazione Media Module](../module_media.md)

## Note di Manutenzione
- Mantenere la coerenza con le convenzioni di naming
- Assicurarsi che tutte le azioni abbiano chiavi stringa

## MediaRelationManager

_Fonte: `resources/media-relation-manager.md`_

# MediaRelationManager

Il MediaRelationManager è un componente Filament che gestisce le relazioni media seguendo le convenzioni Laraxot.

## Caratteristiche principali

- Gestione delle relazioni media
- Supporto per azioni personalizzate
- Integrazione con il sistema di risorse Filament
- Estensione di XotBaseRelationManager

## Configurazione

### Relazioni
```php
protected static string $relationship = 'media';
protected static ?string $inverseRelationship = 'model';
```

## Azioni disponibili

### Header della tabella
- `AddAttachmentAction`: Permette di aggiungere nuovi allegati

## Integrazione

### Traits utilizzati
- `NavigationLabelTrait`: Per la gestione delle etichette di navigazione

### Classi base
