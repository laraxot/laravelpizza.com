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
