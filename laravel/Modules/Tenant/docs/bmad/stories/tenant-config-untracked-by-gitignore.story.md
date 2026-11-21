---
title: "config/local untracciata applicando il .gitignore ai file tracciati"
type: incident
scope: Tenant
updated_at: '2026-09-29'
status: review
github:
  issue: https://github.com/provtv/base_ptv_fila5/issues/253
related:
  - ../../../../Xot/docs/bmad/stories/domain-config-detracked-by-gitignore-cleanup.story.md
  - ../../../../Xot/docs/bmad/stories/module-root-hygiene.story.md
  - ../../../../Rating/docs/stories/18.35.rating-morph-type-doppia-forma.story.md
---
tags: [docs, tenant, bmad]

# config/local untracciata applicando il .gitignore ai file tracciati

## Segnalazione

L'utente, il 2026-09-29, ha incollato l'output `delete mode` di 90 file
`laravel/config/local/**` e ha scritto: «questi non dovevi cancellarli, capisci il perche'».

## Cosa e' successo

- Il commit root `8b3b7cbea3` (2026-09-29 11:45:34, messaggio `.`, loop automatico
  pull/commit, gia' su `origin/dev` e `laraxot/dev`) ha tolto dall'indice i 90 file della
  config dei tenant `ptvx`, `ptvx-mono`, `tv/prov/personale2019` e `tv/prov/personale2022`.
  Sul disco sono rimasti identici.
- Nello stesso commit sono usciti dall'indice circa 1261 file tracciati ma ignorati, e sono
  state registrate circa 4549 cancellazioni vere di file gia' spariti dal disco.
- La firma e' quella di «applica il `.gitignore` ai file tracciati»: `git rm -r --cached`
  seguito da `git add`. `git add -A` da solo non toglie dall'indice un file che c'e' ancora.
- Il `.gitignore` root conteneva dal 2026-01-20 (`eba886a1a6`) la regola
  `laravel/config/local/`, che contraddiceva il fatto che i file erano versionati. La
  ricetta l'ha applicata alla lettera. La regola «serve `git rm -r --cached`» era scritta,
  senza limiti di scopo, nella story `Xot/module-root-hygiene`.

## Perche' non andavano cancellati

`laravel/config/local/<tenant>/` e' versionata apposta: e' la config per tenant che
`TenantServiceProvider` carica in base all'host (`database.php` connessioni,
`morph_map.php`, `metatag.php` logo e brand, menu, permessi, `xra.php` moduli).

Togliere un file dall'indice non lo cancella da chi fa il commit, ma lo cancella da ogni
altro checkout al primo pull, produzione compresa. Senza quella cartella il tenant non si
risolve e si ripiega su `localhost`: altro database, niente alias morph, niente logo. E' lo
stesso gruppo di sintomi visti la mattina del 2026-09-29 (morph map, logo), qui come
rischio e non come causa.

## Ripristino

