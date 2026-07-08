# AGENTS Project Rules

Regole generali del progetto.

## Documentation Rules

### Filename Convention
- **Markdown filenames** must be semantic, stable, and strictly lowercase
- **NEVER** append dates or timestamps to `.md` filenames
- Dates belong inside the document content for versioning

### PRD Coverage
- Every module and every theme must have a baseline `prd.json` inside its own `docs/` directory
- When scope changes, update `docs/prd.json` before or together with implementation

### Product Doc Suite
- Every module and theme must keep:
  - `product-roadmap.md`
  - `product-launch-plan.md`
  - `product-strategy.md`
  - `user-research.md`
  - `sprint-planning-meeting.md`

### Shared Docs Root
- `laravel/project_docs/` is forbidden
- Shared project docs live under `docs/project/`
- Module/theme docs remain local in each `docs/` directory

---

## JSON Page File Naming

### CRITICAL Rule

All JSON files in `config/local/*/database/content/pages/` MUST follow:

1. **Filename MUST match slug exactly**:
   - File `about.json` MUST have `"slug": "about"`
   - File `predicts.json` MUST have `"slug": "predicts"`

2. **Empty files forbidden**:
   - Never create empty JSON files
   - Always include at least: `id`, `title`, `slug`

3. **No legacy/placeholder files**

### Validation

```bash
# Check all JSON files match their slugs
for f in config/local/*/database/content/pages/*.json; do
    slug=$(grep -m1 '"slug"' "$f" | sed 's/.*"slug": *"\([^"]*\)".*/\1/')
    filename=$(basename "$f" .json)
    if [ "$slug" != "$filename" ]; then
        echo "MISMATCH: $f has slug '$slug'"
    fi
done
```

---

## Module SVG Rules

- Module SVG icons live in `Modules/<ModuleName>/resources/svg`
- The blade icon name must use the module prefix + filename
- Example: `predict-bottlecap` for `Modules/Predict/resources/svg/bottlecap.svg`

---

## Filament Icon Rule

- Prefer the Filament way for icons
- First choice: `<x-filament::icon ...>` or `<x-filament::icon-button ...>`
- Use `@svg(...)` only when Filament icon is not the right fit

---

## GitHub Tracking Rule

- GitHub Issues and Discussions must be written in Italian
- Include percentages for progress, risk, coverage when appropriate
- Do NOT mention competitor names or URLs in Issues/Discussions

---

## Git Completion Rule

- When task is complete and verified: `git commit` e `git push`
- Unless user explicitly asks to stop earlier

---

## Anti-Regola: File Protection

**MAI** cancellare o modificare file senza:

1. Elencare TUTTI i file nella directory (`ls -la`)
2. Leggere il contenuto di OGNI file rilevante
3. Verificare se il file è usato nel codice (`grep`)
4. Chiedere all'utente se non sei sicuro
5. Fare backup prima di qualsiasi operazione

---

## 🔗 Link

- [Indice AGENTS](./agents-split-index.md)
- [regole-critiche.md](./regole-critiche.md) - Regole critiche
- [AGENTS.md originale](../../AGENTS.md)
- [Index principale](./index.md)
