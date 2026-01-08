# Funzioni Safe nel Modulo Xot

## Panoramica

Il modulo Xot utilizza il pacchetto `thecodingmachine/safe` per garantire che le funzioni PHP potenzialmente pericolose lancino eccezioni invece di restituire `false` in caso di errore.

## Funzioni da Utilizzare

### Manipolazione JSON
```php
use function Safe\json_decode;
use function Safe\json_encode;
```

### Espressioni Regolari
```php
use function Safe\preg_match;
use function Safe\preg_match_all;
use function Safe\preg_replace;
```

### File System
```php
use function Safe\glob;
use function Safe\file_get_contents;
use function Safe\file_put_contents;
```

### Date e Logging
```php
use function Safe\date;
use function Safe\error_log;
```

## Implementazione

### 1. Import delle Funzioni
All'inizio di ogni file che utilizza queste funzioni, importare le versioni Safe:

```php
declare(strict_types=1);

namespace Modules\Xot\Commands;

use function Safe\json_decode;
use function Safe\preg_match;
// altri import necessari
```

### 2. Gestione delle Eccezioni
Le funzioni Safe lanciano `\Safe\Exceptions\SafeException` in caso di errore:

```php
try {
    $data = json_decode($input, true);
} catch (\Safe\Exceptions\JsonException $e) {
    // Gestione dell'errore
}
```

## Files da Aggiornare

1. Console Commands:
   - `DatabaseSchemaExportCommand.php`
   - `DatabaseSchemaExporterCommand.php`
   - `GenerateDbDocumentationCommand.php`
   - `GenerateModelsFromSchemaCommand.php`
   - `GenerateResourceFormSchemaCommand.php`

2. Helpers:
   - `ResourceFormSchemaGenerator.php`

## Best Practices

1. **Sempre Usare Safe**:
   - Non utilizzare mai le funzioni PHP native per operazioni critiche
   - Importare sempre le funzioni Safe necessarie
   - Gestire le eccezioni in modo appropriato

2. **Gestione Errori**:
   - Catturare le eccezioni specifiche quando possibile
   - Fornire messaggi di errore chiari
   - Loggare gli errori in modo appropriato

3. **Documentazione**:
   - Commentare l'uso delle funzioni Safe
   - Specificare il tipo di eccezioni che possono essere lanciate
   - Mantenere aggiornata la documentazione

## Note sulla Migrazione

Quando si migrano le funzioni da PHP native a Safe:
1. Identificare tutte le occorrenze delle funzioni unsafe
2. Aggiungere gli import necessari
3. Aggiornare la gestione degli errori
4. Testare il nuovo comportamento
5. Aggiornare la documentazione

# Utilizzo delle Safe Functions in Laraxot

## Introduzione
Le funzioni PHP native possono restituire `false` in caso di errore invece di lanciare eccezioni. Per garantire una gestione più robusta degli errori, utilizziamo il pacchetto `thecodingmachine/safe`.

## Regole Fondamentali

### 1. Import delle Funzioni Safe
All'inizio di ogni file che usa funzioni potenzialmente unsafe, importare le versioni sicure:

```php
use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\preg_match;
use function Safe\preg_replace;
use function Safe\glob;
```

### 2. Funzioni da Sostituire Sempre

| Funzione PHP Nativa | Versione Safe da Usare | Motivo |
|-------------------|------------------------|---------|
| `file_get_contents` | `Safe\file_get_contents` | Può restituire false se il file non esiste |
| `file_put_contents` | `Safe\file_put_contents` | Può fallire silenziosamente |
| `preg_match` | `Safe\preg_match` | Può restituire false per errori di sintassi |
| `preg_replace` | `Safe\preg_replace` | Può restituire null o false |
| `glob` | `Safe\glob` | Può restituire false per errori di permessi |
| `json_decode` | `Safe\json_decode` | Può restituire null per JSON invalido |
| `json_encode` | `Safe\json_encode` | Può restituire false per errori di codifica |

### 3. Gestione delle Eccezioni
Le funzioni Safe lanciano sempre eccezioni in caso di errore:

```php
try {
    $content = Safe\file_get_contents($filename);
} catch (\Safe\Exceptions\FilesystemException $e) {
    // Gestione appropriata dell'errore
    throw new \Exception('Impossibile leggere il file: '.$e->getMessage());
}
```

### 4. Casi Speciali nel ResourceFormSchemaGenerator

Nel contesto del `ResourceFormSchemaGenerator`, è particolarmente importante usare le funzioni Safe per:

1. Lettura file di classe:
```php
$fileContents = Safe\file_get_contents($filename);
```

2. Ricerca file con glob:
```php
$resourceFiles = Safe\glob($pattern);
```

3. Manipolazione contenuti:
```php
Safe\preg_match('/pattern/', $content, $matches);
Safe\file_put_contents($filename, $modifiedContents);
```

### 5. Best Practices

1. **Mai Usare Funzioni Native**:
   ```php
   // ❌ NON FARE
   $content = file_get_contents($file);
   
   // ✅ CORRETTO
   $content = Safe\file_get_contents($file);
   ```

2. **Gestire Sempre le Eccezioni**:
   ```php
   // ❌ NON FARE
   Safe\file_put_contents($file, $content);
   
   // ✅ CORRETTO
   try {
       Safe\file_put_contents($file, $content);
   } catch (\Safe\Exceptions\FilesystemException $e) {
       // Log e gestione appropriata
   }
   ```

3. **Documentare le Eccezioni**:
   ```php
   /**
    * @throws \Safe\Exceptions\FilesystemException Se il file non può essere letto
    */
   public function readConfig(string $filename): array
   ```

## Riferimenti
- [Documentazione thecodingmachine/safe](https://github.com/thecodingmachine/safe)
- [Lista completa funzioni Safe](https://github.com/thecodingmachine/safe/blob/master/generated/Safe.php)
- [Gestione Eccezioni in PHP](https://www.php.net/manual/en/language.exceptions.php) 