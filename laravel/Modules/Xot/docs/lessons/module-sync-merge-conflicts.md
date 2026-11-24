---
title: "Sync dei moduli con conflitti non risolti"
type: lesson
updated: 2026-11-18
tags: [sync, git, moduli, ci]
---

# Sync dei moduli condivisi con conflitti non risolti

## Cosa è successo

Il 13/11/2026 tre commit di sync dei moduli condivisi (`95a546b25`, `71381a481`, `d6d338bb0`) hanno portato su
`dev` di laravelpizza **476 file con marcatori di conflitto** (`<<<<<<<`, `=======`, `>>>>>>>`) lasciati da
`git merge-file`:

- `Modules/Xot/composer.json` non era più JSON valido: `composer install` falliva e **tutta la CI** si fermava al
  passo "Install Dependencies" (tre giorni di CI rossa);
- 72 file di codice (Activity, User, Tenant, Notify, Geo, Gdpr, Lang, Media, Cms) e 71 test con due versioni incollate;
- 333 documenti con blocchi doppi, anche annidati (conflitti già presenti nei repository dei moduli).

Nei marcatori il **primo lato** era la versione di laravelpizza, il **secondo** quella del modulo condiviso.

## Come è stato risolto (18/11/2026)

1. Regole automatiche per blocco: lati uguali → uno; un lato vuoto → l'altro; un lato contenuto nell'altro → il più
   completo. Documentazione: unione dei due lati, nessun contenuto perso.
2. Codice con blocchi divergenti: lato del **modulo condiviso**, che conteneva già le correzioni fatte in laravelpizza
   (erano state riportate nei moduli) e quelle più recenti. Eccezioni tenute dal lato laravelpizza: `Xot/composer.json`
   (autoload-dev dei test), il logo `Xot/public/img/logo.svg`, la migrazione `fix_profiles_id_autoincrement`
   (connessione `user`).
3. File che con la scelta per blocchi non compilavano (`use` doppi) o non passavano PHPStan: versione attuale del
   repository del modulo (`laraxot/module_<nome>_fila5`, ramo `dev`, senza marcatori nel codice).
4. Dipendenze nuove dichiarate dai moduli ma assenti dal `composer.lock` (`railsware/mailtrap-php`,
   `zbateson/mail-mime-parser`) e Filament allineato al vincolo `^5.11.2` di Xot (5.11.4).
5. Verifica: `php -l` su tutti i file PHP tracciati, PHPStan livello 10 su `Modules` senza errori, Pint, suite
   `Project`, build del tema.

## Regole

- Mai fare commit di un sync senza aver cercato i marcatori: `git grep -nE '^(<<<<<<< |>>>>>>> )'`.
- Il test `Modules/Meetup/tests/Unit/Architecture/NoMergeConflictMarkersTest.php` (suite bloccante `Project`) fallisce
  se un file tracciato contiene marcatori.
- Dopo un sync: `composer validate`, `composer install`, `php artisan package:discover`, PHPStan, test.
- I repository dei moduli hanno ancora marcatori nei **docs** (Notify ~280 file, Geo ~90, Gdpr ~40): vanno puliti
  là, altrimenti il prossimo sync li riporta qui e il test di guardia blocca la CI.

## Cosa è venuto fuori dopo, a marcatori tolti (18/11/2026)

Tolti i marcatori, la CI è ripartita e ha mostrato i problemi che i conflitti nascondevano:

| Problema | Causa | Correzione |
|---|---|---|
| CI ferma a "Prepare databases": `Unknown column 'name' in 'users'` | `add_lang_column` (2026_02_13) girava prima di `create_users_table` e, con `tableUpdate()`, creava `users` con la sola colonna `lang` | migrazione unica `2026_11_17_114812_create_users_table` del modulo (upstream d8ef195); tolte le `add_*` |
| `/it/auth/password/confirm` in errore 500 | il modulo User ora ha pagine Folio proprie; tema e modulo usavano lo stesso `@volt('auth.password.confirm')` e Volt mostrava il frammento del modulo | nomi del tema con prefisso `meetup.`; test `UniqueVoltFragmentNamesTest` |
| Dopo il login: 404 su `/area-personale` | `GetPostLoginUrlAction` legge `auth.post_login_path` con quel default | `config/local/laravelpizza/auth.php`: `post_login_path => '/events/my'` |
| Build del tema in CI: `clean-stale-assets.mjs` non trovato | il `.gitignore` del tema ignorava `scripts/` | si ignorano solo i file non `.mjs`/`.cjs` |
| Pagine admin in 500 | viste mancanti, form definiti in `schema()` ma letti da `form()` | vedi `../filament/xotbasepage-form-and-generic-view.md` |

