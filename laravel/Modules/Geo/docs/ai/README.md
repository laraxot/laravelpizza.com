# AI Tools - Guida Completa per PTVX

**Ultimo aggiornamento**: 2026-01-12  
**Status**: ✅ Documentazione Completa

---

## Panoramica

Questa sezione contiene la documentazione completa per tutti gli AI tools utilizzati nello sviluppo del progetto PTVX.

---

## Tool Disponibili

### 1. [Claude Code](./claude/README.md)

IDE AI di Anthropic con integrazione nativa Claude AI.

**Caratteristiche**:
- Integrazione nativa nell'IDE
- MCP support completo
- Project-scoped configuration
- Context-aware development

**Guida**: [Claude Code Guide](./claude/README.md)

---

### 2. [Gemini Code Assist](./gemini/README.md)

Estensione AI di Google per VS Code e IntelliJ.

**Caratteristiche**:
- Agent Mode per task complessi
- Code Customization (Enterprise)
- Context Drawer per gestione file
- Custom Commands

**Guida**: [Gemini Code Assist Guide](./gemini/README.md)

---

### 3. [iFlow CLI](./iflow/README.md)

Assistente AI da terminale con supporto multi-model.

**Caratteristiche**:
- Terminal-based
- 4 execution modes
- Natural language commands
- MCP integration

**Guida**: [iFlow CLI Guide](./iflow/README.md)

---

## Configurazione Condivisa

Tutti i tool condividono la stessa configurazione MCP in `laravel/.mcp.json`.

Vedi [MCP Configuration PTVX](../../laravel/Modules/Xot/docs/mcp-configuration-ptvx.md) per dettagli.

---

## Workflow Standard

Tutti i tool seguono lo stesso workflow Laraxot:

1. **Studia docs**: Leggi `Modules/{Module}/docs/` prima di modificare
2. **Analizza**: Comprendi business logic e architettura
3. **Implementa**: Modifica codice seguendo pattern Laraxot
4. **Verifica**: PHPStan livello 10, PHPMD, PHP Insights
5. **Documenta**: Aggiorna docs del modulo
6. **Commit**: Git commit e push dopo ogni modulo completato

---

## Best Practices Comuni

### 1. Context-Aware

Sempre fornisci contesto completo quando chiedi assistenza AI.

### 2. Modulo per Modulo

Completa un modulo alla volta, poi passa al successivo.

### 3. Fix Don't Ignore

Tutti gli errori vanno corretti, nessuno ignorato.

### 4. Documentazione Viva

Aggiorna sempre la documentazione dopo modifiche importanti.

---

## Collegamenti Correlati

- [Documentazione Progetto](../README.md)
- [MCP Configuration](../../laravel/Modules/Xot/docs/mcp-configuration-ptvx.md)
- [Prompt Improvements](../../laravel/Modules/Xot/docs/prompts-improvements.md)
- [Workflow Laraxot](../project/laraxot-methodology.md)

---

**Filosofia**: AI tools come pair programmer intelligenti che comprendono l'architettura Laraxot e aiutano a mantenere qualità codice al massimo livello.
