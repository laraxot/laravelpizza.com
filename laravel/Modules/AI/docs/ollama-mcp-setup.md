# Ollama MCP Setup

## Perche'

Questa configurazione esiste per rendere disponibile un LLM locale via MCP agli agenti AI che lavorano sul progetto. Lo scopo non e' solo "far funzionare Ollama", ma ridurre attrito operativo, costi di token e dipendenza da servizi remoti per i task che possono essere eseguiti localmente.

## Scopo operativo

- Esporre Ollama come server MCP riusabile da editor e agenti.
- Uniformare la configurazione tra workspace root, Laravel app e configurazioni editor.
- Rendere `docs/` il punto di handoff tra agenti su motivazioni, vincoli e decisioni.

## Politica

- Preferire modelli locali per triage, refactoring semplice, sintesi e generazione boilerplate.
- Tenere i path MCP allineati al repository corrente, non a workspace storici.
- Documentare sempre il contesto della scelta, non solo i parametri tecnici.
- Evitare configurazioni che dipendono da un primo download implicito se il pacchetto puo' essere installato in locale.

## Visione

L'integrazione MCP con Ollama serve a trattare il modello locale come infrastruttura di base del progetto, non come tool occasionale. La documentazione deve permettere a piu' agenti di convergere sulla stessa strategia senza riesplorare da zero.

## Filosofia

- Le `docs/` non sono archivio passivo: sono memoria condivisa tra agenti.
- Il "come" senza il "perche'" degrada rapidamente in configurazione fragile.
- Una configurazione AI e' completa solo se e' verificata e spiegata.

## Scelte fatte in questo setup

- Server MCP scelto: `ollama-mcp-server`
- Endpoint locale: `http://127.0.0.1:11434`
- Modello di default: `qwen2.5-coder:7b`
- Configurazioni aggiornate:
  - root [`.mcp.json`](./.mcp.json)
  - Laravel [`laravel/mcp.json`](./laravel/mcp.json)
  - Cursor [`bashscripts/ai/.cursor/mcp.json`](./bashscripts/ai/.cursor/mcp.json)
  - Windsurf [`bashscripts/ai/.windsurf/mcp_config.json`](./bashscripts/ai/.windsurf/mcp_config.json)
  - VS Code [`bashscripts/ai/.vscode/mcp.json`](./bashscripts/ai/.vscode/mcp.json)

## Nota per altri agenti

Se aggiorni questa integrazione, documenta qui:

- cosa hai cambiato
- perche' l'hai cambiato
- quale editor o agente ne dipende
- quale verifica concreta hai eseguito

## Nota di compatibilita'

In un passaggio iniziale e' stato verificato anche `@rawveg/ollama-mcp`, ma quel pacchetto avvia un server HTTP su porta locale e non corrisponde bene al transport MCP `stdio` usato dalle configurazioni di questo workspace. Per questo e' stato scartato in favore di `ollama-mcp-server`, che espone davvero un server MCP su stdio.

## Convenzione operativa in Codex

Dentro questa chat di Codex non esiste, da quanto verificato localmente, un registro nativo di slash command personalizzati paragonabile a certi altri client AI. Per evitare ambiguita', il workspace adotta quindi questa convenzione:

- input utente: `/ollama <prompt>`
- comportamento atteso: eseguire `<prompt>` con Ollama locale
- modello preferito: `qwen2.5-coder:7b` salvo richiesta diversa
- output atteso: riportare la risposta di Ollama e dichiarare che il passaggio e' avvenuto senza token a pagamento

Questa convenzione non modifica il parser della UI di Codex; definisce invece un contratto operativo condiviso tra utente e agenti che lavorano in questo workspace.

## Custom slash commands per altri client AI

Per i client che supportano command file locali, il workspace ora include uno slash command `ollama` con lo stesso intento operativo: usare prima Ollama locale ed evitare token a pagamento quando il task e' compatibile con un modello locale.

File creati:

- Claude: `bashscripts/ai/.claude/commands/ollama.md`
- Gemini: `bashscripts/ai/.gemini/commands/ollama.toml`
- OpenCode: `bashscripts/ai/.opencode/commands/ollama.md`
- Shared agents reference: `bashscripts/ai/.agents/commands/ollama.md`

Semantica comune:

- input: `/ollama <prompt>`
- modello preferito: `qwen2.5-coder:7b`
- preferenza transport: MCP `ollama`, con fallback a `ollama run`
- obbligo di output: dichiarare che la risposta e' arrivata da Ollama locale e non ha usato token a pagamento

## Suite minima di slash commands consigliata

Un solo comando `/ollama` non basta per un workflow locale serio. Gli agenti hanno bisogno almeno di sei primitive operative oltre all'esecuzione libera del prompt:

- `/ollama-models`
  - scopo: vedere i modelli installati localmente
- `/ollama-pull <model>`
  - scopo: installare un nuovo modello locale
- `/ollama-use <model>`
  - scopo: impostare il modello di default del bridge locale
- `/ollama-status`
  - scopo: verificare servizio, modello corrente e modelli caricati
- `/ollama-current-model`
  - scopo: leggere il modello attivo senza rumore operativo
- `/ollama-auto-model`
  - scopo: tornare al routing automatico per intent

Razionale:

- discovery: senza lista modelli, gli agenti indovinano i nomi
- provisioning: senza pull, il workflow locale resta incompleto
- state selection: senza `use`, ogni agente rischia di usare un modello diverso
- observability: senza status, i failure vengono confusi con problemi di prompt

Implementazione corrente:

- i command file dei client delegano alla logica canonica in `bashscripts/ai/ollama-cmd.sh`
- la selezione persistente del modello usa `bashscripts/ai/.ollama-config`
- il default del bridge e' stato riallineato a `qwen2.5-coder:7b`
