# 📚 Project Rules Index

> **Indice centrale per tutte le regole del progetto**
> **Aggiornato**: 2026-04-01
> **Versione**: 1.0

---

## 🎯 Panoramica

Questo documento fornisce un **indice centrale** per tutte le regole del progetto, organizzato per categoria.

**Convenzione**: Usare sempre questo indice per trovare documentazione esistente prima di creare nuovi file.

---

## 📋 Categorie

### 1. **Laravel & PHP** 🐘

| Regola | Path | Scopo |
|--------|------|-------|
| **Accessor Delegation Pattern** | [`accessor-delegation-pattern.md`](accessor-delegation-pattern.md) | **Metodo puro VICINO all'accessor** |
| PHPStan Code Quality | [`phpstan-code-quality.md`](phpstan-code-quality.md) | PHPStan Level 10 approach |
| PHPMD PHAR Policy | [`phpmd-phar-policy.md`](phpmd-phar-policy.md) | Usare PHPMD come .phar, non Composer |
| Laraxot Rules | [`laraxot-rules.md`](laraxot-rules.md) | Regole specifiche Laraxot |

### 2. **GitHub Actions** ⚙️

| Regola | Path | Scopo |
|--------|------|-------|
| GitHub Actions Node.js | [`github-actions-nodejs.md`](github-actions-nodejs.md) | Usare Node.js 24 per GitHub Actions |
| GitHub Actions Debugging | [`github-actions-debugging.md`](github-actions-debugging.md) | Debug workflow GitHub Actions |

### 3. **Testing** 🧪

| Regola | Path | Scopo |
|--------|------|-------|
| Testing DB Safety | [`testing-db-safety-rule.md`](testing-db-safety-rule.md) | Mai usare `migrate:refresh`, `db:wipe` |

### 4. **Documentation** 📖

| Regola | Path | Scopo |
|--------|------|-------|
| Documentation Philosophy | [`documentation-philosophy.md`](documentation-philosophy.md) | Filosofia documentazione |

### 5. **Filament** 🎨

| Regola | Path | Scopo |
|--------|------|-------|
| Filament Class Extension | [`filament-class-extension-rules.md`](filament-class-extension-rules.md) | Estendere classi Filament |

### 6. **Architecture** 🏗️

| Regola | Path | Scopo |
|--------|------|-------|
| Parental STI Pattern | [`parental-sti-pattern-rules.md`](parental-sti-pattern-rules.md) | Pattern STI con parental filtering |

### 7. **MCP** 🔌

| Regola | Path | Scopo |
|--------|------|-------|
| MCP Validation | [`mcp-validation.md`](mcp-validation.md) | Validazione MCP servers |

### 8. **Scripts** 🛠️

| Regola | Path | Scopo |
|--------|------|-------|
| Scripts Location | [`scripts-location.md`](scripts-location.md) | Script .sh in `bashscripts/` |

---

## 🔗 Indici Correlati

- **Module Docs Index**: `laravel/Modules/Sigma/docs/README.md`
- **Theme Docs Index**: `laravel/Themes/Zero/docs/00-index.md`
- **Project Docs**: `docs/project/README.md`

---

## 📿 Il Mantra

```
Prima di creare regole, ripeti:

"Controllo l'indice, non duplico"
"Uso kebab-case, non CamelCase"
"Aggiorno esistente, creo solo se necessario"

Respira. Documenta. Trova sempre.
```

---

*Documento creato: 2026-04-01*
*Ultimo aggiornamento: 2026-04-01*
*Usa SEMPRE questo indice prima di creare nuovi file .md*
