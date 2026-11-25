---
title: "Topic navigation"
type: digest
status: active
qmd: "digest ceiling 100 navigation"
---

# Topic navigation

Sintesi automatica di 3 documenti (chiave `navigation`).

## NavigationBlock

_Fonte: `blocks/navigation.md`_

# NavigationBlock

## Descrizione
Il NavigationBlock è un blocco Filament che gestisce la creazione e modifica di menu di navigazione all'interno del CMS. Supporta titoli opzionali per organizzare i menu in sezioni.

## Caratteristiche
- Gestione multilingua
- Supporto per menu gerarchici
- Titoli di sezione opzionali
- Configurazione target link
- Gestione stato attivo/inattivo
- Ordinamento drag-and-drop

## Schema
```php
Block::make('navigation')
    ->label('Navigazione')
    ->schema([
        TextInput::make('title')
            ->label('Titolo')
            ->nullable(),
        Repeater::make('items')
            ->label('Voci Menu')
            ->schema([
                TextInput::make('label')->required(),
                TextInput::make('url')->required(),
                Toggle::make('is_active')->default(true),
                TextInput::make('target')->default('_self'),
            ])

## Componenti di Navigazione

_Fonte: `components/navigation.md`_

# Componenti di Navigazione

## Introduzione

I componenti di navigazione sono fondamentali per guidare gli utenti attraverso l'applicazione. Questa sezione documenta i componenti di navigazione disponibili nel modulo CMS.

## Breadcrumb

### Utilizzo Base
```php
<x-cms::breadcrumb>
    <x-cms::breadcrumb.item href="/">Home</x-cms::breadcrumb.item>
    <x-cms::breadcrumb.item href="/blog">Blog</x-cms::breadcrumb.item>
    <x-cms::breadcrumb.item>Articolo</x-cms::breadcrumb.item>
</x-cms::breadcrumb>
```

### Proprietà
- `separator`: string - Separatore personalizzato
- `responsive`: boolean - Comportamento responsivo
- `schema`: boolean - Aggiunge schema.org markup

### Best Practices
1. Mantenere la gerarchia chiara
2. Limitare la profondità
3. Utilizzare URL significativi
4. Includere la pagina corrente

## Pagination

## Navigation {#navigation}

_Fonte: `navigation.md`_

# Navigation {#navigation}

The navigation menu in the left-hand sidebar is defined using an array in `navigation.php`. Nested pages can be added by using the `children` associative array.

```php
<?php
// navigation.php

return [
    'Getting Started' => [
        'url' => 'docs/getting-started',
        'children' => [
            'Customizing Your Site' => 'docs/customizing-your-site',
            'Navigation' => 'docs/navigation',
            'Algolia DocSearch' => 'docs/algolia-docsearch',
            'Custom 404 Page' => 'docs/custom-404-page',
        ],
    ],
    'Jigsaw Docs' => 'https://jigsaw.tighten.co/docs/installation',
];

// config.php
'navigation' => require_once('navigation.php'),

// blade files
$page->navigation
```

## Collegamenti tra versioni di navigation.md
