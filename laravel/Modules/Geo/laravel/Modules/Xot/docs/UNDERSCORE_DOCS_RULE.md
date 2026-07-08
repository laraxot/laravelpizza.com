# Underscore Directories Rule - No _docs/

## Regola Fondamentale

**LE CARTELLE CON SOTTOLINEATURA INIZIALE (_) SONO TEMPORANEE E NON DEVONO ESSERE TRACCIATE**

## Pattern da Evitare

```
❌ _docs/              # Cartella documentazione temporanea
❌ _temp/              # Cartella temporanea
❌ _backup/            # Cartella backup
❌ _old/               # Cartella vecchia versione
❌ _test/              # Cartella test temporanei
```

## Struttura Corretta

```
Modules/{Name}/
├── docs/              # ✅ Documentazione ufficiale
├── tests/             # ✅ Test ufficiali
├── .gitignore         # ✅ Contiene _docs/
└── ...
```

## Rationale

1. **DRY**: Non duplicare cartelle
2. **KISS**: Struttura chiara e semplice
3. **Git**: Le cartelle _ dovrebbero essere ignorate
4. **Convention**: Sottolineatura indica temporaneo/privato

## .gitignore Standard

Ogni modulo deve avere:

```gitignore
# Temporary directories
_docs/
_temp/
_backup/
_old/

# Build artifacts
build/
dist/

# IDE
.idea/
.vscode/

# OS
.DS_Store
Thumbs.db
```

## Caso Studio: _docs/ Removal

**Problema**: Trovate 12 cartelle `_docs/` con file temporanei

**Azione**:
```bash
# 1. Aggiungi a .gitignore
find laravel/Modules -name ".gitignore" -exec sh -c 'echo "_docs/" >> "$1"' _ {} \;

# 2. Rimuovi cartelle
find laravel/Modules -type d -name "_docs" -exec rm -rf {} \;

# 3. Verifica
find laravel -type d -name "_docs"
# Should return nothing
```

**Risultato**: Struttura pulita, _docs ignorata in futuro

## Verifica

```bash
# Trova cartelle _ temporanee
find laravel/Modules -type d -name "_*"

# Verifica .gitignore
find laravel/Modules -name ".gitignore" -exec grep "_docs/" {} \;
```

## Related

- GitHub Issue: #12
- GitHub Discussion: #13
- Skill: `.opencode/skills/underscore-directories/SKILL.md`
- Docs: `Modules/Xot/docs/DIRECTORY_STRUCTURE_RULES.md`

## Reference

- Git Convention: Underscore prefix = temporary
- Laravel Convention: Use `docs/`, not `_docs/`
- Clean Code: No temporary files in repository
