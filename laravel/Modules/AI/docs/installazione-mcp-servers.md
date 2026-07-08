# Installazione e Gestione Centralizzata MCP Servers

## Obiettivo
Centralizzare l'installazione dei server MCP in `/var/www/html/_bases/mcp-servers` per consentire l'uso condiviso tra più progetti Laravel/PHP, evitando duplicazioni e facilitando aggiornamenti e manutenzione.

---

## 1. Struttura consigliata

```
/var/www/html/_bases/
    ├── mcp-servers/         # Qui risiedono tutti i server MCP (clonati e gestiti una sola volta)
    ├── base_predict_fila5_mono/
    ├── altro_progetto/
    └── ...
```

---

## 2. Installazione MCP Server (modelcontextprotocol/servers)

### Clonare il repository nella posizione centralizzata
```bash
cd /var/www/html/_bases
git clone https://github.com/modelcontextprotocol/servers.git mcp-servers
```

### Installare le dipendenze
```bash
cd /var/www/html/_bases/mcp-servers
npm install
```

### (Opzionale) Risolvere dipendenze mancanti
Se durante la build ricevi errori su `shx`:
```bash
npm install shx
```

### Compilare i server
```bash
npm run build
```

---

## 3. Aggiornamento e manutenzione

Per aggiornare i server MCP:
```bash
cd /var/www/html/_bases/mcp-servers
git pull
npm install
npm run build
```

---

## 4. Utilizzo da altri progetti

Ogni progetto può:
- Eseguire i server MCP direttamente dalla cartella centralizzata
- Configurare i propri script/env per puntare a `/var/www/html/_bases/mcp-servers`
- Documentare nei propri README che la dipendenza MCP server è centralizzata

Esempio di avvio di un server (es. everything):
```bash
cd /var/www/html/_bases/mcp-servers/src/everything
node dist/everything.js
```

---

## 5. Pulizia e gestione duplicati

Se hai già cartelle `mcp-server` o `mcp-servers` in altre posizioni:
```bash
# (da eseguire solo dopo aver verificato che non ci siano file personalizzati da salvare)
rm -rf /var/www/html/_bases/base_predict_fila5_mono/mcp-server
rm -rf /var/www/html/_bases/base_predict_fila5_mono/mcp-servers
```

---

## 6. Documentazione nei progetti

In ogni progetto che usa MCP server, aggiungi nel README:

```markdown
## MCP Server centralizzato

Questo progetto utilizza i server MCP installati in `/var/www/html/_bases/mcp-servers`.
Per aggiornare o avviare un server MCP, segui la documentazione centrale in `/var/www/html/_bases/mcp-servers/README.md`.
```

---

## 7. Troubleshooting

- Se hai errori di permessi, assicurati che la cartella sia accessibile a tutti i progetti.
- Se cambi PC, basta riclonare e reinstallare come da punti 2 e 3.
- Per aggiungere nuovi server MCP, segui la stessa procedura nella cartella centralizzata.

---

## 8. Link utili
- [modelcontextprotocol/servers (GitHub)](https://github.com/modelcontextprotocol/servers)
- [Documentazione MCP](https://docs.cursor.com/context/model-context-protocol)
- [README originale del repository](../../../../../../_bases/mcp-servers/README.md)

---

**Questa guida è pensata per essere seguita anche da chi lavora su altri PC o ambienti.**

Per domande o aggiornamenti, fare riferimento alla documentazione centrale e ai README dei progetti coinvolti. 