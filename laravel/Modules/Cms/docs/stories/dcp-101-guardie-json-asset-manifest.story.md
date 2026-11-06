---
id: dcp-101
title: "Guardie filesystem su JSON delle pagine, asset e manifest Design Comuni"
type: story
epic: dc-parity-v2
status: in-review
priority: P0
owner: module:Cms
module: Cms
created: 2026-10-13
updated: 2026-10-13
tags: [cms, json, slug, asset, manifest, guardia, tdd]
qmd: "dcp-101 guardie json slug duplicato asset 0 byte manifest design-comuni-pages blade view pub_theme tests tenant modulo identici"
related:
  - Themes/Sixteen/docs/bmad/stories/dcp-09-json-content-integrity-guard.story.md
  - Themes/Sixteen/docs/bmad/stories/dcp-08-asset-integrity-and-fonts.story.md
  - Themes/Sixteen/docs/bmad/decisions/parity-root-cause-and-guardrails.md
  - Modules/Cms/docs/json-content-slug-uniqueness.md
  - Modules/Fixcity/tests/Unit/TicketCreatePageMiddlewareGuardTest.php
---

# DCP-101: guardie su JSON, asset e manifest

## Richiesta (2026-10-13)
Gli incidenti del giorno (500 "CMS content collision", PNG a 0 byte dopo `npm run copy`, manifest e JSON non allineati) si trovavano solo guardando la pagina.
Servono test che li facciano emergere nel codice, senza database ne' HTTP. Realizza in parte DCP-09 (guardia JSON) e DCP-08 (asset senza 0 byte).

## Test
File: `laravel/Modules/Cms/tests/Unit/Content/ContentIntegrityGuardTest.php` (Pest, solo filesystem; radice = `dirname(__DIR__, 5)` = `laravel/`).

| Guardia | Incidente che protegge | Cosa lo fa fallire |
|---|---|---|
| (a) nessuno slug duplicato nella stessa cartella `content/pages` (tutti i `config/*/*` e `Modules/*/config`) | `homepage.json` + `tests.homepage.json` (poi `risultati-ricerca`) con lo stesso `slug`: 500 per tutti | due file con lo stesso `slug`; il messaggio nomina entrambi |
| (b1) `tests.*.json` identici tra tenant e modulo che hanno entrambe le copie | il tenant vince sul modulo: una copia divergente cambia la pagina senza che nessuno se ne accorga | differenza di contenuto; il messaggio elenca le chiavi di primo livello diverse |
| (b2) ogni `tests.<x>.json` e' JSON valido con `id` e `slug` uguali a `tests.<x>` | nome canonico delle pagine di prova | JSON non valido, `id` o `slug` diversi dal nome file |
| (c) nessun file da 0 byte sotto `Themes/Sixteen/public/design-comuni/assets` | `npm run copy` ha azzerato due PNG (sorgente vuota); sfondo e immagini mancanti | un file di qualunque tipo (immagini, font, svg) a 0 byte; la cartella vuota fa fallire |
| (d1) ogni riga di `design-comuni-pages.txt` ha `tests.<slug>.json` in tenant `local/fixcity` e modulo Fixcity | manifest e JSON non allineati | JSON mancante in una delle due cartelle |
| (d2) ogni `tests.*.json` del tenant e' nel manifest, tranne le eccezioni documentate | JSON orfano, o riga cancellata dal manifest | JSON senza riga e senza eccezione; eccezione "stantia" (ora nel manifest o JSON sparito) |
| (e) ogni `view` che inizia con `pub_theme::components.` in `content_blocks`, `sidebar_blocks` e `footer_blocks` ha il suo `.blade.php` in `Themes/Sixteen/resources/views/components/` | un blocco cancellato o rinominato rompe la pagina in produzione | file Blade mancante; il messaggio dice JSON, percorso della chiave e file atteso |

Test di sanita' (evitano guardie che non controllano nulla): trovate le cartelle Fixcity tenant e modulo e almeno una coppia; almeno una chiave `view` nei `content_blocks`; manifest e `assets` non vuoti.

## Criteri e decisioni
- **Identita' (b1)**: JSON decodificato, ordine delle chiavi degli oggetti ignorato (ricorsivo), ordine delle liste e tipi rispettati (`1` diverso da `1.0`), chiave presente in una sola copia = differenza. Non si confrontano i byte. `tests.homepage.json` differisce nei byte (posizione di `description`) ma e' lo stesso JSON: passa.
- **Slug dal manifest**: `<nome senza .html>`; `index.html` -> `index`; `<cartella>/index.html` -> `<cartella>-index` (quindi `servizi/index.html` -> `servizi-index`).
- **Eccezioni (d2)**, lista esplicita nel test con il motivo (`contentGuardManifestExceptions`):
  - `catalog`: voci di catalogo verso le altre pagine di prova, non replica un riferimento (DCP-25, DCP-80);
  - `pagamenti-multa-pagamento`: derivata da `servizi-pagamento-pagamento`, il riferimento risponde 404 (DCP-28).
- Cartelle senza `tests.*` (oggi `config/eu/fixcity`) passano (b1) e (b2) per costruzione: la guardia confronta solo cio' che esiste in entrambe le copie.
- (e) controlla anche `sidebar_blocks` e `footer_blocks` (stessa semantica di `content_blocks`, costo zero). Il nome della vista e' mappato in modo esatto (`a.b.c` -> `a/b/c.blade.php`), come `view()`.

