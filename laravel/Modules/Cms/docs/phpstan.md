---
title: "phpstan"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-20
qmd: "phpstan cms legacy neon dist non gate solo laravel phpstan.neon"
issues: []
discussions: []
status: draft
related:
  - ./00-index.md
  - ../../Xot/docs/wiki/memories/phpstan-single-neon-config.md
---

<!--
GateGuard facts:
1. Supersedes stale "use phpstan.neon.dist as config" in this same file; canon is Xot phpstan-single-neon-config.md.
2. Linked from 00-INDEX quality section; indexed as Cms docs/phpstan.md.
3. Edit existing file — not a new topic doc.
4. User: "devi utilizzare laravel/phpstan.neon e solo io posso modificarlo, non puoi creare altri .neon"
-->

# Configurazione PHPStan per i moduli

> **Avviso (2026-10-20):** questo file e' **legacy/archivio**. Il gate operativo e' **solo** `laravel/phpstan.neon` (solo l'umano lo modifica). Agenti: `cd laravel && ./vendor/bin/phpstan analyse …` senza `-c`, `--level`, neon di modulo o temp. `Modules/*/phpstan.neon.dist` e gli esempi sotto **non** sono il gate. Canon: [phpstan-single-neon-config](../../Xot/docs/wiki/memories/phpstan-single-neon-config.md). Indice Cms: [00-INDEX.md](./00-index.md).

## Introduzione

Per analizzare il codice nei nostri moduli, utilizziamo PHPStan con l'estensione Larastan. Inoltre, consideriamo l'utilizzo di Safe per gestire meglio gli errori nelle funzioni PHP.

## Configurazione base (storico — non usare come gate)

Il file `phpstan.neon.dist` di modulo e' **legacy**: non crearlo, non citarlo come gate. Esempio storico (non operativo):

```neon
includes:
    - phpstan-baseline.neon
    - ../../vendor/larastan/larastan/extension.neon

parameters:
    level: 4
    paths:
        - app

    excludePaths:
        - app/Filament/Pages
        - build
        - vendor
        - Tests

    ignoreErrors:
        - '#Unsafe usage of new static#'
        - '#Access to an undefined property#'
        - '#Call to an undefined method#'

    checkMissingIterableValueType: false

    # Paths to scan
    scanDirectories:
        - ../../vendor/laravel/framework
        - ../Xot
```

## Note importanti per il progetto

### ServiceProvider personalizzati

Nel progetto il progetto utilizziamo classi base personalizzate invece delle classi standard di Laravel:

- Non estendiamo `Illuminate\Foundation\Support\Providers\RouteServiceProvider` ma utilizziamo `XotBaseRouteServiceProvider`
- Questo può causare problemi con Larastan che cerca le classi standard di Laravel

Per risolvere questi problemi, è importante:
1. Escludere classi specifiche negli `ignoreErrors`
2. Aggiungere i percorsi personalizzati nei `scanDirectories` (come ../Xot)

## Livelli di analisi

PHPStan offre diversi livelli di analisi, da 0 (più permissivo) a 9 (più restrittivo):

- Livello 0: Errori di base
- Livello 4: Consigliato per progetti esistenti
- Livello 8: Consigliato per nuovi progetti
- Livello 9: Massima restrizione

## Baseline

Per gestire errori esistenti in codice legacy, è possibile generare un file baseline:

```bash
./vendor/bin/phpstan analyse --generate-baseline
```

Questo creerà un file `phpstan-baseline.neon` con gli errori attuali ignorati.

## Utilizzo di Safe

Safe è una libreria che fornisce versioni sicure delle funzioni PHP che lanciano eccezioni anziché restituire false in caso di errore.

### Installazione

```bash
composer require thecodingmachine/safe
```

### Uso

Invece di:

```php
$content = file_get_contents('file.txt');
if ($content === false) {
    throw new Exception('Errore lettura file');
}
```

Usare:

```php
use function Safe\file_get_contents;

$content = file_get_contents('file.txt'); // Lancia un'eccezione in caso di errore
```

### Regola PHPStan

Per verificare che tutte le funzioni PHP siano utilizzate in modo sicuro, installare:

```bash
composer require --dev thecodingmachine/phpstan-safe-rule
```

Se serve l'include Safe, **solo l'umano** lo aggiunge a `laravel/phpstan.neon`. Non aggiungere a `phpstan.neon.dist` di modulo (legacy).

## Correzione automatica

Utilizzare Rector per correggere automaticamente le chiamate alle funzioni:

```bash
composer require --dev rector/rector
vendor/bin/rector process app/ --config vendor/thecodingmachine/safe/rector-migrate.php
```
