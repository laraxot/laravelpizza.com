# Regole Architetturali per XotBaseResource

## Dibattito Interno: Navigation Properties e Metodi in XotBaseResource

### 🎯 Problema Identificato

Le classi che estendono `XotBaseResource` stanno sovrascrivendo proprietà e metodi che sono già gestiti automaticamente dal trait `NavigationLabelTrait` e dal trait `HasXotTable`.

### 💬 Dibattito Interno

#### **Posizione A: "Mantenere Sovrascritture per Flessibilità"**
- **Argomento**: Permettere alle classi derivate di sovrascrivere `$navigationIcon`, `$navigationSort`, `getNavigationLabel()`, ecc. offre maggiore flessibilità e controllo.
- **Pro**: Gli sviluppatori possono personalizzare facilmente la navigazione senza modificare i file di traduzione.
- **Contro**: Viola il principio DRY, crea inconsistenze, e bypassa il sistema di traduzione centralizzato.

#### **Posizione B: "Centralizzazione Totale tramite NavigationLabelTrait" (VINCITORE)**
- **Argomento**: `NavigationLabelTrait` già gestisce automaticamente:
  - `getNavigationIcon()` - legge da `navigation.icon` nelle traduzioni
  - `getNavigationSort()` - legge da `navigation.sort` nelle traduzioni
  - `getNavigationLabel()` - legge da `navigation.label` nelle traduzioni
  - `getPluralLabel()` - legge da `navigation.plural` nelle traduzioni
  - `getNavigationGroup()` - legge da `navigation.group.name` nelle traduzioni
- **Pro**: 
  - ✅ DRY: nessuna duplicazione
  - ✅ KISS: un solo punto di verità (file di traduzione)
  - ✅ Coerenza: tutte le risorse seguono lo stesso pattern
  - ✅ Manutenibilità: modifiche centralizzate nei file di traduzione
  - ✅ Localizzazione: supporto multi-lingua automatico
- **Contro**: Richiede di aggiornare i file di traduzione invece di hardcodare nel codice.

### 🏆 Decisione Finale

**VINCE Posizione B**: Centralizzazione Totale tramite NavigationLabelTrait

**Motivazione**:
1. **Filosofia Laraxot**: DRY + KISS sono principi fondamentali. Hardcodare proprietà di navigazione nel codice viola entrambi.
2. **Sistema di Traduzione**: Laraxot ha un sistema di traduzione centralizzato e potente. Bypassarlo con proprietà statiche è un anti-pattern.
3. **Manutenibilità**: Modificare un file di traduzione è più semplice e sicuro che modificare codice PHP distribuito in decine di classi.
4. **Coerenza**: Tutte le risorse devono seguire lo stesso pattern per garantire un'esperienza utente coerente.
5. **Localizzazione**: Il sistema di traduzione supporta automaticamente più lingue. Hardcodare nel codice richiederebbe modifiche multiple.

### 📋 Regole Architetturali

#### ❌ VIETATO nelle classi che estendono `XotBaseResource`:

1. **`protected static string|\BackedEnum|null $navigationIcon`**
   - ❌ **NON** definire questa proprietà
   - ✅ Usare `navigation.icon` nel file di traduzione

2. **`protected static ?int $navigationSort`**
   - ❌ **NON** definire questa proprietà
   - ✅ Usare `navigation.sort` nel file di traduzione

3. **`protected static \UnitEnum|string|null $navigationGroup`**
   - ❌ **NON** definire questa proprietà
   - ✅ Usare `navigation.group.name` nel file di traduzione

4. **`public static function getNavigationLabel(): string`**
   - ❌ **NON** sovrascrivere questo metodo
   - ✅ Gestito automaticamente da `NavigationLabelTrait`

5. **`public static function getPluralLabel(): string`**
   - ❌ **NON** sovrascrivere questo metodo
   - ✅ Gestito automaticamente da `NavigationLabelTrait`

6. **`public static function getModelLabel(): string`**
   - ❌ **NON** sovrascrivere questo metodo
   - ✅ Gestito automaticamente da Filament v4

7. **`public static function table(Table $table): Table`**
   - ❌ **NON** implementare questo metodo
   - ✅ Gestito automaticamente da `HasXotTable` trait (incluso in `XotBaseResource`)
   - ✅ Usare invece: `getTableColumns()`, `getTableHeaderActions()`, `getTableActions()`, `getTableBulkActions()`

### ✅ Pattern Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * ✅ CORRETTO: Nessuna proprietà di navigazione hardcoded
 */
final class TeamUserResource extends XotBaseResource
{
    protected static ?string $model = TeamUser::class;
    protected static ?string $recordTitleAttribute = 'id';

    // ❌ NON aggiungere:
    // protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
    // protected static ?int $navigationSort = 10;
    // protected static \UnitEnum|string|null $navigationGroup = 'Teams';

    // ✅ SOLO getFormSchema() e metodi table* se necessario
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            // Colonne della tabella
        ];
    }
}
```

### 📝 File di Traduzione Corretto

```php
<?php
// Modules/User/lang/it/team_user.php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Utente Team',
        'plural' => 'Utenti Team',
        'label' => 'Utenti Team',
        'group' => [
            'name' => 'Teams',
            'description' => 'Gestione degli utenti associati ai team',
        ],
        'sort' => 65,
        'icon' => 'heroicon-o-user-group',
    ],
    // ... altre traduzioni
];
```

### 🔍 Come Verificare Violazioni

```bash
# Cercare proprietà navigationIcon in Resources
grep -r "protected static.*navigationIcon" laravel/Modules/*/app/Filament/Resources/*.php

# Cercare proprietà navigationSort in Resources
grep -r "protected static.*navigationSort" laravel/Modules/*/app/Filament/Resources/*.php

# Cercare proprietà navigationGroup in Resources
grep -r "protected static.*navigationGroup" laravel/Modules/*/app/Filament/Resources/*.php

# Cercare override di getNavigationLabel in Resources
grep -r "public static function getNavigationLabel" laravel/Modules/*/app/Filament/Resources/*.php

# Cercare override di table() in Resources
grep -r "public static function table(Table" laravel/Modules/*/app/Filament/Resources/*.php
```

### 📚 Collegamenti

- [NavigationLabelTrait](../../app/Filament/Traits/NavigationLabelTrait.php)
- [HasXotTable Trait](../../app/Filament/Traits/HasXotTable.php)
- [XotBaseResource](../../app/Filament/Resources/XotBaseResource.php)
- [Regole Traduzioni](../../../Xot/docs/translation-philosophy.md)
- [No Table Override](./no-table-override.md)

### ⚠️ Note Importanti

1. **Pages e Clusters**: Queste regole si applicano **SOLO** a Resources che estendono `XotBaseResource`. Pages e Clusters possono avere `$navigationIcon` e `$navigationSort` se necessario.

2. **Eccezioni**: Non esistono eccezioni a queste regole per Resources. Se una Resource ha bisogno di personalizzazione, deve essere gestita tramite file di traduzione.

3. **Migrazione**: Quando si rimuovono proprietà hardcoded, assicurarsi di aggiornare i file di traduzione corrispondenti prima di rimuovere il codice.

---

**Data Decisione**: Gennaio 2026  
**Vincitore Dibattito**: Posizione B - Centralizzazione Totale  
**Conforme a**: DRY, KISS, Filosofia Laraxot
