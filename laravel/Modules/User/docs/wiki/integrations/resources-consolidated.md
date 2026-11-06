---
title: "resources: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "resources   consolidated documentation user"
---

# resources: Consolidated Documentation

Consolidated from **5** individual files.

## Table of Contents

- [---](#resources-array-keys-philosophy)
- [---](#resources-array-keys)
- [---](#resources-corrections-summary-)
- [---](#resources-corrections-summary)
- [---](#resources-corrections)

---

## resources-array-keys-philosophy

*Consolidated from: `resources-array-keys-philosophy.md`*

module: theme
topic: resources-array-keys-philosophy
canonical: ../../../Themes/docs/shared-components/resources-array-keys-philosophy.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/resources-array-keys-philosophy.md

---

## resources-array-keys

*Consolidated from: `resources-array-keys.md`*

title: "Resources Array Keys Philosophy: String Keys Always"
type: concept
tags: [resources, array, keys]
created: 2026-07-14
updated: 2026-07-14
qmd: "resources-array-keys resources array keys philosophy: string keys always"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Resources Array Keys Philosophy: String Keys Always

## Data: [DATE]

## Il Dibattito Feroce

### 🎭 Protagonisti

**Il Purista** (Type Safety e Coerenza)
vs
**Il Pragmatico** (Semplice e Funziona)

---

## Round 1: Array Keys: String o Int?

### 🔴 Il Purista Attacca

> "Tutti i metodi che restituiscono array di componenti Filament DEVONO usare chiavi stringhe! È richiesto da Filament e XotBaseResource! `array<int, Component>` è SBAGLIATO!"

**Argomenti:**
- **Filament Requirement**: Filament si aspetta chiavi stringhe per identificazione componenti
- **XotBaseResource**: L'architettura Laraxot impone questo pattern
- **PHPStan Compliance**: La tipizzazione corretta è necessaria per PHPStan livello 10
- **Component Identification**: L'identificazione dei componenti dipende dalle chiavi stringhe

### 🟢 Il Pragmatico Controattacca

> "Ma gli array numerici sono più semplici! Non serve complicare con chiavi stringhe!"

**Argomenti:**
- **Semplicità**: Array numerici sono più semplici da scrivere
- **Funziona**: Anche con chiavi numeriche funziona
- **Meno codice**: Non serve pensare a nomi per le chiavi

### 🏆 VINCITORE: Il Purista

**Motivazione della Vittoria:**

1. **Filament Architecture**: Filament si aspetta chiavi stringhe per:
   - Identificazione univoca dei componenti
   - Gestione del ciclo di vita
   - Aggiornamenti reattivi
   - Validazione e error handling

2. **XotBaseResource Pattern**: `XotBaseResource` e `XotBaseRelationManager` gestiscono automaticamente le traduzioni basandosi sulle chiavi stringhe:
   ```php
   // XotBaseResource usa le chiavi per le traduzioni
   'name' => TextInput::make('name') // Cerca traduzione in 'fields.name.label'
   ```

3. **PHPStan Level 10**: La tipizzazione corretta è necessaria:
   ```php
   // ✅ CORRETTO
   /**
    * @return array<string, \Filament\Tables\Columns\Column>
    */
   public static function getTableColumns(): array
   {
       return [
           'id' => TextColumn::make('id'),
           'name' => TextColumn::make('name'),
       ];
   }

   // ❌ ERRATO
   /**
    * @return array<int, \Filament\Tables\Columns\Column>
    */
   public static function getTableColumns(): array
   {
       return [
           TextColumn::make('id'),
           TextColumn::make('name'),
       ];
   }
   ```

4. **Manutenibilità**: Chiavi stringhe descrittive rendono il codice più leggibile e manutenibile.

**Decisione Finale**: ✅ **SEMPRE USARE CHIAVI STRINGHE**

---

## Metodi che Richiedono Chiavi Stringhe

### Metodi Obbligatori

1. **`getFormSchemaOld()`**: `array<int|string, \Filament\Schemas\Components\Component>` (getFormSchema() e' final su XotBaseResource, migrazione 2026-08)
2. **`getTableColumns()`**: `array<string, Column>`
3. **`getTableFilters()`**: `array<string, BaseFilter>`
4. **`getTableActions()`**: `array<string, Action>`
5. **`getTableBulkActions()`**: `array<string, Action|ActionGroup>`
6. **`getHeaderActions()`**: `array<string, Action>`
7. **`getInfolistSchema()`**: `array<string, Component>`

### Pattern Corretto

```php
/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public static function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id')
            ->sortable()
            ->searchable(),
        'name' => TextColumn::make('name')
            ->sortable()
            ->searchable(),
        'created_at' => TextColumn::make('created_at')
            ->dateTime()
            ->sortable(),
    ];
}
```

### Pattern Errato

```php
/**
 * @return array<int, \Filament\Tables\Columns\Column> // ❌ ERRATO
 */
public static function getTableColumns(): array
{
    return [
        TextColumn::make('id'), // ❌ Nessuna chiave stringa
        TextColumn::make('name'),
        TextColumn::make('created_at'),
    ];
}
```

---

## Correzioni Implementate

### OauthClientResource
- ✅ Corretto `getTableColumns()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableFilters()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableActions()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableBulkActions()`: chiavi stringhe aggiunte
- ✅ Corretto PHPDoc: `array<string, ...>` invece di `array<int, ...>`

### TeamUserResource
- ✅ Corretto `getTableColumns()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableFilters()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableActions()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableBulkActions()`: chiavi stringhe aggiunte
- ✅ Corretto PHPDoc: `array<string, ...>` invece di `array<int, ...>`

### TenantUserResource
- ✅ Corretto `getTableColumns()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableFilters()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableActions()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableBulkActions()`: chiavi stringhe aggiunte
- ✅ Corretto PHPDoc: `array<string, ...>` invece di `array<int, ...>`

### OauthPersonalAccessClientResource
- ✅ Corretto `getTableColumns()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableFilters()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableActions()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableBulkActions()`: chiavi stringhe aggiunte
- ✅ Corretto PHPDoc: `array<string, ...>` invece di `array<int, ...>`
- ✅ Corretto modello: `OauthPersonalAccessClient` invece di `Laravel\Passport\PersonalAccessClient`
- ✅ Corretto import Actions: `Filament\Actions\` invece di `Tables\Actions\`

---

## Filosofia Finale

**Type Safety + Coerenza = Chiavi Stringhe Sempre**

- ✅ **Chiavi stringhe**: Sempre usare chiavi stringhe descrittive
- ✅ **PHPDoc corretto**: `array<string, Type>` invece di `array<int, Type>`
- ✅ **Coerenza**: Tutti i metodi seguono lo stesso pattern
- ✅ **Manutenibilità**: Chiavi descrittive rendono il codice più leggibile

## Prossimi Passi

1. ✅ Corretto `OauthClientResource`
2. ✅ Corretto `TeamUserResource`
3. ✅ Corretto `TenantUserResource`
4. ✅ Corretto `OauthPersonalAccessClientResource`
5. ⚠️ Verificare altre Resources per conformità

## Collegamenti

- [XotBaseResource Source Code](../../../../Xot/app/Filament/Resources/XotBaseResource.php)
- [XotBaseResource Source Code](../../../../Xot/app/Filament/Resources/XotBaseResource.php)
- [Critical Filament Rule: getInfolistSchema String Keys](../../critical-filament-rule-getinfolistschema-string-keys.md)
- [Filament Best Practices](./filament-best-practices.md)

---

## resources-corrections-summary-

*Consolidated from: `resources-corrections-summary-.md`*

module: theme
topic: resources-corrections-summary-
canonical: ../../../Themes/docs/shared-components/resources-corrections-summary-.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/resources-corrections-summary-.md

---

## resources-corrections-summary

*Consolidated from: `resources-corrections-summary.md`*

title: "Resources Corrections Summary - 2025-01-22"
type: concept
tags: [resources, corrections, summary]
created: 2026-07-14
updated: 2026-07-14
qmd: "resources-corrections-summary resources corrections summary - 2025-01-22"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Resources Corrections Summary - 2025-01-22

## Obiettivo
Correggere errori PHPStan livello 10, PHPMD e PHP Insights nelle Resources Filament del modulo User, seguendo rigorosamente le regole Laraxot e la filosofia DRY + KISS.

## Filosofia Applicata

### DRY (Don't Repeat Yourself)
- **XotBaseResource getPages() Automatic**: Rimossi metodi `getPages()` duplicati da Resources che seguono le convenzioni di naming
- **Convenzioni Standard**: `List{Plural}`, `Create{Name}`, `Edit{Name}`, `View{Name}`

### KISS (Keep It Simple, Stupid)
- **Late Static Binding**: Usato `self::` invece di `static::` per classi `final`
- **Import Corretti**: Rimossi import non utilizzati
- **Tipi Corretti**: Usato tipi base (`BaseFilter`, `Action`) invece di sottotipi specifici

### Type Safety
- **Array Keys**: Sempre chiavi stringhe per tutti i metodi che restituiscono array di componenti
- **PHPDoc Completo**: Tipi di ritorno espliciti e corretti
- **Namespace Corretti**: `Filament\Actions\` invece di `Tables\Actions\`

## Correzioni Implementate

### OauthClientResource
1. ✅ Corretto `getTableColumns()`: chiavi stringhe, PHPDoc `array<string, Column>`
2. ✅ Corretto `getTableFilters()`: chiavi stringhe, PHPDoc `array<string, BaseFilter>`
3. ✅ Corretto `getTableActions()`: chiavi stringhe, import `Filament\Actions\`, PHPDoc `array<string, Action>`
4. ✅ Corretto `getTableBulkActions()`: chiavi stringhe, PHPDoc `array<string, Action|ActionGroup>`
5. ✅ Corretto late static binding: `self::` invece di `static::` (classe `final`)
6. ✅ Rimosso import non utilizzato: `Filament\Actions\Action`
7. ✅ Corretto lunghezza riga: divisa riga > 120 caratteri

### TeamUserResource
1. ✅ Corretto `getTableColumns()`: chiavi stringhe, PHPDoc `array<string, Column>`
2. ✅ Corretto `getTableFilters()`: chiavi stringhe, PHPDoc `array<string, BaseFilter>`
3. ✅ Corretto `getTableActions()`: chiavi stringhe, PHPDoc `array<string, Action>`
4. ✅ Corretto `getTableBulkActions()`: chiavi stringhe, PHPDoc `array<string, Action|ActionGroup>`
5. ✅ Corretto late static binding: `self::` invece di `static::` (classe `final`)

### TenantUserResource
1. ✅ Corretto `getTableColumns()`: chiavi stringhe, PHPDoc `array<string, Column>`
2. ✅ Corretto `getTableFilters()`: chiavi stringhe, PHPDoc `array<string, BaseFilter>`
3. ✅ Corretto `getTableActions()`: chiavi stringhe, PHPDoc `array<string, Action>`
4. ✅ Corretto `getTableBulkActions()`: chiavi stringhe, PHPDoc `array<string, Action|ActionGroup>`
5. ✅ Corretto late static binding: `self::` invece di `static::` (classe `final`)

### OauthPersonalAccessClientResource
1. ✅ Corretto modello: `Modules\User\Models\OauthPersonalAccessClient` invece di `Laravel\Passport\PersonalAccessClient`
2. ✅ Corretto `getTableColumns()`: chiavi stringhe, PHPDoc `array<string, Column>`
3. ✅ Corretto `getTableFilters()`: chiavi stringhe, PHPDoc `array<string, BaseFilter>`
4. ✅ Corretto `getTableActions()`: chiavi stringhe, import `Filament\Actions\`, PHPDoc `array<string, Action>`
5. ✅ Corretto `getTableBulkActions()`: chiavi stringhe, PHPDoc `array<string, Action|ActionGroup>`
6. ✅ Corretto late static binding: `self::` invece di `static::` (classe `final`)
7. ✅ Rimosso metodo `getPages()`: gestito automaticamente da `XotBaseResource`

### TeamPermissionResource
1. ✅ Rimosso metodo `getPages()`: gestito automaticamente da `XotBaseResource`

## Pattern Corretti Applicati

### Array Keys Sempre Stringhe
```php
// ✅ CORRETTO
/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public static function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id'),
        'name' => TextColumn::make('name'),
    ];
}

// ❌ ERRATO
/**
 * @return array<int, \Filament\Tables\Columns\Column>
 */
public static function getTableColumns(): array
{
    return [
        TextColumn::make('id'),
        TextColumn::make('name'),
    ];
}
```

### Late Static Binding per Classi Final
```php
// ✅ CORRETTO (classe final)
final class MyResource extends XotBaseResource
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableColumns()) // self:: invece di static::
            ->filters(self::getTableFilters());
    }
}
```

### Namespace Actions Corretto
```php
// ✅ CORRETTO
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

public static function getTableActions(): array
{
    return [
        'view' => ViewAction::make(),
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}

// ❌ ERRATO
use Filament\Tables\Actions\ViewAction; // Namespace sbagliato
```

## Risultati

### PHPStan
- ✅ **0 errori** nel modulo User (livello 10)
- ✅ Tutti i tipi di ritorno corretti
- ✅ Tutti i PHPDoc completi e corretti
- ✅ Tutti gli import corretti

### PHPMD
- ⚠️ `CouplingBetweenObjects`: 22 (accettabile per Resources complesse)
- ✅ Nessun altro errore critico

### PHP Insights
- ✅ Code: Nessun problema critico
- ✅ Style: Solo warning minori (line length, unused imports)

## Documentazione Creata

1. ✅ `xotbase-resource-getpages-automatic.md`: Filosofia DRY per `getPages()` automatico
2. ✅ `resources-array-keys-philosophy.md`: Filosofia per chiavi stringhe sempre
3. ✅ `resources-corrections-summary-2025-01-22.md`: Questo documento

## Lezioni Apprese

1. **DRY First**: Se `XotBaseResource` già implementa la logica, non duplicare
2. **Convenzioni**: Seguire le convenzioni di naming permette di evitare codice boilerplate
3. **Type Safety**: Chiavi stringhe sempre per array di componenti Filament
4. **Late Static Binding**: Usare `self::` per classi `final`
5. **Namespace**: `Filament\Actions\` per Actions, non `Tables\Actions\`

## Collegamenti

- [XotBaseResource getPages() Automatic](../../xotbase-resource-getpages-automatic.md)
- [Resources Array Keys Philosophy](../../resources-array-keys-philosophy.md)
- [Filament Resources Philosophical Debate](../../filament-resources-philosophical-debate.md)
- [Filament Best Practices](./filament-best-practices.md)

---

## resources-corrections

*Consolidated from: `resources-corrections.md`*

title: "Resources Corrections Summary - [DATE]"
type: concept
tags: [resources, corrections]
created: 2026-07-14
updated: 2026-07-14
qmd: "resources-corrections resources corrections summary - [date]"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Resources Corrections Summary - [DATE]

## Obiettivo
Correggere errori PHPStan livello 10, PHPMD e PHP Insights nelle Resources Filament del modulo User, seguendo rigorosamente le regole Laraxot e la filosofia DRY + KISS.

## Filosofia Applicata

### DRY (Don't Repeat Yourself)
- **XotBaseResource getPages() Automatic**: Rimossi metodi `getPages()` duplicati da Resources che seguono le convenzioni di naming
- **Convenzioni Standard**: `List{Plural}`, `Create{Name}`, `Edit{Name}`, `View{Name}`

### KISS (Keep It Simple, Stupid)
- **Late Static Binding**: Usato `self::` invece di `static::` per classi `final`
- **Import Corretti**: Rimossi import non utilizzati
- **Tipi Corretti**: Usato tipi base (`BaseFilter`, `Action`) invece di sottotipi specifici

### Type Safety
- **Array Keys**: Sempre chiavi stringhe per tutti i metodi che restituiscono array di componenti
- **PHPDoc Completo**: Tipi di ritorno espliciti e corretti
- **Namespace Corretti**: `Filament\Actions\` invece di `Tables\Actions\`

## Correzioni Implementate

### OauthClientResource
1. ✅ Corretto `getTableColumns()`: chiavi stringhe, PHPDoc `array<string, Column>`
2. ✅ Corretto `getTableFilters()`: chiavi stringhe, PHPDoc `array<string, BaseFilter>`
3. ✅ Corretto `getTableActions()`: chiavi stringhe, import `Filament\Actions\`, PHPDoc `array<string, Action>`
4. ✅ Corretto `getTableBulkActions()`: chiavi stringhe, PHPDoc `array<string, Action|ActionGroup>`
5. ✅ Corretto late static binding: `self::` invece di `static::` (classe `final`)
6. ✅ Rimosso import non utilizzato: `Filament\Actions\Action`
7. ✅ Corretto lunghezza riga: divisa riga > 120 caratteri

### TeamUserResource
1. ✅ Corretto `getTableColumns()`: chiavi stringhe, PHPDoc `array<string, Column>`
2. ✅ Corretto `getTableFilters()`: chiavi stringhe, PHPDoc `array<string, BaseFilter>`
3. ✅ Corretto `getTableActions()`: chiavi stringhe, PHPDoc `array<string, Action>`
4. ✅ Corretto `getTableBulkActions()`: chiavi stringhe, PHPDoc `array<string, Action|ActionGroup>`
5. ✅ Corretto late static binding: `self::` invece di `static::` (classe `final`)

### TenantUserResource
1. ✅ Corretto `getTableColumns()`: chiavi stringhe, PHPDoc `array<string, Column>`
2. ✅ Corretto `getTableFilters()`: chiavi stringhe, PHPDoc `array<string, BaseFilter>`
3. ✅ Corretto `getTableActions()`: chiavi stringhe, PHPDoc `array<string, Action>`
4. ✅ Corretto `getTableBulkActions()`: chiavi stringhe, PHPDoc `array<string, Action|ActionGroup>`
5. ✅ Corretto late static binding: `self::` invece di `static::` (classe `final`)

### OauthPersonalAccessClientResource
1. ✅ Corretto modello: `Modules\User\Models\OauthPersonalAccessClient` invece di `Laravel\Passport\PersonalAccessClient`
2. ✅ Corretto `getTableColumns()`: chiavi stringhe, PHPDoc `array<string, Column>`
3. ✅ Corretto `getTableFilters()`: chiavi stringhe, PHPDoc `array<string, BaseFilter>`
4. ✅ Corretto `getTableActions()`: chiavi stringhe, import `Filament\Actions\`, PHPDoc `array<string, Action>`
5. ✅ Corretto `getTableBulkActions()`: chiavi stringhe, PHPDoc `array<string, Action|ActionGroup>`
6. ✅ Corretto late static binding: `self::` invece di `static::` (classe `final`)
7. ✅ Rimosso metodo `getPages()`: gestito automaticamente da `XotBaseResource`

### TeamPermissionResource
1. ✅ Rimosso metodo `getPages()`: gestito automaticamente da `XotBaseResource`

## Pattern Corretti Applicati

### Array Keys Sempre Stringhe
```php
// ✅ CORRETTO
/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public static function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id'),
        'name' => TextColumn::make('name'),
    ];
}

