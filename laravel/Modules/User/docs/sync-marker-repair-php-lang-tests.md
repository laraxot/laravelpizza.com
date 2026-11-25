---
title: "Conflitti del sync: riparazione dei marcatori in lang, test e TestCase; LFS e maiuscole"
type: guide
module: User
tags: [sync, git, conflitti, lang, test, testcase, lfs, case-sensitivity]
qmd: "user sync marcatori conflitto lang test testcase riparazione connectionsToTransact lfs case sensitivity"
related:
  - "./stories/14.9.user-sync-marker-repair.story.md"
  - "../../Xot/docs/lessons/module-sync-merge-conflicts.md"
---

# Conflitti del sync: marcatori, LFS, maiuscole

Raccoglie gli incidenti di git/sync ricorrenti sul modulo User e le decisioni prese, cosi' il prossimo agente non rifa' il ragionamento.

## 1. Marcatori di conflitto nei PHP (lang, test, TestCase)

### Perche' succede

Lo script di sync `bashscripts/git/subtrees/merge_remote_repo_2.sh` fa il merge del ramo condiviso in ogni modulo e committa con
`commit -am .`. Quando i due lati divergono lascia nei file i marcatori `<<<<<<<`, `=======`, `>>>>>>>`, a volte annidati (un
conflitto dentro un conflitto gia' committato). Un file PHP con i marcatori non si compila: PHPStan non parte, Pest non carica il test
e, per i file di lingua, ogni schermata che usa quelle chiavi si rompe a runtime. Lo stesso accade nei `.md` (in questo modulo ne
erano colpiti quasi 100) e nelle migrazioni (vedi [migration-consolidation.md](migration-consolidation.md)).

### Regole applicate

1. **Lingua: unione delle chiavi, mai perdita.** Nessuna chiave usata da un chiamante puo' sparire. Per ogni file si costruisce l'insieme
   delle chiavi dei due lati e si verifica che il risultato le contenga tutte.
2. **Valori: vince quello davvero italiano/inglese.** Il lato generato da `AutoLabelAction` scrive come valore il nome della chiave
   (`'login_at'`, `'reorderRecords'`, `'empty'`): e' un segnaposto, non una traduzione, e si scarta a favore della frase vera
   (`'Ora accesso'`, `'Riordina'`) o di `''` quando nessuno ha una traduzione.
3. **`en/` coerente con `it/`.** Dove i due lati inglesi differiscono si sceglie quello allineato al file italiano gemello.
4. **Test: asseriscono il codice di produzione di oggi.** Dove un lato descrive una struttura che non esiste piu' (`section01`/`section02`
   nel form utente) e l'altro quella reale (`Grid` con `main`/`side`, vedi `UserForm`), si tiene quello che corrisponde al codice. Dove
   un lato usa una proprieta' dinamica di Pest (`$this->permission`) e l'altro una funzione tipizzata (`userTestPermission()`), si tiene
   la funzione: in una closure di Pest `$this` e' `Pest\PendingCalls\TestCall`, quindi la proprieta' vale `mixed` per PHPStan.
5. **Nessuna riga `use` duplicata.** Il merge puo' lasciare due `use` identici fuori dai marcatori: `php -l` da' "Cannot use ... because
   the name is already in use" e la `TestCase` del modulo non si carica, quindi falliscono tutti i test.
6. **Mai copiare marcatori** in una pagina di destinazione quando si fondono documenti: si tiene l'unione del contenuto sensato.

### Decisioni non ovvie

