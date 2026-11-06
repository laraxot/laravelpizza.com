---
title: "DCP-441: i prompt operativi dicono scopo, precondizioni, verifica e coordinano nelle story"
type: story
status: in-progress
module: Xot
created: 2026-10-27
updated: 2026-10-27
tags: [prompts, bashscripts, bmad, second-brain, coordinamento, docs-chat, verifica]
qmd: "revisione prompt operativi bashscripts docs prompts scopo prima di iniziare verifica non fare coordinamento story docs chat claims-open link rotti ancore 11-phpstan 00-start docs-clean indice canonici"
related:
  - ../../../Fixcity/docs/stories/dcp-416-coordinamento-agenti-nelle-story-bmad-al-posto-di-docs-chat.story.md
  - ../../../Fixcity/docs/stories/dcp-35-tickets-create-privacy-dati-coordinamento.story.md
  - prompts-bashscripts-improvement.story.md
  - ../../../../../bashscripts/docs/prompts/README.md
---

# DCP-441: revisione dei prompt operativi

## Richiesta

Utente, 2026-10-27: «migliora tutti i prompt scritti dentro bashscripts/docs/prompts ... concentrati non sull'errore, ma su cosa doveva fare, lo scopo il perche'».

Ordine permanente: capire lo scopo di ogni documento, migliorare e riordinare, usare il second brain, nessuna superficialita'. Fase BMAD: Implementation. Perimetro esclusivo: `bashscripts/docs/prompts/**` piu' questa story.

## Origine e scopo

Un prompt operativo vale solo se un agente che lo segue arriva al risultato giusto. Tre guasti lo impediscono:

