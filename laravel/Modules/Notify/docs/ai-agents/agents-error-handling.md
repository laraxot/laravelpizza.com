---
title: "agents error handling"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_zJfqUB
<<<<<<< .merge_file_6FnyG3
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_LzBh8S
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_zJfqUB
>>>>>>> .merge_file_WM0lNq
=======
>>>>>>> .merge_file_LzBh8S
qmd: "agents error handling"
issues: []
discussions: []
status: draft
---

# AGENTS Error Handling

Pattern e best practices per la gestione degli errori.

## Exception Patterns

```php
// Use specific exception types
try {
    // Code
} catch (ModelNotFoundException $e) {
    // Handle not found
} catch (ValidationException $e) {
    // Handle validation
} catch (\Exception $e) {
    // Generic fallback
}
```

---
## Validation

- Use **Form Request classes** for validation (not inline)
- Include custom error messages
- Validate all user input

---

## Error Fix Governance

### Workflow

1. Quando un utente riporta un errore:
   - Studiare e migliorare prima i `docs/` dei moduli/temi coinvolti
   - Leggere la Git history rilevante per recuperare intent e scopo funzionale
   - Lavorare solo forward-only con Git: mai usare rollback come strategia di fix

2. Se un modulo espone già model, factory, resource o view contract, e il runtime si rompe perché manca lo schema:
   - Completare l'infrastruttura mancante invece di mascherare il sintomo

3. Per bugfix significativi:
   - Aggiornare rules, memories, skills locali
   - Valutare se creare/aggiornare GitHub Issue, Discussion o Action

### Reference
- [ERROR_FIX_WORKFLOW.md](../../docs/project/ERROR_FIX_WORKFLOW.md)

---

## Error Fix Workflow

1. Studiare e migliorare i `docs/` dei moduli e temi impattati
2. Ispezionare la Git history per capire intent e scope
3. Ragionare sullo scopo business dell'area rotta prima di patchare
4. Applicare solo correzioni Git forward-only, mai fix basati su rollback
5. Aggiornare conoscenza persistente (`docs`, `rules`, `memories`, `skills`)
6. Valutare aggiornamenti GitHub Issue, Discussion e GitHub Actions
7. Solo dopo implementare e verificare la fix del codice

---

## Debugging Tools

### Available Tools
- **Laravel Telescope** (if installed)
- **Debugbar** (if installed)
- **PHPStan** for static analysis
- **Laravel Pint** for code formatting
- **Xdebug** for step debugging

### Common Issues
- Module autoloading: `composer dump-autoload`
- Cache issues: `php artisan cache:clear`
- View issues: `php artisan view:clear`
- Route issues: `php artisan route:clear`

---

## 🔗 Link

- [Indice AGENTS](./agents-split-index.md)
- [phpstan.md](../phpstan.md) - Analisi statica
- [AGENTS.md originale](../../AGENTS.md)
<<<<<<< .merge_file_zJfqUB
<<<<<<< .merge_file_6FnyG3
<<<<<<< HEAD
- [AGENTS.md originale](../../AGENTS.md)
- [AGENTS.md originale](../agents.md)
=======
<<<<<<< HEAD
- [AGENTS.md originale](../../AGENTS.md)
- [AGENTS.md originale](../agents.md)
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
- [AGENTS.md originale](../../AGENTS.md)
- [AGENTS.md originale](../agents.md)
>>>>>>> .merge_file_WM0lNq
=======
- [AGENTS.md originale](../../AGENTS.md)
- [AGENTS.md originale](../agents.md)
>>>>>>> .merge_file_LzBh8S
- [AGENTS.md originale](../agents.md)
- [Index principale](./index.md)
