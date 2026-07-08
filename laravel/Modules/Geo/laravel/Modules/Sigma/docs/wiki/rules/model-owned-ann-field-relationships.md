---
title: "Sigma — Model Owned ANN Field Relationships"
type: rule
module: Sigma
tags: [relationships, ann-field, dry, inheritance, contract]
created: 2026-06-15
updated: 2026-06-15
qmd: "DateRangeFieldsContract annFieldName hasManyByEnteMatr relatedByAnno relationship"
issues:
  - "https://github.com/provtv/module_sigma_fila5/issues/3"
discussions:
  - "https://github.com/provtv/module_sigma_fila5/discussions/5"
related:
  - ./basemodel-hierarchy.md
  - ./model-contracts-placement.md
  - ../concepts/ente-matr-field-ownership.md
---

# Sigma — Model Owned ANN Field Relationships

## Regola CARDINAL

**Il nome colonna anno (es. `'quaann'`) è un'ownership del modello target.**  
I metodi di relazione (`hasManyByEnteMatr`, `EnteMatrRelationship`) leggono il nome colonna dal contratto `DateRangeFieldsContract`, mai da parametri hardcodati.

## Anti-Pattern (NEVER)

```php
// ❌ SBAGLIATO — passa 'quaann' quando Qua00f lo sa già
$this->relatedByAnno(Qua00f::class, 'quaann');
```

## Pattern CORRETTO

```php
// ✅ CORRETTO — chiama il modello e delega all'interfaccia
$this->hasManyByEnteMatr(Qua00f::class);
// Questo aggiunge automaticamente:
// - where('matr', $this->{$this->matrField()})
// - where('ente', $this->{$this->enteField()})
// - where(Qua00f->annFieldName(), $this->anno)
```

## Perché

| Motivo | Spiegazione |
|--------|-------------|
| **DRY** | Il nome colonna è definito una volta in `Qua00f::annFieldName()`. |
| **Single Source of Truth** | Il modello è l'unica fonte di verità per i propri campi. |
| **Evolution** | Se `Qua00f` cambia nome colonna, basta aggiornare l'interfaccia. |
| **Consistency** | Tutti i modelli con `DateRangeFieldsContract` seguono lo stesso standard. |

## Implementazione

### DateRangeFieldsContract Contract

```php
namespace Modules\Sigma\Models\Contracts;

interface DateRangeFieldsContract
{
    public function rangeFromField(): string;
    public function rangeToField(): string;
    public function annFieldName(): string;   // <-- nome anno colonna
}
```

### BaseModel Helper

```php
// Modules\Sigma\Models\BaseModel
protected function hasManyByEnteMatr(string $relatedClass)
{
    $relation = $this->hasMany($relatedClass, $this->matrField(), 'matr')
        ->where($this->enteField(), $this->{$this->enteField()});

    if (in_array(DateRangeFieldsContract::class, class_implements($relatedClass))) {
        $relatedInstance = new $relatedClass;
        $relation->where($relatedInstance->annFieldName(), $this->anno);
    }

    return $relation;
}
```

**Conclusione:** non passare mai `'quaann'` (o altri nomi) come secondo argomento a `relatedByAnno`; usa `hasManyByEnteMatr()` che delega al modello target.