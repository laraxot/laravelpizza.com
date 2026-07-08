# Analisi DRY + KISS + SOLID + Robustezza - IndennitaResponsabilita

## Executive Summary

Analisi approfondita del modulo IndennitaResponsabilita con identificazione di violazioni dei principi DRY, KISS, SOLID e best practices Laraxot.

**Data analisi:** Dicembre 2025  
**File principale analizzato:** `CompilaIndennitaResponsabilita.php`  
**Livello critico:** 🔴 Alto (4 violazioni critiche)

---

## 🔴 VIOLAZIONI CRITICHE

### 1. ~~Spatie SchemalessAttributes - Uso ERRATO~~ ✅ RISOLTO

**Status:** ✅ FIX APPLICATO — `Rating.php` ora estende `BaseRating` (DRY)

**Problema originale:**
`Rating.php` aveva un `scopeWithExtraAttributes()` che usava `$this->extra_attributes->modelScope()` ignorando i parametri.

**Fix applicato:**
`Rating.php` ora estende `BaseRating`, che implementa correttamente lo scope con filtri JSON path.

```php
// ✅ CORRETTO - Entrambi funzionano ora
$rows = Rating::withExtraAttributes('anno', $anno)->get();
$rows = Rating::where('extra_attributes->anno', $anno)->get();
```

**Riferimento:** [Rating Schemaless Errors](../../../Rating/docs/schemaless-attributes-errors.md) | [Xot Central Guide](../../../Xot/docs/spatie-schemaless-attributes.md)

---

### 2. Proprietà $casts Deprecata

**File:** `IndennitaResponsabilita.php:246-250`

**Problema:**
```php
// ❌ ERRATO - Proprietà deprecata
protected $casts = [
    'dal' => 'date',
    'al' => 'date',
];
```

**Soluzione:**
```php
// ✅ CORRETTO - Usare metodo casts()
/**
 * @return array<string, string>
 */
public function casts(): array
{
    return array_merge(parent::casts(), [
        'dal' => 'date',
        'al' => 'date',
    ]);
}
```

---

### 3. Magic Numbers Non Documentati

**File:** `CompilaIndennitaResponsabilita.php:318,357`

**Problema:**
```php
// ❌ Magic numbers non documentati
$imp_mese_calcolato = $tot * 10;           // Cosa significa 10?
$imp_anno_attribuito = $imp_mese_attribuito * 12 * $perc;  // 12 = mesi, ma non documentato
```

**Soluzione:**
```php
// ✅ CORRETTO - Costanti documentate
private const MOLTIPLICATORE_IMPORTO_MENSILE = 10;
private const MESI_ANNO = 12;

$imp_mese_calcolato = $tot * self::MOLTIPLICATORE_IMPORTO_MENSILE;
$imp_anno_attribuito = $imp_mese_attribuito * self::MESI_ANNO * $perc;
```

---

### 4. Violazione Single Responsibility (SOLID)

**File:** `CompilaIndennitaResponsabilita.php:266-364`

Il metodo `getViewData()` (100+ righe) gestisce:
- Query database
- Calcoli matematici business
- Manipolazione form_data
- Lookup record per titolo

**Soluzione:** Estrarre logica in una Action o Service:

```php
// Creare: app/Actions/CalcolaImportiIndennita.php
namespace Modules\IndennitaResponsabilita\Actions;

class CalcolaImportiIndennita
{
    public function execute(IndennitaResponsabilita $record, array $formData): array
    {
        // Logica di calcolo isolata e testabile
    }
}
```

---

## 🟡 VIOLAZIONI MEDIE

### 5. DRY Violation - Pattern Ripetuto in getViewData()

**File:** `CompilaIndennitaResponsabilita.php:306-359`

**Problema:** Pattern identico ripetuto 4 volte:
```php
// Pattern ripetuto per ogni tipo di importo
$row = $rows->firstWhere('title', 'titolo');
Assert::notNull($row, 'messaggio');
$id = is_int($row->id) ? $row->id : (int) $row->id;
// ... calcolo
Arr::set($this->form_data, 'ratings.'.$id.'.pivot.value', $valore);
```

**Soluzione:** Metodo helper:
```php
private function setRatingValue(
    Collection $rows,
    string $title,
    int|float $value
): void {
    $row = $rows->firstWhere('title', $title);
    if (null === $row) {
        throw new \RuntimeException("Rating '{$title}' not found");
    }
    $id = (int) $row->id;
    Arr::set($this->form_data, "ratings.{$id}.pivot.value", $value);
}
```

---

### 6. Codice Commentato Obsoleto

**File:** Multipli file con blocchi `/* ... */`

**Problema:** 150+ righe di codice commentato:
- `CompilaIndennitaResponsabilita.php:29,54-70,112-117,154-159,226-233,...`
- `FunctionTrait.php:123-162`
- `RelationshipTrait.php:50-63`