| Punto | Scelta | Motivo |
|---|---|---|
| `TestCase::$connectionsToTransact` | `['mysql', 'mariadb', 'user']`, senza connessioni di progetto | la `TestCase` era stata copiata da un progetto con una connessione propria: dove non esiste, `DatabaseTransactions` lancia `Database connection [...] not configured` in `setUp()` e ogni test del modulo e' rosso prima di un'asserzione. La connessione del Profile la aggiunge il progetto, non il modulo condiviso |
| `NoCmsPhantomFolioImportsTest` | senza l'asserzione "la cartella Cms non esiste" | `Modules/Cms` esiste in alcuni progetti e `User/resources/views/pages` e' popolata; resta l'asserzione utile: le Folio page di User non importano `Modules\Cms\` |
| `UserResourceTest` | schema `Grid` -> `main`/`side`, ricerca dei campi per nome | `UserForm::getFormSchema()` restituisce una `Grid` radice; gli indici fissi si rompono a ogni riorganizzazione |
| `DigitalIdentityUserUpsertTest` | tiene i `->group('USER-SPID-UPSERT-INV-*')` | i gruppi filtrano la suite; il lato senza gruppo li perdeva |
| `passport_stats.sections.empty.heading` | `''` | nessun chiamante; `'empty'` era il segnaposto di `AutoLabelAction` |

### Verifica

```bash
cd <radice-repo>
git grep -lIE '^(<<<<<<<|>>>>>>>) ' -- 'laravel/Modules/User/*.php' 'laravel/Modules/User/*.blade.php' 'laravel/Modules/User/docs/*.md'   # nessun output
cd laravel && for f in $(git diff --name-only --relative -- Modules/User | grep '\.php$'); do php -l "$f"; done
./vendor/bin/pint --test Modules/User/tests Modules/User/lang
```

I file di lingua devono restituire un array: `php -r 'var_dump(is_array(include "Modules/User/lang/it/user_form.php"));'`.

### Cosa PHPStan puo' ancora segnalare (non e' un marcatore)

- `tests/Feature/Passport/ClientCredentials.php` e `ClientCredentialsTest.php` dichiarano entrambi `createPassportClient()` nello stesso
  namespace: serve decidere quale tenere.
- `user_form.fields.{created_at,roles,is_active,updated_at}` hanno solo `label`: la struttura espansa (`placeholder`, `helper_text`,
  `description`) non e' stata inventata durante il merge.

## 2. Git LFS: non si usa

Binari (immagini, font, PDF, archivi) si versionano come **blob git normali**. Vietato aggiungere `filter=lfs diff=lfs merge=lfs` in un
`.gitattributes`, lanciare `git lfs install`/`track`, o committare come contenuto il testo `version https://git-lfs.github.com/spec/v1`.

Motivi (incidenti ripetuti): gli asset sono pochi e piccoli (circa 10 MB), quindi LFS non da' vantaggi; i puntatori orfani hanno prodotto
file il cui contenuto committato era il testo del puntatore, con push respinto da `GH008: unknown Git LFS objects` e immagini/SVG rotti a
runtime; il flusso multi-organizzazione (stesso contenuto su due remoti) rende gli oggetti LFS irrecuperabili perche' non sono su entrambi.
Rimedio quando compare un puntatore: `git rm --cached` del file, ripristino del binario reale come blob, nuovo commit (solo in avanti,
nessun reset o riscrittura della storia).

## 3. Nomi che differiscono solo per maiuscole

Nella stessa cartella non possono coesistere nomi uguali a meno delle maiuscole (rompono i checkout su filesystem case-insensitive e
l'autoload PSR-4). Decisioni: `database/` minuscolo (la cartella `Database/` e' stata eliminata); i test delle migrazioni vivono in
`tests/Feature/Database/Migrations/` perche' PSR-4 mappa il namespace `...\Database\Migrations`; per le cartelle di docs vale il nome
minuscolo-con-trattini. Se un test `Database` vecchio ricompare (oggi esistono ancora sia `tests/Feature/Database/Migrations/` sia
`tests/Feature/Database/migrations/`), si fonde nel file con la maiuscola.

## Vedi anche

- [Story 14.9](./stories/14.9.user-sync-marker-repair.story.md)
- [Lezione sul sync dei moduli](../../Xot/docs/lessons/module-sync-merge-conflicts.md)
- [Struttura espansa dei file di traduzione](../../Lang/docs/translation-structure-expanded.md)
- [translations.md](translations.md)
