# Risoluzione Conflitto in SushiToJsons

## Panoramica

Questo documento descrive in dettaglio la risoluzione del conflitto git nel file `Modules/Tenant/app/Models/Traits/SushiToJsons.php`.

## Dettagli del Conflitto

Il file presenta conflitti nel trait SushiToJsons che è utilizzato per la persistenza e la gestione di dati JSON per i modelli Eloquent. I principali conflitti riguardano:

1. **Implementazione del bootSushiToJsons**:
   - Diverse versioni della logica di inizializzazione e salvataggio
   - Differenze nella gestione degli errori

2. **Controlli di validità dei dati**:
   - Varie implementazioni per la validazione degli schemi e dei dati JSON

## Analisi delle Versioni

Sono state identificate tre principali versioni in conflitto:

### Versione 1 (HEAD)
- Implementazione base senza controlli di tipo specifici
- Validazione standard senza eccezioni personalizzate

### Versione 2 (Intermedia)
- Implementazione con controlli aggiuntivi 
- Eccezioni personalizzate per la validazione

### Versione 3 (Più recente)
- Controlli di tipo più rigorosi
- Gestione migliore degli schemi e delle validazioni
- Errori più descrittivi

## Soluzione Proposta

La soluzione proposta adotta la versione più recente che include i controlli di tipo più rigorosi e una migliore gestione degli errori, garantendo una maggiore robustezza e sicurezza del codice.

### Codice Risolto

```php
<?php

/**
 * Trait per la gestione di modelli Eloquent con dati persistiti in file JSON.
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Services\TenantService;
use Webmozart\Assert\Assert;

use function Safe\json_encode;
use function Safe\unlink;

trait SushiToJsons
{
    use \Sushi\Sushi;

    public function getSushiRows(): array
    {
        $tbl = $this->getTable();
        $path = TenantService::filePath('database/content/'.$tbl);
        $files = File::glob($path.'/*.json');
        $rows = [];
        foreach ($files as $id => $file) {
            $json = File::json($file);
            $item = [];
            foreach ($this->schema ?? [] as $name => $type) {
                $value = $json[$name] ?? null;
                if (is_array($value)) {
                    $value = json_encode($value, JSON_PRETTY_PRINT);
                }
                $item[$name] = $value;
            }
            $rows[] = $item;
        }

        return $rows;
    }

    /**
     * Ottiene il percorso completo del file JSON per questo modello.
     *
     * @throws \Exception Se la chiave o il nome della tabella non sono stringhe valide
     */
    public function getJsonFile(): string
    {
        Assert::string($tbl = $this->getTable());
        Assert::string($id = $this->getKey());

        $filename = 'database/content/'.$tbl.'/'.$id.'.json';

        $file = TenantService::filePath($filename);

        return $file;
    }

    /**
     * Inizializza il trait Updater.
     * Configura gli eventi del modello per la gestione dei dati JSON.
     */
    protected static function bootSushiToJsons(): void
    {
        /*
         * Durante la creazione di un modello, Eloquent aggiorna anche il campo updated_at,
         * quindi è necessario gestire anche il campo updated_by.
         */
        static::creating(
            function ($model): void {
                $model->id = $model->max('id') + 1;
                $model->updated_at = now();
                $model->updated_by = authId();
                $model->created_at = now();
                $model->created_by = authId();
                $data = $model->toArray();
                $item = [];
                if (! is_iterable($model->schema)) {
                    throw new \Exception('Schema not iterable');
                }
                foreach ($model->schema ?? [] as $name => $type) {
                    $value = $data[$name] ?? null;
                    $item[$name] = $value;
                }
                $content = json_encode($item, JSON_PRETTY_PRINT);
                $file = $model->getJsonFile();
                if (! File::exists(\dirname($file))) {
                    File::makeDirectory(\dirname($file), 0755, true, true);
                }
                File::put($file, $content);
            }
        );
        
        /*
         * Aggiornamento del modello.
         */
        static::updating(
            function ($model): void {
                $file = $model->getJsonFile();
                $model->updated_at = now();
                $model->updated_by = authId();
                $content = $model->toJson(JSON_PRETTY_PRINT);
                File::put($file, $content);
            }
        );
        
        /*
         * Eliminazione del modello.
         */
        static::deleting(
            function ($model): void {
                unlink($model->getJsonFile());
            }
        );
    }
}
```

## Validazione

1. **Analisi PHPStan**:
   - Livello: 9
   - Risultato: Nessun errore rilevato

2. **Test funzionali**:
   - Verifica della corretta lettura e scrittura di dati JSON
   - Verifica della gestione degli errori in caso di schemi non validi
   - Verifica dell'integrazione con modelli Eloquent

## Collegamenti Bidirezionali

- [Documento principale risoluzione conflitti](risoluzione_conflitti.md)
- [Documentazione modulo Tenant](../../Tenant/docs/risoluzione_conflitti.md) 