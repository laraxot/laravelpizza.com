# Regole Generali di Sviluppo del Progetto

## Collegamenti
- [Documentazione generale progetto](/project_docs/README.md)
- [Regole Filament](filament-best-practices.md)
- [Convenzioni Namespace](namespace-conventions.md)
- [Standard di Codice](code-standards.md)
- [Documentazione](documentation-guidelines.md)

## Processo di Correzione Errori

### Metodologia Obbligatoria
Ogni correzione di errore deve seguire questo processo:

1. **COMPRENDI**: Analizza approfonditamente la causa dell'errore
2. **DOCUMENTA**: Aggiorna la documentazione nella cartella docs più vicina all'errore (esclusa docs root)
3. **COLLEGA**: Crea collegamenti bidirezionali ai file della cartella docs principale
4. **STUDIA**: Studia approfonditamente le cartelle docs coinvolte prima di implementare
5. **CORREGGI**: Implementa la correzione secondo un ordine di priorità
6. **ESTENDI**: Correggi tutti i file che contengono lo stesso problema

### Ordine di Priorità per Correzioni
1. Errori di sicurezza
2. Errori di funzionalità core
3. Errori di namespace e struttura
4. Errori di documentazione
5. Miglioramenti di qualità

### Filosofia della Correzione
- Considerare sempre le implicazioni di politica, filosofia, religione e zen
- Progettare pensando ai controlli di qualità elevati futuri
- Seguire principi DRY (Don't Repeat Yourself) e KISS (Keep It Simple, Stupid)

## Namespace e Struttura

### Namespace Corretto
Il namespace corretto per i moduli è:
- ✅ `Modules\<nome>\Filament`
- ❌ `Modules\<nome>\App\Filament`
- ✅ `Modules\<nome>\`
- ❌ `Modules\<nome>\App\`

### Struttura Directory
```
Modules/<nome>/
├── app/                    # Codice principale
│   ├── Filament/          # Classi Filament
│   ├── Models/            # Modelli Eloquent
│   ├── Actions/           # Business logic
│   └── ...
├── docs/                  # Documentazione specifica modulo
├── lang/                  # File traduzione
│   ├── it/
│   └── en/
└── ...
```

## Filament e Estensioni

### Regola Fondamentale
**NON estendere mai classi Filament direttamente**. Utilizzare sempre classi astratte con prefisso `XotBase`.

### 🚨 REGOLA CRITICA: CreateRecord con Modello Translatable
**IMPORTANTE**: Se il MODELLO utilizza il trait `HasTranslations`, NON estendere `XotBaseCreateRecord`, ma estendere `LangBaseCreateRecord`.

- ❌ Modello con `use HasTranslations` + `extends XotBaseCreateRecord`
- ✅ Modello con `use HasTranslations` + `extends LangBaseCreateRecord`
- **SEMPRE verificare**: Se il MODELLO ha `use Spatie\Translatable\HasTranslations`, usare `LangBase*` invece di `XotBase*`
- **Controllo**: Verificare il MODELLO associato alla risorsa, non il CreateRecord stesso
- **Applicazione**: Tutti i record (Create, Edit, View, etc.) devono usare `LangBase*`

### Classi Base Obbligatorie
- `XotBaseResource` invece di `Filament\Resources\Resource`
- `XotBasePage` invece di `Filament\Resources\Pages\Page`
- `XotBaseListRecords` invece di `Filament\Resources\Pages\ListRecords`
- `XotBaseCreateRecord` invece di `Filament\Resources\Pages\CreateRecord` (se NON usa Translatable)
- `LangBaseCreateRecord` invece di `Filament\Resources\Pages\CreateRecord` (se usa Translatable)
- `XotBaseEditRecord` invece di `Filament\Resources\Pages\EditRecord` (se NON usa Translatable)
- `LangBaseEditRecord` invece di `Filament\Resources\Pages\EditRecord` (se usa Translatable)

### Esempi Corretti
```php
// ❌ ERRATO
class PatientResource extends \Filament\Resources\Resource

// ✅ CORRETTO  
class PatientResource extends \Modules\Xot\Filament\Resources\XotBaseResource

// MODELLO con HasTranslations
class Patient extends Model
{
    use Spatie\Translatable\HasTranslations; // ← QUESTO è il trigger!
}

// ❌ ERRATO - Modello ha HasTranslations ma uso XotBase
class CreatePatient extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
{
    // Errore! Il modello Patient ha HasTranslations
}

// ✅ CORRETTO - Modello ha HasTranslations quindi uso LangBase
class CreatePatient extends \Modules\Xot\Filament\Resources\Pages\LangBaseCreateRecord
{
    // Corretto! Il modello Patient ha HasTranslations
}

// ✅ CORRETTO - Modello SENZA HasTranslations
class CreateUser extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
{
    // Corretto! Il modello User NON ha HasTranslations
}
```

### Struttura Namespace Filament
Rispettare la struttura del namespace di Filament:
```php
// Se una classe estendeva:
\Filament\Resources\Pages\Page

// Ora estende:
\Modules\Xot\Filament\Resources\Pages\XotBasePage
```

## Traduzioni e Localizzazione

### Regole per Traduzioni
- ❌ **NON usare** `->label()`
- ✅ **Usare** file di traduzione del modulo: `Modules/<nome>/lang/<lingua>`
- ✅ Tramite `LangServiceProvider` utilizziamo direttamente i file di traduzione

### Struttura File Traduzione
```
Modules/<nome>/lang/
├── it/
│   ├── messages.php
│   ├── validation.php
│   ├── filament.php
│   └── navigation.php
└── en/
    ├── messages.php
    ├── validation.php
    ├── filament.php
    └── navigation.php
```

### Esempio Utilizzo
```php
// ❌ ERRATO
TextInput::make('name')->label('Nome')

// ✅ CORRETTO
TextInput::make('name')
// La traduzione viene gestita automaticamente dal LangServiceProvider
```

## Regole per XotBaseResource

### Metodi NON Implementare
Chi estende `XotBaseResource` NON deve implementare:
- `getTableColumn`
- `getTableFilters` 
- `getBulkActions`
- `table`
- `getPages` (se restituisce solo index,create,edit o index,create,edit,view)

### Metodi con Array Associativo
I seguenti metodi devono restituire array associativo con chiavi stringhe:
- `getFormSchema`
- `getTableActions`
- `getTableColumns`
- `getTableFilters`
- `getTableBulkActions`

```php
// ✅ CORRETTO
public function getFormSchema(): array
{
    return [
        'personal_info' => Group::make([
            'name' => TextInput::make('name'),
            'email' => TextInput::make('email'),
        ]),
        'settings' => Group::make([
            'active' => Toggle::make('active'),
        ]),
    ];
}

public function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id'),
        'name' => TextColumn::make('name'),
        'email' => TextColumn::make('email'),
        'created_at' => TextColumn::make('created_at'),
    ];
}
```

### Ragionamento Array Associativo
Le chiavi stringhe permettono:
1. **Organizzazione logica**: Raggruppare elementi correlati
2. **Override selettivo**: Modificare solo specifici elementi
3. **Estensibilità**: Aggiungere elementi in posizioni specifiche
4. **Debugging**: Identificare facilmente gli elementi
5. **Manutenibilità**: Codice più leggibile e modificabile

## Form e Select

### Enum per Options
Se una select ha options che sono un array, convertire agli enum:

```php
// ❌ ERRATO
Select::make('status')->options([
    'active' => 'Attivo',
    'inactive' => 'Inattivo',
])

