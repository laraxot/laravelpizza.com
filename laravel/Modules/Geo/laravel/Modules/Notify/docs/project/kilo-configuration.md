# Kilo Configuration Guide

**File**: `.kilo/kilo.jsonc`  
**Created**: 2026-03-30  
**Version**: 1.0.0

## Overview

Kilo è un'estensione VS Code per AI-assisted coding con CLI. La configurazione `.kilo/kilo.jsonc` definisce:

- Provider AI e modelli
- Agent specializzati (Architect, Coder, Debugger, etc.)
- Mode operative (Plan, Code, Debug, Review, Test)
- Integrazioni (BMAD, GSD, Ralph, OpenViking, NotebookLM)
- Quality gates (PHPStan, Pint, Pest)

## Configurazione FixCity

### Provider AI Configurati

| Provider | Modelli | Use Case |
|----------|---------|----------|
| **Anthropic** | Claude Sonnet 4, Opus 4 | Coding quotidiano, architettura complessa |
| **Google** | Gemini 2.5 Pro | Codebase grandi (1M context) |
| **Ollama** | Qwen2.5-Coder:32b, Llama3.1:8b | Test locali, privacy |
| **DeepSeek** | DeepSeek Chat | Budget-conscious work |

### Agent Specializzati

#### 1. Architect
- **Modello**: Claude Opus 4
- **Uso**: Pianificazione BMAD, architettura
- **Temperature**: 0.5 (più analitico)
- **Tools**: file-read, file-write, search, terminal

#### 2. Coder
- **Modello**: Claude Sonnet 4
- **Uso**: Implementazione quotidiana Laravel/Filament
- **Temperature**: 0.7 (bilanciato)
- **System Prompt**: "Follow Laraxot patterns: XotBase, Actions over Services, PHPStan L10"

#### 3. Debugger
- **Modello**: Claude Sonnet 4
- **Uso**: Troubleshooting sistematico
- **Temperature**: 0.3 (più conservativo)
- **Tools**: Include Ray per debugging

#### 4. Reviewer
- **Modello**: Claude Opus 4
- **Uso**: Code review, quality check
- **Temperature**: 0.2 (molto critico)
- **Check**: Laraxot compliance, PHPStan, security

#### 5. Tester
- **Modello**: Claude Sonnet 4
- **Uso**: Scrittura test Pest PHP
- **Temperature**: 0.5
- **Target**: 90%+ coverage

### Mode Operative

| Mode | Agent | Modello | Descrizione |
|------|-------|---------|-------------|
| **plan** | Architect | Opus 4 | Pianificazione BMAD |
| **code** | Coder | Sonnet 4 | Implementazione |
| **debug** | Debugger | Sonnet 4 | Troubleshooting |
| **review** | Reviewer | Opus 4 | Code review |
| **test** | Tester | Sonnet 4 | Test creation |

## Integrazioni

### BMAD Integration
```jsonc
"bmad": {
  "enabled": true,
  "prdsDirectory": "_bmad/bmm/2-plan",
  "architectureDirectory": "_bmad/bmm/3-solutioning",
  "storiesDirectory": "_bmad/bmm/4-stories"
}
```

### GSD Integration
```jsonc
"gsd": {
  "enabled": true,
  "planningDirectory": ".planning",
  "phasesDirectory": ".gsd/phases"
}
```

### Ralph Loop Integration
```jsonc
"ralph": {
  "enabled": true,
  "directory": ".ralph",
  "maxIterations": 20,
  "autoApprove": false
}
```

### OpenViking Integration
```jsonc
"openviking": {
  "enabled": true,
  "command": "openviking",
  "autoIndex": true,
  "indexDirectories": ["docs/", "laravel/Modules/*/docs/", "laravel/Themes/*/docs/"]
}
```

### NotebookLM Integration
```jsonc
"notebooklm": {
  "enabled": true,
  "scriptPath": "~/.claude/skills/notebooklm/scripts/run.py",
  "autoFollowUp": true,
  "synthesizeAnswers": true
}
```

## Quality Gates

### PHPStan Level 10
```jsonc
"phpstan": {
  "enabled": true,
  "level": 10,
  "memoryLimit": "2G",
  "command": "vendor/bin/phpstan analyse --level=10 --memory-limit=2G",
  "autoRun": true,
  "blockOnErrors": true
}
```

### Laravel Pint
```jsonc
"pint": {
  "enabled": true,
  "command": "vendor/bin/pint",
  "autoRun": true,
  "autoFix": true
}
```

### Pest PHP
```jsonc
"pest": {
  "enabled": true,
  "command": "vendor/bin/pest",
  "coverageTarget": 90,
  "autoRun": true
}
```

### Frontend Quality
```jsonc
"frontend": {
  "enabled": true,
  "command": "npm run quality",
  "tools": ["biome", "eslint", "htmlhint"],
  "autoRun": true
}
```

