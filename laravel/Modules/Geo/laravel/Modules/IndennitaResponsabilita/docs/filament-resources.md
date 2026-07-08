# Filament Resources - IndennitaResponsabilita Module

**Versione**: 1.0  
**Data**: 2025-12-02  
**Maintainer**: Development Team
**Filament Version**: Aggiornamento v4 in corso

---

## 🚀 Upgrade Filament v4 - Status

### ✅ Cambiamenti Applicati
- **Attributi Override**: Corretti `#[\\Override]` → `#[Override]`
- **Import Namespace**: Aggiornati a `Filament\Schemas\Components`
- **Type Hints**: Migliorati con generics (`array<string, Component>`)
- **Proprietà Formattate**: `$navigationIcon` spaziato correttamente

### 🔄 Resources Aggiornati
- ✅ **ImportiCategoriaResource.php** - Completato
- ✅ **LettFResource.php** - Completato  
- ✅ **LettIResource.php** - Completato
- 🔄 **MyLogResource** - Ereditato da PTV, da verificare

### 📋 Checklist Upgrade Modulo
- [x] Script upgrade automatico eseguito
- [x] Attributi `#[Override]` corretti
- [x] Import `Filament\Schemas\Components` aggiornati
- [x] Type hints migliorati
- [ ] Test PHPStan livello 10 su tutto il modulo
- [ ] Verifica funzionalità post-upgrade
- [ ] Aggiornamento documentazione traduzioni

### ⚠️ Note Importanti
- **File Visibility**: Se usate S3/cloud, configurare `visibility('public')` in AppServiceProvider
- **Tailwind v4**: Verificare compatibilità temi custom
- **Performance**: Beneficiare automaticamente di miglioramenti 2-3x rendering

---

## 📋 Indice

