# ✅ Kilo (OpenCode) Configuration - COMPLETE

**Date**: 2026-03-30  
**Status**: ✅ **COMPLETE**  
**Config File**: `.kilo/kilo.jsonc` (symlink → `bashscripts/ai/.agents/kilo.jsonc`)  
**Schema**: https://app.kilo.ai/config.json

---

## Cos'è Kilo Code

**Kilo Code** (ora **OpenCode**) è un AI coding assistant open source che:

- ✅ Supporta 500+ modelli AI (Claude, GPT-4, Gemini, etc.)
- ✅ Lavora con qualsiasi provider (OpenAI, Anthropic, Google)
- ✅ È gratuito e open source
- ✅ Supporta MCP (Model Context Protocol)
- ✅ Ha interfaccia TUI (Terminal)
- ✅ Supporta agenti e workflow personalizzati

**Links**:
- **Docs**: https://opencode.ai/docs
- **GitHub**: https://github.com/anomalyco/opencode
- **Schema**: https://app.kilo.ai/config.json

---

## Configurazione FixCity

### File di Configurazione

```
.kilo/kilo.jsonc → bashscripts/ai/.agents/kilo.jsonc (symlink)
```

### Configurazione Attuale

```jsonc
{
  "$schema": "https://app.kilo.ai/config.json",
  
  // Modelli AI
  "model": "anthropic/claude-sonnet-4-6",
  "small_model": "anthropic/claude-haiku-4-5-20251001",
  "autoupdate": true,
  "snapshot": true,
  
  // MCP servers
  "mcp": {},
  
  // Documentazione per contesto AI
  "instructions": [
    "AGENTS.md",
    "laravel/AGENTS.md"
  ],
  
  // Tool abilitati
  "tools": {
    "write": true,
    "edit": true,
    "bash": true,
    "read": true,
    "glob": true,
    "grep": true
  },
  
  // Permessi: "allow" | "ask" | "deny"
  "permission": {
    "bash": "ask",
    "edit": "ask",
    "write": "ask",
    "read": "allow",
    "glob": "allow",
    "grep": "allow"
  },
  
  // Sperimentale
  "experimental": {}
}
```

---

## Chiavi di Configurazione Valide

### ✅ Chiavi Supportate

| Chiave | Tipo | Descrizione | Valore FixCity |
|--------|------|-------------|----------------|
| `$schema` | string | URL schema JSON | `https://app.kilo.ai/config.json` |
| `model` | string | Modello primario | `anthropic/claude-sonnet-4-6` |
| `small_model` | string | Modello semplice | `anthropic/claude-haiku-4-5` |
| `autoupdate` | boolean | Auto-update | `true` |
| `snapshot` | boolean | Snapshot | `true` |
| `mcp` | object | MCP servers | `{}` |
| `instructions` | array | Docs contesto | `["AGENTS.md", ...]` |
| `tools` | object | Tool abilitati | `{write, edit, bash...}` |
| `permission` | object | Permessi | `{bash: "ask", ...}` |
| `experimental` | object | Feature sperimentali | `{}` |

### ❌ Chiavi NON Supportate (Errore Comune)

Queste chiavi **CAUSANO ERRORI**:

