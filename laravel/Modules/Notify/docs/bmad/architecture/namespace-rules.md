---
title: "Regole Namespace PSR-4 per il Modulo Notify"
type: rule
tags: [namespace, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "namespace-rules-1 regole namespace psr-4 per il modulo notify"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
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
- Questa regola è valida per tutti i moduli: vedi [Xot Namespace Rules](../../Xot/docs/NAMESPACE_RULES.md)
- Collegamento alla documentazione generale: [Regole Namespace Moduli - Root Docs](../../../docs/namespace-moduli.md)

---

**Ultimo aggiornamento:** 2025-05-13
- Questa regola è valida per tutti i moduli: vedi [Xot Namespace Rules](../../xot/docs/namespace-rules.md)
- Collegamento alla documentazione generale: [Regole Namespace Moduli - Root Docs](../../../../docs/namespace-moduli.md)

---

**Ultimo aggiornamento:** 2025-05-13

**Link bidirezionale:** Aggiornare anche la root docs e la docs di Xot per riferimenti e cross-link.