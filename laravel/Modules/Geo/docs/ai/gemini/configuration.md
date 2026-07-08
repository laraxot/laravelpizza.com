# Configurazione Gemini Code Assist per PTVX

---

## File di Configurazione

### 1. Configurazione Globale

**Percorso**: `~/.gemini/settings.json`

```json
{
  "gemini": {
    "model": "gemini-2.5",
    "subscription": "enterprise"
  },
  "mcp": {
    "enabled": true
  }
}
```

### 2. Configurazione Progetto

**Percorso**: `laravel/.mcp.json` (condiviso con Claude Code)

Questa configurazione è version-controlled e condivisa con il team.

---

## Configurazione MCP per PTVX

Il file `laravel/.mcp.json` contiene tutti i server MCP necessari (stessa configurazione di Claude Code).

Vedi [Setup MCP](./mcp-setup.md) per dettagli completi.

---

## Configurazione VS Code

### Settings.json

Aggiungi in `.vscode/settings.json`:

```json
{
  "gemini.codeAssist.enabled": true,
  "gemini.codeAssist.model": "gemini-2.5",
  "gemini.codeAssist.agentMode": true,
  "gemini.codeAssist.codeCustomization": true
}
```

---

## Configurazione IntelliJ

### Plugin Settings

1. **File → Settings → Plugins**
2. Cerca "Google Cloud Code"
3. Installa e abilita
4. **File → Settings → Tools → Gemini Code Assist**
5. Configura model e subscription

---

## Variabili d'Ambiente

Per sicurezza, le credenziali database sono gestite tramite variabili d'ambiente (stesse di Claude Code).

---

## Verifica Configurazione

### VS Code

1. Apri Command Palette (`Ctrl+Shift+P` / `Cmd+Shift+P`)
2. Cerca "Gemini: Test Connection"
3. Verifica che tutti i server MCP siano attivi

### IntelliJ

1. **Tools → Gemini Code Assist → Test Connection**
2. Verifica status server MCP

---

## Collegamenti Correlati

- [Setup MCP](./mcp-setup.md)
- [Workflow](./workflow.md)
- [Agent Mode](./agent-mode.md)
- [Code Customization](./code-customization.md)
