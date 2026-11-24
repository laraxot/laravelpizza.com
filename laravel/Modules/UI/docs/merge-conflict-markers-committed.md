---
title: "Marker di merge committati nel modulo UI — diagnosi e criteri di risoluzione"
module: "UI"
type: troubleshooting
status: approved
tags: [ui, git, merge-conflict, phpstan, blade, lang]
created: 2026-08-18
updated: 2026-08-18
qmd: "marker conflitto merge committati T_SL phpstan.parse UI blocchi lang blade risoluzione"
related:
  - "../../../../docs/chat/formschema-widget-hierarchy-regression.md"
  - "./stories/5.8.merge-conflict-markers-cleanup.story.md"
---

# Marker di merge committati nel modulo UI

> `phpstan analyse Modules` si fermava a **6 errori `phpstan.parse`** senza analizzare
> nulla: `Syntax error, unexpected T_SL`. `T_SL` è l'operatore `<<`, cioè l'inizio di
> `<<<<<<< HEAD`. Nove file del modulo `UI` erano stati committati con i marker di
> conflitto dentro.
## Come si riconosce
Un errore `phpstan.parse` **non è ignorabile** e blocca il resto dell'analisi. Se il
messaggio cita `T_SL` o `unexpected EOF`, cerca i marker prima di qualsiasi altra ipotesi:
```bash
cd laravel && git grep -ln '^<<<<<<< ' -- 'Modules/**/*.php'
```
## I nove file e il criterio applicato
| File | Le due varianti | Criterio |
|---|---|---|
| `Blocks/Navigation.php`, `Blocks/Page.php`, `Blocks/Slider.php` | `getFormSchema` vs `getFormSchemaOld` | **`getFormSchema`**: i Block estendono `XotBaseBlock`, non `XotBaseResource`; i Block fratelli (`Post`, `Image`, `Category`, `Contact`) usano `getFormSchema` |
| `Tables/Columns/GroupColumn.php` | `return;` vs corpo vuoto | **`return;`**: la guardia `if (null === $table)` senza `return` prosegue e monta i figli su una table nulla |
| `lang/it/table_layout_enum.php` | chiavi in radice vs sotto `values` | **`values`**: è la struttura di `gender_enum.php`, `yes_no_enum.php` e del gemello `table-layout-enum.php` |
| `Models/Category.php` | docblock spezzato in due vs unico | **unico**, con `@property ProfileContract\|null $deleter` una sola volta |
| `views/components/logo/v1.blade.php`, `views/components/headernav/simple.blade.php` | `assets/predict/img/…` vs `assets/branding/img/…` | **`branding`**: `UI` è un modulo riusabile, non deve nominare un progetto specifico (nessuno dei due asset esiste su disco) |
| `views/filament/forms/components/inline-date-picker.blade.php` | `$currentValue = $currentValue;` vs `$currentValue ?? null` | **`?? null`**: l'auto-assegnazione è un no-op che lascia la variabile non definita |
| `tests/TestCase.php` | `ptv_data.sqlite` vs `database.sqlite` (riga duplicata) | **`ptv_data.sqlite`**: è il database condiviso usato da `Xot`, `Job` e `Lang` |
| `tests/Unit/Models/ComponentModelTest.php` | due test separati vs uno solo | **due test**: `can be instantiated` e `has fillable attributes` verificano cose diverse |
## Regola
Un marker di conflitto non si risolve scegliendo «la parte HEAD» per abitudine. Ogni
blocco è una domanda a sé: si risponde con il **codice circostante** (classi sorelle,
classe base, file gemelli), non con la posizione nel diff.
## Verifica
cd laravel
git grep -ln '^<<<<<<< \|^>>>>>>> ' -- 'Modules/**/*.php'   # nessun risultato
git diff --name-only | while read f; do case "$f" in *.php) php -l "$f";; esac; done
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules
```

## Riferimenti

- [Story 5.8 — pulizia marker di merge](./stories/5.8.merge-conflict-markers-cleanup.story.md)
