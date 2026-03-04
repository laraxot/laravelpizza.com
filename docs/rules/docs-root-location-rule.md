# Docs Root Location Rule

## Regola vincolante

1. La documentazione globale vive solo in `./docs` (root repository).
2. `./laravel/docs` non deve esistere.
3. I moduli continuano a usare `laravel/Modules/*/docs` e i temi `laravel/Themes/*/docs`.
4. I link da moduli/temi verso documentazione globale devono puntare a `../../../../docs/...` (o profondita equivalente).
5. Dopo ogni migrazione docs, eseguire link-check sui file aggiornati.
6. Prima di qualunque modifica codice, il primo step operativo e sempre docs-first: ragionare, studiare docs del modulo/tema, aggiornare `docs/rules`, `docs/memory`, `docs/skills`.

Riferimento operativo: `docs/rules/pre-edit-docs-first-rule.md`.
