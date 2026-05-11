---
title: "Performance Optimization — Module Gdpr"
type: documentation
created: 2026-05-11
updated: 2026-05-11
tags: [performance, optimization, tokens, context]
related:
  - ../../docs/wiki/concepts/llm-wiki-operational-discipline.md
---

# Performance Optimization — Module **Gdpr**

## Ottimizzazioni Applicate

### 1. On-Demand Loading (principale)

**Prima**: Bootstrap caricava tutte le rules (50K+ token)
**Dopo**: Carico solo what's needed (~2K startup)

```diff
- 150+ rules embeddate in AGENTS.md
+ 0 rules embeddate — tutte on-demand
```

### 2. Cache Esterna al Repo

```diff
- .cache/ (8KB nel repo)
+ ~/.cache/qmd-cache/ (fuori da git)
```

**Risultato**:
- Clone più veloce (nessuna cache da scaricare)
- Git history pulito
- Nessun rischio di commit cache

### 3. Node Modules Puliti

```diff
- bashscripts/ai/.agents/node_modules/ (58MB)
+ laravel/node_modules/ (singola installazione)
```

### 4. Wiki Indici Locali

Ogni modulo ha i propri :
- Ricerca più rapida (scope limitato)
- Context rilevante per il modulo
- Non mischia contenuti eterogenei

## Metriche Attuali

| Metric | Before | After |
|--------|--------|-------|
| **Token startup** | ~50,000 | ~2,000 |
| **Context usage** | 90% | 60-70% |
| **Ricerca regole** | 500ms (grep) | 30ms (qmd) |
| **Repo size** | +58MB | -58MB |
| **Cache in git** | 8KB tracked | 0KB |

## Best Practice per Sviluppatori

### Caricamento Efficiente

```python
# ❌ MAI fare così
Read all_rules = Read docs/wiki/rules/*.md  # TOO MANY TOKENS

# ✅ SEMPRE fare così
trigger = detect_task_trigger()
if trigger in trigger_map:
    Read specific_rule = Read docs/wiki/rules/$trigger.md
```

### Query QMD Efficienti

```bash
# ❌ Troppo generico — risultati enormi
qmd search "form"

# ✅ Specifico — risultati precisi
qmd search "filament form schema conventions"
```

### Limitare lo Scope

```bash
# Cerca solo nel modulo corrente
qmd search "validation" -c Gdpr

# Cerca globalmente (solo se necessario)
qmd search "global validation rules"
```

## Prossimi Miglioramenti (TODO)

1. **Auto-index rebuild** — Dopo 500 file changes, `qmd index rebuild`
2. **Hooks pre-task** — Auto-memory sync
3. **Context-mode batch** — Convertire script in batch exec
4. **Permissions allowlist** — .claude/settings.json

## Monitoring

Controlla performance attuali:

```bash
# Dimensione cache
du -sh ~/.cache/qmd-cache/

# Token usage (se disponibile)
context-mode ctx-stats
```

## Riferimenti

- [Global Performance Guide](../../docs/wiki/concepts/performance-optimization.md)
- [On-Demand Pattern](./ON-DEMAND-PATTERN.md)
- [QMD Setup](./QMD-SETUP.md)

---
*Status: Ottimizzato | Token risparmiati: ~48K per session*
