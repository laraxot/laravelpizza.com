# GetFilenameBySchedaAction - Generazione Nome File PDF

## Panoramica

`GetFilenameBySchedaAction` è una action dedicata alla generazione di nomi file PDF per le schede, centralizzando la logica di naming e garantendo coerenza e riutilizzabilità in tutto il modulo Ptv.

## Business Logic

### Perché una Action Separata?

**Problema**: Logica di generazione nome file duplicata in più punti del codice
- `SendMailByRecord.php` - generazione nome file per allegati email
- `ZipSchedeBulkAction.php` - generazione nome file per file ZIP
- Potenziali altre azioni future

**Soluzione**: Centralizzare la logica in una action dedicata
- ✅ **DRY (Don't Repeat Yourself)**: Una sola implementazione
- ✅ **Manutenibilità**: Modifiche in un solo punto
- ✅ **Testabilità**: Test unitari dedicati
- ✅ **Coerenza**: Stesso pattern di naming ovunque
- ✅ **Sanitizzazione**: Gestione caratteri problematici centralizzata

## Architettura

### Pattern di Naming

```
scheda_{id}_{matr}_{cognome}_{nome}.pdf
```

**Esempio**:
```
scheda_123_45678_Rossi_Mario.pdf
```

**Fallback**:
```
scheda.pdf
```

### Flusso di Esecuzione

```
GetFilenameBySchedaAction::execute($scheda)
    ↓
1. Verifica disponibilità campi identificativi (id, matr, cognome, nome)
    ↓
2. Se disponibili:
   ├─ Normalizza ID (string)
   ├─ Normalizza matr (string o 'unknown')
   ├─ Sanitizza cognome (rimuove caratteri problematici)
   └─ Sanitizza nome (rimuove caratteri problematici)
    ↓
3. Costruisce nome file: scheda_{id}_{matr}_{cognome}_{nome}.pdf
    ↓
4. Se campi non disponibili:
   └─ Restituisce fallback: scheda.pdf
```

## Implementazione

### Codice Completo

```php
<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_replace;

class GetFilenameBySchedaAction
{
    use QueueableAction;

    /**
     * Genera il nome file PDF per una scheda.
     *
     * @param Scheda $scheda La scheda per cui generare il nome file
     * @return string Nome file PDF generato
     */
    public function execute(Scheda $scheda): string
    {
        if (
            isset($scheda->id) &&
            isset($scheda->matr) &&
            isset($scheda->cognome) &&
            isset($scheda->nome)
        ) {
            $id = (string) $scheda->id;
            $matr = is_string($scheda->matr) ? $scheda->matr : 'unknown';
            $cognome = is_string($scheda->cognome) 
                ? $this->sanitizeFilename($scheda->cognome) 
                : 'unknown';
            $nome = is_string($scheda->nome) 
                ? $this->sanitizeFilename($scheda->nome) 
                : 'unknown';

            return 'scheda_'.$id.'_'.$matr.'_'.$cognome.'_'.$nome.'.pdf';
        }

        return 'scheda.pdf';
    }

    /**
     * Sanitizza una stringa per essere utilizzata come parte di un nome file.
     *
     * @param string $filename Parte del nome file da sanitizzare
     * @return string Stringa sanitizzata
     */
    protected function sanitizeFilename(string $filename): string
    {
        // Rimuove caratteri problematici (mantiene solo alfanumerici, underscore, trattini)
        $sanitized = preg_replace('/[^a-zA-Z0-9_-]/', '', $filename);

        if ($sanitized === '' || $sanitized === null) {
            return 'unknown';
        }

        // Limita lunghezza per evitare nomi file troppo lunghi
        return mb_substr((string) $sanitized, 0, 50);
    }
}
```

## Sanitizzazione File Name

### Caratteri Rimossi

La funzione `sanitizeFilename()` rimuove:
- Spazi e caratteri speciali
- Accenti e caratteri Unicode problematici
- Caratteri di controllo
- Caratteri riservati filesystem (`/`, `\`, `:`, `*`, `?`, `"`, `<`, `>`, `|`)

### Caratteri Mantenuti

- Lettere maiuscole/minuscole (a-z, A-Z)
- Numeri (0-9)
- Underscore (`_`)
- Trattino (`-`)

### Limiti

- Lunghezza massima per parte: 50 caratteri
- Se dopo sanitizzazione è vuoto: `unknown`

### Esempi di Sanitizzazione

```php
// Input: "Rossi-Mario"
// Output: "Rossi-Mario" ✅ (mantiene trattino)

// Input: "Rossi Mario"
// Output: "RossiMario" ✅ (rimuove spazio)

// Input: "Rossi/Mario"
// Output: "RossiMario" ✅ (rimuove slash)

// Input: "Rossì"
// Output: "Rossi" ✅ (rimuove accento)

// Input: "123-ABC"
// Output: "123-ABC" ✅ (mantiene numeri e trattino)
```

## Utilizzo

### Esempio 1: Invio Email con Allegato

```php
use Modules\Ptv\Actions\Scheda\GetFilenameBySchedaAction;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

// Genera PDF binario
$pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);

// Genera nome file
$filename = app(GetFilenameBySchedaAction::class)->execute($record);

// Prepara allegato
$attachments = [
    [
        'data' => $pdfContent,
        'as' => $filename, // scheda_123_45678_Rossi_Mario.pdf
        'mime' => 'application/pdf',
    ],
];
```

### Esempio 2: Bulk Action ZIP

```php
use Modules\Ptv\Actions\Scheda\GetFilenameBySchedaAction;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

foreach ($records as $record) {
    // Genera PDF
    $pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
    
    // Genera nome file (coerente con email)
    $filename = app(GetFilenameBySchedaAction::class)->execute($record);
    
    // Aggiunge a ZIP
    $zip->addFromString($filename, $pdfContent);
}
```

### Esempio 3: Download Singolo PDF

```php
use Modules\Ptv\Actions\Scheda\GetFilenameBySchedaAction;

// Genera nome file per download
$filename = app(GetFilenameBySchedaAction::class)->execute($scheda);

// Download con nome file personalizzato
return response()->download($pdfPath, $filename);
```

## Best Practices

### 1. Riutilizzo della Action

**✅ DO**: Usare sempre `GetFilenameBySchedaAction` per generare nomi file

```php
// ✅ CORRETTO
$filename = app(GetFilenameBySchedaAction::class)->execute($scheda);
```

**❌ DON'T**: Duplicare la logica di generazione nome file

```php
// ❌ ERRATO
$filename = 'scheda_'.$record->id.'_'.$record->matr.'_'.$record->cognome.'_'.$record->nome.'.pdf';
```

### 2. Gestione Errori

**✅ DO**: Gestire fallback quando i campi non sono disponibili

```php
// La action gestisce automaticamente il fallback
$filename = app(GetFilenameBySchedaAction::class)->execute($scheda);
// Se campi mancanti → 'scheda.pdf'
```

### 3. Sanitizzazione

**✅ DO**: La action gestisce automaticamente la sanitizzazione

```php
// Non serve sanitizzare manualmente
$filename = app(GetFilenameBySchedaAction::class)->execute($scheda);
```

**❌ DON'T**: Non sanitizzare manualmente prima di passare alla action

```php
// ❌ ERRATO - sanitizzazione ridondante
$cognome = preg_replace('/[^a-zA-Z0-9_-]/', '', $scheda->cognome);
$filename = app(GetFilenameBySchedaAction::class)->execute($scheda);
```

## Testing

### Test Unitario Esempio

```php
<?php

declare(strict_types=1);

namespace Modules\Ptv\Tests\Unit\Actions\Scheda;

use Tests\TestCase;
use Modules\Ptv\Actions\Scheda\GetFilenameBySchedaAction;
use Modules\Ptv\Models\Schede;

class GetFilenameBySchedaActionTest extends TestCase
{
    /** @test */
    public function it_generates_filename_with_all_fields(): void
    {
        // Arrange
        $scheda = Schede::factory()->create([
            'id' => 123,
            'matr' => '45678',
            'cognome' => 'Rossi',
            'nome' => 'Mario',
        ]);

        // Act
        $filename = app(GetFilenameBySchedaAction::class)->execute($scheda);

        // Assert
        $this->assertEquals('scheda_123_45678_Rossi_Mario.pdf', $filename);
    }

    /** @test */
    public function it_sanitizes_special_characters(): void
    {
        // Arrange
        $scheda = Schede::factory()->create([
            'id' => 123,
            'matr' => '45678',
            'cognome' => "Rossi/Mario", // Contiene slash
            'nome' => "Mario'", // Contiene apostrofo
        ]);

        // Act
        $filename = app(GetFilenameBySchedaAction::class)->execute($scheda);

        // Assert
        $this->assertEquals('scheda_123_45678_RossiMario_Mario.pdf', $filename);
    }

    /** @test */
    public function it_returns_fallback_when_fields_missing(): void
    {
        // Arrange
        $scheda = Schede::factory()->create([
            'id' => 123,
            // matr, cognome, nome mancanti
        ]);

        // Act
        $filename = app(GetFilenameBySchedaAction::class)->execute($scheda);

        // Assert
        $this->assertEquals('scheda.pdf', $filename);
    }
}
```

## Integrazione con Altri Componenti

### SendMailByRecord

```php
// Modules/Ptv/app/Actions/Scheda/SendMailByRecord.php

$filename = app(GetFilenameBySchedaAction::class)->execute($record);

$attachments = [
    [
        'data' => $pdfContent,
        'as' => $filename,
        'mime' => 'application/pdf',
    ],
];
```

### ZipSchedeBulkAction

```php
// Modules/Ptv/app/Filament/Actions/Bulk/ZipSchedeBulkAction.php

foreach ($records as $record) {
    $pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
    $filename = app(GetFilenameBySchedaAction::class)->execute($record);
    $zip->addFromString($filename, $pdfContent);
}
```

## Vantaggi della Centralizzazione

### Prima (Logica Duplicata)

```php
// File 1: SendMailByRecord.php
$filename = 'scheda_'.$record->id.'_'.$record->matr.'_'.$record->cognome.'_'.$record->nome.'.pdf';

// File 2: ZipSchedeBulkAction.php
$filename = 'scheda_'.$record->id.'_'.$record->matr.'_'.$record->cognome.'_'.$record->nome.'.pdf';

// Problema: Modifiche richiedono aggiornamento in più punti
```

### Dopo (Action Centralizzata)

```php
// File 1: SendMailByRecord.php
$filename = app(GetFilenameBySchedaAction::class)->execute($record);

// File 2: ZipSchedeBulkAction.php
$filename = app(GetFilenameBySchedaAction::class)->execute($record);

// Vantaggio: Modifiche in un solo punto
```

## Modifiche Future

Se in futuro serve modificare il pattern di naming:

1. **Modifica unica**: Aggiornare solo `GetFilenameBySchedaAction::execute()`
2. **Propagazione automatica**: Tutti i punti di utilizzo adottano la nuova logica
3. **Test centralizzati**: Test unitari garantiscono coerenza

## Edge Cases Gestiti

### Campi Null o Vuoti

```php
// Se matr è null → 'unknown'
$scheda->matr = null;
// Result: scheda_123_unknown_Rossi_Mario.pdf
```

### Caratteri Speciali

```php
// Se cognome contiene caratteri speciali → sanitizzato
$scheda->cognome = "Rossi/Mario";
// Result: scheda_123_45678_RossiMario_Mario.pdf
```

### Campi Mancanti

```php
// Se mancano campi identificativi → fallback
unset($scheda->matr, $scheda->cognome, $scheda->nome);
// Result: scheda.pdf
```

## Collegamenti

### Documentazione Correlata

- [Email PDF Attachments](./email-pdf-attachments.md) - Utilizzo in email
- [SendMailByRecord](./email-pdf-attachments.md#sendmailbyrecord) - Action principale
- [ZipSchedeBulkAction](../filament-resources.md#zip-schede-bulk-action) - Bulk action

### File Correlati

- `Modules/Ptv/app/Actions/Scheda/GetFilenameBySchedaAction.php` - Implementazione
- `Modules/Ptv/app/Actions/Scheda/SendMailByRecord.php` - Utilizzo in email
- `Modules/Ptv/app/Filament/Actions/Bulk/ZipSchedeBulkAction.php` - Utilizzo in ZIP

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0.0  
**Compatibilità**: PHPStan livello 10 ✅

