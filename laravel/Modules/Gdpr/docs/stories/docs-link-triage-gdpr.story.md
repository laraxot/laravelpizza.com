---
title: "Triage dei link rotti nelle docs di Gdpr"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: Gdpr
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["nessuna per i passi 1 e 4", "decisione D1 dell'utente (cosa conta il gate) per chiudere i passi 2 e 3"]
related: [./dcp-165-gdpr-docs-indice-canonico.story.md, ./docs-index-audit.story.md, ../../../Xot/docs/bmad/docs-architecture/module-theme-docs-contract.md, ../../../../../bashscripts/ai/wiki/memories/docs-organizer-non-destructive-pilot.md, ../../../../../bashscripts/tools/docs/docs-organizer.py]
tags: [bmad, docs, link-rotti, docs-organizer, triage, gdpr]
---

# Triage dei link rotti nelle docs di Gdpr

Fase BMAD: documentazione/qualita' (triage per causa, poi riparazione meccanica e scelte umane).

## Richiesta
Come manutentore delle docs del modulo Gdpr voglio che ogni link rotto sia riparato con una regola verificata oppure classificato per causa e deciso da una persona, cosi' che il conteggio dei link rotti diventi un gate affidabile e non rumore.
Perche': 390 link rotti su 377 file letti, ma solo 18 (5%) sono riparabili in modo meccanico e 210 (54%) vengono da due copie di un solo report generato. Senza triage chi ripara a mano tocca la parte sbagliata.

## Scopo
Le pagine di `laravel/Modules/Gdpr/docs` si linkano tra loro: chi segue un link (persona o agente che cerca regole GDPR) deve arrivare a una pagina vera. `docs-organizer.py links` misura e ripara i link relativi senza cancellare ne' spostare file. Questa story separa i link per causa, ripara quelli sicuri e lascia a una persona i casi ambigui (omonimi, pagine di moduli assenti, pagine mai scritte).

## Stato misurato
Misure del 2026-10-20 tra 13:43 e 13:58 UTC, working tree, stesse cifre alle 13:43 e alle 13:56.
- `/usr/bin/find laravel/Modules/Gdpr/docs -name '*.md' | wc -l` = 428 file; il tool ne legge 377 (salta `raw/` e `stories/` in testa alla docs).
- `python3 -I bashscripts/tools/docs/docs-organizer.py --busy-minutes 0 links laravel/Modules/Gdpr/docs --report` = totale 390: FIXABLE_BASIC 18, MOVED_UNIQUE 0, MOVED_MANY 65, NO_MATCH 11, OUTSIDE_OWNER 86, CODE_TARGET 210.
- Misura "vivi" (eventi `unresolved` senza `--report`: includono i link nel frontmatter e non i riparabili): 505 eventi, 0 in cartelle archivio, 210 in `duplicate-methods*`, 295 vivi, di cui 194 verso altri moduli o la radice del repo. Comando (stampa i contatori e i 10 file peggiori):
  `python3 -I bashscripts/tools/docs/docs-organizer.py --busy-minutes 0 links laravel/Modules/Gdpr/docs | python3 -I -c 'import sys,json,re,collections as C;R=re.compile(r"(^|/)(laravel|modules|themes|bashscripts|project_docs|bmad-output|\.windsurf|\.cursor|\.claude)(/|$)|(^|/)[\w-]+/docs/",re.I);A={"archive","_archive","historical","_da-riconciliare","raw"};u=[d for d in map(json.loads,sys.stdin) if d.get("event")=="unresolved"];a=lambda d:bool(A&set(p.lower() for p in d["file"].split("/")[:-1]));m=lambda d:d["file"].rsplit("/",1)[-1].startswith("duplicate-methods");v=[d for d in u if not a(d) and not m(d)];print("unresolved",len(u),"in_archivi",sum(map(a,u)),"in_duplicate_methods",sum(map(m,u)),"vivi",len(v),"vivi_verso_altri_moduli_o_radice",sum(1 for d in v if R.search(d["target"])));print(*[f"{n} {k}" for k,n in C.Counter(d["file"] for d in v).most_common(10)],sep="\n")'`
