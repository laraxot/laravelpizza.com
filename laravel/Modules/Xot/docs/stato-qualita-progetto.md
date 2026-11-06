---
title: "stato qualita progetto 2026 08 31"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "stato qualita progetto 2026 08 31"
issues: []
discussions: []
status: draft
---

# Stato di qualita' del progetto: misurazione 2026-08-31

**Domanda**: il progetto e' perfetto?
**Risposta**: no. Segue la misurazione, non l'opinione.

Ogni numero in questa pagina e' riproducibile con il comando indicato. Dove non c'e'
un comando, il dato non e' stato verificato e non compare.

---
## Quadro dimensionale

| Metrica | Valore | Comando |
|---|---|---|
| Moduli | 53 | `ls laravel/Modules \| wc -l` |
| File PHP nei moduli | 18052 | `find Modules -name '*.php' -not -path '*/vendor/*' \| wc -l` |
| File PHP nei temi | 1023 | `find Themes -name '*.php' -not -path '*/vendor/*' \| wc -l` |
| File di test | 1243 | `find Modules Themes -path '*/tests/*' -name '*Test.php' \| wc -l` |

---

## 1. Il gate di qualita' copre meno di quanto sembri

`phpstan.neon` dichiara `paths: - ./Modules/`. I temi non sono mai analizzati.

```bash
cd laravel && ./vendor/bin/phpstan analyse --memory-limit=-1              # [OK] No errors
cd laravel && ./vendor/bin/phpstan analyse --memory-limit=-1 Themes/      # 1330 errori
```

Il primo comando e' quello che il progetto considera la verifica canonica, ed e'
verde. Il secondo scopre 1330 errori a livello max. Il 2026-08-31 in quell'area sono
stati trovati e corretti cinque difetti fatali a runtime, tra cui il login SPID e CIE
non funzionante e un identificatore corrotto `$this__(`.

Dettaglio e piano: [Themes/docs/phpstan-non-analizza-i-temi.md](../../../Themes/docs/phpstan-non-analizza-i-temi.md).

**Azione**: aggiungere `./Themes/` ai `paths`, con baseline se il volume va assorbito
per gradi. La modifica a `phpstan.neon` spetta al responsabile del progetto.

**Priorita': massima.** Un gate che non copre un'area non protegge quell'area, e la
copertura mancante non e' visibile da nessuna parte.

---

## 2. Collisioni di nome per sola differenza di maiuscole

Il progetto ha una regola esplicita contro le varianti di case
(`no-case-variations`, `case_sensitive_naming_critical`). Stato attuale:

```bash
cd laravel && find Modules Themes -name '*.php' -not -path '*/vendor/*' \
  | awk '{print tolower($0)}' | sort | uniq -d | wc -l     # 113
cd laravel && find Modules Themes -type d -not -path '*/vendor/*' \
  -not -path '*/node_modules/*' | awk '{print tolower($0)}' | sort | uniq -d | wc -l   # 55
```

