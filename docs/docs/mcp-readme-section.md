# MCP (Model Context Protocol) Integration

## Cosa è MCP?

**Model Context Protocol (MCP)** è uno standard aperto che permette agli IDE AI di:

- 📁 Accedere al filesystem del progetto
- 🔍 Cercare informazioni sul web
- 💾 Ricordare decisioni e pattern
- 🐙 Interagire con GitHub (PRs, issues)
- 🧠 Eseguire problem-solving strutturato

## Quick Start

### 1. Configurazione Base

I file di configurazione MCP sono già presenti nel progetto:

- **Cursor**: `.cursor/mcp.json`
- **Windsurf**: `.windsurf/mcp_config.json`

### 2. Aggiungi API Keys

```bash
# GitHub Token (required per github server)
# Crea token: https://github.com/settings/tokens
# Permissions: repo, read:org

# Brave API Key (optional per web search)
# Registrati: https://brave.com/search/api/
```

Edita i file di configurazione e inserisci le tue keys.

### 3. Riavvia IDE

- **Cursor**: Riavvia completamente
- **Windsurf**: Click "Refresh" nel plugin panel
- **Cline**: Install server dal MCP Marketplace

## Server MCP Configurati

| Server | Descrizione | Status |
|--------|-------------|--------|
| **filesystem** | Accesso a laravel/, Modules/, Themes/ | ✅ Configurato |
| **github** | Gestione PRs, issues, code reviews | ⚙️ Richiede API key |
| **memory** | Ricorda context e decisioni | ✅ Configurato |
| **sequential-thinking** | Problem-solving strutturato | ✅ Configurato |
| **fetch** | Web content fetching | ✅ Configurato |
| **laravel-boost** | Custom Laravel commands | ✅ Configurato |

## Documentazione

- **Guide Completa**: [`mcp-servers.md`](./mcp-servers.md) - Documentazione dettagliata per tutti gli IDE
- **Quick Start**: [`mcp-quickstart.md`](./mcp-quickstart.md) - Setup rapido e troubleshooting
- **Official MCP**: [modelcontextprotocol.io](https://modelcontextprotocol.io/)

## Esempi d'Uso

### Debugging con Context

```text
<<<<<<< .merge_file_OAQfOz
Analizza errori PHPStan in Modules/healthcare_app seguendo pattern in .windsurf/rules/
=======
Analizza errori PHPStan in Modules/ModuloEsempio seguendo pattern in .windsurf/rules/
>>>>>>> .merge_file_zmr9Tz
```

### Refactoring Guidato

```text
Refactorizza Modules/User/Models/User.php:
1. Segui BaseModel pattern
2. Aggiungi PHPDoc
3. Verifica PHPStan L10
4. Aggiorna documentazione
```

### GitHub Integration

```text
Crea PR per branch feature/mcp-integration con descrizione delle modifiche
```

## Supporto

Per problemi, consulta [`mcp-servers.md`](./mcp-servers.md) sezione Troubleshooting.
