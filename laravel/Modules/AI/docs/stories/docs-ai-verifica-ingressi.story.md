---
title: "AI docs: ingressi verificati contro il codice"
type: story
status: done
created: 2026-10-14
updated: 2026-10-14
module: AI
tags: [docs, ai, verifica, indici, mcp, ollama, link]
qmd: "ai docs ingressi readme 00-index verifica codice mcp assente ollama ds4 openai piani roadmap link rotti stale"
related:
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
---

# AI docs: ingressi verificati contro il codice

Fase BMAD: documentazione e qualita' (DOC-010 e DOC-002 del piano `bmad-output/stories/docs-organization/`).

## Richiesta
Studiare il modulo AI (MCP, Ollama), distinguere cio' che e' implementato da cio' che e' strategia o roadmap, correggere gli ingressi, ridurre i link rotti e i blocchi spuri.

## Analisi
- Il README si intitolava "Integrazione MCP" e prometteva MCP Protocol, chat multi-utente e addestramento. Nel codice: nessuna occorrenza di `mcp` in `app/`, `config/`, `routes/`, `composer.json` del modulo. Il progetto ha `laravel/mcp` e `laravel/config/mcp.php`, ma `laravel/routes/ai.php` ha i server solo commentati.
- Implementato davvero: client Ollama (`Actions/Ollama/`), DS4 (`Actions/Ds4/`), OpenAI (`CompletionAction`, `ContextCompressorAction`), azioni sul dominio ticket (`ClassifyTicketAction`, `SuggestSolutionsAction`, prompt), sentiment, proposte di azione con conferma o annullamento (`AiActionProposal`), 4 tabelle (`ai_threads`, `ai_messages`, `ai_action_proposals`, `ai_tool_logs`), `AiActionProposalResource` e pagine `Completion`, `FineTuning`, `Dashboard`, script `bin/fine_tuning.py`.
- Residui di altri progetti: `GeneratePredictionsAction`, `Predict/*`, `OpenAiPredictionMapper` (il modulo `Predict` non esiste) e `deferred-operator-assistant-agent.md` (modulo `AiAssistant` di `gestionale_commesse`).
- Nessun consumatore: `Modules\AI\` compare fuori dal modulo solo in `laravel/config/app.php`.
- `ollama-actions-moved-from-xot.md` dice spostate le Actions Ollama; le copie in `Modules/Xot/app/Actions/AI/Ollama/` esistono ancora (ultimo commit 2026-10-09).
- Rotte: `routes/` vuoto, 11 rotte Filament `ai/admin`. Nessuna interfaccia di chat.
- I link rotti del README (`MCP_*.md`, `docs/project/references/*.md`) puntavano a file che non esistono.

## Modifiche
- `README.md`: riscritto al posto delle sezioni su MCP (le sezioni finali su LLM wiki e regole sono rimaste); identita', cosa contiene, nessun consumatore, limiti.
- `00-INDEX.md`: indice canonico con stato verificato, sezione "Piani, strategia e visione" (PRD, prodotto, roadmap, sprint, strategia Ollama, visione MCP), ruolo delle directory.
- `index.md`: nota di canonicita' e data; 6 link a file assenti resi testo "riferimento non presente nel repository".
- Segnati con nota datata: `ollama-actions-moved-from-xot.md` e `00-index.md` (`stale`), `INDEX.md` (`stub`).
- `wiki/index.md`: 5 riferimenti sistemati (1 ricollegato a `../sources/`, 4 resi testo).
- Front matter: 35 file corretti con `frontmatter --fix --default-status draft`; rimosse 168 righe spurie (i "22 blocchi spuri residui" misurati prima).

## Verifica
```
audit_one (file indice a profondita' 0 e 1)       link rotti: 21 -> 0
docs-organizer links --by-name, busy-minutes 0    unresolved: 194 -> 173 (tutta la cartella)
stessi eventi sugli 8 file toccati                22 -> 1
grep -ri mcp app config routes composer.json      nessun risultato
php artisan route:list --name=ai                  11 rotte, tutte ai/admin
Pest su DB usa-e-getta                            Fatal error: Cannot redeclare class OpenAI (Pest\Exceptions\FatalException)
```

## Decisioni
- Le guide MCP restano come riferimento ma il README dice che il modulo non contiene codice MCP.
- Strategia, roadmap e visione sono elencate come piani nell'indice; non sono state riscritte.

## Aperto
- Decidere se le copie Ollama di Xot vanno rimosse (codice, non docs).
- Il test che dichiara `OpenAI` e' un difetto della suite: da correggere nel codice di test.
- Il modulo e' attivo ma senza consumatori: collegare `ClassifyTicketAction` a Fixcity oppure dichiararlo non in uso.
- Il `decision-log.md` ha solo la voce modello.
- 32 collisioni di maiuscole nella radice e 27 stub con `canonical` verso `Themes/docs/shared-components` (DOC-004, DOC-006).
