# Correzioni Violazioni XotBaseResource - Gennaio 2026

## Problema Identificato

Le classi che estendono `XotBaseResource` stavano sovrascrivendo proprietà e metodi che sono già gestiti automaticamente dal trait `NavigationLabelTrait` e dal trait `HasXotTable`, violando i principi DRY e KISS.

## Violazioni Corrette

### 1. `ClientResource` (Modules/User)
**Problema**: `protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;`
**Correzione**: Rimossa la proprietà, aggiunto commento esplicativo
**File**: `laravel/Modules/User/app/Filament/Resources/ClientResource.php`
**Traduzione Aggiornata**: `laravel/Modules/User/lang/it/client.php` - icona aggiornata a `heroicon-o-key`

### 2. `OauthRefreshTokenResource` (Modules/User)
**Problema**: 
- `protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path';`
- `protected static ?string $modelLabel = 'OAuth Refresh Token';`
- `protected static ?string $pluralModelLabel = 'OAuth Refresh Tokens';`
**Correzione**: Rimosse tutte le proprietà, aggiunto commento esplicativo
**File**: `laravel/Modules/User/app/Filament/Resources/OauthRefreshTokenResource.php`
**Traduzione Aggiornata**: `laravel/Modules/User/lang/it/oauth_refresh_token.php` - aggiunta struttura completa `navigation` con `name`, `plural`, `group` (con `name` e `description`)

### 3. `ConsentResource` (Modules/Gdpr)
**Problema**: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';`
**Correzione**: Rimossa la proprietà, aggiunto commento esplicativo
**File**: `laravel/Modules/Gdpr/app/Filament/Resources/ConsentResource.php`

### 4. `TreatmentResource` (Modules/Gdpr)
**Problema**: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';`
**Correzione**: Rimossa la proprietà, aggiunto commento esplicativo
**File**: `laravel/Modules/Gdpr/app/Filament/Resources/TreatmentResource.php`

### 5. `EventResource` (Modules/Gdpr)
**Problema**: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';`
**Correzione**: Rimossa la proprietà, aggiunto commento esplicativo
**File**: `laravel/Modules/Gdpr/app/Filament/Resources/EventResource.php`

### 6. `ProfileResource` (Modules/Gdpr)
**Problema**: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';`
**Correzione**: Rimossa la proprietà, aggiunto commento esplicativo
**File**: `laravel/Modules/Gdpr/app/Filament/Resources/ProfileResource.php`

### 7. `ConsentResource` (Modules/Gdpr/Clusters/Profile)
**Problema**: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';`
**Correzione**: Rimossa la proprietà, aggiunto commento esplicativo
**File**: `laravel/Modules/Gdpr/app/Filament/Clusters/Profile/Resources/ConsentResource.php`

### 8. `ProfileResource` (Modules/Gdpr/Clusters/Profile)
**Problema**: `protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';`
**Correzione**: Rimossa la proprietà, aggiunto commento esplicativo
**File**: `laravel/Modules/Gdpr/app/Filament/Clusters/Profile/Resources/ProfileResource.php`

### 9. `SocialiteUserResource` (Modules/User)
**Problema**: Tipo di ritorno `Builder` non qualificato in `getEloquentQuery()`
**Correzione**: Aggiunto `use Illuminate\Database\Eloquent\Builder;`
**File**: `laravel/Modules/User/app/Filament/Resources/SocialiteUserResource.php`

## Regole Architetturali Applicate

### ❌ VIETATO nelle classi che estendono `XotBaseResource`:

1. **`protected static string|\BackedEnum|null $navigationIcon`**
   - ❌ **NON** definire questa proprietà
   - ✅ Usare `navigation.icon` nel file di traduzione

2. **`protected static ?int $navigationSort`**
   - ❌ **NON** definire questa proprietà
   - ✅ Usare `navigation.sort` nel file di traduzione

3. **`protected static \UnitEnum|string|null $navigationGroup`**
   - ❌ **NON** definire questa proprietà
   - ✅ Usare `navigation.group.name` nel file di traduzione

4. **`protected static ?string $modelLabel`**
   - ❌ **NON** definire questa proprietà
   - ✅ Gestito automaticamente da Filament v4

