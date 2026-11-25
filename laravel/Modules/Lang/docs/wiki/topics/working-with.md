---
title: "Topic working-with"
type: digest
status: active
qmd: "digest ceiling 100 working-with"
---

# Topic working-with

Sintesi automatica di 4 documenti (chiave `working-with`).

## Divergenza: `working-with-locales-2.md`

_Fonte: `wiki/integrations/_da-riconciliare/working-with-locales-2.divergenza.md`_

# Divergenza: `working-with-locales-2.md`

Questo file veniva da `../../../working-with-locales-2.md`, cancellato dal working tree senza migrazione. Il modulo ha gia' un file con lo stesso nome, ma con **corpo diverso**:

- versione del modulo: `laravel/Modules/Lang/docs/working-with-locales-2.md`
- versione recuperata: `laravel/Modules/Lang/docs/wiki/integrations/_da-riconciliare/working-with-locales-2.md`

Vanno confrontate e fuse a mano. Quando la fusione e' fatta, questo file e la nota vanno rimossi.

Vedi [XOT-5.39](../../../stories/5.39.wiki-integrations-ownership.story.md).

## Divergenza: `working_with_locales.md`

_Fonte: `wiki/integrations/_da-riconciliare/working-with-locales.divergenza.md`_

# Divergenza: `working_with_locales.md`

Questo file veniva da `docs/wiki/integrations/modules/lang/working_with_locales.md`, cancellato dal working tree senza migrazione. Il modulo ha gia' un file con lo stesso nome, ma con **corpo diverso**:

- versione del modulo: `laravel/Modules/Lang/docs/working-with-locales.md`
- versione recuperata: `laravel/Modules/Lang/docs/wiki/integrations/_da-riconciliare/working_with_locales.md`

Vanno confrontate e fuse a mano. Quando la fusione e' fatta, questo file e la nota vanno rimossi.

Vedi [XOT-5.39](../../../stories/5.39.wiki-integrations-ownership.story.md).

## Gestione delle Lingue (Locales) in Laravel

_Fonte: `wiki/integrations/_da-riconciliare/working-with-locales.md`_

# Gestione delle Lingue (Locales) in Laravel

## Introduzione

In Laravel, la gestione delle lingue (locales) è fondamentale per determinare quale lingua utilizzare per le traduzioni. Ogni progetto Laravel ha una lingua predefinita e una di fallback. Questa documentazione, basata sul corso di Laravel Daily, esplora come configurare queste impostazioni e propone modifiche per il progetto `<nome progetto>corrente`.

## Configurazione della Lingua Predefinita

Per impostare la lingua predefinita dell'applicazione, modificare il file `config/app.php`:

```php
'locale' => 'it',
// Deve corrispondere al nome della cartella in `lang/FOLDER` o al nome del file `lang/KEY.json`.
```

Questa sarà la lingua predefinita per tutti gli utenti dell'applicazione. È importante non lasciare il valore predefinito 'en' se l'applicazione è destinata a un pubblico con una lingua diversa.

## Configurazione della Lingua di Fallback

La lingua di fallback viene utilizzata quando una traduzione non è disponibile nella lingua predefinita. Configurarla in `config/app.php`:

```php
'fallback_locale' => 'en',
```

Quando una traduzione manca nella lingua predefinita, Laravel cercherà la traduzione nella lingua di fallback. Ad esempio, se la lingua predefinita è 'it' e manca una traduzione per 'register', Laravel utilizzerà la traduzione da `lang/en/auth.php`:

```php
return [
    // ...

## Gestione delle Lingue (Locales) in Laravel

_Fonte: `working-with-locales.md`_

# Gestione delle Lingue (Locales) in Laravel

## Introduzione

In Laravel, la gestione delle lingue (locales) è fondamentale per determinare quale lingua utilizzare per le traduzioni. Ogni progetto Laravel ha una lingua predefinita e una di fallback. Questa documentazione, basata sul corso di Laravel Daily, esplora come configurare queste impostazioni e propone modifiche per il progetto `<nome progetto>`.

## Configurazione della Lingua Predefinita

Per impostare la lingua predefinita dell'applicazione, modificare il file `config/app.php`:

```php
'locale' => 'it',
// Deve corrispondere al nome della cartella in `lang/FOLDER` o al nome del file `lang/KEY.json`.
```

Questa sarà la lingua predefinita per tutti gli utenti dell'applicazione. È importante non lasciare il valore predefinito 'en' se l'applicazione è destinata a un pubblico con una lingua diversa.

## Configurazione della Lingua di Fallback

La lingua di fallback viene utilizzata quando una traduzione non è disponibile nella lingua predefinita. Configurarla in `config/app.php`:

```php
'fallback_locale' => 'en',
```

Quando una traduzione manca nella lingua predefinita, Laravel cercherà la traduzione nella lingua di fallback. Ad esempio, se la lingua predefinita è 'it' e manca una traduzione per 'register', Laravel utilizzerà la traduzione da `lang/en/auth.php`:

```php
return [
    // ...
