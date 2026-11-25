---
title: "Topic static-text"
type: digest
status: active
qmd: "digest ceiling 100 static-text"
---

# Topic static-text

Sintesi automatica di 4 documenti (chiave `static-text`).

## Traduzione di Testi Statici in Laravel

_Fonte: `static-text-translation.md`_

# Traduzione di Testi Statici in Laravel

## Introduzione

La traduzione di testi statici in Laravel può essere gestita utilizzando due approcci principali: file PHP e file JSON. Questa documentazione, basata sul corso di Laravel Daily, analizza entrambi i metodi, evidenziando vantaggi e svantaggi, e propone un'implementazione per il progetto `<nome progetto>`.

## Opzioni di Archiviazione delle Traduzioni

### File PHP

I file PHP sono stati il metodo predefinito per lungo tempo. Le traduzioni sono organizzate in file separati per lingua e funzionalità.

**Esempio**:
In un file Blade come `resources/views/auth/register.blade.php`, potremmo avere:
In un file Blade come `resources/views/auth/register.blade.php`, potremmo avere:
In un file Blade come `/var/www/html/<nome progetto>/laravel/resources/views/auth/register.blade.php`, potremmo avere:
In un file Blade come `/var/www/html/<nome progetto>/laravel/resources/views/auth/register.blade.php`, potremmo avere:
In un file Blade come `/var/www/html/<nome progetto>/laravel/resources/views/auth/register.blade.php`, potremmo avere:
In un file Blade come `/var/www/html/<nome progetto>/laravel/resources/views/auth/register.blade.php`, potremmo avere:
In un file Blade come `resources/views/auth/register.blade.php`, potremmo avere:
In un file Blade come `resources/views/auth/register.blade.php`, potremmo avere:
```php
<!-- Nome -->
<div>
    <x-input-label for="name" :value="__('auth.register.name')" />
    <x-text-input id="name" cla

## Divergenza: `static-text-translation-2.md`

_Fonte: `wiki/integrations/_da-riconciliare/static-text-translation-2.divergenza.md`_

# Divergenza: `static-text-translation-2.md`

Questo file veniva da `../../../static-text-translation-2.md`, cancellato dal working tree senza migrazione. Il modulo ha gia' un file con lo stesso nome, ma con **corpo diverso**:

- versione del modulo: `laravel/Modules/Lang/docs/static-text-translation-2.md`
- versione recuperata: `laravel/Modules/Lang/docs/wiki/integrations/_da-riconciliare/static-text-translation-2.md`

Vanno confrontate e fuse a mano. Quando la fusione e' fatta, questo file e la nota vanno rimossi.

Vedi [XOT-5.39](../../../stories/5.39.wiki-integrations-ownership.story.md).

## Divergenza: `static_text_translation.md`

_Fonte: `wiki/integrations/_da-riconciliare/static-text-translation.divergenza.md`_

# Divergenza: `static_text_translation.md`

Questo file veniva da `docs/wiki/integrations/modules/lang/static_text_translation.md`, cancellato dal working tree senza migrazione. Il modulo ha gia' un file con lo stesso nome, ma con **corpo diverso**:

- versione del modulo: `laravel/Modules/Lang/docs/static-text-translation.md`
- versione recuperata: `laravel/Modules/Lang/docs/wiki/integrations/_da-riconciliare/static_text_translation.md`

Vanno confrontate e fuse a mano. Quando la fusione e' fatta, questo file e la nota vanno rimossi.

Vedi [XOT-5.39](../../../stories/5.39.wiki-integrations-ownership.story.md).

## Traduzione di Testi Statici in Laravel

_Fonte: `wiki/integrations/_da-riconciliare/static-text-translation.md`_

# Traduzione di Testi Statici in Laravel

## Introduzione

La traduzione di testi statici in Laravel può essere gestita utilizzando due approcci principali: file PHP e file JSON. Questa documentazione, basata sul corso di Laravel Daily, analizza entrambi i metodi, evidenziando vantaggi e svantaggi, e propone un'implementazione per il progetto `<nome progetto>corrente`.

## Opzioni di Archiviazione delle Traduzioni

### File PHP

I file PHP sono stati il metodo predefinito per lungo tempo. Le traduzioni sono organizzate in file separati per lingua e funzionalità.

**Esempio**:
In un file Blade come `[project-root]/laravel/resources/views/auth/register.blade.php`, potremmo avere:
```php
<!-- Nome -->
<div>
    <x-input-label for="name" :value="__('auth.register.name')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
```

La traduzione corrispondente sarebbe in `[project-root]/laravel/lang/it/auth.php`:
```php
return [
    'register' => [
        'name' => 'Nome',
        'email' => 'Email',
        // ...
