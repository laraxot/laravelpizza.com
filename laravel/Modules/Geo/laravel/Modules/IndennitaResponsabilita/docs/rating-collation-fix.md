# Fix Problema Collation SQL nella Tabella Ratings

## Problema Identificato

**Errore**: `SQLSTATE[HY000]: General error: 1267 Illegal mix of collations (utf8_general_ci,COERCIBLE) and (utf8_unicode_ci,COERCIBLE)`

**Query problematica**:
```sql
select count(*) as aggregate 
from `ratings` 
where (json_unquote(json_extract(`extra_attributes`, '$."anno"')) = 2025)
```

**Causa**: La tabella `ratings` (o alcune colonne) usa `utf8_general_ci` mentre la query JSON confronta con valori che usano `utf8_unicode_ci`, causando un conflitto di collation.

## Soluzione Implementata

### 1. Correzione Sintassi `withExtraAttributes()`

**PRIMA (errato - parametri separati)**:
```php
$rows = $model::withExtraAttributes('anno', $anno_prec)->get();
return $query->withExtraAttributes('anno', $anno);
```

**DOPO (corretto - array associativo)**:
```php
$rows = $model::withExtraAttributes(['anno' => $anno_prec])->get();
return $query->withExtraAttributes(['anno' => $anno]);
```

**File modificato**: `Modules/IndennitaResponsabilita/app/Filament/Resources/RatingResource/Pages/ListRatings.php`

### 2. Migrazione Collation

**File**: `Modules/Rating/database/migrations/2025_12_02_111106_fix_ratings_table_collation.php`

**Azione**: Converte la tabella `ratings` e tutte le sue colonne a `utf8mb4_unicode_ci` per garantire consistenza.

```php
// Convert table collation to utf8mb4_unicode_ci
DB::connection($connection)->statement(
    "ALTER TABLE `{$this->table_name}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
);

// Ensure extra_attributes column specifically uses utf8mb4_unicode_ci
DB::connection($connection)->statement(
    "ALTER TABLE `{$this->table_name}` MODIFY COLUMN `extra_attributes` JSON CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
);
```

## Spiegazione Tecnica

### Perché il Problema si Verifica

1. **JSON Extraction**: La funzione `json_unquote(json_extract(...))` restituisce una stringa
2. **Collation Implicita**: MySQL assegna automaticamente una collation alla stringa estratta
3. **Confronto**: Quando la stringa estratta viene confrontata con un valore letterale, MySQL deve usare una collation comune
4. **Conflitto**: Se tabella e valore letterale hanno collation diverse e incompatibili → errore 1267

### Perché utf8mb4_unicode_ci

- **utf8mb4**: Supporto completo Unicode (inclusi emoji)
- **unicode_ci**: Case-insensitive, più accurato per confronti linguistici
- **Standard Laravel**: Laravel usa `utf8mb4_unicode_ci` come default
- **Compatibilità**: Evita mix di collation tra diverse parti del sistema

## Come Applicare la Correzione

```bash
# 1. Esegui la migrazione
cd laravel
php artisan migrate --path=Modules/Rating/database/migrations

# 2. Verifica la collation
php artisan tinker --execute="DB::select('SHOW CREATE TABLE ratings')"

# 3. Test funzionalità
# Accedi alla pagina: http://ptvx.local/indennitaresponsabilita/admin/ratings
# Filtra per anno 2025 - dovrebbe funzionare senza errori
```

## Pattern da Usare con Schemaless Attributes

### ✅ CORRETTO - Array Associativo

```php
// Singolo attributo
Rating::withExtraAttributes(['anno' => 2025])->get();

// Multipli attributi
Rating::withExtraAttributes([
    'anno' => 2025,
    'type' => 'stipendio'
])->get();

// In query builder chain
Rating::query()
    ->withExtraAttributes(['anno' => 2025])
    ->where('is_disabled', false)
    ->get();
```

### ❌ ERRATO - Parametri Separati

```php
// NON FUNZIONA - parametri vengono ignorati
Rating::withExtraAttributes('anno', 2025)->get();
```

## Verifica Post-Fix

### Test Manuale
1. Accedi all'admin Filament: `/indennitaresponsabilita/admin/ratings`
2. Seleziona filtro "Anno: 2025"
3. Verifica che la tabella si carichi senza errori SQL
4. Verifica che i dati filtrati siano corretti

### Test Automatico
```bash
php artisan test --filter=RatingTest
```

## Collegamenti

- [Rating Schemaless Usage](./rating-schemaless-usage.md)
- [Refactoring Rating Functions](./refactoring-rating-functions.md)
- [Modules/Rating/Models/Rating.php](../../Rating/app/Models/Rating.php)

---

**Data fix**: 2 Dicembre 2025  
**Autore**: Claude Code Assistant  
**Status**: ✅ Risolto con migrazione collation + correzione sintassi withExtraAttributes()

