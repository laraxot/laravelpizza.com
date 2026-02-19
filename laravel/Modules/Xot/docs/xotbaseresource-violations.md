# VIOLAZIONI CRITICHE XotBaseResource - Regole Globali Laraxot PTVX

## 🚨 ERRORI GRAVISSIMI DA EVITARE SEMPRE

### Regole Fondamentali XotBaseResource

#### 1. DIVIETO ASSOLUTO: ->label(), ->placeholder(), ->helperText()
```php
// ❌ GRAVEMENTE ERRATO - MAI USARE
TextInput::make('field')
    ->label('Label')          // VIETATO!
    ->placeholder('Placeholder')  // VIETATO!
    ->helperText('Help text');    // VIETATO!

DatePicker::make('date')
    ->label('Data');          // VIETATO!

Toggle::make('active')
    ->label('Attivo');        // VIETATO!
```

**Motivazione**: Le traduzioni sono gestite automaticamente dal LangServiceProvider tramite i file di traduzione del modulo.

#### 2. DIVIETO ASSOLUTO: Metodi Tabellari nella Resource Principale
```php
// ❌ GRAVEMENTE ERRATO - NON implementare nella Resource principale
public static function getTableColumns(): array { ... }     // VIETATO!
public static function getTableFilters(): array { ... }     // VIETATO!
public static function getTableActions(): array { ... }     // VIETATO!
public static function getTableBulkActions(): array { ... } // VIETATO!
```

**Motivazione**: Questi metodi vanno implementati nelle Pages specifiche (es. ListRecords), NON nella Resource principale.

#### 3. DIVIETO ASSOLUTO: getPages() Standard
```php
// ❌ GRAVEMENTE ERRATO - Se contiene solo route standard
public static function getPages(): array
{
    return [
        'index' => Pages\ListRecords::route('/'),
        'create' => Pages\CreateRecord::route('/create'),
        'edit' => Pages\EditRecord::route('/{record}/edit'),
        'view' => Pages\ViewRecord::route('/{record}'),  // Standard
    ];
}
```

**Motivazione**: XotBaseResource gestisce automaticamente le route standard.

## Architettura Fondamentale Laraxot

### Principi Architetturali

#### 1. Centralizzazione e Standardizzazione
- **XotBaseResource** è il punto centrale di controllo per TUTTE le risorse
- **Ogni override locale** rompe la standardizzazione del sistema
- **La manutenibilità** dipende dalla centralizzazione

#### 2. Sistema di Traduzioni Automatico
- **LangServiceProvider** gestisce automaticamente TUTTE le traduzioni
- **File di traduzione del modulo** forniscono label, placeholder, help
- **Zero stringhe hardcoded** nelle interfacce

#### 3. Separazione delle Responsabilità
- **Resource principale**: SOLO `getFormSchema()` e configurazione modello
- **Pages specifiche**: `getTableColumns()`, `getTableFilters()`, `getTableActions()`
- **File di traduzione**: Tutte le stringhe UI

### Pattern Architetturale

```
XotBaseResource (Classe Base)
├── Gestione automatica form() [FINAL]
├── Gestione automatica table() [FINAL]
├── Gestione automatica traduzioni
├── Gestione automatica route standard
└── Configurazione centralizzata

Resource Specifica (Estende XotBaseResource)
├── SOLO getFormSchema()
├── SOLO configurazione modello
└── NESSUN override se standard

Pages Specifiche (es. ListRecords)
├── getTableColumns()
├── getTableFilters()
├── getTableActions()
└── getTableBulkActions()

File Traduzioni Modulo
├── fields.*.label
├── fields.*.placeholder
├── fields.*.help
└── actions.*.label
```

## Impatti delle Violazioni

### Impatti Tecnici Critici
- **Rottura della standardizzazione** Laraxot
- **Perdita della localizzazione automatica**
- **Violazione dell'architettura modulare**
- **Duplicazione del codice** e logica
- **Inconsistenza** tra risorse diverse

### Impatti Operativi Critici
- **Problemi di manutenibilità** del codice
- **Difficoltà negli aggiornamenti** globali
- **Perdita di controllo centralizzato**
- **Regressioni** in funzionalità esistenti

## Pattern Corretto Universale

### ✅ Resource Principale CORRETTA
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Filament\Resources;

use Modules\{ModuleName}\Models\{ModelName};
use Modules\Xot\Filament\Resources\XotBaseResource;

class {ModelName}Resource extends XotBaseResource
{
    protected static ?string $model = {ModelName}::class;

    // UNICO metodo necessario nella Resource principale
    public static function getFormSchema(): array
    {
        return [
            Section::make()  // NO ->label() - gestito automaticamente
                ->schema([
                    TextInput::make('field')  // NO ->label() - gestito automaticamente
                        ->required(),
                    // Altri campi senza ->label(), ->placeholder(), ->helperText()
                ]),
        ];
    }

