# Refactor prompt start

Data: 2026-07-06

## Ambito

Aggiornato `bashscripts/tools/prompts/start.txt`.

## Sintesi

- Rimossa duplicazione di blocchi PHPStan e istruzioni ripetute.
- Reso esplicito il bootstrap: `AGENTS.md`, trigger map, chat, ricerca wiki/docs.
- Consolidati lock file, quality gate, Git forward-only, divieti PHPStan/test e regole root moduli.
- Corretto il riferimento operativo da `docs/chat/INDEX.md` a `docs/chat/README.md`, che e' l'indice presente nel repository.

## Verifiche

- Controllato contenuto del prompt con `sed`.
- Controllati refusi operativi noti con `rg`.
- `bash bashscripts/quality-gates/verify-llm-wiki.sh` fallisce per errore preesistente nello script: `line 201: syntax error: unexpected end of file`.
- `bash -n bashscripts/quality-gates/verify-llm-wiki.sh` conferma lo stesso errore di sintassi.

## Sessione 2026-07-06

- **Fix** `verify-llm-wiki.sh`: chiuso blocco `if` mancante a riga 37 (`else` + `fi`). Script ora passa `bash -n`.
- **Aggiornato** `start.txt`:
  - Corretto percorso TRIGGER_MAP: `bashscripts/ai/wiki/rules/00-TRIGGER_MAP.md` (non `docs/wiki/rules/` che è un file-puntatore)
  - Aggiunta regola dipendenza moduli: `Xot ← UI ← Geo, …`
  - Aggiunta riga vietato: `use Modules\Geo\*` dentro `Modules/UI/`
- **Esito gate**: 13 pass, 1 fail (Folio semantic dirs — preesistente), 7 warn.

## Sessione 2026-07-07

- **Issue audit**: aperta `provtv/base_ptv_fila5#185`.
- **Aggiornato** `bashscripts/tools/prompts/start.txt`:
  - aggiunta sezione stile risposta italiano/sintetico/conciso;
  - resi espliciti issue audit GitHub, Skills Index e standard Markdown;
  - rafforzato divieto `persist*` su metodi dominio;
  - rimossa riga utente finita in coda al prompt.

## Sessione 2026-07-08 — v26

- **Ripulito** `start.txt`: da ~1973 righe a ~170 (rimossi append utente, `welcome.txt` e `llm-wiki.txt` incollati).
- **v26**: §0 `run-session-gate.sh`, §10 task sessione sicuri, **vietato `composer go`** (cancella migrations).
- **Esecuzione**: `artisan optimize` OK; PHPStan Modules 0 errori / 5907 file.
- Handoff: `docs/chat/2026-07-08-start-prompt-v26-cleanup.md`
