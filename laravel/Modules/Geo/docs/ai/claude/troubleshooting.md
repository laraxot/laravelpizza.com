# Troubleshooting Claude Code per PTVX

---

## Problemi Comuni

### 1. Server MCP Non Si Avvia

**Sintomi**: Server MCP non risponde, errori di connessione

**Soluzioni**:

1. **Verifica Node.js**:
   ```bash
   node -v  # Deve essere 18+
   ```

2. **Reinstalla server**:
   ```bash
   npm install -g @modelcontextprotocol/server-filesystem
   ```

3. **Verifica path**:
   ```bash
   # Controlla che path in .mcp.json esistano
   ls -la /var/www/_bases/base_ptvx_fila5_mono/laravel
   ```

4. **Check logs**:
   ```bash
   # Verifica log Claude Code
   tail -f ~/.config/claude-code/logs/claude-code.log
   ```

---

### 2. Database Connection Failed

**Sintomi**: MySQL MCP non si connette, errori autenticazione

**Soluzioni**:

1. **Verifica variabili d'ambiente**:
   ```bash
   echo $DB_HOST $DB_USERNAME $DB_DATABASE
   ```

2. **Test connessione manuale**:
   ```bash
   mysql -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE
   ```

3. **Verifica permessi database**:
   ```sql
   SHOW GRANTS FOR '$DB_USERNAME'@'$DB_HOST';
   ```

4. **Check configurazione MCP**:
   ```json
   "env": {
     "MYSQL_HOST": "${DB_HOST}",  // Non hardcode!
     "MYSQL_USER": "${DB_USERNAME}",
     "MYSQL_PASSWORD": "${DB_PASSWORD}",
     "MYSQL_DATABASE": "${DB_DATABASE}"
   }
   ```

---

### 3. Filesystem Access Denied

**Sintomi**: Filesystem MCP non può leggere/scrivere file

**Soluzioni**:

1. **Verifica path esistono**:
   ```bash
   ls -la /var/www/_bases/base_ptvx_fila5_mono/laravel
   ```

2. **Controlla permessi directory**:
   ```bash
   chmod 755 /var/www/_bases/base_ptvx_fila5_mono
   chmod -R 755 /var/www/_bases/base_ptvx_fila5_mono/laravel
   ```

3. **Verifica utente**:
   ```bash
   whoami
   # Deve avere accesso alla directory
   ```

4. **Test accesso manuale**:
   ```bash
   cat /var/www/_bases/base_ptvx_fila5_mono/laravel/composer.json
   ```

---

### 4. Context Token Limit

**Sintomi**: Risposte incomplete, timeout, performance lente

**Soluzioni**:

1. **Disabilita server MCP non usati**:
   ```bash
   @puppeteer disable  # Se non serve
   @fetch disable      # Se non serve
   ```

2. **Usa project-scoped config**: Configura solo server necessari

3. **Limita context**: Non includere file troppo grandi in chat

4. **Usa riferimenti**: Invece di incollare codice, usa `@filename`

---

### 5. Configurazione Non Si Applica

**Sintomi**: Modifiche a `.mcp.json` non hanno effetto

**Soluzioni**:

1. **Riavvia Claude Code**: Chiudi e riapri l'applicazione

2. **Verifica file location**: `.mcp.json` deve essere in `laravel/`

3. **Check syntax JSON**:
   ```bash
   cat laravel/.mcp.json | jq .
   ```

4. **Verifica permessi file**:
   ```bash
   chmod 644 laravel/.mcp.json
   ```

---

### 6. Git MCP Non Funziona

**Sintomi**: Git operations falliscono, errori repository

**Soluzioni**:

1. **Verifica path repository**:
   ```bash
   ls -la /var/www/_bases/base_ptvx_fila5_mono/.git
   ```

2. **Test git manuale**:
   ```bash
   cd /var/www/_bases/base_ptvx_fila5_mono
   git status
   ```

3. **Verifica configurazione**:
   ```json
   "git": {
     "command": "npx",
     "args": [
       "-y",
       "@modelcontextprotocol/server-git",
       "--repository",
       "/var/www/_bases/base_ptvx_fila5_mono"  // Path assoluto corretto
     ]
   }
   ```

---

## Debug Avanzato

### Abilitare Log Verbosi

```bash
# Claude Code logs
tail -f ~/.config/claude-code/logs/claude-code.log

# MCP server logs (se disponibili)
export MCP_DEBUG=true
```

### Test Server Individuali

```bash
# Test filesystem
npx -y @modelcontextprotocol/server-filesystem /var/www/_bases/base_ptvx_fila5_mono/laravel

# Test memory
npx -y @modelcontextprotocol/server-memory

# Test fetch
npx -y @modelcontextprotocol/server-fetch
```

---

## Collegamenti Correlati

- [Setup MCP](./mcp-setup.md)
- [Configurazione](./configuration.md)
- [Best Practices](./best-practices.md)
- [Documentazione Ufficiale Claude](https://docs.claude.com/en/docs/claude-code/mcp)