// ✅ CORRETTO
Select::make('status')->enum(StatusEnum::class)
```

## Codice Deprecato

### Proprietà Deprecate
- ❌ `protected $casts` (deprecato in Laravel 11+)
- ❌ `protected $dates` (deprecato)

### Alternative Moderne
```php
// ❌ DEPRECATO
protected $casts = [
    'created_at' => 'datetime',
    'settings' => 'array',
];

// ✅ MODERNO
protected function casts(): array
{
    return [
        'created_at' => 'datetime',
        'settings' => 'array',
    ];
}
```

## Documentazione

### Regola Fondamentale
- **docs/ (root)**: Solo informazioni generali del progetto + collegamenti ai moduli
- **Modules/{Module}/project_docs/**: Documentazione specifica di ogni modulo
- **Collegamenti bidirezionali**: Root ↔ Moduli per navigazione fluida

### Naming Convention Docs
- File e sottocartelle: **NO caratteri maiuscoli**
- Eccezione: `README.md`
- Formato: `kebab-case.md`

### Struttura Obbligatoria
```
docs/                           # Generale + collegamenti
├── README.md                   # Panoramica progetto
├── routing-localization.md     # Link al sistema routing (CMS)
├── modules.md                  # Link ai moduli
└── development/                # Guide sviluppo generali