**Soluzione:** Rimuovere tutto il codice commentato. Usare Git per history.

---

### 7. KISS Violation - getView() Troppo Complesso

**File:** `CompilaIndennitaResponsabilita.php:133-152`

**Problema:** Metodo che ricava la view dal namespace tramite manipolazione stringhe.

**Soluzione:** Usare costante o configurazione diretta:
```php
protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';

public function getView(): string
{
    if (!view()->exists($this->view)) {
        throw new ViewNotFoundException("View [{$this->view}] not found");
    }
    return $this->view;
}
```

---

### 8. fillForm() - Logica di Default Dates Duplicata

**File:** `CompilaIndennitaResponsabilita.php:191-264`

**Problema:** Logica identica per `dal` e `al`:
```php
if (!isset($data['dal'])) { $data['dal'] = Carbon::parse(...); }
if (is_string($data['dal'])) { ... }
// Stessa logica per 'al'
```

**Soluzione:**
```php
private function normalizeDate(?string $field, int $anno, string $default): Carbon
{
    $value = $this->getRecord()->{$field};
    if (null === $value) {
        return Carbon::parse("{$anno}-{$default}");
    }
    $date = Carbon::parse($value);
    return $date->year === $anno ? $date : Carbon::parse("{$anno}-{$default}");
}

// Uso:
$data['dal'] = $this->normalizeDate('dal', $anno, '01-01');
$data['al'] = $this->normalizeDate('al', $anno, '12-31');
```

---

## 🟢 MIGLIORAMENTI SUGGERITI

### 9. Type Casting Ripetuto

**Problema:** Pattern `is_int($x) ? $x : (int) $x` ripetuto 15+ volte.

**Soluzione:** Helper method:
```php
private function toInt(mixed $value): int
{
    return is_int($value) ? $value : (int) $value;
}
```

---

### 10. Robustezza - Assert vs Eccezioni Custom

**Problema:** Uso di `Assert::notNull()` con messaggi generici.

**Soluzione:** Eccezioni domain-specific:
```php
// Creare eccezione custom
class RatingNotFoundException extends \DomainException {}

// Uso
$row = $rows->firstWhere('title', $title)
    ?? throw new RatingNotFoundException("Rating '{$title}' not found for year {$anno}");
```

---

## Piano di Refactoring

### Fase 1 - Critici (Immediato)
1. ✅ Correggere query Spatie SchemalessAttributes
2. ✅ Convertire $casts in metodo casts()
3. ✅ Documentare/estrarre magic numbers

### Fase 2 - SOLID (1-2 giorni)
4. Creare `CalcolaImportiIndennita` Action
5. Estrarre calcoli da getViewData()

### Fase 3 - DRY (1 giorno)
6. Creare helper methods
7. Rimuovere codice commentato

### Fase 4 - Testing
8. Aggiungere unit test per calcoli
9. Test di integrazione per form

---

## Checklist Post-Refactoring

- [ ] PHPStan livello 10 passa
- [ ] PHPMD senza warning
- [ ] PHPInsights >= 90%
- [ ] Test copertura >= 80%
- [ ] Nessun codice commentato
- [ ] Nessun magic number
- [ ] Documentazione aggiornata

---

## Riferimenti

### Documentazione Claude

- [SOLID Principles](../../../../docs/claude/solid-principles.md) - Violazioni SOLID e fix
- [DRY + KISS Patterns](../../../../docs/claude/dry-kiss-patterns.md) - Pattern per codice pulito
- [Schemaless Attributes Bug](../../../../docs/claude/schemaless-attributes.md) - Bug withExtraAttributes()

### Documentazione Modulo

- [DRY+KISS Violations Analysis](./dry-kiss-violations-analysis.md)
- [Business Logic Analysis](./business-logic-analysis.md)

### Documentazione Xot

- [Spatie SchemalessAttributes](../../Xot/docs/spatie-schemaless-attributes.md)
- [Laraxot Conventions](../../Xot/docs/laraxot-conventions.md)

---

## Violazioni Aggiuntive Identificate

### RelationshipTrait Issues

| File | Linea | Problema | Priorità |
|------|-------|----------|----------|
| `RelationshipTrait.php` | 94 | `echo` in codice produzione | Alta |
| `RelationshipTrait.php` | 27-47 | `request()` in model | Media |
| `RelationshipTrait.php` | 82-111 | `importi()` troppo complesso | Media |

### Actions Issues

| File | Linea | Problema | Priorità |
|------|-------|----------|----------|
| `MakePdfByRecord.php` | 23-34 | Codice commentato | Bassa |
| `SendMailByRecord.php` | 25 | Loose comparison `== 0` | Media |
| `SendMailByRecord.php` | 31, 40 | Codice commentato | Bassa |

---

*Ultimo aggiornamento: Dicembre 2025*