113 coppie di file e 55 directory differiscono solo per maiuscole. Di quelle coppie,
**97 hanno contenuto identico** (pura duplicazione) e **16 sono divergenti** (due
verita' diverse sotto lo stesso nome logico).

Su Linux convivono. Su filesystem case-insensitive: macOS di default, Windows: un
clone del repository e' corrotto in partenza: i due file collidono e uno sovrascrive
l'altro in modo non deterministico.

I 16 divergenti, che vanno riconciliati leggendo il contenuto e non a colpo d'occhio:

```
Modules/Activity/tests/fixtures/ListLogActivitiesActionTestPage.php
Modules/Activity/tests/fixtures/ListLogActivitiesActionTestResource.php
Modules/Activity/tests/fixtures/ListLogActivitiesActionTestResourceSimple.php
Modules/Activity/workbench/app/providers/WorkbenchServiceProvider.php
Modules/Cms/app/config/xra.php
Modules/Cms/tests/Unit/dashboardtest.php
Modules/Cms/tests/Unit/exampletest.php
Modules/Employee/app/Filament/Resources/WorkHourResource/Pages/TimeclockPage.php
Modules/Gdpr/tests/Feature/conflictresolutiontest.php
Modules/Notify/resources/views/emails/templates/widgets/newfeaturestart.blade.php
Modules/Notify/tests/Feature/emailtemplatestest.php
Modules/Notify/tests/Feature/jsoncomponentstest.php
Modules/Tenant/tests/Unit/domaintest.php
Modules/User/tests/Feature/Database/migrations/UserMigrationSyntaxTest.php
Modules/Xot/lang/en/labels/backend/takeaway/ingredient.php
Modules/Xot/tests/pest.php
```

Le 97 identiche si eliminano tenendo la variante conforme a PSR-4 (`Fixtures/`,
`DataObjects/`, `Unit/`, `Feature/`) e cancellando l'altra.

Nota collegata: `Modules/Blog/app/dataobjects/` viola anche la regola
`dataobjects-folders-prohibited`.

**Priorita': alta.** E' l'unico difetto dell'elenco che rende il repository
inutilizzabile su una piattaforma intera.

---

## 3. Distanza tra regole dichiarate e codice

Le regole del progetto sono scritte. Il codice non le segue ovunque. Numeri:

| Regola dichiarata | Violazioni | Comando |
|---|---|---|
| Niente classi `*Service`, usare Queueable Actions | 56 file | `find Modules -path '*/Services/*.php' -not -path '*/vendor/*' \| wc -l` |
| Mai estendere Filament direttamente, usare `XotBase*` | 10 su 387 (2.6%) | `grep -rln 'extends Resource\b' Modules/*/app/Filament` |
| Mai `->label()`, usare i file di traduzione | 2085 occorrenze | `grep -rn '\->label(' Modules/*/app/Filament \| wc -l` |
| `$casts` come proprieta' e' deprecato, usare `casts()` | 18 file | `grep -rln 'protected \$casts' Modules Themes \| wc -l` |
| Niente `env()` fuori da `config/` | 45 occorrenze | `grep -rn 'env(' Modules Themes \| grep -v '/config/' \| wc -l` |

Il caso `->label()` merita una decisione esplicita, non una campagna di correzione:
2085 occorrenze non sono una svista, sono la prova che la regola non e' mai stata
applicata. O si applica davvero, con un test che la fa rispettare, o si ritira. Una
regola scritta e disattesa costa piu' di una regola assente, perche' insegna che le
regole del progetto sono decorative.

Lo stesso vale per le 56 classi `*Service`: vanno convertite o la regola va
circoscritta a cio' che e' davvero business logic, distinguendola dai wrapper di
infrastruttura.

**Priorita': media, ma la decisione va presa subito.** La conversione puo' essere
graduale; l'ambiguita' no.

---

## 4. Le regole non sono verificate da nulla

Nessuna delle regole del punto 3 ha un test che la fa fallire. Sono documenti, non
vincoli. Finche' e' cosi', il numero di violazioni puo' solo crescere.

**Azione**: per ogni regola che si decide di tenere, un test Pest in
`Modules/Xot/tests/` che scandisce l'albero e fallisce sulla violazione. Un test per
regola, con il conteggio attuale come soglia iniziale da abbassare, cosi' il debito
esistente non blocca il lavoro ma non puo' aumentare.

Questo e' l'intervento con il rapporto valore/sforzo piu' alto dell'intera pagina:
trasforma cinque documenti in cinque garanzie.

---

## 5. La documentazione e' cresciuta senza potatura

`Modules/Xot/docs/` contiene 2688 file. Tra questi convivono
`00-index.md`, `00-INDEX.md`, `00-index-v2.md`, `00-master-index.md`,
`00-MASTER-INDEX.md`, e cinque roadmap PHPStan distinte
(`phpstan-roadmap.md`, `phpstan-roadmap-completo.md`, `phpstan-fix-roadmap.md`,
`phpstan-errors-resolution-roadmap.md`,
`phpstan-xotbasewidget-view-string-fix-roadmap.md`) piu' quattro varianti di
`product-roadmap`.

Il costo non e' lo spazio su disco: e' che nessuno sa quale documento sia vero. Una
documentazione con cinque risposte alla stessa domanda ha lo stesso valore
informativo di nessuna documentazione, con in piu' il costo di leggerla.

**Azione**: per ogni gruppo di duplicati scegliere un owner canonico, fondere il
contenuto vivo, e sostituire gli altri con un rimando di una riga. Le regole del
progetto lo prevedono gia' (`docs-naming-convention`, `no-numbered-filenames`); vale
il punto 4, servono verifiche automatiche.

**Priorita': media.** Rallenta ogni intervento futuro, incluso quello degli agenti.

---

## 6. Artefatti estranei nell'albero dei moduli

```bash
cd laravel && ls Modules/agentdb.rvf Modules/ruvector.db
```

`Modules/` deve contenere moduli. Contiene anche due file di database di strumenti:
`ruvector.db` (1.5 MB, ignorato da git) e `agentdb.rvf` (162 byte, **tracciato**).
Vanno spostati fuori dall'albero applicativo e ignorati entrambi.

**Priorita': bassa**, ma e' il tipo di intervento che costa cinque minuti.

---

## Ordine consigliato

1. `./Themes/` dentro il gate PHPStan: punto 1.
2. Riconciliazione delle 16 coppie divergenti e delle 97 identiche: punto 2.
3. Decisione esplicita su `->label()` e su `*Service`: punto 3.
4. Un test Pest per ogni regola che si decide di tenere: punto 4.
5. Potatura della documentazione, un owner canonico per argomento: punto 5.
6. Pulizia degli artefatti: punto 6.

I punti 1 e 2 sono difetti: producono bug e rompono il repository su alcune
piattaforme. I punti 3, 4 e 5 sono debito strutturale: non rompono nulla oggi e
rendono ogni intervento futuro piu' lento e piu' rischioso.

---

## Cosa non e' stato misurato

Onesta' del perimetro. Non sono stati verificati:

- l'esito della suite di test, perche' il database non ha tabelle e i dati sono
  sacri: nessuna migrazione e' stata eseguita per rendere i test eseguibili;
- la copertura di test reale;
- le performance, le query N+1, la sicurezza applicativa oltre ai difetti emersi da
  PHPStan;
- l'accessibilita' e la resa dei temi nel browser.

Ognuno di questi merita una misurazione dedicata prima di qualsiasi affermazione.

---

## 7. Aggiornamento misurazione: 2026-08-31 (sera)

Dati verificati in sessione, senza migrazioni distruttive.

| Check | Esito | Comando / nota |
|---|---|---|
| PHPStan `Modules/` | **0 errori** | `./vendor/bin/phpstan analyse Modules --memory-limit=-1` |
| `artisan about` + `module:list` | **OK** | 51 moduli enabled (Blog/Comment disabled) |
| `RefreshDatabase` nei test moduli | **0 uso reale** | solo commenti/docblock che vietano il trait |
| Dati sacri in Xot Artisan | **fix applicati** | niente `--force` su `migrate` in `ArtisanAction` / handlers |
| Pest unit GC (Intervention + Quotation + Billing) | **77 passed** | `php artisan test Modules/{Intervention,Quotation,Billing}/tests/Unit` |
| Pest feature Filament (es. Billing invoices) | **fallisce** | `workorder_data_test.roles` assente: debito **D17** |
| ide-helper | **OK** | `generate` + `meta` + `models --nowrite` |

**Interpretazione:** il gate statico sui moduli è verde, ma **perfezione operativa** richiede ancora
schema test completo (D17), suite feature verde, temi nel gate PHPStan, e chiusura debiti D1–D11
(vedi [gestionale-technical-debt.md](../../../docs/gestionale-technical-debt.md)).

Criteri espliciti di “perfezione”: [progetto-perfezione-criteri](./wiki/concepts/progetto-perfezione-criteri.md).
