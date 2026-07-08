# Installazione iFlow CLI per PTVX

---

## Prerequisiti

- **Node.js**: 22+ (richiesto)
- **npm**: Installato con Node.js
- **Accesso terminale**: Shell access

---

## Installazione

### macOS/Linux

```bash
# Installazione automatica
bash -c "$(curl -fsSL https://gitee.com/iflow-ai/iflow-cli/raw/main/install.sh)"

# Oppure via npm
npm install -g @iflow-ai/iflow-cli@latest
```

### Windows

1. Scarica Node.js installer da [nodejs.org](https://nodejs.org/en/download)
2. Esegui installer
3. Apri terminale e esegui:
   ```bash
   npm install -g @iflow-ai/iflow-cli@latest
   ```

---

## Verifica Installazione

```bash
# Verifica versione
iflow --version

# Dovrebbe mostrare versione installata
```

---

## Autenticazione

### 1. Genera API Key

1. Vai su [iFlow Platform](https://platform.iflow.cn/)
2. **Account Settings → API Keys**
3. Genera nuova API key
4. Copia la key

### 2. Configura API Key

```bash
# Configurazione interattiva
iflow

# Segui prompt per inserire API key
# Oppure usa variabile d'ambiente
export IFLOW_API_KEY="your_api_key_here"
```

---

## Configurazione Iniziale

### File: `~/.iflow/settings.json`

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

---

## Test Installazione

```bash
# Test connessione
iflow

# Dovrebbe aprire prompt interattivo
# Prova comando semplice:
> /help
```

---

## Collegamenti Correlati

- [Configurazione MCP](./mcp-setup.md)
- [Workflow](./workflow.md)
- [Best Practices](./best-practices.md)