1. [Panoramica](#panoramica)
2. [Resources Esistenti](#resources-esistenti)
3. [Resources da Implementare](#resources-da-implementare)
4. [Pattern e Best Practices](#pattern-e-best-practices)
5. [Traduzioni](#traduzioni)

---

## Panoramica

Questo documento cataloga tutte le Filament Resources del modulo IndennitaResponsabilita, seguendo rigorosamente la filosofia LARAXOT.

### Principi Fondamentali LARAXOT

- ✅ **SEMPRE** estendere `XotBaseResource`
- ✅ **MAI** usare `->label()`, `->placeholder()`, `->helperText()` 
- ✅ Traduzioni automatiche tramite file di traduzione espansi
- ✅ PHPStan livello 10
- ✅ DRY + KISS
- ✅ Tipizzazione rigorosa con `declare(strict_types=1);`

---

## Resources Esistenti

### 1. IndennitaResponsabilitaResource

**Model**: `Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita`

**Scopo**: Gestione principale delle indennità di responsabilità del personale.

**Campi Form**:
- `matr` - Matricola dipendente
- `cognome` - Cognome
- `nome` - Nome
- `email` - Email dipendente
- `valutatore_id` - ID valutatore assegnato

**Pagine Custom**:
- `compila` - Compilazione indennità
- `send-mail` - Invio mail
- `log-activity` - Storico modifiche

**Status**: ✅ Conforme LARAXOT

---

### 2. StabiDirigenteResource

**Model**: `Modules\IndennitaResponsabilita\Models\StabiDirigente`

**Scopo**: Gestione stabilimenti e dirigenti assegnati.

**Status**: ✅ Implementata

---

### 3. RatingResource

**Model**: `Modules\IndennitaResponsabilita\Models\Rating`

**Scopo**: Sistema di valutazione e rating del personale.

**Status**: ✅ Implementata

---

### 4. RatingMorphResource

**Model**: `Modules\IndennitaResponsabilita\Models\RatingMorph`

**Scopo**: Relazioni polimorfe per i rating.

**Status**: ✅ Implementata

---

### 6. MyLogResource

**Model**: `Modules\IndennitaResponsabilita\Models\MyLog`

**Scopo**: Sistema di logging per tracciamento operazioni (invio mail, modifiche, ecc.)

**Business Logic**:
- Estende `Modules\Ptv\Models\MyLog`
- Connection dedicata: `indennita_responsabilita`
- Tracciamento azioni e modifiche
- Log invio mail

**Campi Principali**:
- `id_tbl` - ID record correlato
- `tbl` - Nome tabella correlata
- `note` - Note/descrizione azione (es. 'sendMailLettF')
- `obj` - Oggetto azione
- `act` - Azione eseguita
- `data` - Dati serializzati (JSON)
- Audit fields standard (created_by, updated_by, ecc.)

**Relazioni**:
- Polymorphic relationship via `post_type` e `post_id`

**Pagine Custom**:
- `ListMyLogs` - Lista log con filtri e colonne complete (estende `Modules\Ptv\Filament\Resources\MyLogResource\Pages\ListMyLogs`)
- `ViewMyLog` - Vista dettaglio log con schema infolist completo

**Implementazione Tecnica**:
- Estende `Modules\Ptv\Filament\Resources\MyLogResource\Pages\ListMyLogs` (corretto rispetto a implementazione precedente)
- Metodi `getTableColumns()`, `getTableFilters()`, `getTableActions()`, `getTableBulkActions()` implementati
- Schema infolist completo per visualizzazione readonly
- Tipizzazione completa con PHPStan livello 10
- Segue regola generale: modello estende PTV → risorsa estende PTV

**Status**: ✅ Conforme LARAXOT - Implementato correttamente con ereditarietà modulare

**Model**: `Modules\IndennitaResponsabilita\Models\ImportiCategoria`

**Scopo**: Gestione categorie economiche con range min/max per le indennità.

**Business Logic**:
- Gestisce importi minimi e massimi per categoria
- Collegata ad anno di riferimento
- Lista propro (profilo professionale) per assegnazione

**Campi Principali**:
- `ente` - Codice ente
- `categoria` - Codice categoria economica
- `lista_propro` - Lista profili professionali (CSV)
- `anno` - Anno di riferimento
- `min` - Importo minimo categoria
- `max` - Importo massimo categoria

**Priorità**: 🔴 ALTA - Fondamentale per calcoli indennità

---

### 2. LettFResource

**Model**: `Modules\IndennitaResponsabilita\Models\LettF`

**Scopo**: Gestione Lettera F - valutazioni con criteri complessità, coordinamento, responsabilità.

**Business Logic**:
- Sistema di rating con 3 criteri (complessità, coordinamento, responsabilità)
- Calcolo automatico valore economico
- Range temporali (dal/al, dalf/alf, dali/ali)
- Validazione rigorosa input
- Export XLS

**Campi Principali**:
- `matr`, `cognome`, `nome`, `email`
- `stabi`, `repar` - Stabilimento e reparto
- `posizione_lavoro` - Descrizione posizione
- `complessita` (0-40) - Valutazione complessità ruolo
- `coordinamento` (0-30) - Valutazione coordinamento team
- `responsabilita` (0-30) - Valutazione responsabilità
- `tot` - Totale calcolato automaticamente
- `valore_economico_calcolato` - Importo calcolato
- `valore_economico_attribuito` - Importo finale assegnato
- `dal`, `al` - Range temporale generale
- `dalf`, `alf` - Range temporale retribuzione
- `dali`, `ali` - Range temporale indennità

**Validazioni**:
```php
'posizione_lavoro' => 'required',
'email' => 'required',
'complessita' => 'required|numeric|min:0|max:40',
'coordinamento' => 'required|numeric|min:0|max:30',
'responsabilita' => 'required|numeric|min:0|max:30',
```

**Relazioni**:
- `importi()` - HasOne ImportiCategoria (con replica anno precedente se mancante)
- `stabiDirigente()` - HasOne StabiDirigente
- `mailInviate()` - HasMany MyLog
- `ratings` - Trait HasRatingsTrait

**Priorità**: 🔴 CRITICA - Core business del modulo

---

### 3. LettIResource

**Model**: `Modules\IndennitaResponsabilita\Models\LettI`

**Scopo**: Gestione Lettera I - indennità speciali (archivista, relazioni pubblico, protezione civile, formatore).

**Business Logic**:
- 4 tipologie di indennità specialistiche
- Range temporali multipli
- Export XLS
- Integrazione con sistema mail

**Campi Principali**:
- Dati anagrafici standard (matr, cognome, nome, email)
- `stabi`, `repar`, `anno`
- `dal`, `al` - Range temporale principale
- `dalf`, `alf` - Range retribuzione
- `dali`, `ali` - Range indennità (con accessor computed `dali__ali`)
- `archivista_informatico` - Flag indennità archivista
- `relazioni_pubblico` - Flag indennità relazioni pubblico
- `protezione_civile` - Flag indennità protezione civile
- `formatore_professionale` - Flag indennità formatore

**Computed Properties**:
- `dali_ali` - Formato "dd/mm/YYYY - dd/mm/YYYY" (read-only)

**XLS Fields** per Export:
```php
['ente', 'matr', 'cognome', 'nome', 'email', 'propro', 'posfun',
 'categoria_eco', 'dal', 'al', 'archivista_informatico', 
 'relazioni_pubblico', 'protezione_civile', 'formatore_professionale']
```

**Relazioni**:
- `importi()` - Logica complessa con replica anno precedente
- `stabiDirigente()` - HasOne StabiDirigente
- `mailInviate()` - HasMany MyLog
- `ratings` - Trait HasRatingsTrait

**Priorità**: 🔴 CRITICA - Core business del modulo

---

### 4. MyLogResource

**Model**: `Modules\IndennitaResponsabilita\Models\MyLog`

**Scopo**: Sistema di logging per tracciamento operazioni (invio mail, modifiche, ecc.)

**Business Logic**:
- Estende `Modules\Ptv\Models\MyLog`
- Connection dedicata: `indennita_responsabilita`
- Tracciamento azioni e modifiche
- Log invio mail

**Campi Principali**:
- `id_tbl` - ID record correlato
- `tbl` - Nome tabella correlata
- `note` - Note/descrizione azione (es. 'sendMailLettF')
- `obj` - Oggetto azione
- `act` - Azione eseguita
- `data` - Dati serializzati (JSON)
- Audit fields standard (created_by, updated_by, ecc.)

**Relazioni**:
- Polymorphic relationship via `post_type` e `post_id`

**Priorità**: 🟡 MEDIA - Sistema supporto e audit

---

## Pattern e Best Practices

### Struttura Resource Standard

```php
<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Override;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Modules\IndennitaResponsabilita\Models\NomeModel;
use Modules\Xot\Filament\Resources\XotBaseResource;

class NomeModelResource extends XotBaseResource
{
    protected static string $resourceFile = __FILE__;

    protected static ?string $model = NomeModel::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('field_name')
                ->required(),
            // Altri campi...
        ];
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            // RelationManagers...
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNomeModels::route('/'),
            'create' => Pages\CreateNomeModel::route('/create'),
            'view' => Pages\ViewNomeModel::route('/{record}'),
            'edit' => Pages\EditNomeModel::route('/{record}/edit'),
        ];
    }
}
```

### Struttura Pagina List Standard (con getTableColumns)

```php
<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\NomeModelResource\Pages;

use Filament\Tables;
use Modules\IndennitaResponsabilita\Filament\Resources\NomeModelResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListNomeModels extends XotBaseListRecords
{
    protected static string $resource = NomeModelResource::class;

    /**
     * Get the table columns definition.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('field_name')
                ->searchable()
                ->sortable(),
            // Altre colonne...
        ];
    }
}
```

⚠️ **IMPORTANTE**: Il metodo `getTableColumns()` DEVE essere implementato nella pagina List/Index e MAI nella classe Resource!

### ✅ DO - Pattern Corretti

#### 1. Estensione Base
```php
// ✅ CORRETTO
class MyResource extends XotBaseResource
```

#### 2. Nessuna Label Hardcoded
```php
// ✅ CORRETTO
TextInput::make('nome')
    ->required()
```

#### 3. Tipizzazione Completa
```php
// ✅ CORRETTO
#[Override]
public static function getFormSchema(): array
{
    return [
        // ...
    ];
}
```

#### 4. Form Schema con Validazione
```php
// ✅ CORRETTO
TextInput::make('complessita')
    ->numeric()
    ->minValue(0)
    ->maxValue(40)
    ->required()
```

#### 5. Select con Options
```php
// ✅ CORRETTO
Select::make('categoria')
    ->relationship('category', 'name')
    ->searchable()
    ->preload()
    ->required()
```

### ❌ DON'T - Anti-Pattern da Evitare

#### 1. Label Hardcoded
```php
// ❌ ERRATO - MAI FARE QUESTO
TextInput::make('nome')
    ->label('Nome Dipendente')  // VIETATO!
    ->placeholder('Inserisci nome')  // VIETATO!
```

#### 2. Estensione Diretta Filament
```php
// ❌ ERRATO
use Filament\Resources\Resource;

class MyResource extends Resource  // VIETATO!
```

#### 3. Tipizzazione Mancante
```php
// ❌ ERRATO
public static function getFormSchema()  // Manca tipo ritorno
{
    // ...
}
```

---

## Traduzioni

### Struttura File Traduzioni

Ogni Resource necessita di file traduzione in:

```
Modules/IndennitaResponsabilita/lang/
├── it/
│   ├── importi_categoria.php
│   ├── lett_f.php
│   ├── lett_i.php
│   └── my_log.php
├── en/
│   └── ...
└── de/
    └── ...
```

### Struttura Traduzione Espansa

```php
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Etichetta Navigazione',
        'group' => 'Gruppo Navigazione',
    ],
    
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'help' => 'Testo di aiuto',
        ],
        // Altri campi...
    ],
    
    'actions' => [
        'create' => [
            'label' => 'Crea Nuovo',
            'success' => 'Elemento creato con successo',
            'error' => 'Errore durante la creazione',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Elemento modificato con successo',
            'error' => 'Errore durante la modifica',
        ],
        'delete' => [
            'label' => 'Elimina',
            'confirmation' => 'Sei sicuro di voler eliminare questo elemento?',
            'success' => 'Elemento eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
    ],
    
    'messages' => [
        'empty_state' => 'Nessun elemento trovato',
        'validation_error' => 'Si sono verificati errori di validazione',
    ],
];
```

---

## Implementazione Prossimi Step

### Fase 1: ImportiCategoriaResource (Priorità ALTA)
1. Creare Resource base
2. Definire form schema
3. Creare file traduzione
4. Implementare validazioni
5. Test PHPStan livello 10

### Fase 2: LettFResource (Priorità CRITICA)
1. Creare Resource base
2. Form schema con validazioni complesse
3. Gestione range temporali
4. Integrazione ratings
5. File traduzione completi
6. Test PHPStan livello 10

### Fase 3: LettIResource (Priorità CRITICA)
1. Creare Resource base
2. Form schema con 4 flag indennità
3. Gestione range temporali multipli
4. Computed property dali_ali
5. File traduzione completi
6. Test PHPStan livello 10

### Fase 4: MyLogResource (Priorità MEDIA)
1. Creare Resource base (read-only)
2. Form schema semplice
3. Filtri per tipo log
4. File traduzione
5. Test PHPStan livello 10

---

## Collegamenti

### Documentazione Modulo
- [README.md](./README.md)
- [Best Practices](./best-practices.md)
- [Business Logic Analysis](./business-logic-analysis.md)

### Documentazione LARAXOT
- [Xot/docs/FILAMENT_RESOURCES.md](../../Xot/docs/FILAMENT_RESOURCES.md)
- [Xot/docs/TRANSLATIONS.md](../../Xot/docs/TRANSLATIONS.md)
- [docs/FILAMENT-BEST-PRACTICES.md](../../../docs/FILAMENT-BEST-PRACTICES.md)

---

**Ultima Revisione**: 2025-12-10 - Corretto MyLogResource per estendere PTV\ListMyLogs seguendo regola ereditarietà modello-risorsa  
**Prossima Revisione**: Dopo implementazione resources mancanti

