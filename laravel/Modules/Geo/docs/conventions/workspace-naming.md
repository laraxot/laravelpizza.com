# Workspace Naming Convention

> **Regola di Naming per file `.code-workspace`**
> 
> **Status:** Active
> **Last Updated:** 2026-03-13
> **Owner:** Development Team

---

## Regola Generale

Ogni modulo o tema deve avere **UNICO** file `.code-workspace` con il nome del modulo stesso, preceduto da underscore.

### Formato

```
_{module-name}.code-workspace
```

Dove `{module-name}` è il nome del modulo/tema in lowercase.

---

## Esempi

### ✅ Corretti

| Modulo/Tema | File Workspace | Path |
|-------------|----------------|------|
| Xot | `_xot.code-workspace` | `laravel/Modules/Xot/_xot.code-workspace` |
| Activity | `_activity.code-workspace` | `laravel/Modules/Activity/_activity.code-workspace` |
| User | `_user.code-workspace` | `laravel/Modules/User/_user.code-workspace` |
| Theme One | `_one.code-workspace` | `laravel/Themes/One/_one.code-workspace` |
| Theme Zero | `_theme_zero.code-workspace` | `laravel/Themes/Zero/_theme_zero.code-workspace` |

### ❌ Sbagliati

| File Trovato | Path | Problema | Correzione |
|--------------|------|----------|------------|
| `_activity.code-workspace` | `laravel/Modules/Xot/` | Activity ≠ Xot | Rimuovere |
| `_user.code-workspace` | `laravel/Modules/Job/` | User ≠ Job | Rimuovere |
| `_activity.code-workspace` | `laravel/Modules/Job/` | Activity ≠ Job | Rimuovere |
| `_blog.code-workspace` | `laravel/Modules/Rating/` | Blog ≠ Rating | Rimuovere |

---

## Principi

### 1. One Module, One Workspace

Ogni modulo deve avere **solo il proprio** workspace file. Non workspace di altri moduli.

**Perché:**
- Evita confusione su quale workspace usare
- Mantiene il contesto chiaro per VS Code
- Previene conflitti di configurazione

### 2. Naming Coerente

Il nome del file deve corrispondere esattamente al nome del modulo:

```
Modulo: Activity → File: _activity.code-workspace
Modulo: User     → File: _user.code-workspace
Modulo: Xot      → File: _xot.code-workspace
```

### 3. Posizione

Il file workspace va nella **root del modulo**:

```
laravel/Modules/{ModuleName}/
├── _{module-name}.code-workspace  ✅ CORRETTO
├── app/
├── docs/
├── src/
└── ...
```

---

## Eccezioni

### Root Project Workspaces

I workspace nella root del progetto possono avere naming diverso:

```
/var/www/_bases/base_ptvx_fila5/
├── _ptvx_fila5.code-workspace          ✅ Project workspace
├── _base_ptvx_fila5_mono.code-workspace ✅ Mono-repo workspace
└── laravel/
```

### Multi-Module Workspaces (Sconsigliato)

In alcuni casi, si possono creare workspace che includono più moduli, ma:
- Devono essere nella root, non nei moduli
- Devono avere nome descrittivo del contesto

---

## Cleanup

### Rimuovere Workspace Errati

Se trovi workspace file errati in un modulo:

```bash
# Esempio: rimuovere _activity.code-workspace da Xot
cd laravel/Modules/Xot
rm -f _activity.code-workspace
```

### Verificare Conformità

Per verificare se un modulo ha solo il workspace corretto:

```bash
cd laravel/Modules/{ModuleName}
ls -la _*.code-workspace

# Dovresti vedere SOLO: _{module-name}.code-workspace
```

---

## Configurazione Workspace Tipica

```json
{
  "folders": [
    {
      "path": "."
    }
  ],
  "settings": {
    "editor.formatOnSave": true,
    "php-cs-fixer.onsave": true,
    "php-cs-fixer.formatHtml": true,
    "php-cs-fixer.executable": "php-cs-fixer",
    "php-cs-fixer.executablePath": "",
    "php-cs-fixer.executablePathWindows": "php-cs-fixer.bat",
    "vscode-php-cs-fixer.allowRisky": true,
    "phpmd.enabled": false,
    "phpmd.validate.rulesets": "cleancode,codesize,controversial,design,naming,unusedcode",
    "phpmd.SuppressWarnings": true,
    "phpmd.verbose": false,
    "editor.defaultFormatter": "junstyle.php-cs-fixer",
    "[php]": {
      "editor.defaultFormatter": "junstyle.php-cs-fixer"
    },
    "editor.tokenColorCustomizations": {
      "semanticHighlighting": true
    },
    "vscode-php-cs-fixer.useCache": true,
    "git.ignoreLimitWarning": true,
    "files.eol": "\n",
    "editor.wordWrap": "wordWrapColumn",
    "editor.wordWrapColumn": 120,
    "git.autofetch": "all"
  }
}
```

---

## Riferimenti

### Documenti Correlati

- [Project Structure](../../docs/project/structure.md)
- [Coding Standards](../../docs/project/coding-standards.md)
- [AGENTS.md](../../AGENTS.md)

### VS Code Documentation

- [VS Code Workspaces](https://code.visualstudio.com/docs/editor/workspaces)
- [Workspace Settings](https://code.visualstudio.com/docs/getstarted/settings)

---

## Violazioni Note

| Modulo | Violazione | Status | Fix Date |
|--------|------------|--------|----------|
| Xot | `_activity.code-workspace` presente | ❌ Da rimuovere | - |
| Job | `_activity.code-workspace` presente | ❌ Da rimuovere | - |
| Job | `_user.code-workspace` presente | ❌ Da rimuovere | - |
| Rating | `_blog.code-workspace` presente | ❌ Da rimuovere | - |

---

## Checklist Conformità

Per ogni modulo:

- [ ] Presente SOLO `_{module-name}.code-workspace`
- [ ] Rimossi eventuali workspace di altri moduli
- [ ] Nome del file corrisponde al nome del modulo (lowercase)
- [ ] File nella root del modulo
- [ ] Configurazione workspace valida

---

*Ultimo aggiornamento: 2026-03-13*
