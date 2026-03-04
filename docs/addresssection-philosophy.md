# AddressSection - Filosofia del Componente Riutilizzabile

**Modulo**: Geo
**Status**: 📚 **DOCUMENTAZIONE**

## Concetto Fondamentale

AddressSection è un **wrapper semantico** che adatta lo schema degli indirizzi per l'uso in sezioni form, seguendo il principio di **delegazione pulita** e **riutilizzo intelligente**.

## Filosofia dell'Architettura

### 1. Single Source of Truth
```php
// AddressResource detiene la verità
AddressResource::getFormSchema() // Tutti i campi indirizzo

// AddressSection è un wrapper specializzato
AddressSection::make('address') // Schema senza metadati
```

### 2. Pattern Wrapper
AddressSection non ridefinisce la logica, ma:
- **Rimuove campi metadati** (name, is_primary)
- **Configura layout** (columns: 2)
- **Mantiene delega** a AddressResource

### 3. Separazione delle Responsabilità
- **AddressResource**: Definisce tutti i campi e validazioni
- **AddressSection**: Adatta per uso in sezioni form
- **ClientResource**: Consuma senza duplicare codice

## Religione dell'Implementazione

### DRY Principle
> "Non ripetere te stesso, ma delega con intelligenza"

AddressSection evita duplicazione:
- Non ridefinisce i campi
- Non riscrive la logica
- Si concentra solo sull'adattamento

### KISS Principle
> "Semplice è meglio, ma delegato è ancora meglio"

```php
// Semplicità estrema
protected function getFormSchema(): array
{
    $schema = AddressResource::getFormSchema();
    unset($schema['name'], $schema['is_primary']);
    return $schema;
}
```

## Zen del Componente

> "Il wrapper non contiene, ma rivela"

AddressSection non contiene logica, ma rivela lo schema indirizzo nella forma appropriata per le sezioni.

## Politica di Utilizzo

### Quando Usare AddressSection
1. **Form complessi** che necessitano sezioni indirizzo
2. **Rapida integrazione** senza definire campi manualmente
3. **Consistenza** con altri form del sistema

### Quando NON Usare AddressSection
1. **Hai bisogno di campi personalizzati**
2. **Devi modificare la logica di validazione**
3. **Hai requisiti specifici del dominio**

## Pattern di Integrazione

### Base Pattern
```php
use Modules\Geo\Filament\Forms\Components\AddressSection;

// In form schema
'address' => AddressSection::make('address')
    ->relationship('address'), // Per relazioni polimorfiche
```

### Con Configurazione Aggiuntiva
```php
'address' => AddressSection::make('address')
    ->relationship('address')
    ->columns(3) // Override default
    ->collapsed(true), // Iniziare chiuso
```

## Dipendenze e Relazioni

### Relazione Polimorfica
AddressSection supporta relazioni polimorfiche:
```php
// In Model
public function address()
{
    return $this->morphOne(Address::class, 'addressable');
}

// In Resource
AddressSection::make('address')
    ->relationship('address'),
```

### Schema Delegato
AddressSection delega completamente ad AddressResource:
- Campi dinamici (region → province → locality)
- Validazioni live
- Logica di business

## Vantaggi Filosofici

1. **Manutenzione Centralizzata**
   - Modifica in AddressResource → Propagata ovunque
   - Nessuna duplicazione da mantenere

2. **Evoluzione Controllata**
   - Nuovi campi indirizzo → Automaticamente disponibili
   - Miglioramenti validazione → Istantanei per tutti

3. **Consistenza Assoluta**
   - Stesso comportamento in ogni form
   - Stessa validazione, stessa UX

4. **Semplificazione per Sviluppatori**
   - Una riga vs 50+ righe di definizione campi
   - Focus sulla logica di business, non sulla UI

## Best Practices

### 1. Import Sempre Esplicito
```php
use Modules\Geo\Filament\Forms\Components\AddressSection;
```

### 2. Non Modificare AddressSection
Se hai bisogno di comportamento diverso:
```php
// Estendi invece di modificare
class ClientAddressSection extends AddressSection
{
    protected function getFormSchema(): array
    {
        $schema = parent::getFormSchema();
        // Aggiungi/rimuovi campi specifici
        return $schema;
    }
}
```

### 3. Documenta l'Uso
```php
// ClientResource.php
/**
 * Address section for client form.
 *
 * Uses AddressSection from Geo module for:
 * - Consistent address fields across app
 * - Centralized validation logic
 * - Automatic updates when address schema changes
 */
'address' => AddressSection::make('address')
    ->relationship('address'),
```

## Conclusione

AddressSection embodies the philosophy of **intelligent delegation**: rather than duplicating code, it adapts existing functionality for specific use cases while maintaining a single source of truth. This creates a maintainable, consistent, and evolving address system that scales with the application.