- Cartelle archivio (`archive`, `_archive`, `historical`, `_da-riconciliare`, `raw`): 1, solo `raw/` (saltata dal tool). Controprova dello zero: lo stesso comando su Notify da' 4402 eventi in archivio, su Job 8.
- CODE_TARGET 210 = i soli `duplicate-methods-analysis.md` e `analysis/duplicate-methods-analysis.md` (105 + 105, corpo identico). Sono link a `Modules/<X>/app/...php` scritti dalla radice `laravel/`: 81 su 105 esistono se risolti da `laravel/`, gli altri puntano a moduli assenti (Blog, Fixcity, Comment, Rating).
- MOVED_UNIQUE 0: nessun link ha una sola pagina con coda coincidente. FIXABLE_BASIC resta 18, quindi la riparazione `--tail` del 2026-10-20 (481 link in 14 moduli) non risulta applicata qui. Controprova dello zero: lo stesso `--report` su User da' MOVED_UNIQUE 1123.
- Blocchi generati "Collegamenti tra versioni di X.md" (`rg -l -P '^## Collegamenti tra versioni di' laravel/Modules/Gdpr/docs --glob '*.md'` = 8 file): 42 rotti in 5 file, tutti MOVED_MANY verso pagine omonime di altri moduli (`laravel/modules/xot/docs/translations.md`).
- `docs-organizer.py dups` in dry-run: 58 file diventerebbero `superseded`, con 131 link rotti (34% degli eventi).
- Link a `docs/wiki/**` (radice del repo): 66 eventi, 46 hanno l'omologo in `bashscripts/ai/wiki/**`. `docs/wiki/.gitignore` riga 20 ignora `rules`, quindi in un clone pulito quelle pagine non ci sono.
- File sporchi in git nella docs: 6 (`git -C laravel/Modules/Gdpr status --porcelain -- docs`), di cui 2 con link riparabili: `INDEX.md` (2), `architecture/architecture.md` (1). Riparabili nei file puliti: 15 in 13 file.
- Attribuzione per leva (script locale di sola lettura che importa `classify_link` dal tool, ogni link contato una volta): riparabili puliti 15, `duplicate-methods*` 210, copie `dups` 12, blocchi versioni 42, risolvibili dalla radice repo 2, residuo umano 109 in 66 file (OUTSIDE_OWNER 75, MOVED_MANY 20, NO_MATCH 11, FIXABLE_BASIC 3 nei file sporchi).

I 10 file con piu' eventi vivi: translations.md 18, structure.md 16, wiki/index.md 9, wiki/concepts/second-brain-local-discipline.md 8, ON-DEMAND-PATTERN.md 6, wiki/concepts/registration-account-lifecycle.md 6, customizing-your-site.md 5, r8-gdpr-register-widget-wins.md 5, mcp-configuration.md 4, phpstan-compliance-status.md 4.

