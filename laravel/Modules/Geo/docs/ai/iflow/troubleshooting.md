# Troubleshooting iFlow CLI per PTVX

---

## Problemi Comuni

Stessi problemi di Claude Code e Gemini. Vedi [Troubleshooting Claude](../claude/troubleshooting.md) per dettagli.

---

## Problemi Specifici iFlow

### 1. Comando Non Riconosciuto

**Sintomi**: `iflow: command not found`

**Soluzioni**:

1. **Verifica installazione**:
   ```bash
   npm list -g @iflow-ai/iflow-cli
   ```

2. **Reinstalla**:
   ```bash
   npm install -g @iflow-ai/iflow-cli@latest
   ```

3. **Verifica PATH**:
   ```bash
   echo $PATH
   # Deve includere percorso npm global
   ```

---

### 2. API Key Non Funziona

**Sintomi**: Errori autenticazione, "Invalid API key"

**Soluzioni**:

1. **Verifica API key**:
   ```bash
   echo $IFLOW_API_KEY
   ```

2. **Rigenera key**: Vai su [iFlow Platform](https://platform.iflow.cn/) e rigenera

3. **Reconfigura**:
   ```bash
   iflow
   # Segui prompt per reconfigurare
   ```

---

### 3. MCP Server Non Funziona

**Sintomi**: Server MCP non risponde in iFlow

**Soluzioni**:

1. **Verifica configurazione**:
   ```bash
   cat ~/.iflow/settings.json
   ```

2. **Test server manuale**:
   ```bash
   npx -y @modelcontextprotocol/server-filesystem --help
   ```

3. **Verifica path**: Controlla che tutti i path siano corretti

---

### 4. Mode Non Funziona

**Sintomi**: `--mode yolo` non ha effetto

**Soluzioni**:

1. **Verifica sintassi**:
   ```bash
   iflow --mode yolo  # Corretto
   iflow -m yolo      # Potrebbe non funzionare
   ```

2. **Check versione**:
   ```bash
   iflow --version
   # Aggiorna se necessario
   npm install -g @iflow-ai/iflow-cli@latest
   ```

---

## Collegamenti Correlati

- [Installazione](./installation.md)
- [Configurazione MCP](./mcp-setup.md)
- [Best Practices](./best-practices.md)
- [Documentazione Ufficiale iFlow](https://platform.iflow.cn/en/cli)
