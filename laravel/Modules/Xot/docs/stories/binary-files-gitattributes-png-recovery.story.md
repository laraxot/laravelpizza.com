---
title: "Xot - PNG corrotti dalla conversione fine riga: attributi e recupero"
module: Xot
bmad: true
status: done
date: 2026-11-05
owner: Modules/Xot (politica .gitattributes di moduli e temi)
---
# PNG corrotti dalla conversione fine riga

- Fase BMAD: Quick Flow (analisi, causa, fix, verifica)
- Branch: dev

## Problema

`git status` mostrava come modificati PNG che nessuno aveva toccato, con il
warning "CRLF will be replaced by LF". Controllando la firma dei file:
**697 dei 764 PNG tracciati erano già corrotti in HEAD**. La firma era
`\x89PNG\n\x1a\n` invece di `\x89PNG\r\n\x1a\n`: Git aveva tolto i CR come se
fossero file di testo. Tra i file rotti c'erano asset usati a runtime: icone e
loghi Fixcity, `marker-icon.png` e `layers.png` di Leaflet nel modulo Geo,
favicon, `logo.png` di Xot e illustrazioni di UI e User.

## Causa radice

Tre regole, combinate:

1. `laravel/.gitattributes` imposta `* text=auto eol=lf`.
2. I `.gitattributes` di 15 moduli/temi, dopo `*.png binary !filter`, avevano
   righe `*.png !text !filter !merge !diff`. Il prefisso `!` rende l'attributo
   **non specificato**: annulla il `binary` della riga precedente.
3. Con `text` non specificato ed `eol=lf` ereditato, Git tratta il file come
   testo e converte i fine riga al commit.

In più `laravel/Themes/Sixteen/.gitattributes` conteneva marcatori di
conflitto di merge mai risolti (`<<<<<<<`, `=======`, `>>>>>>>`).
`laravel/Modules/Xot/.gitattributes` aveva solo le righe `!text`, senza regole binary.

## Modifiche

- `.gitattributes` (root): regole `binary` per immagini, font, pdf, zip, sqlite, db, rvf.
- 16 `.gitattributes` di moduli e temi: tolte le righe `*.ext !text !filter !merge !diff`;
  in Xot e nel pacchetto `coolsam/panel-modules` aggiunto il blocco `binary !filter`;
  in Sixteen risolto il conflitto tenendo il ramo con le regole binary
  (scartato il ramo con `filter=lfs`, Git LFS è vietato dal canone).
  Ogni blocco porta un commento che spiega perché le righe `!text` non vanno rimesse.
- 675 PNG ripristinati dalla cronologia. Per ogni file si è presa la versione
  più recente che (a) ha firma PNG valida, (b) togliendo i CRLF coincide byte per
  byte con il blob attuale, quindi è la stessa immagine, (c) supera il controllo
  CRC di tutti i chunk e la decodifica completa con Pillow. Fonti: cronologia
  completa di questo repository, poi quella dei repository dei singoli moduli
  (`laraxot/module_*_fila5`, `laraxot/theme_*_fila5`).
  Il criterio (c) serve: alcune versioni "sane" della cronologia avevano CR in
  più (conversione LF→CRLF al contrario) e non si decodificavano.

## Verifica

- `git check-attr text` su tutti i 1.012 file binari tracciati: `unset` o `auto`, nessuno `set`/non specificato.
- `git status` non mostra più PNG modificati senza intervento.
- I 675 PNG ripristinati si decodificano tutti (Pillow `load()` + CRC dei chunk).

## Aperto

- **22 PNG non recuperabili**: nessuna versione integra esiste in nessuna
  cronologia, perché erano già corrotti al primo commit. Sono screenshot di
  documentazione, più `Themes/Sixteen/scripts/fixcity-admin-ticket-create-map.png`.
  Vanno rigenerati con gli strumenti di visual parity:
  - `Modules/Cms/docs/screenshots/design-comuni/reference-homepage.png`
  - `Modules/Fixcity/docs/assets/ticket-step-dati-after-fix--28*.png` (3)
  - `Modules/{Job,Lang,Media,Notify,Tenant}/docs/**/screenshots/event-detail-page.png` (6)
  - `Themes/Sixteen/docs/{comparisons,prompts,visual-parity}/**` (7)
  - `Themes/Sixteen/scripts/fixcity-admin-ticket-create-map.png`
  - `Themes/TwentyOne/docs/screenshots/{01-homepage,09-blog,f1-world-champion-2026-options}.png`
