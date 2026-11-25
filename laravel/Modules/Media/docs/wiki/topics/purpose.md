---
title: "Topic purpose"
type: digest
status: active
qmd: "digest ceiling 100 purpose"
---

# Topic purpose

Sintesi automatica di 3 documenti (chiave `purpose`).

## Media — perche' esiste

_Fonte: `bmad/purpose.md`_

# Media — perche' esiste

## Lo scopo in una frase

**Media custodisce i file che fanno da prova a una decisione, e li rende utilizzabili
nei formati che servono senza che il dominio sappia nulla di dischi e conversioni.**

## L'evidenza

- **49 Action** per soli 124 file PHP: e' il modulo con la densita' operativa piu' alta
  del progetto dopo Xot. Coerente: manipolare file e' fatto di molte operazioni piccole.
- `Media`, `MediaConvert`, `TemporaryUpload`.
- Zero Widget: lavora sotto le altre schermate.

`TemporaryUpload` merita attenzione: un file caricato in un form non ancora salvato
esiste **prima** dell'entita' a cui apparterra'. Gestire quel limbo — e ripulirlo — e'
un problema reale che il modello rende esplicito.

## Il vincolo che decide tutto: dove finiscono i file

In questo progetto `public_path()` e' **`public_html/`**, fratello di `laravel/`, non
`laravel/public/`. `App\Application::publicPath()` in `bootstrap/app.php` lo garantisce.

Sbagliarlo e' l'errore muto per eccellenza: i file si scrivono, i test passano, e il
**404 arriva solo dal browser in produzione**. Vale per `storage:link`, per il manifest
Vite e per ogni `asset()`. Guardia esistente:
`laravel/tests/Unit/PublicPathPointsToPublicHtmlTest.php`.

## Come raggiungerlo **meglio**

## Media — perche' esiste

_Fonte: `purpose.md`_

# Media — perche' esiste

## Lo scopo in una frase

**Media custodisce i file che fanno da prova a una decisione, e li rende utilizzabili
nei formati che servono senza che il dominio sappia nulla di dischi e conversioni.**

## L'evidenza

- **49 Action** per soli 124 file PHP: e' il modulo con la densita' operativa piu' alta
  del progetto dopo Xot. Coerente: manipolare file e' fatto di molte operazioni piccole.
- `Media`, `MediaConvert`, `TemporaryUpload`.
- Zero Widget: lavora sotto le altre schermate.

`TemporaryUpload` merita attenzione: un file caricato in un form non ancora salvato
esiste **prima** dell'entita' a cui apparterra'. Gestire quel limbo — e ripulirlo — e'
un problema reale che il modello rende esplicito.

## Il vincolo che decide tutto: dove finiscono i file

In questo progetto `public_path()` e' **`public_html/`**, fratello di `laravel/`, non
`laravel/public/`. `App\Application::publicPath()` in `bootstrap/app.php` lo garantisce.

Sbagliarlo e' l'errore muto per eccellenza: i file si scrivono, i test passano, e il
**404 arriva solo dal browser in produzione**. Vale per `storage:link`, per il manifest
Vite e per ogni `asset()`. Guardia esistente:
`laravel/tests/Unit/PublicPathPointsToPublicHtmlTest.php`.

## Come raggiungerlo **meglio**

## Media — perche' esiste

_Fonte: `wiki/purpose.md`_

# Media — perche' esiste

## Lo scopo in una frase

**Media custodisce i file che fanno da prova a una decisione, e li rende utilizzabili
nei formati che servono senza che il dominio sappia nulla di dischi e conversioni.**

## L'evidenza

- **49 Action** per soli 124 file PHP: e' il modulo con la densita' operativa piu' alta
  del progetto dopo Xot. Coerente: manipolare file e' fatto di molte operazioni piccole.
- `Media`, `MediaConvert`, `TemporaryUpload`.
- Zero Widget: lavora sotto le altre schermate.

`TemporaryUpload` merita attenzione: un file caricato in un form non ancora salvato
esiste **prima** dell'entita' a cui apparterra'. Gestire quel limbo — e ripulirlo — e'
un problema reale che il modello rende esplicito.

## Il vincolo che decide tutto: dove finiscono i file

In questo progetto `public_path()` e' **`public_html/`**, fratello di `laravel/`, non
`laravel/public/`. `App\Application::publicPath()` in `bootstrap/app.php` lo garantisce.

Sbagliarlo e' l'errore muto per eccellenza: i file si scrivono, i test passano, e il
**404 arriva solo dal browser in produzione**. Vale per `storage:link`, per il manifest
Vite e per ogni `asset()`. Guardia esistente:
`laravel/tests/Unit/PublicPathPointsToPublicHtmlTest.php`.

## Come raggiungerlo **meglio**
