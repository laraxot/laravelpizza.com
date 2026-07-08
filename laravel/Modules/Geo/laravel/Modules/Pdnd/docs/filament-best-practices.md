# Best Practice Filament 4 - Modulo Pdnd

## Regole Vincolanti

### 1. Estensioni Classi
**MAI estendere classi Filament direttamente**. Utilizzare sempre le classi XotBase del modulo Xot:

- ✅ `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` invece di `Filament\Resources\Pages\CreateRecord`
- ✅ `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` invece di `Filament\Resources\Pages\EditRecord`
- ✅ `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` invece di `Filament\Resources\Pages\ListRecords`
- ✅ `Modules\Xot\Filament\Pages\XotBasePage` invece di `Filament\Resources\Pages\Page`

### 2. Risorse
**Chi estende `XotBaseResource` NON deve avere il metodo `getTableColumns()`**

Definire invece le colonne direttamente nel metodo `table()`.

### 3. Pagine
**Chi estende `Modules\Xot\Filament\Pages\XotBasePage` NON deve avere:**
- `protected static ?string $navigationIcon`
- `protected static ?string $title`
- `protected static ?string $navigationLabel`

Queste proprietà sono gestite automaticamente tramite traduzioni.

### 4. Componenti Form
**MAI usare:**
- `->label()` 
- `->placeholder()` 
- `->tooltip()`

Le traduzioni vengono gestite automaticamente dal `LangServiceProvider`. Tutte le label devono essere nei file di traduzione del modulo.

#### Esempio ERRATO:
```php
TextInput::make('codiceFiscale')
    ->label('Codice Fiscale')
    ->placeholder('Inserisci codice fiscale')
    ->required()
```

#### Esempio CORRETTO:
```php
TextInput::make('codiceFiscale')
    ->required()
```

Con traduzione in `lang/it/fields.php`:
```php
'codiceFiscale' => [
    'label' => 'Codice Fiscale',
    'placeholder' => 'Inserisci codice fiscale',
]
```

### 5. Colonne Badge
**`BadgeColumn` è deprecato**. Usare `TextColumn` con il metodo `badge()`:

#### Esempio ERRATO:
```php
BadgeColumn::make('status')
```

#### Esempio CORRETTO:
```php
TextColumn::make('status')->badge()
```

### 6. Architettura: Actions invece di Services
**NON usare services tradizionali**. Utilizzare [Spatie Laravel Queueable Actions](https://github.com/spatie/laravel-queueable-action).

#### Esempio Conversione:

**PRIMA (Service):**
```php
// PdndClientService.php
class PdndClientService
{
    public function execute($data)
    {
        // logica
    }
}

// Uso
$service = new PdndClientService();
$service->execute($data);
```

**DOPO (Action):**
```php
// PdndClientAction.php
use Spatie\QueueableAction\QueueableAction;

class PdndClientAction
{
    use QueueableAction;
    
    public function execute($data)
    {
        // logica
    }
}

// Uso sincrono
PdndClientAction::dispatchSync($data);

// Uso asincrono (con coda)
PdndClientAction::dispatch($data);
```

## Correzioni Applicate al Modulo Pdnd

### 2025-10-01: Refactoring Completo Filament 4

#### ✅ Rimozione ->label() da Actions
- **File**: `CurlProxyPage.php` (2 occorrenze)
- **File**: `GuzzleProxyPage.php` (1 occorrenza)
- **Fix**: Rimosso `->label()` da tutte le Actions. Label gestite da traduzioni.

#### ✅ Pulizia Import
- **Tutti i file**: Rimossi ~7-8 import inutilizzati per file
- **Tutti i file**: Import ordinati alfabeticamente
- **Fix**: Codice più leggibile e performance migliorate

#### ✅ Applicato Laravel Pint
- **Tutte le pagine**: Formattazione PSR-12
- **Fix**: 6 violazioni stile corrette automaticamente

#### ✅ Documentazione Completa
- Creati 5 nuovi file documentazione
- Aggiornato `phpstan-fixes.md`
- **Fix**: Modulo completamente documentato

### Prossimi Step (Migrazione Architetturale)
1. Conversione `PdndClientService` → `PdndClientAction`
2. Conversione `C003Service` → `VerificaGeneralitaAction`
3. Conversione `C030Service` → `CercaPerCodiceFiscaleAction`

**Timeline**: Da pianificare dopo approvazione refactoring corrente

## Riferimenti
- [Filament 4 Upgrade Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [Spatie Queueable Actions](https://github.com/spatie/laravel-queueable-action)
- [Documentazione XotBase Classes](../../Xot/docs/xot-base-conventions.md)

## Checklist Pre-Commit
- [ ] Nessuna estensione diretta di classi Filament
- [ ] Nessun `->label()`, `->placeholder()`, `->tooltip()`
- [ ] Nessun `BadgeColumn` (usare `TextColumn::badge()`)
- [ ] Nessun metodo `getTableColumns()` in risorse
- [ ] Nessuna proprietà `$navigationIcon`, `$title`, `$navigationLabel` in pagine
- [ ] Servizi convertiti in Actions
- [ ] PHPStan passa senza errori

*Ultimo aggiornamento: 2025-01*

