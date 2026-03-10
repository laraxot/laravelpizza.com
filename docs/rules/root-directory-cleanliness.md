# Root Directory Cleanliness - Regola Critica

## Problema

File di vario tipo (report, script, discussion drafts, PRD) sono stati creati direttamente
nella root `/var/www/_bases/base_laravelpizza/` invece delle destinazioni corrette.

## Regola

**MAI creare file nella root `/var/www/_bases/base_laravelpizza/`.**

La root deve contenere SOLO:
- `AGENTS.md`, `CLAUDE.md`, `GEMINI.md`, `IFLOW.md` — istruzioni AI
- `LICENSE`, `README.md` — metadati progetto
- `*.code-workspace` — workspace VS Code
- `bashscripts/` — script bash/python
- `docs/` — documentazione progetto
- `laravel/` — applicazione Laravel
- `public_html/` — web root

## Mappa Destinazioni

| Tipo File | Dove va |
|-----------|---------|
| Script `.sh`, `.py` | `bashscripts/` |
| GitHub discussion drafts/updates | `docs/discussions/` |
| GitHub issue summaries / reports | `docs/github/` |
| Report di verifica GitHub | `docs/github/` |
| PRD principale | `docs/PRD.md` |
| PRD secondari / loop | `docs/{nome}-prd.md` |
| Changelog / project updates | `docs/` |
| Report implementazione modulo | `laravel/Modules/{Module}/docs/` |
| Marketing / brainstorming content | `docs/` |

## Anti-Pattern

```bash
# ❌ SBAGLIATO - file nella root
/var/www/_bases/base_laravelpizza/discussion_226_update.md
/var/www/_bases/base_laravelpizza/PRD.md
/var/www/_bases/base_laravelpizza/update_discussions.sh
/var/www/_bases/base_laravelpizza/final_verification_report.md
```

```bash
# ✅ CORRETTO
/var/www/_bases/base_laravelpizza/docs/discussions/226-update.md
/var/www/_bases/base_laravelpizza/docs/ralph-loop-prd.md
/var/www/_bases/base_laravelpizza/bashscripts/update-discussions.sh
/var/www/_bases/base_laravelpizza/docs/github/final-verification-report.md
```

## Verifica

```bash
# La root deve avere solo directory e file autorizzati
ls /var/www/_bases/base_laravelpizza/ | grep -v -E "^(AGENTS|CLAUDE|GEMINI|IFLOW|LICENSE|README|.*\.code-workspace|bashscripts|docs|laravel|public_html|\.git|\.cursor|\.windsurf|gitmodules|index\.js|package|error\.log|event-detail|_base)$"
# Risultato atteso: nessun output (niente file non autorizzati)
```
