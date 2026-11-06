---
title: Miglioramento dei prompt operativi di bashscripts
type: story
module: Xot
phase: BMAD Quick Flow, analisi, implementazione, QA
status: done
created: 2026-10-20
updated: 2026-11-05
tags: [prompts, bashscripts, second-brain, bmad, phpstan, wave3, wave5, wave6]
qmd: "miglioramento prompt bashscripts docs prompts scopo perche quando usarlo passi gate anti-pattern alias canonici lezioni apprese inventario duplicati wave3 wave4 wave5 wave6 phpstan zero vittoria verificata a zero non ti fermi prompt stickiness catena permanente single-neon services-to-actions ProfileTest DELETED Hindsight non blocca"
related:
  - ../bmad/stories/docs-prompts-reorganization.story.md
  - ../bmad/stories/5.258-prompts-execute-improve.story.md
  - phpstan-test-wave-regression.story.md
---

# Miglioramento dei prompt operativi di bashscripts

## Richiesta

Ordine dell'utente: "migliora tutti i prompt scritti dentro bashscripts/docs/prompts", concentrandosi su scopo e perche, non solo sulla forma. `bashscripts` e' un repo git a se: nessun commit, reset, checkout, restore o stash.

## Scopo ricostruito

Un prompt serve a evitare un guasto che un agente ha gia' causato. Un prompt che non dice quale guasto previene, quando non va usato e come si prova che ha funzionato viene copiato in una seconda versione che diverge (da qui i 24 alias) e invecchia in silenzio (da qui le affermazioni false trovate sotto). La struttura comune impone quindi: Scopo e perche, Quando usarlo, Passi, Gate di verifica con comando reale, Anti-pattern.

## Inventario (89 file, tutti conservati)

- 63 prompt canonici (struttura comune), 24 alias, `INDEX.md`, `prompts-review.story.md`.
- Nessun file creato, rinominato o cancellato: `git ls-files` 89, sul disco 89, 0 cancellati. Modificati 89 (+3148, -2190 righe). Il totale sale da 4839 a 5798 righe perche' ogni canonico ha ora scopo, gate e anti-pattern, e gli alias spiegano il perche' del nome; `98-daily-report.md` scende da 1378 a 364.
- Riferimenti entranti, verificati con due metodi indipendenti (`rg -uu -P` con confine di parola e `grep -rlP`): i due metodi concordano su 87 file su 89, le due differenze sono `98-daily-report.md` (5 contro 4) e `INDEX.md` (1246 contro 1245), file che i metodi leggono in modo diverso; si e' preso l'unione. Dato che nessun nome e' cambiato, ogni riferimento resta valido. Ancore citate da fuori e ancora presenti: `00-start.md#3-concorrenza-e-sicurezza`, `#vincoli-permanenti`, `#4-gate-iniziali-proporzionati`, `04-filament.md#mappa-classi`. Il solo caso rotto, `03-quality-gates.md#preflight` (citato da una story di Activity), era gia' assente nella versione di partenza: non e' una regressione.

## Duplicati e puntatori

Nessuna coppia con corpo uguale oltre il 95% (gate DUPLICATE = 0). Il criterio era lo scopo, non il testo: il piu' completo resta canonico, gli altri sono alias brevi con `superseded_by` e `canonical`.

