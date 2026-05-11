# Claude Code Laraxot Rules Path Scoping

## Decisione

Le regole Claude Code su Laraxot, XotBase, Filament, migrazioni e traduzioni devono essere concise e path-scoped.

La documentazione owner resta nei `docs/` dei moduli; `.claude/rules/` deve solo attivare il promemoria quando Claude Code apre file pertinenti.

## Fondamento Claude Code

Claude Code carica le rules in `.claude/rules/*.md` senza `paths` ad ogni sessione. Le rules con frontmatter `paths` si applicano solo ai file che matchano i glob dichiarati.

Per il core Laraxot questo evita che regole Filament/XotBase/migration entrino nel contesto durante task puramente frontend, docs o DevOps.

## Regola Operativa

1. Una rule per argomento.
2. Frontmatter `paths` obbligatorio per regole di codice.
3. Corpo breve: sintesi, anti-pattern, link al documento owner.
4. Nessuna duplicazione lunga di pagine wiki o prompt BMAD.

## Esempi Di Scope

```yaml
paths:
  - "laravel/Modules/**/*.php"
```

```yaml
paths:
  - "laravel/Modules/**/database/migrations/**/*.php"
  - "laravel/Modules/**/Models/**/*.php"
```

```yaml
paths:
  - "laravel/Modules/**/lang/**/*.php"
  - "laravel/Themes/**/lang/**/*.php"
```

## Rule Coinvolte

- `filament-template-as-dress.md`
- `filament5-infolist-wizard-summary.md`
- `filament5-schemas-section.md`
- `one-migration-per-model.md`
- `translation-5-elements.md`
- `xotbase-blade-icons-auto-registration.md`
- `xotbasepage-inheritance.md`
