# XotBasePage

## Panoramica
`XotBasePage` è una classe base astratta che estende `Filament\Pages\Page` e fornisce funzionalità comuni per tutte le pagine Filament nel sistema. Questa classe implementa pattern e best practices standardizzati per la gestione delle pagine.

## Caratteristiche Principali

### 1. Gestione delle View
- Risoluzione automatica delle view basata sul namespace della classe
- Supporto per view personalizzate
- Gestione delle view mancanti con messaggi di errore appropriati

### 2. Sistema di Traduzione
- Integrazione con il sistema di traduzioni di Laravel
- Generazione automatica delle chiavi di traduzione
- Supporto per etichette di navigazione e gruppi

### 3. Gestione dei Form
- Integrazione con il sistema di form di Filament
- Schema di form configurabile
- Gestione dello stato del form

### 4. Autorizzazioni
- Sistema di autorizzazioni integrato
- Verifica automatica dei permessi
- Supporto per politiche di accesso

## Utilizzo

```php
namespace Modules\YourModule\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class YourPage extends XotBasePage
{
    protected static string $view = 'your-module::pages.your-page';
    
    protected function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
}
```

## Best Practices

1. **View**
   - Definire sempre la proprietà `$view` nelle classi figlie
   - Utilizzare il namespace del modulo per le view
   - Seguire la convenzione di naming delle view

2. **Traduzioni**
   - Utilizzare il sistema di traduzioni per tutte le stringhe
   - Non hardcodare le stringhe nel codice
   - Mantenere i file di traduzione organizzati

3. **Form**
   - Implementare `getFormSchema()` per definire la struttura del form
   - Utilizzare i componenti Filament standard
   - Gestire correttamente lo stato del form

4. **Autorizzazioni**
   - Implementare le politiche di accesso appropriate
   - Utilizzare il sistema di autorizzazioni di Laravel
   - Documentare i requisiti di accesso

## Metodi Principali

### `getModuleName()`
Restituisce il nome del modulo dalla classe.

### `trans(string $key)`
Genera una chiave di traduzione basata sul namespace della classe.

### `getModel()`
Restituisce il modello associato alla pagina.

### `getFormSchema()`
Definisce lo schema del form della pagina.

### `authorizeAccess()`
Verifica se l'utente ha l'accesso alla pagina.

## Note Tecniche

1. **Namespace**
   - Le classi devono essere nel namespace `Modules\{ModuleName}\Filament\Pages`
   - Le view devono essere nel namespace `{module-name}::pages`

2. **Dipendenze**
   - Filament Pages
   - Filament Forms
   - Laravel Authorization

3. **Compatibilità**
   - Compatibile con Filament 4.x
   - Richiede PHP 8.1+

## Link Correlati

- [Documentazione Filament](../../../docs/filament/index.md)
- [Best Practices](../../../docs/best-practices.md)
- [Guida Traduzioni](../../../docs/translations.md) 