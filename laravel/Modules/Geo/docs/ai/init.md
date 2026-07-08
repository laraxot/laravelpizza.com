# AI Tools - Setup Iniziale

**Ultimo aggiornamento**: 2026-01-12

---

## Panoramica

Questa guida descrive il setup iniziale per tutti gli AI tools utilizzati nel progetto PTVX.

---

## Tool Supportati

1. **Claude Code** - IDE AI di Anthropic
2. **Gemini Code Assist** - Estensione AI di Google
3. **iFlow CLI** - Assistente AI da terminale

---

## Setup Rapido

### 1. Claude Code

1. Installa Claude Code: [Download](https://claude.ai/code)
2. Configura MCP: Vedi [Claude MCP Setup](./claude/mcp-setup.md)
3. Apri progetto: Apri `laravel/` come workspace

---

### 2. Gemini Code Assist

1. Installa estensione: [VS Code](https://marketplace.visualstudio.com/items?itemName=GoogleCloudTools.cloud-code) o [IntelliJ](https://plugins.jetbrains.com/plugin/22324-google-cloud-code)
2. Configura MCP: Vedi [Gemini MCP Setup](./gemini/mcp-setup.md)
3. Apri progetto: Apri `laravel/` come workspace

---

### 3. iFlow CLI

1. Installa iFlow CLI: Vedi [iFlow Installation](./iflow/installation.md)
2. Configura MCP: Vedi [iFlow MCP Setup](./iflow/mcp-setup.md)
3. Test: `iflow --version`

---

## Configurazione Condivisa

Tutti i tool condividono:
- **MCP Configuration**: `laravel/.mcp.json`
- **Variabili d'ambiente**: Database credentials
- **Workflow**: Modulo per modulo, Fix Don't Ignore

---

## Collegamenti Correlati

- [Claude Code Guide](./claude/README.md)
- [Gemini Code Assist Guide](./gemini/README.md)
- [iFlow CLI Guide](./iflow/README.md)
- [MCP Configuration](../../laravel/Modules/Xot/docs/mcp-configuration-ptvx.md)