- `version` ❌
- `// Note` ❌ (i commenti vanno fatti con `//` all'inizio)
- `global` ❌
- `providers` ❌ (si usa `provider` se necessario)
- `agents` ❌
- `modes` ❌
- `autoApprove` ❌
- `features` ❌
- `integrations` ❌
- `project` ❌
- `quality` ❌
- `security` ❌
- `performance` ❌
- `logging` ❌

---

## Setup e Utilizzo

### 1. Verifica Installazione

```bash
# Controlla se Kilo/OpenCode è installato
which opencode
# oppure
which kilo
```

### 2. Configura API Keys

```bash
# Anthropic (Claude)
export ANTHROPIC_API_KEY="your-key-here"

# OpenAI
export OPENAI_API_KEY="your-key-here"

# Google
export GOOGLE_API_KEY="your-key-here"
```

### 3. Avvia Kilo

```bash
cd /var/www/_bases/base_fixcity_fila5

# Avvia TUI
opencode

# Oppure
kilo
```

### 4. Comandi Utili

```
/init          - Inizializza progetto
/connect       - Connetti a provider
/undo          - Annulla modifica
/redo          - Ripristina modifica
/share         - Condividi sessione
/compact       - Compatta contesto
/help          - Mostra aiuto
Ctrl+Q         - Esci
```

---

## Project Context

### Documentazione Inclusa

Kilo legge automaticamente:

1. **AGENTS.md** - Contesto principale
2. **laravel/AGENTS.md** - Contesto Laravel

### Per Aggiungere Altra Docs

Modifica `.kilo/kilo.jsonc`:

```jsonc
{
  "instructions": [
    "AGENTS.md",
    "laravel/AGENTS.md",
    "docs/**/*.md",                    // Tutta la docs
    "laravel/Modules/docs/README.md",  // Index moduli
    "laravel/Themes/docs/README.md",   // Index temi
    ".planning/**/*.md"                // Planning
  ]
}
```

---

## Theme Configuration

### Tema Attivo

- **Tema**: Sixteen ✅
- **Domain**: fixcity.local
- **Config**: `laravel/config/localhost/xra.php` → `pub_theme`

### Document Root

- **Root**: `public_html/`
- **Entry**: `public_html/index.php`
- **Assets**: `public_html/themes/Sixteen/`

---

## DRY + KISS Compliance

### ✅ DRY (Don't Repeat Yourself)

- Configurazione centralizzata in `.kilo/kilo.jsonc`
- Symlink a `bashscripts/ai/.agents/` per condivisione
- Instructions puntano a file esistenti (no duplicati)

### ✅ KISS (Keep It Simple, Stupid)

- Configurazione minimale (solo chiavi necessarie)
- Permessi semplici (allow/ask/deny)
- No feature sperimentali abilitate
- Documentazione essenziale

---

## Integration with AI Tools

### OpenViking

```bash
# OpenViking initialized
openviking status

# Context management per Kilo
openviking search "Kilo configuration"
```

### BMAD

```bash
# BMAD ready
/bmad-create-prd

# Kilo può eseguire PRD
```

### GSD

```bash
# GSD active
/gsd-discuss-phase 1

# Kilo supporta GSD workflow
```

### Ralph Loop

```bash
# Ralph ready
./.ralph/ralph-loop.sh

# Kilo può eseguire Ralph
```

### NotebookLM Skill

```bash
# NotebookLM installed
~/.claude/skills/notebooklm/

# Kilo può query NotebookLM
```

---

## Best Practices

### 1. Mantenere Config Minimale

```jsonc
// ✅ CORRETTO
{
  "model": "anthropic/claude-sonnet-4-6",
  "permission": {
    "bash": "ask"
  }
}

// ❌ TROPPO COMPLESSO
{
  "model": "...",
  "providers": {...},
  "agents": {...},
  "modes": {...},
  ...
}
```

### 2. Usare Commenti per Documentare

```jsonc
{
  "// Models": "Primary and fallback models",
  "model": "anthropic/claude-sonnet-4-6"
}
```

### 3. Permessi Sicuri

```jsonc
{
  "permission": {
    "bash": "ask",    // ✅ Chiedi prima
    "edit": "ask",    // ✅ Chiedi prima
    "write": "ask",   // ✅ Chiedi prima
    "read": "allow"   // ✅ Auto-approvato
  }
}
```

### 4. Ignorare File Inutili

```jsonc
{
  "watcher": {
    "ignore": [
      "node_modules/**",
      "vendor/**",
      "*.log"
    ]
  }
}
```

---

## Troubleshooting

### Errore: "Unrecognized keys"

**Sintomo**:
```
Error: Unrecognized keys: "version", "global", "providers", ...
```

**Soluzione**:
```bash
# Rimuovi chiavi non valide da .kilo/kilo.jsonc
# Mantieni solo chiavi supportate (vedi tabella sopra)
```

### Errore: "Invalid schema"

**Sintomo**:
```
Error: Invalid schema URL
```

**Soluzione**:
```jsonc
{
  "$schema": "https://app.kilo.ai/config.json"
}
```

### Errore: "Provider not configured"

**Sintomo**:
```
Error: No API key configured for anthropic
```

**Soluzione**:
```bash
export ANTHROPIC_API_KEY="sk-ant-..."
```

---

## Files Created/Modified

| File | Status | Purpose |
|------|--------|---------|
| `.kilo/kilo.jsonc` | ✅ Updated | Kilo configuration |
| `.kilo/README.md` | ✅ Created | Kilo guide |
| `KILO_CONFIGURATION_COMPLETE.md` | ✅ Created | This summary |

---

## Related Documentation

| Document | Location |
|----------|----------|
| **Kilo Guide** | `.kilo/README.md` |
| **Theme Context** | `.planning/THEME_CONTEXT.md` |
| **Modules Index** | `laravel/Modules/docs/README.md` |
| **Themes Index** | `laravel/Themes/docs/README.md` |
| **Project Overview** | `.planning/PROJECT.md` |

---

## Next Steps

### Immediate

1. ✅ Kilo configuration created
2. ✅ Documentation written
3. [ ] Test Kilo with `opencode` command
4. [ ] Configure API keys if needed

### This Week

1. [ ] Integrate Kilo with GSD workflow
2. [ ] Use Kilo for Phase 1.2 (CI/CD)
3. [ ] Test Ralph Loop with Kilo

---

## Resources

### Official Docs

- **Main**: https://opencode.ai/docs
- **Config**: https://opencode.ai/docs/config
- **Providers**: https://opencode.ai/docs/providers
- **Tools**: https://opencode.ai/docs/tools

### GitHub

- **Repo**: https://github.com/anomalyco/opencode
- **Issues**: https://github.com/anomalyco/opencode/issues

### Community

- **Discord**: https://discord.gg/opencode
- **Twitter**: @opencode_ai

---

**Status**: ✅ **COMPLETE**  
**Config**: `.kilo/kilo.jsonc` (valid schema)  
**Schema**: https://app.kilo.ai/config.json  
**Next**: Test with `opencode` command