- Il commit root `57c400993d` (11:50:49, un'altra sessione) ha ritracciato 93 file. I 90
  sono identici byte per byte al parent `c0395dc0f9` (verificato con sha1 file per file).
- I 3 file in piu' non erano mai stati tracciati prima:
  - `laravel/config/local/ptvx/test.php` e `laravel/config/local/ptvx-mono/test.php`:
    identici, 72 byte, un array di esempio, nessun segreto;
  - `laravel/config/local/ptvx/database/content/information_schema_tables.json`: una cache
    generata a runtime (nomi di schema e tabelle, conteggi righe), nessun segreto. Il
    `.gitignore` root la esclude esplicitamente alle righe ~409-411.
  - La sessione pari li sta gia' togliendo: il json e' stato untracciato di nuovo in
    `122705398e` (11:58), e i due `test.php` risultano in stage come rimossi dall'indice.
    Stato alle 12:00: 90 file tracciati sotto `laravel/config/local`, cioe' esattamente
    quelli originali. Non li ho toccati.

## Correzioni

- [x] `.gitignore` root: la regola `laravel/config/local/` e' sostituita da un commento di
      due righe che spiega che la cartella e' versionata e non va untracciata.
      `git check-ignore -v laravel/config/local/ptvx/database.php` non restituisce niente;
      0 file non tracciati nuovi sotto `laravel/config/local`.
- [x] Guardia Pest `laravel/Modules/Tenant/tests/Unit/TenantConfigTrackedTest.php`:
  - (a) `database.php` e `morph_map.php` di ogni tenant con `database.php` sono tracciati
    (`git ls-files --error-unmatch`);
  - (b) nessun file tracciato sotto `laravel/config/local` e' coperto da una regola
    (`git ls-files -c -i --exclude-standard`, cioe' esattamente l'insieme che «applica
    .gitignore ai tracciati» toglie dall'indice). Riscritta alle 12:01 da una sessione pari:
    la mia prima versione usava `check-ignore --no-index` sul solo `database.php`, questa
    copre tutti i file, compresi `metatag.php` (logo), menu e policy. Serve comunque lo
    stesso principio: `check-ignore` senza `--no-index` non riporta mai un file tracciato.
  - La root si cerca risalendo da `__DIR__`, non da `base_path()`: sotto testbench
    `base_path()` puo' puntare altrove. Fuori dal progetto il test si salta.
- [x] Regola corretta in `Xot/docs/bmad/stories/module-root-hygiene.story.md` (Rischi):
      `git rm --cached` solo sul path appena aggiunto al `.gitignore`, mai su `.`, mai su
      `laravel/config/local/`.

## Gate reali

- Prova del rosso: con la vecchia regola `laravel/config/local/` come excludesFile,
  `ls-files -c -i --exclude-standard` restituisce 90 file, quindi (b) fallirebbe. Il tree di
  `8b3b7cbea3` ha 0 file sotto `laravel/config/local`, quindi (a) fallirebbe.
- Pest: `Tests: 2 passed (11 assertions)` (versione attuale, 12:01).
- PHPStan (livello da `phpstan.neon`, cache isolata): `[OK] No errors`.
- PHPMD (`tools/phpmd.sh`, ruleset reale): 0 violazioni, exit 0.
- Pint `--test`: passed.

## Decisione aperta: gli altri file ignorati usciti dall'indice

Nello stesso commit circa 1171 file ignorati, oltre ai 90 di `config/local`, sono usciti
dall'indice e restano non tracciati. Non li ho ripristinati. Per ogni area va deciso se
l'ignore e' voluto oppure se, come `config/local`, erano versionati apposta:

| Area | File |
| --- | --- |
| `laravel/Modules/Lang` | 251 |
| `laravel/Modules/UI` | 220 |
| `laravel/Modules/Performance` | 167 |
| `laravel/Modules/User` | 153 |
| `laravel/Modules/Notify` | 133 |
| `laravel/Modules/Job` | 108 |
| `laravel/Modules/Xot` | 45 |

(Conteggi con il `.gitignore` di quel momento; il dettaglio viene da
`git show --name-status 8b3b7cbea3` incrociato con `git check-ignore --stdin`.)

## Sovrapposizione con la story pari in Xot

In parallelo, una sessione pari ha scritto
`Xot/docs/bmad/stories/domain-config-detracked-by-gitignore-cleanup.story.md` con la
guardia `Xot/tests/Unit/DomainConfigStaysTrackedTest.php`. Quella guardia controlla con
`ls-files` un campione di path scritti a mano. Questa story aggiunge due cose che la guardia
pari non copre:

1. scopre i tenant da disco (ogni cartella con `database.php`), invece di usare un elenco;
2. verifica che nessun file tracciato della config per tenant sia coperto da una regola.

Due correzioni alla story pari, verificate sul codice:

- `laravel/.gitignore` **non** contiene `laravel/config/local/` (o `config/local/`): ci sono
  solo le due righe del json. La regola generale era soltanto nel `.gitignore` root.
- La regola root compare in `c79cb18eef` (2026-03-10, messaggio `.`), cioe' quando i file
  erano gia' tracciati. Non c'e' un messaggio che ne spieghi l'intento.

**Decisione dell'utente**: le guardie sono due, sullo stesso rischio, in due moduli diversi.
Va scelto se tenerle entrambe o consolidarle in una (proposta: Tenant, owner della config
per tenant). Va scelto anche se la regola di ignore va ripristinata in forma sicura, cioe'
`laravel/config/local/*` con `!` per ogni tenant versionato, nel caso in cui l'intento fosse
evitare l'aggiunta accidentale di nuovi tenant. Oggi la guardia (b) fallisce se torna la
regola generale.

## Coordinamento

| Chi | Cosa | Esito |
| --- | --- | --- |
| loop automatico pull/commit | `8b3b7cbea3` | ha untracciato config/local e ~1171 altri file ignorati |
| altra sessione | `57c400993d` | ha ritracciato i 90 file + 3 nuovi |
| sessione pari | `122705398e`, story + guardia Xot, memoria `config-local-dominio-non-e-spazzatura` | json di nuovo untracciato, `test.php` in stage come rimossi |
| sessione 30a9bfba (fork D) | `.gitignore`, guardia Tenant, regola in module-root-hygiene, questa story, issue #253 | fatto, nessun commit |