Modules/{Module}/project_docs/          # Specifica modulo
├── index.md                    # Indice del modulo
├── feature-name.md            # Documentazione feature specifica
├── api/                       # Documentazione API
└── examples/                  # Esempi di utilizzo
```

## Moduli e Responsabilità

### Scopo Specifico per Modulo
- **Xot**: Core del sistema, regole generali, classi XotBase
- **Cms**: Frontend, temi, contenuti, Laravel Folio
- **Patient**: Gestione pazienti e dati ISEE
- **Dental**: Gestione visite dentistiche e trattamenti
- **User**: Gestione utenti, autenticazione, autorizzazione
- **Tenant**: Supporto multi-tenant

### Regole per Moduli
- **Regole generali**: Vanno documentate nel modulo **Xot**
- **Collegamenti bidirezionali**: Dagli altri moduli verso Xot
- **Elementi frontend**: Vanno nel modulo **Cms**
- **Ogni modulo**: Ha uno scopo specifico e ben definito

## Qualità del Codice

### Principi Fondamentali
- **DRY**: Don't Repeat Yourself
- **KISS**: Keep It Simple, Stupid
- **SOLID**: Principi di design object-oriented
- **Clean Code**: Codice leggibile e manutenibile

### Standard di Qualità
- Type hints obbligatori per tutti i parametri
- Return types obbligatori per tutti i metodi
- PHPDoc completo per metodi pubblici
- Test coverage elevato (>80%)
- Analisi statica con PHPStan (livello 9)

### Controlli di Qualità
Progettare sempre pensando che il codice dovrà superare:
- PHPStan livello 9
- PHP CS Fixer
- PHPUnit tests
- Code review rigoroso
- Performance testing

## Filosofia e Principi

### Approccio Olistico
- **Politica**: Considerare l'impatto delle decisioni tecniche
- **Filosofia**: Applicare principi di design eleganti
- **Religione**: Rispettare le convenzioni e le tradizioni del codice
- **Zen**: Mantenere equilibrio tra funzionalità e semplicità

### Zen del Codice
- **Semplicità è eleganza**: Preferire soluzioni semplici
- **Consistenza è armonia**: Mantenere pattern uniformi
- **Documentazione è compassione**: Aiutare i futuri sviluppatori
- **Test sono saggezza**: Prevenire problemi futuri
- **Refactoring è crescita**: Migliorare continuamente

## Memoria e Apprendimento

### Aggiornamento Continuo
- Aggiornare comprensione delle cartelle docs
- Studiare regole e memorie esistenti
- Imparare dagli errori precedenti
- Documentare nuove scoperte

### File da Aggiornare Sempre
- `.cursor/rules/`
- `.windsurf/rules/`
- `Modules/Xot/project_docs/`
- Memoria personale
- Collegamenti bidirezionali

### Processo di Apprendimento
1. **Leggere** attentamente tutto il codice del progetto
2. **Studiare** tutte le cartelle docs comprese le sottocartelle
3. **Ragionare** sulla filosofia, logica, politica, religione, zen
4. **Aggiornare** le cartelle docs coinvolte
5. **Implementare** la correzione sempre ragionando

## Esempi Pratici

### Correzione Errore Namespace
```php
// ❌ PROBLEMA TROVATO
namespace Modules\Patient\App\Filament\Resources;

// ✅ CORREZIONE
namespace Modules\Patient\Filament\Resources;
```

### Correzione Estensione Filament
```php
// ❌ PROBLEMA TROVATO
class PatientResource extends \Filament\Resources\Resource

// ✅ CORREZIONE
class PatientResource extends \Modules\Xot\Filament\Resources\XotBaseResource
```

### Correzione Translatable
```php
// MODELLO con HasTranslations
class Patient extends Model
{
    use Spatie\Translatable\HasTranslations; // ← QUESTO è il trigger!
}

// ❌ PROBLEMA TROVATO - Modello ha HasTranslations ma uso XotBase
class CreatePatient extends \Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
{
    // Errore! Il modello Patient ha HasTranslations
}

// ✅ CORREZIONE - Modello ha HasTranslations quindi uso LangBase
class CreatePatient extends \Modules\Xot\Filament\Resources\Pages\LangBaseCreateRecord
{
    // Corretto! Il modello Patient ha HasTranslations
}
```

### Correzione Traduzione
```php
// ❌ PROBLEMA TROVATO
TextInput::make('name')->label('Nome del Paziente')

// ✅ CORREZIONE
TextInput::make('name')
// Traduzione in Modules/Patient/lang/it/filament.php:
// 'name' => 'Nome del Paziente'
```

## Checklist per Correzioni

### Prima di Correggere
- [ ] Ho compreso la causa dell'errore?
- [ ] Ho studiato la documentazione correlata?
- [ ] Ho identificato tutti i file con lo stesso problema?
- [ ] Ho pianificato l'ordine di priorità?
- [ ] **Il MODELLO ha `use HasTranslations`? Devo usare `LangBase*`!**

### Durante la Correzione
- [ ] Sto seguendo le convenzioni del progetto?
- [ ] Sto aggiornando la documentazione?
- [ ] Sto creando collegamenti bidirezionali?
- [ ] Sto considerando le implicazioni filosofiche?
- [ ] **Sto verificando se il MODELLO ha HasTranslations?**

### Dopo la Correzione
- [ ] Ho testato la correzione?
- [ ] Ho aggiornato tutti i file correlati?
- [ ] Ho documentato la soluzione?
- [ ] Ho aggiornato le regole per evitare errori futuri?

---

**Nota**: Queste regole sono fondamentali per mantenere la qualità e la consistenza del progetto. Devono essere sempre seguite e aggiornate quando necessario.
