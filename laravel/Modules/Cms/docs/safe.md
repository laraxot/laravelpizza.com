---
title: "safe"
type: note
tags: [documentation, cms, testing]
created: 2026-09-26
updated: 2026-10-20
qmd: "safe thecodingmachine cms json filesystem test"
issues: []
discussions: []
status: active
related:
  - ./00-index.md
  - ./scopo.md
  - ./content-blocks-architecture.md
---

# Utilizzo di Safe nel modulo Cms

Indice: [00-INDEX.md](./00-index.md) · scopo: [scopo.md](./scopo.md).

## Perché qui

Cms legge/scrive JSON e path di tenant. `file_get_contents` / `json_decode` nativi tornano `false` e PHPStan li tratta come `string|false`: i test che assumono stringa "funzionano" finché il path è sbagliato. Safe forza l'errore esplicito — allinea runtime e analisi statica allo scopo (contenuto JSON affidabile).

## Introduzione

[Safe](https://github.com/thecodingmachine/safe) fornisce versioni sicure delle funzioni PHP native: lanciano eccezioni anziché restituire `false`.

## Installazione

Per installare Safe nel progetto, eseguire:

```bash
composer require thecodingmachine/safe
```

## Utilizzo Base

### Prima (senza Safe)

```php
$content = file_get_contents('file.txt');
if ($content === false) {
    throw new Exception('Impossibile leggere il file file.txt');
}

$data = json_decode($content, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    throw new Exception('JSON non valido: ' . json_last_error_msg());
}
```

### Dopo (con Safe)

```php
use function Safe\file_get_contents;
use function Safe\json_decode;

$content = file_get_contents('file.txt'); // Lancia un'eccezione se il file non esiste
$data = json_decode($content, true); // Lancia un'eccezione se il JSON non è valido
```

## Integrazione con PHPStan

<!--
GateGuard facts:
1. Supersedes nothing — corrects stale neon.dist advice in this same safe.md.
2. Linked from 00-INDEX.md and scopo.md (related).
3. Edit existing file; not a new doc.
4. User: "devi utilizzare laravel/phpstan.neon e solo io posso modificarlo, non puoi creare altri .neon"
-->

Gate unico del monorepo: solo `laravel/phpstan.neon` (modifica = solo umano; agenti mai `-c` / neon di modulo). Canon: [phpstan-single-neon-config](../../Xot/docs/wiki/memories/phpstan-single-neon-config.md).

Per garantire che tutte le funzioni PHP siano utilizzate in modo sicuro, è possibile installare la regola PHPStan di Safe:

```bash
composer require --dev thecodingmachine/phpstan-safe-rule
```

Se serve includere `phpstan-safe-rule.neon`, **chiedere all'umano** di aggiornare `laravel/phpstan.neon`. Non creare `phpstan.neon.dist` di modulo (legacy/archivio, non gate) e non usare `-c` verso altri `.neon`.

## Migrazione Automatica

Per convertire automaticamente tutte le funzioni PHP nelle loro varianti safe, utilizzare Rector:

```bash
composer require --dev rector/rector
vendor/bin/rector process Modules/Cms/app --config vendor/thecodingmachine/safe/rector-migrate.php
```

## Funzioni Supportate

Safe supporta tutte le funzioni PHP principali che restituiscono `false` in caso di errore, tra cui:

- File system (`file_get_contents`, `file_put_contents`, `mkdir`, ...)
- JSON (`json_decode`, `json_encode`, ...)
- Stringhe (`substr`, `strpos`, ...)
- Array (`array_merge`, `array_search`, ...)
- Date (`date`, `date_create`, ...)
- cURL (`curl_init`, `curl_exec`, ...)
- E molte altre...

## Gestione delle Eccezioni

Tutte le funzioni Safe lanciano eccezioni specifiche per ciascun gruppo di funzioni:

```php
try {
    $content = Safe\file_get_contents('file.txt');
} catch (Safe\Exceptions\FilesystemException $e) {
    // Gestire l'errore specifico del file system
}

try {
    $data = Safe\json_decode($content);
} catch (Safe\Exceptions\JsonException $e) {
    // Gestire l'errore specifico del JSON
}
```

## Performance

L'impatto sulle performance è minimo, circa 700μs per richiesta. Questo è un compromesso accettabile rispetto al miglioramento della sicurezza e della leggibilità del codice.
