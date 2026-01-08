# XotBaseListRecords

## Panoramica
`XotBaseListRecords` è una classe base astratta che estende `ListRecords` di Filament e fornisce funzionalità comuni per la visualizzazione di elenchi di record.

## Caratteristiche Principali

### 1. Metodi Pubblici
I seguenti metodi sono dichiarati come `public` e **devono rimanere public** nelle classi che ereditano:
- `getTableHeaderActions()`: array - Definisce le azioni nell'header della tabella
- `getListTableColumns()`: array - Definisce le colonne della tabella
- `getTableActions()`: array - Definisce le azioni per ogni riga
- `getTableBulkActions()`: array - Definisce le azioni bulk
- `getTableFilters()`: array - Definisce i filtri della tabella

### 2. Metodi Protetti
- `getHeaderActions()`: array - Definisce le azioni nell'header della pagina
- `getPreviewModalView()`: ?string - Definisce la vista per l'anteprima
- `getPreviewModalDataRecordKey()`: ?string - Definisce la chiave per i dati dell'anteprima

## Utilizzo

```php
namespace Modules\YourModule\Filament\Resources\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListYourRecords extends XotBaseListRecords
{
    public function getListTableColumns(): array
    {
        return [
            // Definisci qui le colonne
        ];
    }

    public function getTableHeaderActions(): array
    {
        return [
            // Definisci qui le azioni dell'header
        ];
    }
}
```

## Best Practices
1. Mantenere i metodi pubblici come `public` nelle classi figlie
2. Non modificare il livello di accesso dei metodi ereditati
3. Implementare tutti i metodi astratti richiesti
4. Utilizzare i trait forniti per funzionalità aggiuntive (es. `Translatable`)

## Note Tecniche
- La classe utilizza `strict_types=1`
- Supporta la traduzione attraverso il trait `Translatable`
- Integra con il sistema di layout delle tabelle di Filament 