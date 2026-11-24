---
qmd: "ui lessons learned reusable filament components pattern md"
name: reusable-filament-components-pattern
description: "Un componente Filament riutilizzabile porta con sé la sua logica di styling/comportamento, non va sparpagliata nel Resource che lo usa"
metadata:
  type: lesson-learned
  created: 2026-09-15
  github_issues: []
---

# Il componente riutilizzabile porta la sua logica (case study: OrderColumn)

## L'errore che si è ripetuto

Prima di introdurre `OrderColumn`, la colonna "order" veniva ricostruita inline in ogni
Table class che ne aveva bisogno (`TextColumn::make('order_column')->sortable()->...`),
duplicando styling e comportamento (toggleable, tooltip, label) in ogni Resource.

## Perché è sbagliato

Logica di visualizzazione ripetuta in più Resource significa: se cambia lo stile del badge
o il comportamento delle frecce, va aggiornato in ogni punto dove è stato copiato. Il
componente diventa un "concetto" solo nella testa dello sviluppatore, non nel codice.

## Come si fa correttamente

Componenti custom dedicati, uno per contesto (Table e Form sono contesti diversi):

```php
// Modules/UI/app/Filament/Tables/Columns/OrderColumn.php — badge, sortable, toggleable
// Modules/UI/app/Filament/Forms/Components/OrderColumn.php — badge + frecce ↑↓ (Livewire $set())
```

Il Resource che li adotta si limita a:

```php
use Modules\UI\Filament\Tables\Columns\OrderColumn;

OrderColumn::make('order_column'),
```

Tutta la logica di styling/comportamento vive nel componente, non nel Resource. Nessuna
`->label()` esplicita (vedi lezione `filament-label-autoconfigured` in Xot): il componente
non forza una label, la eredita dal meccanismo standard del progetto.

## Come riconoscerlo in futuro

Se stai per scrivere `->sortable()->toggleable()->tooltip()->alignment()->width()` (o
combinazioni simili) più di una volta per lo stesso concetto in Resource diversi, è il
segnale che serve un componente condiviso in `Modules/UI/app/Filament/`.

## Riferimenti

- Commit `Modules/UI` `6cf8e31a` (componenti), `e0d770b0` (fix label)
- Commit `Modules/IndennitaResponsabilita` `f9ded67` (adozione)
- Issue `provtv/module_ui_fila5#24`
