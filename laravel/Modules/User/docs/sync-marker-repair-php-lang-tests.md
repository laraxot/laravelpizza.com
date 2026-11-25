---
title: "Riparazione dei marcatori di conflitto in lang, test e TestCase del modulo User"
type: guide
module: User
tags: [sync, git, conflitti, lang, test, testcase]
qmd: "user sync marcatori conflitto lang test testcase riparazione"
related:
  - "./stories/14.9.user-sync-marker-repair.story.md"
  - "../../Xot/docs/lessons/module-sync-merge-conflicts.md"
---

# Riparazione dei marcatori di conflitto nei PHP del modulo User

## Perché esiste questa pagina

Lo script di sync `bashscripts/git/subtrees/merge_remote_repo_2.sh` fa il merge di `laraxot/dev` in ogni modulo e
committa con `commit -am .`. Quando i due lati divergono lascia nei file i marcatori `<<<<<<<`, `=======`, `>>>>>>>`,
a volte annidati (un conflitto dentro un conflitto già committato). Un file PHP con i marcatori non si compila:
PHPStan non parte, Pest non carica il file di test e, per i file di lingua, ogni schermata che usa quelle chiavi si
rompe a runtime.

Questa pagina documenta come sono stati ripuliti i file PHP di `Modules/User` (lingua e test; i `.md` sono un altro
lavoro) e **perché** ogni scelta, così il prossimo agente non rifà il ragionamento da zero.

## Regole applicate

1. **Lingua: unione delle chiavi, mai perdita.** Nessuna chiave usata da un chiamante può sparire. Per ogni file si è
   costruito l'insieme delle chiavi di entrambi i lati e si è verificato che il risultato le contenga tutte
   (script di confronto: stessa chiave presente nel risultato, stesso valore o valore migliore).
2. **Valori: vince quello che è davvero italiano/inglese.** Il lato generato da `AutoLabelAction` scrive come valore il
   nome della chiave (`'login_at'`, `'reorderRecords'`, `'empty'`): è un segnaposto, non una traduzione, e si scarta a
   favore del lato con la frase vera (`'Ora accesso'`, `'Riordina'`) o di `''` quando nessuno ha una traduzione.
3. **`en/` coerente con `it/`.** Dove i due lati inglesi differiscono si sceglie quello allineato al file italiano
   gemello (`navigation.label` singolare come `'Profilo'`; `subheading` come `'I tuoi dati personali e la password'`).
4. **Test: asseriscono il codice di produzione di oggi.** Dove un lato descrive una struttura che non esiste più
   (`section01`/`section02` nel form utente) e l'altro quella reale (`Grid` → `main`/`side`, vedi `UserForm`), si tiene
   quello che corrisponde al codice. Dove un lato usa una proprietà dinamica di Pest (`$this->permission`, `$this->userData`)
   e l'altro una funzione tipizzata (`userTestPermission()`, `userTestAuthUserData()`), si tiene la funzione: dentro
   una closure di Pest `$this` è `Pest\PendingCalls\TestCall`, quindi la proprietà valeva `mixed` per PHPStan.
5. **Nessuna riga d'import duplicata.** Il merge aveva lasciato due `use` identici (`DatabaseManager`, `Mockery\...`)
   fuori dai marcatori: `php -l` dà "Cannot use ... because the name is already in use". Un duplicato basta a rendere
   la `TestCase` del modulo non caricabile, quindi a far fallire tutti i test del modulo.

## Decisioni che non sono ovvie

| Punto | Scelta | Motivo |
|-------|--------|--------|
| `TestCase::$connectionsToTransact` | `['mysql', 'mariadb', 'user']`, senza `fixcity` | `fixcity` è il modulo-progetto di un altro progetto da cui la `TestCase` era stata copiata; in laravelpizza non esiste la connessione e `DatabaseTransactions` lancia `Database connection [fixcity] not configured` in `setUp()`, cioè ogni test del modulo rosso prima di un'asserzione. La connessione del Profile la aggiunge il progetto, non il modulo condiviso. |
| `NoCmsPhantomFolioImportsTest` | senza l'asserzione "la cartella Cms non esiste" | `Modules/Cms` esiste in questo progetto e `User/resources/views/pages` è tracciata e popolata: il test del lato "PTVX senza Cms" sarebbe rosso qui. Resta l'asserzione utile: le Folio page di User non importano `Modules\Cms\`. |
| `UserResourceTest` | schema `Grid` → `main`/`side`, ricerca dei campi per nome | `UserForm::getFormSchema()` restituisce una `Grid` radice; gli indici fissi si rompono a ogni riorganizzazione del layout. |
| `DigitalIdentityUserUpsertTest` | tiene i `->group('USER-SPID-UPSERT-INV-*')` | I gruppi sono usati per filtrare la suite; il lato senza gruppo li perdeva. |
| `passport_stats.sections.empty.heading` | `''` | Nessun chiamante; `'empty'` era il segnaposto di `AutoLabelAction`. |

## Come verificare

```bash
cd /mnt/nas07/var/www/_bases/base_laravelpizza_fila5
git grep -lIE '^(<<<<<<<|>>>>>>>) ' -- 'laravel/Modules/User/*.php' 'laravel/Modules/User/*.blade.php'   # nessun output
cd laravel && for f in $(git diff --name-only --relative -- Modules/User | grep '\.php$'); do php -l "$f"; done
./vendor/bin/pint --test Modules/User/tests Modules/User/lang
```

I file di lingua devono anche restituire un array: `php -r 'var_dump(is_array(include "Modules/User/lang/it/user_form.php"));'`.

## Cosa PHPStan potrebbe ancora segnalare (non è un marcatore)

- `tests/Feature/Passport/ClientCredentials.php` e `ClientCredentialsTest.php` dichiarano entrambi
  `createPassportClient()` nello stesso namespace: la doppia dichiarazione può essere segnalata dall'analisi statica
  (a runtime il primo non termina per `Test`, quindi Pest non lo carica). Non è un marcatore e non è stato toccato:
  serve decidere quale dei due tenere.
- `user_form.fields.{created_at,roles,is_active,updated_at}` hanno solo `label`: la struttura espansa
  (`placeholder`, `helper_text`, `description`) non è stata inventata durante il merge.

## Vedi anche

- [Story 14.9](./stories/14.9.user-sync-marker-repair.story.md)
- [Lezione sul sync dei moduli](../../Xot/docs/lessons/module-sync-merge-conflicts.md)
- [Struttura espansa dei file di traduzione](../../Lang/docs/translation-structure-expanded.md)
