# MCP Quick Start Guide

## Setup Rapido per il Nostro Progetto

### 1. Prerequisiti

```bash
# Verifica Node.js 18+
node -v

# Se non installato
# Ubuntu/Debian
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### 2. Cursor IDE

**File**: `~/.cursor/mcp.json` (già configurato nel progetto)

**Configurazione API Keys**:

```bash
# Edita il file
nano ~/.cursor/mcp.json

# Aggiungi le tue API keys:
# - GITHUB_PERSONAL_ACCESS_TOKEN: https://github.com/settings/tokens
# - BRAVE_API_KEY: https://brave.com/search/api/
```

**Riavvia Cursor**.

### 3. Windsurf IDE

**File**: `~/.codeium/windsurf/mcp_config.json` (già configurato nel progetto)

**Configurazione API Keys**:

```bash
# Copia configurazione dal progetto
cp .windsurf/mcp_config.json ~/.codeium/windsurf/mcp_config.json

# Edita
nano ~/.codeium/windsurf/mcp_config.json

# Aggiungi GITHUB_PERSONAL_ACCESS_TOKEN
```

**Refresh Plugins** in Windsurf.

### 4. Cline (VS Code)

**Installazione**:

1. Apri VS Code
2. Extensions → Cerca "Cline"
3. Install
4. Click "MCP Servers" icon nella navbar Cline
5. Installa server dal Marketplace:
   - filesystem
   - github
   - memory
   - sequential-thinking

### 5. iFlow CLI

**Installazione**:

```bash
# macOS/Linux
bash -c "$(curl -fsSL https://cloud.iflow.cn/iflow-cli/install.sh)"

# Windows (con Node.js installato)
npm install -g @iflow-ai/iflow-cli
```

**Primo Utilizzo**:

```bash
cd init

# Esempio: Analizza architettura
> Analizza l'architettura modulare del progetto e documenta le dipendenze tra Modules
```

---

## Server MCP Configurati

### filesystem

**Accesso a**:

- `laravel`
- `Modules`
- `Themes`

**Cosa fa**: Legge/scrive file, esplora struttura progetto

### github

**Cosa fa**: Gestisce PRs, issues, code reviews

**Setup**: Richiede `GITHUB_PERSONAL_ACCESS_TOKEN`

**Permissions needed**: `repo`, `read:org`

### memory

**Cosa fa**: Ricorda pattern, decisioni architetturali, context

**Dove salva**: `~/.modelcontextprotocol/memory` (Cursor/Windsurf)

### sequential-thinking

**Cosa fa**: Problem-solving strutturato step-by-step

**Usa quando**: Debug complessi, refactoring, architettura

### fetch

**Cosa fa**: Scarica contenuti web, converte per LLM

**Usa quando**: Cercare documentazione, esempi online

### laravel-boost (Custom)

**Cosa fa**: Comandi Laravel custom tramite MCP

**Setup**: `php artisan boost:mcp`

---

## Casi d'Uso Pratici

### 1. Debugging PHPStan

```
# In Cursor/Windsurf/Cline
Analizza gli errori PHPStan in Modules/Quaeris e suggerisci correzioni seguendo le regole in .windsurf/rules/
```

### 2. Refactoring Modulo

```
# In qualsiasi IDE con MCP
Refactorizza Modules/User/Models/User.php:
1. Segui pattern BaseModel
2. Aggiungi PHPDoc completi
3. Verifica PHPStan livello 10
4. Aggiorna docs/
```

### 3. GitHub PR Review

```
# Con github MCP server attivo
Crea PR per branch feature/mcp-integration:
- Title: "feat: Aggiungi configurazione MCP"
- Body: Descrizione modifiche
- Reviewers: @maintainer
```

### 4. Documentazione Automatica

```
# In iFlow CLI
iflow
> Genera documentazione completa per Modules/Cms analizzando il codice e seguendo lo stile esistente in docs/
```

### 5. Analisi Architettura

```
# Con memory + sequential-thinking
Analizza l'architettura del modulo Quaeris:
1. Identifica pattern utilizzati
2. Documenta dipendenze
3. Suggerisci miglioramenti
4. Salva decisioni in memory per future reference
```

---

## Troubleshooting

### Server non si avvia

```bash
# Reinstalla server
npm install -g @modelcontextprotocol/server-filesystem
npm install -g @modelcontextprotocol/server-github
npm install -g @modelcontextprotocol/server-memory
```

### API Key non funziona

```bash
# Verifica formato (no spazi extra)
cat ~/.cursor/mcp.json | jq '.mcpServers.github.env'

# Rigenera token
# https://github.com/settings/tokens
```

### Filesystem Access Denied

```bash
# Verifica permessi
ls -la 

# Fix permessi se necessario
sudo chown -R $USER:$USER 
```

---

## Best Practices

### ✅ DO

- Limita filesystem access solo a directory progetto
- Usa memory server per ricordare decisioni architetturali
- Documenta pattern scoperti con sequential-thinking
- Testa modifiche con PHPStan prima di commit

### ❌ DON'T

- Non dare accesso filesystem a `/` root
- Non hardcodare API keys in file committed
- Non abilitare tutti i 100 tools disponibili
- Non ignorare warning di sicurezza MCP

---

## Links Utili

- **Documentazione Completa**: [`mcp-servers.md`](./mcp-servers.md)
- **MCP Official**: [https://modelcontextprotocol.io/](https://modelcontextprotocol.io/)
- **GitHub Servers**: [https://github.com/modelcontextprotocol/servers](https://github.com/modelcontextprotocol/servers)
- **Cursor Docs**: [https://docs.cursor.com/](https://docs.cursor.com/)
- **Windsurf Docs**: [https://docs.windsurf.com/](https://docs.windsurf.com/)
- **iFlow**: [https://github.com/iflow-ai/iflow-cli](https://github.com/iflow-ai/iflow-cli)

---

## Support

Per problemi o domande:

1. Consulta [`mcp-servers.md`](./mcp-servers.md) (guida completa)
2. Check GitHub issues dei server MCP
3. Community: Discord/Slack del tuo IDE

---

**Ultimo aggiornamento**: [DATE]
