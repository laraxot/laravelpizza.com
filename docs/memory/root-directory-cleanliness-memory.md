# Root Directory Cleanliness Memory

## Lezione appresa

12 file di vario tipo (report, script, discussion drafts, PRD) erano stati creati
direttamente nella root `/var/www/_bases/base_laravelpizza/` invece delle
destinazioni corrette. Questo è stato scoperto e corretto (issue #563).

## Mappa destinazioni

| Tipo | Dove |
|------|------|
| Script `.sh`, `.py` | `bashscripts/` |
| GitHub discussion drafts/updates | `docs/discussions/` |
| GitHub issue reports / summaries | `docs/github/` |
| PRD principale | `docs/PRD.md` |
| PRD varianti (Ralph Loop, etc.) | `docs/{nome}-prd.md` |
| Changelog / project updates | `docs/` |
| Report implementazione modulo | `laravel/Modules/{Module}/docs/` |
| Marketing / brainstorming content | `docs/` con nome descrittivo |

## Standard operativo

1. **Mai** creare file nella root tranne quelli autorizzati
2. Prima di creare un file, decidere la categoria e la destinazione
3. Tracciare ogni spostamento in GitHub Issues
4. Verificare che la root sia pulita dopo ogni sessione

## Regola correlata

`docs/rules/root-directory-cleanliness.md`
`.cursor/rules/root-directory-cleanliness.mdc`