## Auto-Approve Commands

### Safe Commands (Sempre approvati)
```bash
git status, git diff, git log
ls, find, grep, cat, head, tail
php artisan --version, php artisan route:list
composer --version, npm --version, node --version
```

### Test Commands
```bash
php artisan test, vendor/bin/pest
vendor/bin/phpunit, npm run test
vendor/bin/phpstan analyse
```

### Quality Commands
```bash
vendor/bin/pint, vendor/bin/phpmd
npm run lint, npm run format
```

## Project Configuration

### Tipo Progetto
```jsonc
"project": {
  "type": "laravel",
  "framework": "laravel-12",
  "frontend": "filament-v5",
  "architecture": "modular-monolith",
  "activeTheme": "Sixteen"
}
```

### Pattern Architetturali
```jsonc
"patterns": [
  "Actions over Services",
  "XotBase extension",
  "No Controllers (Volt+Folio+Filament)",
  "PHPStan Level 10",
  "DRY + KISS",
  "container0/slug0 CMS pattern"
]
```

### Directory Importanti
```jsonc
"directories": {
  "modules": "laravel/Modules/",
  "themes": "laravel/Themes/",
  "documentRoot": "public_html/",
  "config": "laravel/config/local/fixcity/xra.php"
}
```

## Setup

### 1. Environment Variables

Crea `.env` o aggiungi al tuo shell:

```bash
# Kilo API Keys (MAI committare!)
export KILO_ANTHROPIC_API_KEY="sk-ant-..."
export KILO_GOOGLE_API_KEY="AIza..."
export KILO_DEEPSEEK_API_KEY="..."
```

### 2. Verifica Installazione

```bash
# Verifica Kilo CLI
kilo --version

# Verifica configurazione
kilo config show

# Test connessione
kilo chat --model "anthropic/claude-sonnet-4" "Hello"
```

### 3. Usa Mode Diverse

```bash
# Plan Mode (Architect)
kilo run --mode plan "Create PRD for new feature"

# Code Mode (Coder)
kilo run --mode code "Implement Filament resource"

# Debug Mode (Debugger)
kilo run --mode debug "Fix PHPStan errors"

# Review Mode (Reviewer)
kilo run --mode review "Review this PR"

# Test Mode (Tester)
kilo run --mode test "Write tests for this feature"
```

## Best Practices

### 1. Usa il Mode Giusto

| Task | Mode | Agente |
|------|------|--------|
| Pianificazione feature | plan | Architect |
| Implementazione | code | Coder |
| Bug fixing | debug | Debugger |
| Code review | review | Reviewer |
| Test writing | test | Tester |

### 2. Context Window

- **Small tasks**: Default (128K)
- **Large refactoring**: Gemini (1M)
- **Local testing**: Ollama (32K)

### 3. Auto-Approve

- ✅ Safe: git status, ls, grep
- ✅ Tests: php artisan test
- ✅ Quality: phpstan, pint
- ❌ File write: Richiede approvazione
- ❌ Git commit: Richiede approvazione

### 4. Quality Gates

Ogni modifica deve passare:
1. ✅ PHPStan Level 10
2. ✅ Laravel Pint (auto-fix)
3. ✅ Pest tests (90%+ coverage)
4. ✅ Frontend quality (npm run quality)

### 5. Git Integration

```jsonc
"git": {
  "autoStage": false,      // Review before stage
  "autoCommit": false,     // Manual commit messages
  "commitTemplate": "feat: {description}",
  "branchPrefix": "kilo/"
}
```

## Troubleshooting

### Kilo non trova la configurazione

```bash
# Verifica percorso
ls -la .kilo/kilo.jsonc

# Verifica sintassi
cat .kilo/kilo.jsonc | jq .

# Reload Kilo
kilo config reload
```

### API Keys non funzionano

```bash
# Verifica variabili d'ambiente
echo $KILO_ANTHROPIC_API_KEY

# Test connessione
kilo test-provider anthropic
```

### Contesto insufficiente

```bash
# Switch a Gemini per contesto ampio
kilo chat --model "google/gemini-2.5-pro"

# Oppure riduci file inclusi
# Modifica context.maxMessages in kilo.jsonc
```

## Resources

- **Config File**: `.kilo/kilo.jsonc`
- **Logs**: `.kilo/logs/kilo.log`
- **Backups**: `.kilo/backups/`
- **Cache**: `.kilo/cache/`

## Related Documentation

- [Kilo Official Docs](https://kilo.ai/docs)
- [BMAD Integration](docs/project/bmad-gsd-ralph-integration.md)
- [NotebookLM Integration](docs/project/notebooklm-integration.md)
- [OpenViking Integration](docs/openviking-integration.md)

---

**Last Updated**: 2026-03-30  
**Configuration Version**: 1.0.0  
**Status**: ✅ Active
