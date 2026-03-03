# MCP (Model Context Protocol) - Guida Completa

## Indice

1. [Introduzione](#introduzione)
2. [Cursor IDE](#cursor-ide)
3. [Windsurf IDE](#windsurf-ide)
4. [Claude Code / Cline](#claude-code--cline)
5. [iFlow CLI](#iflow-cli)
6. [Server MCP Disponibili](#server-mcp-disponibili)
7. [Configurazione per il Progetto](#configurazione-per-il-progetto)

---

## Introduzione

**Model Context Protocol (MCP)** è uno standard aperto che consente agli agenti AI di connettersi seamlessly con strumenti esterni, sorgenti dati e servizi.

### Cos'è MCP?

MCP agisce come un **"ponte universale"** tra il tuo IDE/AI assistant e:
- File system locali
- Database
- API esterne (GitHub, Notion, Supabase, ecc.)
- Servizi cloud
- Strumenti personalizzati

### Perché MCP?

**Senza MCP:**
- L'AI vede solo piccoli snippet di codice
- Manca contesto del progetto completo
- Non può interagire con servizi esterni

**Con MCP:**
- L'AI ha accesso al contesto completo del progetto
- Può leggere/scrivere file, query database, cercare su web
- Comprende relazioni tra moduli e dipendenze
- Può interagire con GitHub, Notion, Slack, ecc.

---

## Cursor IDE

### Configurazione

#### Percorso File: `~/.cursor/mcp.json`

```json
{
  "mcpServers": {
    "filesystem": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-filesystem",
        "server-brave-search"
      ],
      "env": {
        "BRAVE_API_KEY": "<YOUR_BRAVE_API_KEY>"
      }
    },
    "memory": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-memory"
      ]
    },
    "sequential-thinking": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-sequentialthinking"
      ]
    },
    "github": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-github"
      ],
      "env": {
        "GITHUB_PERSONAL_ACCESS_TOKEN": "<YOUR_GITHUB_TOKEN>"
      }
    }
  }
}
```

### Setup

1. **Installare Node.js 18+**
2. **Creare/Editare** `~/.cursor/mcp.json`
3. **Aggiungere API Keys** dove richieste
4. **Riavviare Cursor**

### Accesso

- **File → Cursor Settings → MCP**
- **Add New Global MCP Server**

---

## Windsurf IDE

### Configurazione

#### Percorso File: `~/.codeium/windsurf/mcp_config.json`

```json
{
  "mcpServers": {
    "filesystem": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-filesystem",
        "laravel",
        "Modules",
        "Themes"
      ]
    },
    "github": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-github"
      ],
      "env": {
        "GITHUB_PERSONAL_ACCESS_TOKEN": "<YOUR_GITHUB_TOKEN>"
      }
    },
    "memory": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-memory"
      ]
    },
    "sequential-thinking": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-sequentialthinking"
      ]
    },
    "fetch": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-fetch"
      ]
    }
  }
}
```

### Server HTTP (Esempio: Figma)

```json
{
  "mcpServers": {
    "figma": {
      "serverUrl": "https://your-server-url/mcp"
    }
  }
}
```

### Setup

1. **Aprire Windsurf**
2. **Click Plugins icon** nella sidebar
3. **Browse** available MCP servers
4. **Install** e inserire credenziali
5. **Save** e refresh

### Plugin Store

Windsurf ha un **Plugin Store** integrato con server MCP ufficiali (blue checkmark).

### Gestione Tools

- **Windsurf Settings → Cascade → Plugins**
- **Manage plugins → View raw config**
- Limite: **100 tools totali**

### Admin Controls (Teams/Enterprise)

- Whitelist server approvati
- Toggle accesso MCP per team
- [https://windsurf.com/team/settings](https://windsurf.com/team/settings)

---

## Claude Code / Cline

### Configurazione

#### Percorso File: `cline_mcp_settings.json` (gestito da UI)

### Setup

1. **Installare Cline extension** da VS Code Marketplace
2. **Click MCP Servers icon** in Cline navigation bar
3. **Install from Marketplace** o configure manually

### MCP Marketplace Integrato

Cline ha un **MCP Marketplace** integrato per installare server con 1 click.

### Gestione Server

**Access**: MCP Servers icon → Installed tab

**Global Control:**
- `Advanced MCP Settings`
- `Cline > Mcp:Mode` (enable all, disable all, specific)

**Individual Control:**
- Enable/Disable toggle
- Restart button
- Delete server (⚠️ no confirmation)
- Network Timeout (30s - 1h, default 1min)

### Configuration File

**Manuale**: Click `Configure MCP Servers` → `cline_mcp_settings.json`

```json
{
  "mcpServers": {
    "filesystem": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-filesystem",
        "server-github"],
      "env": {
        "GITHUB_PERSONAL_ACCESS_TOKEN": "<YOUR_TOKEN>"
      }
    }
  }
}
```

### Assistenza AI per Creare Server

Cline può aiutarti a:
- Scaffolding codice server da linguaggio naturale
- Clonare repo GitHub e gestire build
- Gestire configurazioni, env vars, dipendenze
- Troubleshooting e debugging

---

## iFlow CLI

### Introduzione

**iFlow CLI** è un assistente AI per terminale sviluppato da team affiliato Alibaba.
Supporta **Qwen3-Coder, Kimi K2, DeepSeek v3** direttamente da command line.

### Features Chiave

- ✅ **AI-powered code analysis**: Scansiona repository, genera documentazione
- ✅ **Natural language automation**: Comandi in linguaggio naturale
- ✅ **Multi-model support**: Modelli AI gratuiti via Xinliu Open Platform
- ✅ **VS Code extension**: Analisi contesto codice attivo
- ✅ **GitHub Actions**: Integrazione CI/CD
- ✅ **MCP server support**: Collega strumenti locali a suite enterprise
- ✅ **4 running modes**: yolo, accepting edits, plan mode, default

### Installazione

#### macOS/Linux

```bash
bash -c "$(curl -fsSL https://cloud.iflow.cn/iflow-cli/install.sh)"
```

#### Windows

```bash
npm install -g @iflow-ai/iflow-cli
iflow
```

### Autenticazione

1. Genera API key da [iFlow account settings](https://platform.iflow.cn/)
2. Supporta qualsiasi OpenAI-compatible API key

### Uso

```bash
# Run in workspace
iflow

# New project
> Crea un'app Laravel con autenticazione e dashboard

# Existing repo
> /init
# Scansiona e documenta codebase

# Debugging
> Ho un null pointer exception dopo la request, aiutami a trovare la causa
```

### MCP Integration

**iFlow Open Market**: Installa SubAgents e MCP con 1 click

```bash
# Access Open Market
# https://platform.iflow.cn/
```

**Customization**: Edit `~/.iflow/settings.json`

```json
{
  "baseUrl": "https://api.openai.com/v1",
  "modelName": "gpt-4",
  "mcpServers": {
    "filesystem": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-filesystem", "."]
    }
  }
}
```

### Casi d'Uso

- 📊 **Information & Planning**: Ricerca ristoranti, confronto prezzi
- 📁 **File Management**: Organizza file per tipo, batch download
- 📈 **Data Analysis**: Analizza Excel, merge CSV
- 👨‍💻 **Development Support**: Analisi architettura, debugging
- ⚙️ **Workflow Automation**: Backup automatici, script personalizzati

### Ecosistema

- **Python SDK**: `iflow-cli-sdk` per integrazioni custom
- **VS Code extension**: `iflow-cli-vscode-ide-companion`
- **GitHub Actions**: Ready-to-use workflows

---

## Server MCP Disponibili

### Reference Servers (Ufficiali)

| Server | Descrizione | URL |
|--------|-------------|-----|
| **filesystem** | Operazioni file sicure con access controls | [@modelcontextprotocol/server-filesystem](https://github.com/modelcontextprotocol/servers/tree/main/src/filesystem) |
| **fetch** | Fetching e conversione web content | [@modelcontextprotocol/server-fetch](https://github.com/modelcontextprotocol/servers/tree/main/src/fetch) |
| **memory** | Sistema memoria persistente con knowledge graph | [@modelcontextprotocol/server-memory](https://github.com/modelcontextprotocol/servers/tree/main/src/memory) |
| **git** | Tools per leggere, cercare, manipolare Git repos | [@modelcontextprotocol/server-git](https://github.com/modelcontextprotocol/servers/tree/main/src/git) |
| **github** | API GitHub: file ops, repo management, search | [@modelcontextprotocol/server-github](https://github.com/modelcontextprotocol/servers/tree/main/src/github) |
| **sequential-thinking** | Problem-solving dinamico e riflessivo | [@modelcontextprotocol/server-sequentialthinking](https://github.com/modelcontextprotocol/servers/tree/main/src/sequentialthinking) |
| **brave-search** | Brave Search API: web search, local search | [@modelcontextprotocol/server-brave-search](https://github.com/modelcontextprotocol/servers/tree/main/src/brave-search) |

### Official Integrations

- **PostgreSQL** - Database queries
- **Slack** - Team messaging
- **Google Drive** - Cloud storage
- **Sentry** - Error tracking
- **Puppeteer** - Browser automation
- **AWS** - Cloud services
- **Supabase** - Backend as a service
- **Context7** - Documentation access
- **Notion** - Note-taking e knowledge base

### Community Servers

Vedi lista completa: [GitHub MCP Servers](https://github.com/modelcontextprotocol/servers)

---

## Configurazione per il Progetto

### Obiettivi

Per il nostro progetto Laravel + Filament vogliamo:

1. ✅ **Filesystem access** a `laravel/`, `Modules/`, `Themes/`
2. ✅ **GitHub integration** per PRs, issues, code reviews
3. ✅ **Memory system** per ricordare pattern e decisioni
4. ✅ **Sequential thinking** per problem-solving strutturato
5. ✅ **Web search** (Brave) per documentazione aggiornata
6. ✅ **Database access** (PostgreSQL/MySQL) per query dirette

### File Configurazione

Creare nei path appropriati per ciascun IDE (vedere sezioni sopra).

### API Keys Necessarie

1. **Brave Search**: [https://brave.com/search/api/](https://brave.com/search/api/)
2. **GitHub Token**: [https://github.com/settings/tokens](https://github.com/settings/tokens) (permissions: `repo`, `read:org`)

### Best Practices

#### ✅ DO

- Limitare filesystem access solo a directory progetto
- Usare environment variables per API keys
- Testare server individualmente prima di aggiungerne multipli
- Documentare custom servers in `Modules/{Module}/docs/`
- Mantenere updated liste tools abilitati (limite 100)

#### ❌ DON'T

- Non hardcode API keys in config files
- Non dare accesso filesystem a `/` root
- Non abilitare tutti i tools di tutti i server (limite 100)
- Non ignorare warning di sicurezza

### Verifica Installazione

#### Cursor

```bash
# Verifica config
cat ~/.cursor/mcp.json
```

#### Windsurf

```bash
# Verifica config
cat ~/.codeium/windsurf/mcp_config.json

# Refresh plugins
# Windsurf → Plugins → Refresh button
```

#### Cline

```bash
# Apri VS Code
# Cline → MCP Servers → Installed tab
# Verifica stato server (green = running)
```

#### iFlow

```bash
# Verifica installazione
iflow --version

# Test
iflow
> /agent
# Vedi lista SubAgents disponibili
```

---

## Troubleshooting

### Server Non Si Avvia

1. **Verifica Node.js** versione 18+
   ```bash
   node -v
   ```

2. **Reinstalla server**
   ```bash
   npm install -g @modelcontextprotocol/server-filesystem
   ```

3. **Check logs** (specifico per IDE)

### API Key Non Funziona

1. Verifica formato key (no spazi, no quotes extra)
2. Controlla permissions token GitHub
3. Rigenera key se necessario

### Filesystem Access Denied

1. Verifica path assoluti corretti
2. Check permissions directory
3. Assicurati path esista

### Timeout Errors

1. Aumenta network timeout (Cline: 30s → 5min)
2. Verifica connessione internet
3. Check se server MCP è down

---

## Risorse

### Documentazione Ufficiale

- [MCP Spec](https://modelcontextprotocol.io/)
- [GitHub Servers Repo](https://github.com/modelcontextprotocol/servers)
- [Cursor Docs](https://docs.cursor.com/context/model-context-protocol)
- [Windsurf Docs](https://docs.windsurf.com/windsurf/cascade/mcp)
- [Cline Docs](https://github.com/cline/cline)
- [iFlow GitHub](https://github.com/iflow-ai/iflow-cli)

### Community

- [OpenTools MCP Directory](https://opentools.com/)
- [Awesome MCP Servers](https://github.com/punkpeye/awesome-mcp-servers)

---

## Changelog

- **[DATE]**: Documentazione iniziale creata
  - Cursor, Windsurf, Cline, iFlow
  - Server MCP essenziali configurati
  - Best practices e troubleshooting

---

## Licenza

<<<<<<< .merge_file_dEbBqU
Questa documentazione è parte del progetto **base_healthcare_app_fila5_mono** ed è soggetta alla stessa licenza del progetto principale.
=======
Questa documentazione è parte del progetto **base_ptvx_fila5_mono** ed è soggetta alla stessa licenza del progetto principale.
>>>>>>> .merge_file_qgiGPI
