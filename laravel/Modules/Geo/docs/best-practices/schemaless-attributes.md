# Spatie Laravel Schemaless Attributes - Best Practices

## ⚠️ AVVISO CRITICO

**L'implementazione corrente di `scopeWithExtraAttributes()` nei modelli Laraxot IGNORA i parametri passati!**

Usare SEMPRE `where()` con JSON path per query su schemaless attributes.

## Pattern Corretto

```php
// ✅ CORRETTO: Query con JSON path - FUNZIONA SEMPRE
$ratings = Rating::where('extra_attributes->anno', 2025)->get();
$ratings = Rating::where('extra_attributes->type', 'valutazione')->get();

// ✅ CORRETTO: Con operatori
$ratings = Rating::where('extra_attributes->anno', '>=', 2023)->get();

// ✅ CORRETTO: Attributi nested
$ratings = Rating::where('extra_attributes->config->enabled', true)->get();
```

## Pattern Errato

```php
// ❌ ERRATO: I parametri vengono IGNORATI!
$ratings = Rating::withExtraAttributes('anno', 2025)->get(); // Restituisce TUTTI i record!

// ❌ ERRATO: withExtraAttributes() vuoto è inutile
$ratings = Rating::withExtraAttributes()->where('extra_attributes->anno', $anno)->get();
```

## Documentazione Completa

Per dettagli completi, consultare:

- [Guida Completa Schemaless Attributes](../laravel/Modules/Xot/docs/spatie-schemaless-attributes.md)
- [Regole Windsurf](../.windsurf/rules/schemaless-attributes.md)

## Bug Identificato

Il metodo `scopeWithExtraAttributes()` nel modello `Rating` ignora i parametri:

```php
// Implementazione BUGGATA:
public function scopeWithExtraAttributes(Builder $query, string|array $schemalessAttributes = [], mixed $value = null): Builder
{
    return $this->extra_attributes->modelScope(); // ❌ IGNORA i parametri!
}
```

**Data identificazione:** Dicembre 2025

**Status:** Non corretto - usare `where()` con JSON path come workaround

---

*Ultimo aggiornamento: Dicembre 2025*
