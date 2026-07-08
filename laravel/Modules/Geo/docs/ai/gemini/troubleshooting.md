# Troubleshooting Gemini Code Assist per PTVX

---

## Problemi Comuni

Stessi problemi di Claude Code. Vedi [Troubleshooting Claude](../claude/troubleshooting.md) per dettagli.

---

## Problemi Specifici Gemini

### 1. Agent Mode Non Disponibile

**Sintomi**: Tab "Agent" non visibile

**Soluzioni**:

1. **Verifica subscription**: Agent Mode richiede subscription Standard o Enterprise
2. **Check versione**: Aggiorna Gemini Code Assist all'ultima versione
3. **Riavvia IDE**: Chiudi e riapri VS Code/IntelliJ

---

### 2. Code Customization Non Funziona

**Sintomi**: Suggerimenti non basati su codebase

**Soluzioni**:

1. **Verifica subscription**: Code Customization richiede Enterprise
2. **Check indicizzazione**: Verifica che indicizzazione sia completata
3. **Rigenera indicizzazione**: Settings → Code Customization → Reindex

---

### 3. Context Drawer Non Si Aggiorna

**Sintomi**: File nel drawer non vengono considerati

**Soluzioni**:

1. **Ricarica drawer**: Rimuovi e riaggiungi file
2. **Verifica path**: Controlla che path siano corretti
3. **Riavvia IDE**: Chiudi e riapri

---

### 4. Custom Commands Non Funzionano

**Sintomi**: Comandi custom non vengono riconosciuti

**Soluzioni**:

1. **Verifica sintassi**: Controlla formato comando in settings
2. **Ricarica configurazione**: Riavvia IDE
3. **Check permessi**: Verifica che file settings.json sia leggibile

---

## Collegamenti Correlati

- [Configurazione](./configuration.md)
- [Setup MCP](./mcp-setup.md)
- [Best Practices](./best-practices.md)
- [Documentazione Ufficiale Gemini](https://cloud.google.com/gemini/docs/codeassist)
