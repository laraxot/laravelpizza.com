# Aggiunte a start.txt

Data: 2026-07-07

## Ambito

Eseguito bootstrap da `start.txt`, poi aggiunte sezioni mancanti.

## Modifiche a `bashscripts/tools/prompts/start.txt`

- **Bootstrap**: aggiunto punto 5 — carica prompt modulari (`00-master-prompt.md` → `07-documentation-standards.md`)
- **Nuova §4 Ponytail Mode**: ladder, intensity ultra, divieti
- **Nuova §5 Context-Mode & Token Budget**: `ctx doctor`, overflow, compressione
- **Nuova §6 BMAD Agents**: referenza a `.bmad-core/agents/`
- **Rinumerate** sezioni 5–10 → 8–13
- **Rimossa** riga auto-referenziale finale "esegui il prompt..."

## Verifiche

- `bash bashscripts/quality-gates/verify-llm-wiki.sh` → 13 pass, 1 fail (Folio semantic dirs — preesistente), 7 warn

## Sessione successiva (stesso giorno)

Rieseguito bootstrap end-to-end (non solo lettura): `guard-prompt-conflicts.sh`, `guard-prompt-start-hygiene.sh`, `bashscripts/docs/second-brain-session-bootstrap.sh`, `bashscripts/tools/run-session-gate.sh --markdown`, `verify-llm-wiki.sh`.

Trovato e corretto:
- **Anti-pattern ricorrente**: testo grezzo di un prompt utente riappeso in coda a `start.txt` (stesso anti-pattern già rimosso sopra — probabile hook/processo che logga l'ultimo prompt nel file invece che in chat). Rimosso di nuovo.
- **`bashscripts/docs/llm-wiki-qmd.sh`** non era eseguibile (644) → bloccava lo script canonico second-brain-bootstrap. Fix: `chmod +x`.
- **Pointer mancante `docs/wiki/how-to`**: gli altri 4 pointer (`rules`, `memories`, `skills`, `commands`) esistono, `how-to` no → rotto il link a `github-issue-agent-discipline.md` citato da root `CLAUDE.md`/README. Creato file puntatore (stesso formato, no newline finale) → `../../bashscripts/ai/wiki/how-to`.
- **`start.txt` §1**: non citava `bashscripts/tools/run-session-gate.sh`, script già commentato nel proprio sorgente come "implementazione DRY di start.txt §1" e referenziato da `bashscripts/tools/prompts/README.md`. Aggiunto come automazione canonica in cima alla sezione, con i passi manuali come fallback.
- **`start.txt` §11 GitHub & BMAD**: mancava la disciplina "commenta l'issue a fine task" (già presente nel Trigger Map, riga BOOTSTRAP SESSIONE AGENTE). Aggiunta.

## Gate risultati (stato repo, non causati da queste modifiche)

`run-session-gate.sh --markdown` segnala bloccanti preesistenti: `wiki-junction`, `ide-junction` (root `.claude/.cursor/.devin/.windsurf` non sono symlink), `guard-no-legacy-folders`, `runtime-psr4`. Fuori scope per questo task (limitato a `start.txt`); da aprire come issue separata se non già tracciata.

## Verifiche (sessione successiva)

- `guard-prompt-conflicts.sh` / `guard-prompt-start-hygiene.sh` → ok
- `bash bashscripts/quality-gates/verify-llm-wiki.sh` → 13 pass, 1 fail (Folio semantic dirs — preesistente), 7 warn (invariato)
