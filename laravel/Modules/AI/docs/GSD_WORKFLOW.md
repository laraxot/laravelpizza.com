# GSD Workflow — Modulo AI

> Workflow spec-driven per lo sviluppo del modulo AI usando GSD e BMAD.

## Contesto

Il modulo AI gestisce la generazione predizioni con AI:
- **Provider**: Ollama (locale), OpenRouter (cloud)
- **GPU**: AMD GPU con ROCm in WSL
- **Features**: Seeders AI, generazione payload

## Workflow GSD per il Modulo AI

### 1. Prima di iniziare

```bash
# Verifica sempre lo stato corrente
/gsd-progress

# Leggi il PROJECT.md se esiste
cat .planning/PROJECT.md
```

### 2. Per nuove feature

```bash
# 1. Discuss fase
/gsd-discuss-phase {N}

# 2. Plan fase
/gsd-plan-phase {N}

# 3. Execute
/gsd-execute-phase {N}

# 4. Verify
/gsd-verify-work {N}
```

### 3. Per debugging Ollama

```bash
# Verifica GPU AMD
rocm-smi

# Verifica Ollama
ollama list

# Test modello
ollama run llama3.2 "Hello"
```

## Regole Specifiche Modulo AI

### GPU Readiness Check

1. **Host Windows**: Verifica driver AMD + WSL integration
2. **Guest Linux**: Verifica ROCm libraries (`/opt/rocm`)
3. **Ollama**: Verifica che funzioni con GPU

```bash
# Non fare churn cieco - verifica prima
rocm-smi  # Se funziona, ROCm è OK
ollama ps  # Se mostra GPU, è pronto
```

### Model Configuration

```php
// Usa configurazione da config/ non hardcoded
config('ai.providers.openrouter.key')
```

## File Chiave

| File | Scopo |
|------|-------|
| Configurazione | `config/ai.php` |
| Providers | `app/Providers/*` |
| Seeders | `Database/Seeders/` |

## Riferimenti

- [GSD Workflow progetto](../../../docs/project/gsd-and-bmad-workflow.md)
- [Local AI Runtime Governance](../../../docs/project/local-ai-runtime-governance.md)
