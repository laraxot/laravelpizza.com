---
date: 2026-11-18
pubblicata: no
---

Categoria: Ideas · Titolo: **LaravelPizza parla con gli agenti AI: server MCP pronto, e adesso una chat nel sito?**

Dal talk "Apri la tua app agli agenti: MCP, AG-UI e A2UI" del LaravelDay 2026 (https://github.com/datomatic/laravelday-2026) abbiamo preso l'idea centrale: **la stessa logica, più porte d'ingresso**. Dettagli: issue #582.

Cosa c'è già:
- **Server MCP** su `/api/mcp`: Claude, Cursor e gli altri client cercano i meetup e iscrivono per conto dell'utente del token. I tool chiamano le stesse Action del sito: posti, iscrizioni doppie, email di conferma funzionano esattamente come sul sito.
- **Iscrizione in un passo**: dalla pagina di un evento bastano email e password, l'account nasce con l'iscrizione.

Domande per la community:
1. **Chat nel sito**: un assistente che risponde a "che meetup ci sono a Milano a dicembre?" e iscrive dopo conferma. Lo costruiamo sul modulo AI condiviso con modelli gratuiti (OpenRouter/Groq). Vi interessa? Che limiti mettereste?
2. **Token per gli assistenti**: oggi li crea un amministratore. Una pagina nel profilo "Collega un assistente AI" per crearli e revocarli da soli: la usereste?
3. **WebMCP** (tool dichiarati dalla pagina all'agente del browser, origin trial su Chrome): vale la pena provarlo già ora?