## Esecuzione
```
cd laravel && APP_ENV=testing DB_CONNECTION=sqlite APP_CONFIG_CACHE=/tmp/dcp101-nonexistent.php ./vendor/bin/pest Modules/Cms/tests/Unit/Content/ContentIntegrityGuardTest.php
cd laravel && ./vendor/bin/phpstan analyse Modules/Cms/tests/Unit/Content/ContentIntegrityGuardTest.php --no-progress
```
`APP_CONFIG_CACHE` inesistente: la cache di config dello sviluppo farebbe puntare i test al DB di sviluppo. I test non usano il database.

## Verifica (output reali, 2026-10-13)
**Rosso poi verde** su una copia in `scratchpad/dcp101-copy/laravel` (stessa struttura, file veri mai toccati), un difetto per guardia:

| Difetto iniettato nella copia | Esito rosso |
|---|---|
| `tests.eventi.json` copiato come `eventi-doppione.json` nel tenant | (a) `slug [tests.eventi] dichiarato da .../eventi-doppione.json e .../tests.eventi.json` |
| `description` cambiata in `Modules/Fixcity/.../tests.novita.json`; `id` cambiato in `tests.argomenti.json` del tenant | (b1) `tests.novita.json ... differiscono (chiavi: description)` e `tests.argomenti.json ... (chiavi: id)`; (b2) `id e ["tests.argomenti-x"], atteso [tests.argomenti]` |
| un file di `assets/images` troncato a 0 byte | (c) `File da 0 byte: .../images/cie.svg` |
| `tests.mappa-sito.json` tolto dal modulo; `tests.orfana.json` aggiunto al tenant | (d1) `riga [sito/mappa-sito.html] -> manca Modules/Fixcity/.../tests.mappa-sito.json`; (d2) `tests.orfana.json non ha una riga nel manifest` |
| `blocks/events-page/design-comuni.blade.php` rinominato | (e) `vista [pub_theme::components.blocks.events-page.design-comuni] -> manca Themes/Sixteen/.../design-comuni.blade.php` su tenant e modulo |

Risultato: `8 failed, 8 passed (944 assertions)` (i `passed` sono le cartelle e le guardie non toccate). Ripristinata la copia dai file veri: `16 passed (942 assertions)`.

**Stato reale**: `Tests: 16 passed (942 assertions)`, 0,26 s. PHPStan sul file: `[OK] No errors`.

## Difetti veri trovati
Le sette guardie sono verdi sullo stato reale: nessun duplicato di slug, nessuna coppia tenant/modulo diversa (a parte l'ordine delle chiavi di `tests.homepage.json`), nessun asset a 0 byte, nessuna riga di manifest senza JSON, nessuna vista `pub_theme::components.*` mancante. Non corretto nulla.
Osservazioni fuori dalle guardie, da decidere con i proprietari:
1. **Vista inesistente fuori dal prefisso `pub_theme`**: `laravel/config/eu/fixcity/database/content/pages/1.json:17` (pagina `home`, tenant `eu`, dati del 2024-12) usa `fixcity::components.blocks.ticket_list.agid` e il file non esiste (`Modules/Fixcity/resources/views/components/blocks/` ha solo `footer/agid` e `headernav/agid`). La guardia (e) copre solo `pub_theme::components.` come da richiesta: estenderla a `fixcity::` la farebbe diventare rossa su questo file.
2. **Falso positivo dello script** `dcp0-manifest-check.sh`: elenca `servizi-index` come "senza riga nel manifest" perche' il suo `sed` riduce `servizi/index.html` a `index`. Il test calcola lo slug con la regola corretta: le eccezioni reali sono due (`catalog`, `pagamenti-multa-pagamento`).
3. **Solo nel modulo, senza copia tenant e senza riga nel manifest**: `Modules/Fixcity/config/database/content/pages/tests.segnalazione-conferma.json`, `tests.segnalazione-dati.json`, `tests.segnalazione-privacy.json`, `tests.segnalazione-riepilogo.json` (nel manifest i nomi sono `segnalazione-01..04-*`), piu' `tests.json` (slug `tests`, forma legacy; l'indice vero e' `tests.index`). Non rompono nulla (nessuno slug duplicato); (d2) guarda solo il tenant.
4. `Modules/Fixcity/config/database/content/pages/home.json.lock` (lock di `codex` del 2026-10-09) e' un file residuo nella cartella dei contenuti; non e' `*.json`, quindi ignorato.

## Limiti noti
- Mapping tenant -> modulo con `ucfirst` del nome cartella (`fixcity` -> `Fixcity`): un modulo con nome composto va mappato a mano nel test.
- (d) e' fissato su `config/local/fixcity` e `Modules/Fixcity` (come il manifest); righe duplicate nel manifest non sono controllate.
- Un test del modulo Cms legge dati di Fixcity e del tema Sixteen: se i moduli vengono estratti in repo separati la guardia va spostata dove vive la sua radice (`laravel/`).
- La guardia non sostituisce il gate di parity (HTML/visual): protegge solo l'integrita' dei dati.

## Second brain
Nessuna scrittura in `MEMORY.md` ne' negli indici globali (fuori proprieta'). Da annotare dal proprietario: "guardie DCP-101: `Modules/Cms/tests/Unit/Content/ContentIntegrityGuardTest.php`, lanciare dopo ogni modifica a `content/pages`, manifest o `npm run copy`".