- **9 file `.png` che non sono immagini**: contengono una frontmatter Markdown
  (`---\nmodule: theme ...`), scritta da uno strumento di docs che ha trattato il
  PNG come `.md`, oppure un puntatore Git LFS. Esempi: `Modules/Blog/docs/img/1723028968367.png`,
  `Modules/Cms/docs/screenshots/event-detail-page.png`, `Modules/Geo/docs/img/debug-segnalazione-crea.png`.
  Lo strumento che aggiunge frontmatter deve escludere i file non `.md`.
- **Repository dei moduli**: i `.gitattributes` e i PNG corrotti sono anche nei
  repository `laraxot/module_*_fila5` e `laraxot/theme_*_fila5`. Il prossimo
  "mirror al root" li riporterebbe qui. La stessa correzione va applicata a
  monte, e il template `bashscripts/templates/sync-gitattributes-modules.sh`
  non deve più generare righe `!text`.

## Aggiornamento 2026-11-05 - bonifica dei file presenti nel checkout

- Fase BMAD: Quick Flow, implementazione e verifica; owner Xot.
- Tutti i `.gitattributes` root di `laravel/Modules/*` e `laravel/Themes/*` sono stati
  riallineati alla policy `binary !filter`; i file annidati di `Geo/docs`, `Geo/resources`
  e `Xot/packages` sono stati lasciati nel loro perimetro.
- Rimossi i marker di conflitto e le vecchie righe `!text !filter !merge !diff` che
  annullavano `binary` e permettevano conversioni CRLF/LF sui binari.
- Rimossi i blocchi locali `[lfs]` dai repository annidati senza eseguire comandi
  `git lfs`; la configurazione globale/system non è stata modificata.
- Verifica `.gitattributes` nativa su tutti i repository: nessun marker e nessun attributo
  attivo `filter=lfs`, `diff=lfs` o `merge=lfs`.
- Rischio residuo separato: `check-no-git-lfs.sh` rileva ancora due pointer LFS già
  presenti in `Modules/Weighing/laravel/Modules/Geo/docs/img/`; non sono stati alterati
  perché questa tranche riguarda esclusivamente gli attributi Git.

## Aggiornamento 2026-11-10 - correzione a monte nei repository dei moduli

- Fase BMAD: Quick Flow, implementazione e verifica; owner Xot.
- Dopo il pull dei moduli la root mostrava 1.797 modifiche. Fra queste, **453 binari
  integri in root ma corrotti nei repository dei moduli** (`\r\n` → `\n`, esattamente
  il rischio "mirror al root" segnalato sopra). Committare il mirror così com'era
  avrebbe annullato il recupero del 2026-11-05.
- Ripristinati nel working tree dei moduli 458 binari, ognuno solo se la versione
  corrotta coincide byte per byte con la sorgente integra dopo `CRLF→LF` (quindi è la
  stessa immagine):
  - 453 dalla root `HEAD`;
  - `Geo/public/assets/images/{layers,layers-2x,marker-shadow}.png` da
    `Geo/node_modules/leaflet/dist/images/` (Leaflet 1.9.4);
  - `Geo/public/assets/images/marker-icon{,-2x}.png` da `Geo/resources/css/images/`
    (icone personalizzate, diverse da quelle di Leaflet).
  Repository toccati: Blog (16), Cms (2), Gdpr (2), Geo (53), Job (3), Lang (2),
  Notify (17), Rating (1), Tenant (3), UI (24), User (4), Sixteen (322), TwentyOne (9).
- Il pull aveva riportato le righe `*.ext !text !filter !merge !diff` nei
  `.gitattributes` di **Blog** e **Comment**: tolte di nuovo; `git check-attr text`
  sui `.png` torna `unset`.
- Ancora non recuperabile: `Cms/docs/screenshots/design-comuni/reference-homepage.png`
  (corrotto dal primo commit, già nell'elenco dei 22 sopra).
- Rischio residuo: lo strumento di sync che rimette `!text` nei `.gitattributes` dei
  moduli non è nel checkout (`bashscripts/templates/` non esiste); finché non viene
  corretto a monte, ogni pull va ricontrollato con la verifica della firma PNG.