1. Istruzioni di coordinamento vecchie. [DCP-416](../../../Fixcity/docs/stories/dcp-416-coordinamento-agenti-nelle-story-bmad-al-posto-di-docs-chat.story.md) ha spostato il coordinamento dalla cartella `docs/chat/` alle story BMAD del modulo o tema owner, ma i prompt di questa cartella dicevano ancora di leggere e scrivere in `docs/chat/`.
2. Riferimenti che non portano da nessuna parte (link, ancore, percorsi, esempi misurati su moduli che non esistono piu'). Un agente che li segue perde tempo o, peggio, inventa il bersaglio.
3. Prompt senza "prima di iniziare": nessuno diceva di leggere la story owner, i claim aperti e l'mtime dei file prima di toccarli. E in due casi un blocco in coda al prompt contraddiceva la regola del prompt stesso.

## Misurato prima

Vedi la tabella "Misurato dopo" (colonna Prima). Fatti non ovvi emersi:

- `claims-open.py` legge solo `laravel/Modules/*/docs/bmad/stories/*.md` con `status: in-progress` e le righe sotto `## Claim`. Non vede `docs/stories/`, non vede i temi, non vede `## Coordinamento`. Le story DCP vivono in `docs/stories/`. Il tool serve ancora (mostra anche i lock `.lock`), ma da solo non basta: un output vuoto non prova che nessuno abbia preso il file. Comandi complementari: `rg -l '^status: in-progress' laravel/Modules/*/docs/stories laravel/Themes/*/docs/stories` e `rg -n -A6 '^## Coordinamento' <story>`.
- La tabella degli strumenti di `00-start.md` diceva `qmd`, `graphify` e `rg` assenti (misura di un'altra macchina, 2026-10-25). Su questa macchina, 2026-10-27, sono presenti. La presenza dipende dalla macchina: si misura con `command -v`, non si eredita.
- `11-phpstan.md` chiudeva con un blocco appeso («Convenzione generics Eloquent ... m00179») che suggeriva `phpstan.agent.<Mod>.neon` e `@phpstan-ignore solo bug reali`: due cose che lo stesso prompt vieta. Un secondo blocco «aggiunta 2026-10-27» citava un file di memoria inesistente.
- `01-architecture-patterns.md` aveva due righe di tabella (Traduzioni, CMS front office) finite dopo un elenco puntato, quindi fuori dalla tabella.
- `INDEX.md` aveva perso, in un commit precedente, l'intestazione della tabella dei prompt canonici e le righe 00-04 (7 prompt, tra cui `00-start.md` e `03-quality-gates.md`): le righe 05 in poi comparivano subito dopo l'elenco «Tracciamento».
- Esempi eseguibili con `M=Setting` (4 prompt) e valori attesi misurati su moduli spariti (`Limesurvey`, `Quaeris`, `Chart`, `Setting`, tema `Zero`): con un modulo inesistente i comandi stampano vuoto, che sembra uno zero.
- La funzione di shell `grep` non gestisce `-r` e restituisce vuoto anche dove ci sono risultati: ogni scansione ricorsiva usa `rg`, `git grep` o `/usr/bin/grep -r` (correzione del coordinatore; i numeri "prima" sono stati ripetuti con `git grep` e `rg` e non sono cambiati).
- `Pest.php`: User, Geo, Job e Comment vietano `pest()->extend()` e `uses()->in()` (ogni file test dichiara `uses()`); il contrario di quanto scriveva `10-test.md` (misura del 2026-10-20).

## Cosa e' cambiato

Perimetro: `bashscripts/docs/prompts/` (repo `bashscripts`, working tree, nessun commit).

Prompt riscritti o estesi con Scopo, "Prima di iniziare", Verifica con esito atteso e "Non fare":

- `00-start.md`: "Prima di iniziare" canonica (story owner, `claims-open.py` con i suoi limiti, mtime), strumenti misurati per macchina, `docs/chat/` sostituito dalla `## Coordinamento` della story owner, nota sul `git status` della radice che non vede `bashscripts` e moduli, vincoli su Pint, `:memory:` e lingue.
- `11-phpstan.md` (443 a 305 righe): prima la funzione e lo scopo del codice che genera l'errore, poi il fix alla sorgente; `mixed` ultima spiaggia; mai `phpstan.neon`, `--level`, `-c`; coda `flock`; tolti i blocchi che contraddicevano le regole; comando `class_exists` corretto (con autoload) e provato.
- `46-multi-agent-module-swarm.md`: nuova sezione "Coordinamento tra agenti" (tabella, tre fonti di claim, limite di `claims-open.py`, lock come secondo strato), passi coordinatore e subagent, regola 429/timeout.
- `03-quality-gates.md`: "Prima di iniziare" con ancora `#preflight`, Pint solo su file lockati, Pest senza `:memory:` (DCP-435), quarta trappola di shell (`grep -r`).
- `98-daily-report.md`: "Prima di iniziare", `docs/chat/INDEX.md` sostituito dalle story, Verifica con esito atteso, "Non fare", tolte 5 righe di "Errori gia' commessi" che erano correzioni al testo del prompt e non difetti di risultato.
- `01-architecture-patterns.md`, `02-controller-to-folio-actions.md`, `25-services-to-actions.md`: tabella riparata, numeri rimisurati, "Prima di iniziare", Verifica con controprova positiva, "Non fare".
- `docs-clean.md` (creato da un'altra sessione, senza frontmatter, con istruzioni vietate: cancellare file datati, `git add -A` e commit, scrivere in `docs/chat/`, "Mai mixed" come regola assoluta): riscritto con frontmatter, strumenti non distruttivi (`md-filenames.py`, `docs-organizer.py`), nessun commit, nessuna cancellazione. Non cancellato: il file esisteva.

Correzioni puntuali di riferimenti e misure: `04-filament`, `07-contracts`, `08-ui`, `10-test`, `15-bmad`, `17-gitmodules-path-iteration`, `21-translations`, `32`, `33`, `34`, `35`, `36`, `37`, `38`, `44-module-docs-continuous`, `97-yaml-frontmatter-convention`, `99-closing-ritual` (alcuni di questi con ancore sistemate in parallelo da un altro agente).

Indici: `README.md` e `INDEX.md` aggiornati alla realta' (struttura comune con "Prima di iniziare", Preflight con story owner e `claims-open.py`, `docs-clean.md`, `llm-wiki.txt`, tracciamento a questa story). In `INDEX.md` ripristinate l'intestazione e le 7 righe 00-04 della tabella dei canonici (recuperate da `git show 2d2981d0:docs/prompts/INDEX.md`).

Non toccato: `prompts-review.story.md` (storico, non si estende), `llm-wiki.txt` (nota libera, solo indicizzata), nessun file fuori perimetro, nessun commit, nessun `.lock`.

## Misurato dopo

Tutti i numeri con comandi eseguiti il 2026-10-27 dalla root (`rg`, `git grep`, `/usr/bin/grep`, checker locale link/ancore/percorsi).

| Misura | Prima | Dopo |
|---|---|---|
| Istruzioni a leggere o scrivere in `docs/chat/` | 3 (00-start x2, 98 x1) | 0 |
| Righe che citano `docs/chat` | 4 in 3 file | 21 in 13 file: tutte note "archivio in sola lettura" o divieti (l'aumento e' voluto: ogni prompt di coordinamento ora lo dice) |
| Link relativi rotti | 2 | 0 |
| Ancore rotte | 7 | 0 |
| Percorsi citati come esistenti ma inesistenti | 8 | 0 (restano 3 segnalati dal checker: affermazioni di assenza o storia, legittimi) |
| Prompt con "Prima di iniziare" | 0 su 62 | 9 (8 prompt principali piu' `docs-clean.md`) |
| Prompt senza Scopo, Verifica o Non fare (per intestazione) | 0 | 0 (le intestazioni c'erano; il difetto era il contenuto: precondizioni, esito atteso, controprova) |
| Prompt con intestazioni nuove «Verifica» e «Non fare» | 0 | 9; 54 conservano «Gate di verifica» e «Anti-pattern» per non rompere le ancore entranti |
| Righe in `INDEX.md` tabella canonici | 55 (mancavano 7 prompt e l'intestazione) | 63 |
| File della cartella non indicizzati | 1 (`llm-wiki.txt`) piu' `docs-clean.md` nuovo | 0 |
| Em dash | 19 | 0 |
| Marker di merge | 0 | 0 |
| Nomi `.md` non conformi (`md-filenames.py check`) | 0 | 0 |
| Frontmatter non validi o senza `title`/`qmd` (91 file `.md`) | 0 | 0 |
| `git diff --check -- docs/prompts` | exit 0 | exit 0 |
| Righe: 00-start / 01 / 02 / 03 / 11 / 25 / 46 / 98 | 240 / 92 / 104 / 141 / 439 / 108 / 93 / 408 | 261 / 96 / 117 / 161 / 305 / 119 / 134 / 413 |
| Righe totali `*.md` della cartella | 7060 | 7132 (include i 69 di `docs-clean.md`) |

Controlli eseguiti sui comandi nuovi dei prompt: `composer validate --no-check-publish` ("valid"), `composer install --dry-run` ("Nothing to install, update or remove"), `php artisan --version` (Laravel 13.38.0), `class_exists` su `BaseRating`, `Cms\Models\Menu`, `Cms\Models\BaseTreeModel` (tre `OK`), `/usr/bin/grep -nE` su `phpstan.neon` (exit 1, nessun ignore attivo; `-c baseline` = 1 riga commentata), `md-filenames.py name` (propone il nome senza data), ciclo `diff` dei provider (Geo e Seo differiscono, 18 moduli su 20 allineati), `env()` sotto `Modules/*/app` (0 con rg e con `/bin/grep`), ciclo temi `README.md` (Barthelemy, Meetup, Sixteen, TwentyOne con README; `laravel/Themes/docs` escluso). `NoServicesTest.php` con `bashscripts/tools/pest-scratch-db.sh`: 8 test passati (misura fatta prima della riscrittura di `25-services-to-actions.md`).

Non eseguito: PHPStan su `Modules` e Pest (nessun file PHP toccato), `qmd update` (compito del coordinatore).

## Aperto

- `claims-open.py` non legge `docs/stories/`, i temi e `## Coordinamento`: estenderlo e' una decisione dell'utente e sta fuori dal perimetro (`bashscripts/tools/`). Finche' non cambia, i prompt rimandano ai tre comandi complementari.
- `docs-clean.md` e' arrivato da un'altra sessione: se l'utente voleva davvero un prompt che cancella e committa, va deciso a parte; qui e' stato reso conforme alle regole del repo.
- I `.lock` orfani in `docs/chat/` compaiono ancora in `claims-open.py` (pulizia aperta in DCP-427, collegata a DCP-425 e DCP-426).
- 54 prompt conservano le intestazioni «Gate di verifica» e «Anti-pattern» e non hanno "Prima di iniziare" proprio (rimandano a quella di `00-start.md`): la rinomina in blocco rompe le ancore entranti e non e' stata fatta. Candidati successivi: `10-test`, `09-migrations`, `16-git-forward-only`, `15-bmad`.
- `bashscripts/docs/root-script-policy.md` e `bashscripts/docs/modular-bmad-story-policy.md` non esistono ma sono citati fuori dal perimetro (`bashscripts/ai/.agents/rules/00-ON_DEMAND_USAGE.md`, `00-ON_DEMAND_PATTERN.md`); quello vero e' `bashscripts/docs/script-layout.md`. I prompt non li citano.
- Esempi storici rimasti per scelta (marcati come tali): `Chart`/`Setting` in `11-phpinsights.md` (misura datata), `Zero` in `98-daily-report.md` (misure del 2026-09-24).
- `README.md` e `INDEX.md` sono stati modificati in parte con uno script Python a sostituzione unica asserita (non con Edit); l'esito e' identico ma e' un'eccezione al metodo dichiarata qui.
- Reindicizzazione QMD (`qmd update`) non eseguita: la fa il coordinatore a swarm fermo.

### Appendice: testo originale di `docs-clean.md` (recuperato)

Il file era non tracciato (nessuna copia in git) e la riscrittura lo ha sostituito. Il testo e' stato recuperato dal transcript del sottoagente, che lo aveva stampato prima di riscriverlo (creato il 2026-10-27 alle 21:02:32, 1415 byte, autore non identificato). Riportato qui come riferimento per la decisione, **da non eseguire**: cancella file, usa `git add -A` e commit, e indica `mixed` come divieto assoluto. L'unico carattere cambiato e' un trattino lungo, reso come trattino semplice.

```text
# Prompt: docs-clean

Ruolo: agent di manutenzione documentale per questo repository BMAD.
Scopo: organizzare, deduplicare, standardizzare le cartelle `docs/` nei moduli e nei temi senza mai alterare il codice funzionante.

Passi (esegui in ordine, senza conferma):
1. Trova file `.md` con date o suffissi `-1.md`/`-2.md` (`find ... -name '*[0-9]*[0-9]-*'`). Per ciascuno: se ha un gemello senza data, cancella quello con data; se no, rinominalo togliendo la data (usando `git mv`).
2. Verifica che ogni `docs/README.md` abbia frontmatter YAML (`type`, `status`, `tags`, `updated`). Se manca, aggiungilo - non inventare `id`, usa il basename del file.
3. Se `docs/stories/` manca nel modulo/tema attivo, crea una story vuota di traccia con `status: draft`.
4. Non cancellare mai `docs/chat/` storici (solo lettura). Non lasciare `bmad-output/` nel root del progetto.
5. Dopo ogni modifica: `git diff --stat`, `git add -A`, `git commit -m "docs(<modulo>): <azione> - DRY + naming convention"`.
6. Registra la decisione nel `docs/chat/` o nella story BMAD del modulo (se esiste), non in chat esterni.

Regole dure:
- Mai `mixed` come tipo (usa `string` o union esplicite).
- Mai `.md` senza frontmatter YAML se non `README.md`.
- Sempre `git status` prima di modificare; `git log --oneline -1` dopo commit.

Verifica finale: `grep -rE '[0-9]{4}-[0-9]{2}-[0-9]{2}' laravel/Modules/*/docs/*.md` deve tornare vuoto.
```

Differenze con le regole del repo, per chi decide: (1) il passo 1 cancella, mentre la regola e' rinominare con una migration map; (2) il passo 5 fa `git add -A` e commit automatico, ma i repo dei moduli sono annidati e si committa per repo, file per file; (3) il passo 6 scrive in `docs/chat/`, ora archivio in sola lettura (DCP-416); (4) «Mai mixed» contraddice l'ordine dell'utente («mixed solo come ultima spiaggia»); (5) la verifica finale con `grep -r` della shell non trova nulla (vedi memoria `shell-and-tool-gotchas`). Sono in linea con il repo il punto 2 (frontmatter) e la prima meta' del punto 4 (`docs/chat/` in sola lettura, niente `bmad-output/` nella radice).

## Coordinamento

| Data | Agente | Scope | Nota |
|------|--------|-------|------|
| 2026-10-27 (sessione swarm) | subagent prompts | `bashscripts/docs/prompts/**` | altri agenti su docs User e Cms; altre sessioni su Fixcity, Sixteen, Media, Xot (galleria foto, upload): file non toccati da questa story. Chiusa la parte di revisione; resta aperto quanto elencato in "Aperto" |