    // NESSUN altro metodo se standard:
    // - NO getTableColumns(), getTableFilters(), getTableActions(), getTableBulkActions()
    // - NO getPages() se contiene solo route standard
    // - NO form(), table() (sono FINAL in XotBaseResource)
}
```

### ✅ Page Specifica CORRETTA
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Filament\Resources\{ModelName}Resource\Pages;

use Modules\{ModuleName}\Filament\Resources\{ModelName}Resource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class List{ModelName}s extends XotBaseListRecords
{
    protected static string $resource = {ModelName}Resource::class;

    // QUI vanno i metodi tabellari
    public function getTableColumns(): array
    {
        return [
            'field' => TextColumn::make('field')  // NO ->label() - gestito automaticamente
                ->searchable()
                ->sortable(),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            // Filtri senza ->label()
        ];
    }

    public function getTableActions(): array
    {
        return [
            // Azioni senza ->label()
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            // Bulk actions senza ->label()
        ];
    }
}
```

### ✅ File Traduzione CORRETTO
```php
<?php

declare(strict_types=1);

// Modules/{ModuleName}/lang/it/{resource}.php
return [
    'navigation' => [
        'label' => 'Etichetta Navigazione',
        'group' => 'Gruppo Navigazione',
    ],
    'fields' => [
        'field' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'help' => 'Testo di aiuto Campo',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Nuovo',
            'success' => 'Creato con successo',
            'error' => 'Errore durante la creazione',
        ],
    ],
    'sections' => [
        'main' => [
            'label' => 'Sezione Principale',
            'description' => 'Descrizione sezione',
        ],
    ],
];
```

## Regole Permanenti Globali

### ❌ DIVIETI ASSOLUTI
1. **MAI** usare ->label(), ->placeholder(), ->helperText() in QUALSIASI componente Filament
2. **MAI** implementare metodi tabellari nella Resource principale
3. **MAI** implementare getPages() se contiene solo route standard
4. **MAI** sovrascrivere form() o table() (sono FINAL)
5. **MAI** duplicare logica già presente in XotBaseResource

### ✅ OBBLIGHI ASSOLUTI
1. **SEMPRE** estendere XotBaseResource per le risorse
2. **SEMPRE** implementare SOLO getFormSchema() nella Resource principale
3. **SEMPRE** spostare metodi tabellari nelle Pages specifiche
4. **SEMPRE** affidarsi al sistema di traduzioni automatico
5. **SEMPRE** documentare eventuali personalizzazioni non standard

## Processo di Correzione Standard

### Fase 1: Audit della Resource
1. Identificare tutti i ->label(), ->placeholder(), ->helperText()
2. Identificare metodi tabellari nella Resource principale
3. Verificare se getPages() è necessario

### Fase 2: Correzione Resource
1. Rimuovere TUTTI i ->label(), ->placeholder(), ->helperText()
2. Rimuovere getTableColumns(), getTableFilters(), getTableActions(), getTableBulkActions()
3. Rimuovere getPages() se standard

### Fase 3: Correzione Pages
1. Spostare metodi tabellari in Pages specifiche
2. Rimuovere ->label() da componenti tabellari
3. Verificare funzionamento traduzioni automatiche

### Fase 4: Verifica Sistema
1. Testare funzionalità complete
2. Verificare traduzioni automatiche
3. Eseguire PHPStan per validazione
4. Documentare correzioni applicate

## Checklist di Conformità

### Resource Principale
- [ ] Estende XotBaseResource
- [ ] Contiene SOLO getFormSchema()
- [ ] NESSUN ->label(), ->placeholder(), ->helperText()
- [ ] NESSUN metodo tabellare
- [ ] NESSUN getPages() se standard

### Pages Specifiche
- [ ] Contengono metodi tabellari
- [ ] NESSUN ->label() nei componenti
- [ ] Traduzioni automatiche funzionanti

### File Traduzioni
- [ ] Struttura completa (fields, actions, sections)
- [ ] Tutte le chiavi necessarie presenti
- [ ] Nessuna duplicazione

### Sistema Generale
- [ ] Funzionalità complete operative
- [ ] Traduzioni automatiche attive
- [ ] PHPStan compliance
- [ ] Documentazione aggiornata

## Collegamenti Documentazione

### Documentazione Moduli
- [Progressioni: XotBaseResource Violations](../laravel/modules/progressioni/docs/xotbaseresource-violations-critical.md)
- [Xot: XotBaseResource Rules](../laravel/modules/xot/docs/filament/resources/xot-base-resource.md)
- [Xot: Filament Resource Guidelines](../laravel/modules/xot/docs/rules/filament-resource-guidelines.md)

### Regole Correlate
- [Sistema Traduzioni](translation-system.md)
- [Filament Best Practices](filament-best-practices.md)
- [Architettura Modulare](modular-architecture.md)

*Documento creato: agosto 2025*
*Ultimo aggiornamento: agosto 2025*