// ❌ ERRATO
/**
 * @return array<int, \Filament\Tables\Columns\Column>
 */
public static function getTableColumns(): array
{
    return [
        TextColumn::make('id'),
        TextColumn::make('name'),
    ];
}
```

### Late Static Binding per Classi Final
```php
// ✅ CORRETTO (classe final)
final class MyResource extends XotBaseResource
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableColumns()) // self:: invece di static::
            ->filters(self::getTableFilters());
    }
}
```

### Namespace Actions Corretto
```php
// ✅ CORRETTO
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

public static function getTableActions(): array
{
    return [
        'view' => ViewAction::make(),
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}

// ❌ ERRATO
use Filament\Tables\Actions\ViewAction; // Namespace sbagliato
```

## Risultati

### PHPStan
- ✅ **0 errori** nel modulo User (livello 10)
- ✅ Tutti i tipi di ritorno corretti
- ✅ Tutti i PHPDoc completi e corretti
- ✅ Tutti gli import corretti

### PHPMD
- ⚠️ `CouplingBetweenObjects`: 22 (accettabile per Resources complesse)
- ✅ Nessun altro errore critico

### PHP Insights
- ✅ Code: Nessun problema critico
- ✅ Style: Solo warning minori (line length, unused imports)

## Documentazione Creata

1. ✅ `xotbase-resource-getpages-automatic.md`: Filosofia DRY per `getPages()` automatico
2. ✅ `resources-array-keys-philosophy.md`: Filosofia per chiavi stringhe sempre
3. ✅ `resources-corrections-summary-[DATE].md`: Questo documento

## Lezioni Apprese

1. **DRY First**: Se `XotBaseResource` già implementa la logica, non duplicare
2. **Convenzioni**: Seguire le convenzioni di naming permette di evitare codice boilerplate
3. **Type Safety**: Chiavi stringhe sempre per array di componenti Filament
4. **Late Static Binding**: Usare `self::` per classi `final`
5. **Namespace**: `Filament\Actions\` per Actions, non `Tables\Actions\`

## Collegamenti

- [XotBaseResource getPages() Automatic](../../xotbase-resource-getpages-automatic.md)
- [Resources Array Keys Philosophy](../../resources-array-keys-philosophy.md)
- [Filament Resources Philosophical Debate](../../filament-resources-philosophical-debate.md)
- [Filament Best Practices](./filament-best-practices.md)

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04