| Gruppo | Canonico | Alias |
|--------|----------|-------|
| Controller verso Folio | `02-controller-to-folio-actions` | `04b-controller-to-folio-actions` |
| Widget Livewire verso Filament | `05-livewire-to-filament-widgets` | `05-widget`, `28-livewire-to-filament-widgets` |
| Audit Filament | `06-filament` | `06-filament-audit` |
| Test | `10-test`, `29-testing-standards` | `10-pest-xot-base-test`, `06-testing-standards` |
| BMAD | `15-bmad` | `15-bmad-audit`, `BMAD_PROMPT` (era l'unico guasto bloccante: nessun frontmatter, e non era BMAD) |
| Git | `16-git-forward-only` | `16-git`, `17-git` |
| Sync repo | `48-gitmodules-sync` | `17-gitmodules-sync` |
| Docs | `19-docs`, `30-documentation-standards` | `19-docs-second-brain`, `07-documentation-standards` |
| Filesystem | `20-filesystem` | `20-filesystem-before-assertions` |
| Bootstrap | `01-confidence-bootstrap` | `27-confidence-bootstrap` |
| Second brain | `57-second-brain` | `57-second-brain-operating-model`, `second-brain-master` |
| Altri | `00-start`, `10-ponytail-audit`, `46-multi-agent-module-swarm`, `97-yaml-frontmatter-convention`, `98-daily-report`, `09-migrations`, `08-ui` | `start`, `17-ponytail`, `56-multiple-ai`, `97-YAML-FRONTMATTER-CONVENTION`, `daily-report`, `09-migrations-forward-only`, `08-playwright-ui` |

Sovrapposizioni di scopo tra canonici risolte per puntatore: `19-docs` (dove scrivere cosa) contro `57-second-brain` (ciclo), e `30` (regole assolute), `55` (verifiche), `12` (come scrivere una pagina), `44` (durante il task).

## Affermazioni stantie corrette (prova sul filesystem)

- `docs/wiki/rules/` non esiste: il canone e' `bashscripts/ai/wiki/rules/`. Corretti i link relativi e i percorsi testuali (12 link rotti e una ventina di percorsi misurati all'inizio), con verifica del file di destinazione.
- `laravel/tools/` esiste (`phpmd.sh`, `phpinsights.sh`, `quality-reminder.md`); `11-phpinsights` diceva che non esiste un wrapper. `phpmd.sh` non e' eseguibile: si lancia con `bash`.
- `laravel/pint.json` e `laravel/CLAUDE.md` non esistono. `bmad-output/sprint-status.yaml` non esiste (il file e' `docs/implementation-artifacts/sprint-status.yaml`).
- Fixcity e Sixteen non esistono in questo repo (moduli: 19; tema: Zero): esempi sostituiti, `62-header-json-content` reso condizionale al precheck del file.
- `find -newermt '-60 minutes'` non funziona (e' bfs): usare `-mmin -60`.
- Le `Modules/*/routes/*.php` non sono "non caricate": `routes/web.php` e `routes/api.php` sono mappate da `XotBaseRouteServiceProvider` (`php artisan route:list --path=api/user/login` risponde); un altro file risponde solo se `web.php` lo include (`require __DIR__.'/socialite.php'`). Corretti `02`, `03`, `38`.
- `mutateFormDataBeforeEdit` non esiste in Filament v5; `CanComment` non esiste; `troubleshooting-login-auth.md` non esiste. Corretti `04-filament`, `07-contracts`, `14-module-dependency-direction`.
- `10-test.md` diceva "mai `uses()->in()` in `Pest.php`" e "ogni file dichiara `uses`": lo stato misurato e' `pest()->extend(TestCase::class)->in(...)` in cinque moduli e `uses(TestCase::class)` in 179 file su 200 in Xot. Il prompt ora riporta regola e stato, senza uniformare in blocco.
- Nella shell degli agent `grep` e' una funzione (`type grep`) che filtra i path ignorati: come secondo metodo si usa `/bin/grep`.

## Lezioni del 2026-10-20 e dove vivono

1. Salto del conteggio PHPStan senza cambi di produzione (10053 errori dopo il pull, 393 file di test con mtime 08:57, 9784 errori in poche cause alla sorgente): `11-phpstan.md`, sezione "Salto improvviso del conteggio", con `find -newermt`, `git diff --stat HEAD -- tests`, `hash-object` piu' `log --find-object` (provato su un blob reale di Notify) e conteggio per identificatore e messaggio. Richiami in `03`, `10-test`, `16-git-forward-only`.
2. Test con SUT assente: scala delle decisioni in `10-test.md`; richiami in `11`, `29`, `53`, `09`, `36`.
3. Concorrenza: gate lock piu' mtime sopra 120 s nel codice in `03-quality-gates.md` (Lock), con le due soglie (file caldo sotto 120 s, lock vivo sotto 60 min) e il limite ai PHPStan paralleli (misurati 33 processi, circa 33 GiB RSS); `46`, `00-start`, `11`.
4. Misure: `rg -P`, mai `2>/dev/null` dove vuoto significa ok, controprova di ogni zero, `/bin/grep`: `20-filesystem.md`; applicato a `14`, `42`, `43`, `45`, `51`, `33`-`37`.
5. Artefatti BMAD solo in `laravel/Modules/<M>/docs/` o `laravel/Themes/<T>/docs/`, nomi senza date, data in frontmatter: `15-bmad.md`; allineati `00`, `19`, `30`, `55`, `99`, `98` e gli altri che citavano `bmad-output/`.
6. `laravel/phpstan.neon` immutabile, nessun baseline: `11-phpstan.md` con comando di prova (`ignoreErrors` e include del baseline commentati; ultima modifica 2026-09-24).

## Verifica (output reale, 2026-10-20)

- `bash bashscripts/quality-gates/audit-prompts.sh --bloated`: 89 prompt, 103 snippet bash, BLOCCANTI 0 (CONFLICT 0, EATEN 0, BROKEN 0, SLUG 0, FRONTMATTER 0), DUPLICATE 0, STUB senza puntatore 0, BLOAT 0, "nessun guasto bloccante". Resta un solo avviso (`prompts-review.story.md` senza `role`).
- Link e path: nessun link relativo rotto; ancore interne tutte valide; restano 4 token di percorso volutamente inesistenti (`helpers/Helper.php` relativo al modulo, `laravel/config/notify-env.php` citato come assente, `sections/header.json` precheck condizionale, `public/manifest.json` esempio).
- `rg -cP '\x{2014}|\x{2013}'` su tutta la cartella: nessun match (controprova positiva su file di prova: trova; `/bin/grep` concorde). Nessuna emoji.
- `grep -rlP '^(<<<<<<< |>>>>>>> )'`: nessun file. `git -C bashscripts diff --check`: pulito. Nessun `*.lock` residuo.

## Wave 3 (post PHPStan Modules = 0)

Dopo la verifica wave3 a zero errori su `analyse Modules`, i prompt sono stati rafforzati cosi' che lo zero non chiuda il lavoro ne' venga dichiarato su un report falso:

- `bashscripts/docs/prompts/00-start.md`: ordine permanente: a zero continua Services→Actions + docs/boy scout; vittoria solo con json `totals` e banner `[OK] No errors`.
- `bashscripts/docs/prompts/11-phpstan.md`: sezione `Vittoria verificata` (calo improvviso a 0 = lane finite **oppure** JSON troncato).
- `bashscripts/docs/prompts/25-services-to-actions.md` e `INDEX.md`: trigger e lezione collegati.
- Traccia locale prompt: `bashscripts/docs/prompts/prompts-review.story.md` (sezione Wave 3).
- Nessuna modifica a `phpstan.neon` ne' a PHP applicativo in questa tranche.

## Wave 4 (boy scout: zombie Services + prompt)

Misura: `/tmp/phpstan_wave4.json`: `file_errors` 0, `errors` 0, exit 0, banner `[OK] No errors`.

- `24-boy-scout.md`: post-zero continua bonifica Services/docs/prompt (ordine permanente).
- `25-services-to-actions.md`: misura viva zero `*Service.php` applicativi (~745 Actions); `ProfileTest` spurio DELETED; Translators/Trend = **DELETE** non relocate a zero callers; gate aggiornato.
- Codice: re-delete Xot `Services/{Translators,Trend,ProfileTest}` + junk tracciato (`FileService.ot_action`, `bashscripts/` accidentale, `cacheservice.md`); `RouteService.php.bak` untracked lasciato (non recuperabile).
- Story: [services-to-actions-global-wave](./services-to-actions-global-wave.story.md), [phpstan-modules-zero-wave3](./phpstan-modules-zero-wave3.story.md).

### Wave 4b (docs-guardian: prompt canonici DRY+KISS)

Nessun prompt nuovo. Solo canonici sotto `bashscripts/docs/prompts/`:

- `00-start.md`: sezione `A zero non ti fermi` (vittoria = json `totals` 0 **e** `[OK] No errors`); Hindsight empty/auth non blocca.
- `11-phpstan.md`: `Anti zombie Service`; coordinator-only `analyse Modules`; anti-pattern tipizzare/relocare zombie.
- `44-module-docs-continuous.md` + `57-second-brain.md`: Hindsight vuoto/auth fail/reflect 500 non ferma docs/QMD/PHPStan.
- Hindsight reflect in sessione: 500 auth: fallback docs+QMD usato (coerente coi prompt).

### Wave 4c (2026-10-20 ~11:52: gate verde + ordine permanente)

<!-- GateGuard: edit existing story linked from 00-start §1.4; user: esegui phpstan analyse Modules e sistema tutte le segnalazioni … sempre senza conferma -->

Rimisura: `analyse Modules` → `0/0` + `[OK] No errors`. Aggiornati
`00-start.md` (**Ricordalo sempre**) e `11-phpstan.md` (SSoT `TestCase` helper).

## Wave 5 (2026-10-20: prompt stickiness; PHPStan ancora zero)

Misura verificata ora: `analyse Modules` → `file_errors` 0, exit 0, banner `[OK] No errors`. Nessun PHP, nessun edit a `phpstan.neon`. Solo stickiness dei prompt cosi' l'ordine permanente non si dimentica:

- `00-start.md`: tabella **Impossibile da dimenticare** → canoni 11 / 25 / 44 / 05; sezione **A zero non ti fermi** in checklist esplicita (boy scout, Services→Actions, docs, REUSE W0, prompt).
- `11-phpstan.md`: HARD Pest helpers = `TestCase` FQCN SSoT (no `scanFiles`); anti-pattern ignore unmatched (`constantTypeCoverage` **oppure** `Out of N possible constant types`) = rimozione umana ignore, non `reportUnmatchedIgnoredErrors: false`.
- `05-livewire-to-filament-widgets.md`: sezione **W0 REUSE: gemelli legali** (`TermsOfService`/`PrivacyPolicy`).
- `44-module-docs-continuous.md`: gate concreto tema Zero: `README.md` = indice (`test -f …/README.md && test ! -e …/00-INDEX.md`).

## Wave 6 (2026-10-20 ~12:10: catena permanente + single-neon)

Misura verificata: `/tmp/phpstan_ord_121026.json` → `file_errors` 0, `errors` 0, banner `[OK] No errors`. Nessun PHP, nessun edit a `laravel/phpstan.neon`, nessun altro `.neon` creato. Nessun prompt nuovo sullo stesso tema.

Stickiness (solo edit ai canonici esistenti):

- `bashscripts/docs/prompts/00-start.md`: **HARD un solo neon**; **Catena permanente** in una riga (`phpstan Modules → 0` → sorgente → swarm disgiunto → BMAD+second brain → docs moduli/temi → improve prompts → a zero boy scout); ciclo automatico a 7 passi; stato vivo aggiornato al fotogramma sopra.
- `bashscripts/docs/prompts/11-phpstan.md`: stessa catena + HARD single-neon in testa; stato vivo `/tmp/phpstan_ord_121026.json`; post-vittoria → boy scout; `related` include `24-boy-scout.md`.
- `bashscripts/docs/prompts/24-boy-scout.md`: posto esplicito nella catena; HARD single-neon; anti-pattern "toccare/creare neon".

## Aperto (fuori scope di questa story)

- `bashscripts/docs/modular-bmad-story-policy.md` ammette ancora epic in `bmad-output/` e date nei nomi: va allineata alla regola dell'utente.
- `CLAUDE.md` di root e `bashscripts/tools/prompts/README.md` citano ancora `docs/wiki/rules` e gli 8 prompt storici.
- `.mcp.json`: `qmd` punta a un binario inesistente e `github` ha un header `Authorization` segnaposto; `bashscripts/docs/mcp-servers.md` dichiara 10 server contro i 21 attuali.
- `bashscripts/tools/claims-open.py` legge solo `docs/bmad/stories/`: le story in `docs/stories/` (come questa) non risultano come claim.
- `Modules/Xot/tests` e `Modules/Cms/tests` hanno anche `pest.php` minuscolo (duplicato riportato dal pull); alcuni file in `Modules/Xot/docs/` contengono ancora marker di conflitto.
- `worklog.py index` scrive i `.md` di `docs/worklog` senza frontmatter; `docs/worklog/2026/10/09/` fallisce `verify`.
- Reindicizzazione QMD non ottenuta: `bash bashscripts/docs/llm-wiki-qmd.sh update` esce con 0 ma le quattro collezioni (`trade-fila5-prompts`, `-bashscripts`, `-modules`, `-wiki`) puntano a `/mnt/nas07/var/www/_bases/base_ptvx_fila5/...`, un altro progetto: 0 nuovi, 0 aggiornati, e una `search` sul testo nuovo non trova nulla. E' il caso descritto in `55-md-conventions.md` (un `update` senza errori non prova l'indicizzazione). Va ripuntato l'indice a questo repo: decisione dell'utente, non toccata qui.
## Prompt 98, run del 2026-10-29

Richiesta dell'utente: "esegui e poi migliora il prompt 98". Fase BMAD: Quick Flow, esecuzione e QA del prompt.

- **Lock:** il lock di questa story era del 2026-10-20 18:05 (`claude-code-080d107f`, task `prompt-98-daily-report-improve`), oltre i 60 minuti: rilasciato e ripreso come `claude-code-fc17112b`. Il prompt non aveva lock ne' modifiche locali; la rivendicazione della story Xot 5.258 (2026-09-30) e' trattata come scaduta, come il 2026-10-22.
- **Esecuzione:** worklog del 2026-10-29 in `docs/worklog/2026/10/29/` (`index.md`, `malebestia.md`), 25 commit di un solo contributore, `verify` OK, controprova su tutti i ref: 8 commit nella radice e 17 nei moduli e in `bashscripts`, nessuno fuori da `dev`. Passo 7 fermato alla misura, scritta in `laravel/Modules/Xot/docs/bmad/stories/docs-100-fleet-merge.story.md` ("Misura del 2026-10-29").
- **Difetti dimostrati dal run e corretti nel prompt:**
  1. Il riallineamento della radice ai moduli (un commit, 11.987 dei 12.089 file del giorno, +181.575 / -346.116 righe) era attribuito a chi lo registra: lo specchio ne riconosceva 36 file. Nuovo blocco "Riallineamento della radice ai moduli e versioni solo nella radice": confronta ogni percorso con lo stato del modulo all'ora del commit e conta i commit di origine per autore e data. Esito: 12.023 percorsi su 12.023 uguali, da 381 commit di modulo (367 di un altro contributore, scritti in altri giorni); il 2026-10-22, 8.489 su 8.489. Il blocco e' stato estratto dal prompt ed eseguito com'e' scritto.
  2. Il vecchio blocco "Versioni solo nella radice" confrontava con l'HEAD di adesso: 5 falsi "diverso" il 2026-10-29, 81 il 2026-10-22. Ora confronta con `git -C <modulo> log -1 --before=<ora> dev`.
  3. `worklog.py detail` attribuisce i file copiati a chi registra il riallineamento («Test aggiunti (57)», 8 propri): avviso nel contratto, correzione di `worklog.py` da aprire.
  4. Il prompt diceva che il report di un giorno passato "non cambia": il registro del 2026-10-22 e' passato da 48 a 109 commit, quello del 2026-10-20 da 134 a 223, per commit di altri cloni arrivati con i pull. Ora l'indice dichiara data e ora della raccolta (applicato al 2026-10-29).
  5. Passo 7: "con commit" vuol dire commit nel repo del modulo; i 6 moduli toccati solo dal riallineamento non contano.
  Quattro righe nuove nella tabella "Errori gia' commessi"; riferimento al blocco rinominato aggiornato; frontmatter `updated: 2026-10-29`. Una sola copia del prompt nel repo (verificato con `find`).
- **Regola d'oro non soddisfatta:** `verify` non passa sui worklog del 2026-10-22 e del 2026-10-20, perche' il registro e' cresciuto dopo la scrittura (difetto 4). Va rieseguito il prompt su due giorni passati (revisione dichiarata, Passo 6): 109 e 223 commit, lavoro da chiedere all'utente.

## Prompt 98, run del 2026-11-03

Richiesta dell'utente: "prima esegui e poi migliora il prompt 98". Fase BMAD: Quick Flow, esecuzione e QA del prompt.

- **Lock:** prompt e story liberi; lock presi come `claude-code` (task `prompt-98-run-2026-11-03`) e rilasciati a fine run. Misura del Passo 7 scritta con lock su `docs-100-fleet-merge.story.md`.
- **Esecuzione:** worklog del 2026-11-03 in `docs/worklog/2026/11/03/` (`index.md`, `malebestia.md`), 14 commit di un solo contributore in 10 repository, tutti su `dev` e pubblicati, `verify` OK, registro coerente. Il commit della radice `1d46494e10` e' un riallineamento: 515 percorsi su 515 uguali ai moduli, 473 con l'ultima versione da 26 commit di un altro contributore. Passo 7 fermato alla misura ("Misura del 2026-11-03" in `laravel/Modules/Xot/docs/bmad/stories/docs-100-fleet-merge.story.md`): link rotti invariati in 6 moduli su 7, +1 in Geo.
- **Difetti dimostrati dal run e corretti nel prompt:**
  1. Il secondo ciclo del blocco "Riallineamento della radice ai moduli" contava i commit copiati con una finestra di tempo: 0 commit per Cms, UI e Lang, che avevano 14 file copiati, e un commit di Notify su un file che la radice non traccia. Ora ogni percorso va al commit di modulo che lo ha cambiato per ultimo prima del commit della radice. Provato su tre giorni: 2026-11-03 (515 percorsi), 2026-10-29 (12.023, circa 2 minuti; 140 versioni copiate contro i 381 commit della finestra), 2026-10-22 (8.489).
  2. Il contratto chiedeva di escludere l'hash del riallineamento dal Passo 1, ma il blocco non lo permetteva. Nuova variabile `SKIP` e riga dei volumi propri: 13 commit, 51 file, +2560 / -1435, 7 test, uguali al conteggio a mano.
  3. Il totale della tabella del Passo 7 era sommato a mano (stub 1233 invece di 1243, corretto prima di chiudere). Nuovo blocco che stampa righe e totale dal registro e dal JSON di `docs-organizer.py audit`.
  4. I commit del run stesso cadono nel giorno del report: il registro del 2026-10-29 e' passato da 25 a 30 commit per 5 commit delle 16:20 (worklog, prompt, story, misura), dopo la raccolta delle 15:53. Nuovo paragrafo nel Passo 6: avvisare l'utente e, dopo il commit, rilanciare raccolta, `index --merge` e `verify`.
  5. Con `REG` vuoto il blocco del Passo 1 stampava " commit propri, + / -" senza errore e creava un file `.files` vuoto nella radice (creato da questo run e cancellato). Ora i blocchi del Passo 1 e del Passo 7 si fermano con `: "${REG:?...}"`; provato con e senza registro.
  Cinque righe nuove nella tabella "Errori gia' commessi", bullet su `detail` aggiornato con la misura del giorno (257 test, 7 propri), frontmatter `updated: 2026-11-03`. I tre blocchi modificati sono stati eseguiti cosi' come sono scritti nel prompt. Una sola copia del prompt nel repo (verificato con `find`).
- **Regola d'oro non soddisfatta:** `verify` sul 2026-10-29 da' 7 problemi (registro da 25 a 30 commit, difetto 4) e sul 2026-10-22 10 problemi (registro da 48 a 109 commit). Va rieseguito il prompt su due giorni passati, con revisione dichiarata (Passo 6): 30 e 109 commit, lavoro da chiedere all'utente. Anche il 2026-11-03 cambiera' quando verranno committati i file di questo run.
- **Aperto:** il worklog del 2026-10-29 scrive "da 381 commit di modulo": con il blocco nuovo sono 140 versioni copiate. Va corretto alla prossima revisione di quel giorno.
