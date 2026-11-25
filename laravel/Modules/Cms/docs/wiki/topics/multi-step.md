---
title: "Topic multi-step"
type: digest
status: active
qmd: "digest ceiling 100 multi-step"
---

# Topic multi-step

Sintesi automatica di 3 documenti (chiave `multi-step`).

## Form Multi-Step nel Modulo CMS

_Fonte: `components/multi-step-forms.md`_

# Form Multi-Step nel Modulo CMS

## Introduzione

Questa guida spiega come implementare form multi-step nel modulo CMS utilizzando Laravel Volt e Folio. I form multi-step sono utili per raccogliere grandi quantità di dati in modo organizzato e user-friendly.

## Setup Iniziale

### 1. Installazione Dipendenze
```bash
composer require livewire/volt laravel/folio
php artisan volt:install
```

### 2. Struttura Database
```php
// Esempio di migrazione per un form multi-step
public function up()
{
    Schema::create('form_submissions', function (Blueprint $table) {
        $table->id();
        $table->string('step_1_field');
        $table->string('step_2_field');
        $table->jsonb('additional_data')->nullable();
        $table->timestamps();
    });
}
```

## multi-step-forms-2

_Fonte: `multi-step-forms-2.md`_

See canonical documentation: ../../../Themes/docs/shared-components/multi-step-forms.md

## Form Multi-Step con Laravel Volt e Folio

_Fonte: `multi-step-forms.md`_

# Form Multi-Step con Laravel Volt e Folio

Questa guida spiega come implementare form multi-step utilizzando Laravel Volt e Folio, con particolare attenzione alla gestione dei dati e alla user experience.

## Prerequisiti

- Laravel 10+
- Composer
- PHP 8.1 o superiore
- Conoscenza base di Laravel e database relazionali

## Installazione Componenti

### 1. Laravel Folio per il Routing

```bash
composer require laravel/folio
```

### 2. Laravel Volt per la Reattività

```bash
composer require livewire/volt
php artisan volt:install
```

## Struttura del Database

### 1. Tabella Principale (applicants)
