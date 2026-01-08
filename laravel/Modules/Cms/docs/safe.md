# Utilizzo di Safe nel Progetto il progetto

## Introduzione

[Safe](https://github.com/thecodingmachine/safe) è una libreria che fornisce versioni sicure delle funzioni PHP native. Queste funzioni lanciano eccezioni anziché restituire `false` in caso di errore, rendendo il codice più sicuro e più facile da leggere.

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

Per garantire che tutte le funzioni PHP siano utilizzate in modo sicuro, è possibile installare la regola PHPStan di Safe:

```bash
composer require --dev thecodingmachine/phpstan-safe-rule
```

Aggiungere poi al file `phpstan.neon.dist`:

```neon
includes:
    - vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon
```

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