Regola in più: dopo un sync, **migrare un database vuoto** (non solo quello locale, già migrato) e aprire tutte le
pagine admin. Un database già migrato nasconde l'ordine sbagliato delle migrazioni.

## Regressioni silenziose: il sync del 21/11 non lascia marcatori (24/11/2026)

Togliere i marcatori non basta: `git merge-file` risolve da solo i blocchi che non si toccano e così un sync porta
**indietro nel tempo** file che il progetto aveva già migliorato. Nel solo tema `Themes/Meetup` (`SYNC_BASE` =
ultimo commit root senza marcatori, `dd46996a4`):

| Classe | File | Esempi di danno |
|---|---|---|
| marcatori | 5 | `package.json`, `language-switcher`, `register`, `auth/password/confirm`, `auth/verify` |
| regressione (contenuto più vecchio di quello del progetto) | 92 | `pages/[slug].blade.php`, `auth/login`, `profile/[id]`, `ui/button`, lang `home`/`events` in 9 lingue, ~60 docs |
| ambigui (divergono entrambi) | 9 | `events/detail` e `[container0]/[slug0]` perdevano `visibleTo` (bozze pubbliche), la registrazione Livewire e `JSON_HEX_TAG` nel JSON-LD; `vite.config.js` perdeva `base: '/themes/Meetup/'` (404 su font e immagini); `.gitignore` perdeva `.env.*` e `graphify-out/` |
| cancellati ma ancora usati | 18 | `ui/auth-card`, `ui/auth-field` (usati da `confirm`/`verify`), `errors/page`, `lang/*/errors.php`, 2 script `npm run screenshots`, `.gitattributes` (divieto Git LFS) |
| `public/` | 44 | 7 font Inter e 3 altri file cancellati, 34 asset con hash vecchi rimessi: il manifest citava file inesistenti |

Cosa ha funzionato, in ordine:

1. `SYNC_BASE=<ultimo commit pulito> python3 -I bashscripts/tools/git/sync-repair/find_sync_regressions.py "$PWD" Themes/Meetup`
   (senza `--apply` stampa solo i conteggi; la lista per file va in `$OUT/Themes_Meetup.regress.json`). `--apply` ripristina
   le sole classi `regression` e `deleted-unseen`.
2. Gli **ambigui** si decidono a mano con `git diff -U0 $SYNC_BASE -- <file>`: vince la versione che ha più
   controlli (scope, escape, a11y), non quella più recente. I cambi di nome delle chiavi lang del remoto restano.
3. I **cancellati** vanno confrontati con chi li usa: `git diff --name-status $SYNC_BASE | grep ^D`, poi grep del nome
   (`x-ui.auth-card`, `errors.page`, script in `package.json`).
4. Le **chiavi lang** si uniscono, non si sostituiscono: il remoto rinomina (`login.title` sparisce, nasce
   `*.label`/`*.message`), le viste del progetto usano ancora le vecchie. Si riaggiungono solo le chiavi *referenziate*
   (mai le morte) con i valori correnti che vincono.
5. `public/`: tornare allo stato della base (`git show $SYNC_BASE:<file>`), poi controllare che ogni file del
   `manifest.json` esista. Non lanciare `clean-stale-assets.mjs` se il manifest cita file mancanti: cancellerebbe
   quello che serve.

Il test `Modules/Meetup/tests/Unit/Architecture/ThemeIntegrityTest.php` (suite `Project`) fa fallire la CI su tre di
questi danni: script npm che puntano a file mancanti, manifest incoerente con `public/assets`, chiavi `pub_theme::`
usate dalle viste e assenti da `lang/it` o `lang/en`.

Trappole di shell trovate lavorando: in zsh `"$B:laravel/x"` legge `:l` come modificatore (minuscole), quindi scrivere
`"${B}:laravel/x"`; `git diff <commit>` ignora i file non tracciati, quindi un file ripristinato ma ancora non
aggiunto compare come `D`.
