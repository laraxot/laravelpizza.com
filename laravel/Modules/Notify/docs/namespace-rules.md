---
qmd: "namespace rules"
issues: []
discussions: []
title: "Regole Namespace PSR-4 per il Modulo Notify"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
---

# Regole Namespace PSR-4 per il Modulo Notify

## Regola Fondamentale
- **Mai** usare il segmento `App` nel namespace delle classi del modulo.
- Il namespace deve essere sempre della forma:
  ```php
  namespace Modules\Notify\<Directory>;
  ```
  Anche se la classe si trova in `app/`, il namespace NON deve includere `App`.

## Esempio di Errore Comune
**Errato:**
```php
namespace Modules\Notify\App\Console\Commands;
```
**Corretto:**
```php
namespace Modules\Notify\Console\Commands;
```

## Regola PSR-4
- Il namespace deve riflettere la struttura delle directory a partire da `Modules/Notify/app/`, ma senza includere `app`.
- Esempio:
  - File: `Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php`
  - Namespace: `Modules\Notify\Console\Commands`

## Collegamenti e Regole Generali
- Questa regola è valida per tutti i moduli: vedi [Xot Namespace Rules](../../xot/docs/namespace_rules.md)
- Collegamento alla documentazione generale: [Regole Namespace Moduli - Root Docs](../../../../docs/namespace-moduli.md)

---

**Ultimo aggiornamento:** [DATE]

**Link bidirezionale:** Aggiornare anche la root docs e la docs di Xot per riferimenti e cross-link.
