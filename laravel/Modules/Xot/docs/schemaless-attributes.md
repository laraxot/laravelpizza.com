# Schemaless Attributes - Guida Completa Laraxot PTVX

## Introduzione

Il pacchetto `spatie/laravel-schemaless-attributes` permette di aggiungere attributi dinamici ai modelli Eloquent.

## ✅ Pattern Corretto: Scope

Per filtrare i modelli in base agli attributi schemaless, utilizzare **SEMPRE** lo scope fornito dal trait:

```php
// ✅ CORRETTO
$models = MyModel::withExtraAttributes('key', 'value')->get();
```

## ❌ Anti-Pattern: Raw Where

Evitare di scrivere query raw sulla colonna JSON, in quanto accoppia il codice al nome della colonna e alla struttura interna del DB:

```php
// ❌ DA EVITARE
$models = MyModel::where('extra_attributes->key', 'value')->get();
```

## ❌ Anti-Pattern: Override Manuale

**MAI** sovrascrivere `scopeWithExtraAttributes` nel modello. Il trait gestisce tutto correttamente.

## Implementazione

1.  Aggiungere `use SchemalessAttributesTrait;`
2.  Aggiungere cast: `'extra_attributes' => SchemalessAttributes::class` nel metodo `casts()`
3.  Usare `withExtraAttributes()` per le query.