## Lavoro
1. Riparazione meccanica (13 file puliti, 15 link). Proteggere con `bashscripts/lock/lock.sh` i 2 file sporchi (`INDEX.md`, `architecture/architecture.md`), poi `links --fix --tail` (comandi in "Come ripartire"), poi `unlock.sh`. Il tool NON salta i file sporchi in git, salta solo lock e file toccati da meno di 10 minuti. Rischio: la riparazione cambia bersaglio in silenzio; leggere `git diff -U0` dei 13 file. Da guardare: `testing.md:278` (`../../../../docs/troubleshooting.md` diventa `troubleshooting.md`, esiste) e `PROJECT-STRUCTURE.md:101` (`../../docs/wiki/` diventa `wiki`, cartella).
2. MOVED_MANY (65). 42 sono nei blocchi "Collegamenti tra versioni": non hanno canonico locale (puntano ad altri moduli) e NON vanno ripuntati al file omonimo di Gdpr. Restano 20-23 link: `index.md` (6, 15 candidati: scegliere `INDEX.md` come canonico del modulo solo se `dcp-165` lo conferma), `readme.md` (3, 8 candidati), `agent-confidence-*.md` (4: canonico `agents/` vs radice, scegliere a vista), `on-demand-pattern.md` (2).
3. NO_MATCH (11), uno per uno: `filament-resources-modulo-gdpr.md:64` (`./consent-management.md`), `user-registration-integration.md:585` (`./gdpr-compliance.md`), `phpstan-compliance-status.md:65-68` (4 nomi nudi, pagine mai scritte), `mcp-configuration.md:128` (`./roadmap-[date].md`, segnaposto), `blueprints/registro-richieste-interessato.md:171` (story `dcp-254-...` assente in tutto il repo), `testing/database-testing-configuration.md:22,24,147` (due pagine `../xot/docs/*-critical-rules.md` che non esistono in Xot). Per ciascuno: puntare al canonico se esiste (per `consent-management` e `gdpr-compliance` il candidato e' `gdpr-compliance-roadmap.md`, da confermare a vista) altrimenti `--annotate`. Piu' 2 link di `00-INDEX.md` (righe 80-81) verso `Fixcity/docs/`, modulo assente: annotare, non ripuntare.
4. Regola di non regressione: nessun file toccato dalla story deve avere piu' eventi `unresolved` di prima (script in "Verifica").

## Acceptance criteria
- [ ] `--report`: FIXABLE_BASIC <= 3, MOVED_UNIQUE = 0, totale <= 375 (390 meno i 15 riparabili puliti).
- [ ] Dry-run `links --tail`: 0 eventi `fixed` nei file puliti (il comando di "Verifica" stampa `fixed_puliti 0`).
- [ ] Sui 13 file riparati `git diff --numstat` ha aggiunte = rimosse; letto un campione di `git diff -U0` (almeno i 15 link) e annotato l'esito in fondo a questa story.
- [ ] Gli 11 NO_MATCH e i 2 link Fixcity hanno una riga di esito (ripuntato, annotato o lasciato con motivo).
- [ ] Nessun file toccato ha piu' eventi `unresolved` di prima (`peggiorati []`).
- [ ] Obiettivo dichiarato dalla misura: dopo il passo 1 il totale e' <= 375; con D1 accolta il gate conta il residuo umano (109 link in 66 file, meno i 3 riparabili sbloccati), non 390; il resto esce per regola, non per cancellazione.

## Verifica
- `python3 -I bashscripts/tools/docs/docs-organizer.py --busy-minutes 0 links laravel/Modules/Gdpr/docs --report` deve dare FIXABLE_BASIC <= 3. Controprova: prima del passo 1 dava 18.
- Riparabili puliti: `python3 -I bashscripts/tools/docs/docs-organizer.py --busy-minutes 0 links laravel/Modules/Gdpr/docs --tail | python3 -I -c 'import sys,json;d=set(open(sys.argv[1]).read().split("\n"));e=[x for x in map(json.loads,sys.stdin) if x.get("event")=="fixed"];print("fixed_puliti",sum(x["file"] not in d for x in e),"fixed_sporchi",sum(x["file"] in d for x in e))' /tmp/sporchi-gdpr.txt`; atteso `fixed_puliti 0 fixed_sporchi 3`, prima del passo 1 era `fixed_puliti 15`.
- Sostituzioni pure: `(cd laravel/Modules/Gdpr && sed 's#^#docs/#' /tmp/riparabili-gdpr.txt | xargs -d '\n' git diff --numstat -- | awk '$1!=$2' | wc -l)` atteso 0. Controprova: `git -C laravel/Modules/Gdpr diff --numstat -- docs | awk '$1!=$2'` elenca gia' oggi file con aggiunte diverse da rimosse (INDEX.md 67/51): sono modifiche di altre sessioni, non vanno toccate.
- Non regressione: salvare gli eventi prima e dopo (`... links laravel/Modules/Gdpr/docs > /tmp/links-gdpr-prima.jsonl`, poi `-dopo.jsonl`), poi `git -C laravel/Modules/Gdpr diff --name-only -- docs | sed 's#^docs/##' > /tmp/toccati-gdpr.txt` e `python3 -I -c 'import sys,json,collections as C;n=lambda p:C.Counter(d["file"] for d in map(json.loads,open(p)) if d.get("event")=="unresolved");a,b=n(sys.argv[1]),n(sys.argv[2]);print("peggiorati",[(f,a[f],b[f]) for f in open(sys.argv[3]).read().split() if b[f]>a[f]])' /tmp/links-gdpr-prima.jsonl /tmp/links-gdpr-dopo.jsonl /tmp/toccati-gdpr.txt`. Atteso `peggiorati []`; controprova: scambiando prima e dopo elenca i file migliorati.

## Vincoli
- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: story solo documentale (nessun PHP, artisan o database). Mai cancellare, spostare o rinominare un `.md`; `docs-organizer.py` riscrive solo link relativi. Non toccare i 6 file sporchi della docs. Un link annotato resta contato dal `--report`: per misurare i non annotati usare `linecache` sulle righe degli eventi.

## Decisioni aperte
- D1, cosa conta il gate dei link. Oggi `--report` conta anche archivi, report generati e copie `superseded`. Raccomandazione: contare solo i "vivi" (fuori da cartelle archivio, fuori da `duplicate-methods*`, fuori da file con `status: superseded` o `stale`), con una modifica a `bashscripts/tools/docs/docs-organizer.py` e il suo `selftest`; il tool e' condiviso, quindi decide l'utente.
- D2, link a `docs/wiki/**` che esistono solo in `bashscripts/ai/wiki/**` (46 in Gdpr). Raccomandazione: regola unica del tool che riscrive il percorso quando l'omologo esiste, valida per tutti i moduli.
- D3, `duplicate-methods*` (CODE_TARGET 210). Raccomandazione: `docs-organizer.py stale --fix` con motivo "report generato, percorsi dalla radice laravel/" e uscita dal gate; non riscrivere i 210 link.

## Come ripartire
1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5 && git -C laravel/Modules/Gdpr status --porcelain -- docs | cut -c4- | sed 's#^docs/##' > /tmp/sporchi-gdpr.txt` e poi `python3 -I bashscripts/tools/docs/docs-organizer.py --busy-minutes 0 links laravel/Modules/Gdpr/docs --tail | python3 -I -c 'import sys,json;d=set(open(sys.argv[1]).read().split("\n"));f=sorted({e["file"] for e in map(json.loads,sys.stdin) if e.get("event")=="fixed"});open(sys.argv[2],"w").write("\n".join(x for x in f if x not in d)+"\n");open(sys.argv[3],"w").write("\n".join(x for x in f if x in d)+"\n")' /tmp/sporchi-gdpr.txt /tmp/riparabili-gdpr.txt /tmp/proteggi-gdpr.txt` (13 file da riparare, 2 da proteggere).
2. `xargs -a /tmp/proteggi-gdpr.txt -I{} bashscripts/lock/lock.sh laravel/Modules/Gdpr/docs/{}`; `python3 -I bashscripts/tools/docs/docs-organizer.py links laravel/Modules/Gdpr/docs --fix --tail`; `xargs -a /tmp/proteggi-gdpr.txt -I{} bashscripts/lock/unlock.sh laravel/Modules/Gdpr/docs/{}`; poi le verifiche di "Verifica" (`--report`, `fixed_puliti`, `numstat`, `peggiorati`).
3. Scrivere in fondo a questa story una sezione "Esito" con data/ora UTC, le cifre `--report` dopo il passo 1, il campione letto di `git diff -U0` e la tabella dei 11 NO_MATCH; poi passare ai passi 2 e 3 solo dopo la risposta su D1.
