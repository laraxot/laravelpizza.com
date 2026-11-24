---
title: "Verifica indipendente — hook getTable* nelle List page (cross-check di 5.254)"
type: story
module: Xot
status: done
created: 2026-09-29
updated: 2026-09-29
tags: [quality, filament, verification, cross-check]
related:
  - "./5.254-list-page-table-hooks.story.md"
  - "./5.255-doppi-header-actions-list-page.story.md"
  - "../filament-list-page-table-ownership.md"
  - "../../../../User/docs/bmad/stories/user-filament-boundary-i18n-20260929.story.md"
  - "../../../../../docs/wiki/audits/getTable-methods-audit-2026-09-29.md"
---

# Verifica indipendente — hook `getTable*` nelle List page

## Obiettivo del task ricevuto

Enumerare tutti i moduli/temi, trovare le `Pages/List*.php` con hook `getTable*`
residui non delegati a una `Tables/<Plurale>Table.php` (SSoT), correggerle dove sicuro,
documentare dove bloccato, scrivere/estendere la regola canonica.

## Cosa ho trovato lavorando in autonomia

Scansione `grep`-based (definizioni reali di funzione, non commenti) su
`laravel/Modules/*` + `laravel/Themes/*`, pattern `*/Pages/*List*.php` (intercetta sia
`List*.php` che `BaseList*.php`): **6 violazioni, tutte in `Ptv`** (dettaglio in
`docs/wiki/audits/getTable-methods-audit-2026-09-29.md`).

Prima di correggerle ho controllato lock/claim (`bashscripts/lock/`, `docs/chat/*.md`,
story esistenti per soggetto) e trovato la story `5.254-list-page-table-hooks.story.md`
(questo modulo), già `status: done`, che documenta lo **stesso identico set di 6 file**
individuato con un metodo indipendente (tokenizer PHP, non grep) e già corretto.

Verificato con `stat` che i 6 file erano stati scritti pochi secondi prima della mia
lettura (13:59:09–16 UTC contro un `date` di 13:59:33 UTC): collisione reale con una
sessione concorrente, non ipotetica. Per il protocollo "codice già su disco → non
toccare" non ho applicato nessun fix: ho invece fatto da secondo paio d'occhi.

## Verifica di merito (non fidarsi del "done" dichiarato)

- Rilettura dei 6 file: 0 metodi `getTable*` residui.
- Confronto riga per riga fra ciò che è stato rimosso dalle pagine (`git diff`) e ciò
  che è presente nelle rispettive `Tables/*Table.php`: nessuna perdita di colonne,
  filtri o azioni.
- Caso studiato a mano: `BaseListOptions::getTableFilters()` faceva
  `[...parent::getTableFilters(), ...]`; risalendo la catena (`PtvBaseYearListRecords`
  → `XotBaseListRecords`) non c'è nessuna implementazione di quel metodo prima dello
  stub vuoto → equivalente confermato, nessuna regressione.
- Rilancio dello scan grep-based su tutto `Modules`+`Themes` dopo il fix: **0
  violazioni**.

## Perché la story `User/user-filament-boundary-i18n-20260929.story.md` diceva "0
## violazioni su 154 pagine" quando le 6 di Ptv esistevano ancora

Quella story userà quasi certamente un glob che richiede che il nome file **inizi**
per `List` (`Pages/List*.php`), che non intercetta `BaseList*.php`. Il numero "154" è
quindi una sottostima del perimetro coperto in quella sessione, non un falso negativo
sul perimetro che dichiarava di scansionare. Segnalato qui per second brain: chi audita
questo pattern deve usare un glob a sottostringa o il tokenizer di 5.254, non
`Pages/List*.php` stretto.

## Regola canonica

Già esistente e sufficiente: `laravel/Modules/Xot/docs/filament-list-page-table-ownership.md`
(dal 2026-09-10), rafforzata dalla story 5.254 con la catena di chiamate Filament
verificata riga per riga nel vendor e dalle memorie
`Xot/docs/wiki/memories/tabella-appartiene-alla-resource-non-alla-pagina.md` e
`header-actions-doppi-filament-5.md`. Non duplicata.

## Verifica gate

- Nessun codice modificato da questa sessione (il fix era già presente e corretto).
- PHPStan/Pest sui 6 file: già eseguiti e verdi dalla sessione che ha applicato il fix
  (vedi 5.254 — Acceptance Criteria). Non rieseguiti qui per non introdurre lock su un
  modulo (`Ptv`) con un working tree già sporco di modifiche non correlate a questo
  task (vedi nota sotto).
- Host di lavoro: non `10.100.200.15` (verificato `hostname`), quindi Pest non era
  comunque skippabile per policy — ma non è stato necessario rieseguirlo perché non è
  stato toccato nulla.

## Nota operativa — working tree Ptv già sporco

`git status` in `laravel/Modules/Ptv` mostra, al momento di questa verifica, numerose
modifiche non correlate a questo task (file cancellati/modificati che sembrano lavoro
di un'altra sessione in corso, oltre ai 6 file di 5.254). Per questo non è stato
eseguito alcun `git add -A`/commit su Ptv da questa sessione: un commit ampio avrebbe
rischiato di cristallizzare lavoro altrui incompleto. Il commit dei 6 file rientra
nella responsabilità della sessione che li ha scritti (story 5.254).

## Blocco git — non risolto qui, documentato

Il repo locale di `laravel/Modules/Xot` è divergente da `laraxot/dev` (1 commit locale
contro **257 commit** solo sul remoto, con file cancellati/spostati che non esistono
più nel working tree locale, es. `Datas/XotData.php`, `Helpers/Helper.php`). Un
`git pull --rebase --autostash` si interrompe perché il checkout del rebase
sovrascriverebbe file non tracciati localmente ma presenti sul remoto (nuove story e
test BMAD di altre sessioni). Il push del solo commit di questa story è stato
**rifiutato** (`non-fast-forward`), come previsto dal protocollo: **non forzato**.

Il commit `07636d035` ("docs(bmad): independent verification of getTable* ...") resta
**locale, non pushato**. Non è stato tentato nessun merge/rebase/reset per riconciliare
i 257 commit di differenza: è fuori perimetro per questo task e il rischio di perdere
lavoro di altre sessioni è alto. Segnalato per chi gestisce la sincronizzazione fleet
(vedi `docs/chat/multi-agent-standing-coordination.md` in root, dove sono già loggati
incidenti simili di divergenza oggi).

## Esito per l'utente

0 fix applicati da questa sessione (nulla da fare: già fatto e verificato altrove),
1 audit di cross-verifica indipendente completato e documentato, 1 discrepanza
metodologica segnalata (glob strict vs substring nella story User), 0 regole
duplicate.