5. **`protected static ?string $pluralModelLabel`**
   - ❌ **NON** definire questa proprietà
   - ✅ Gestito automaticamente da `NavigationLabelTrait`

6. **`public static function getNavigationLabel(): string`**
   - ❌ **NON** sovrascrivere questo metodo
   - ✅ Gestito automaticamente da `NavigationLabelTrait`

7. **`public static function getPluralLabel(): string`**
   - ❌ **NON** sovrascrivere questo metodo
   - ✅ Gestito automaticamente da `NavigationLabelTrait`

8. **`public static function getModelLabel(): string`**
   - ❌ **NON** sovrascrivere questo metodo
   - ✅ Gestito automaticamente da Filament v4

9. **`public static function table(Table $table): Table`**
   - ❌ **NON** implementare questo metodo
   - ✅ Gestito automaticamente da `HasXotTable` trait
   - ✅ Usare invece: `getTableColumns()`, `getTableHeaderActions()`, `getTableActions()`, `getTableBulkActions()`

## Motivazione

1. **DRY (Don't Repeat Yourself)**: `NavigationLabelTrait` e `HasXotTable` già gestiscono tutte queste funzionalità. Duplicare nel codice viola il principio DRY.

2. **KISS (Keep It Simple, Stupid)**: Un solo punto di verità (file di traduzione) è più semplice da mantenere rispetto a proprietà hardcoded distribuite in decine di classi.

3. **Sistema di Traduzione Centralizzato**: Laraxot ha un sistema di traduzione potente e centralizzato. Bypassarlo con proprietà statiche è un anti-pattern.

4. **Manutenibilità**: Modificare un file di traduzione è più semplice e sicuro che modificare codice PHP distribuito in molte classi.

5. **Coerenza**: Tutte le risorse devono seguire lo stesso pattern per garantire un'esperienza utente coerente.

6. **Localizzazione**: Il sistema di traduzione supporta automaticamente più lingue. Hardcodare nel codice richiederebbe modifiche multiple.

## Verifica

Tutte le modifiche sono state verificate con successo utilizzando:
- ✅ `phpstan` livello 10 - **Nessun errore**
- ✅ `pint` - **Tutti i file passano**
- ✅ `phpmd` - **Nessun errore**
- ✅ `read_lints` - **Nessun errore**

### File Verificati
1. `Modules/User/app/Filament/Resources/ClientResource.php`
2. `Modules/User/app/Filament/Resources/OauthRefreshTokenResource.php`
3. `Modules/User/app/Filament/Resources/SocialiteUserResource.php`
4. `Modules/Gdpr/app/Filament/Resources/ConsentResource.php`
5. `Modules/Gdpr/app/Filament/Resources/TreatmentResource.php`
6. `Modules/Gdpr/app/Filament/Resources/EventResource.php`
7. `Modules/Gdpr/app/Filament/Resources/ProfileResource.php`
8. `Modules/Gdpr/app/Filament/Clusters/Profile/Resources/ConsentResource.php`
9. `Modules/Gdpr/app/Filament/Clusters/Profile/Resources/ProfileResource.php`

## Documentazione Aggiornata

- **`laravel/Modules/Xot/docs/filament/xotbaseresource-architectural-rules.md`**: Creato nuovo documento che dettaglia le regole architetturali con dibattito interno e motivazione.
- **`.cursor/rules/anti-redundancy-rules.mdc`**: Aggiornato con nuova sezione "Navigation Properties in XotBaseResource".

## Collegamenti

- [Regole Architetturali XotBaseResource](./xotbaseresource-architectural-rules.md)
- [NavigationLabelTrait](../../app/Filament/Traits/NavigationLabelTrait.php)
- [HasXotTable Trait](../../app/Filament/Traits/HasXotTable.php)
- [XotBaseResource](../../app/Filament/Resources/XotBaseResource.php)
- [Regole Anti-Ridondanza](../../../.cursor/rules/anti-redundancy-rules.mdc)

---

**Data Intervento**: Gennaio 2026  
**Conforme a**: DRY, KISS, Filosofia Laraxot  
**PHPStan Level**: 10 ✅
