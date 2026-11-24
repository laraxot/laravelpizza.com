---
title: "Lang — manuale d'uso per attori"
type: manual
---

# Scopo

Lang gestisce le lingue dell'interfaccia e le traduzioni nel backoffice. Il
selettore di lingua è invece una capacità front office disponibile anche senza
ruolo.

## Attori e capacità effettive

| Attore | Dominio | Capacità verificata |
| --- | --- | --- |
| Ospite | Cittadino/front office | Visualizza le lingue supportate e passa all'URL localizzato tramite il selettore. |
| Autenticato | Cittadino/front office | Come l'ospite; non è dichiarata una capacità linguistica aggiuntiva. |
| Gruppo/ruolo con permessi | Backoffice | Opera su traduzioni, file di traduzione e post con i permessi espliciti `translation.*`, `translation_file.*`, `post.*`. |
| `lang::admin` | Backoffice | Bypass delle policy dei modelli Lang. |
| `super-admin` | Backoffice | Bypass delle policy Lang e accesso alle impostazioni dichiarate super-admin-only. |
| Operatore/moderatore | — | N/A: il modulo non dichiara questi ruoli. |

## Flussi

Nel front office il widget legge le lingue da
`LaravelLocalization::getSupportedLocales()`, costruisce URL equivalenti con
`getLocalizedURL()` e reindirizza solo se il codice è supportato. Non è un
editor e non richiede autenticazione.

Nel backoffice l'accesso a ogni modello passa dalla policy: bypass per
`lang::admin`/`super-admin`, oppure permesso preciso per l'abilità richiesta.
Le impostazioni scelgono lingua predefinita e lingue supportate e sono
dichiarate nella fonte come solo super-admin. Le Action possono leggere,
validare, sincronizzare e scrivere file di traduzione; la scrittura deve
restare nel flusso amministrativo previsto, non è una capacità del selettore
cittadino.

## Prerequisiti e limiti

- Il locale deve appartenere alle lingue configurate; un locale non valido è
  ignorato dal widget.
- Il selettore è montato esplicitamente nel tema, non è auto-scoperto come
  card della dashboard Filament.
- I permessi CRUD non sono dedotti dal solo fatto di essere autenticati.
- La scrittura automatica delle chiavi mancanti è condizionata da
  `lang.save_missing_translations`/ambiente; non va considerata un diritto
  dell'utente.
- N/A: il modulo non gestisce registrazione, segnalazioni, mappe o code.

## Riferimenti verificabili

- `app/Models/Policies/LangBasePolicy.php:10-27` — ruoli bypass.
- `app/Models/Policies/TranslationPolicy.php:13-68` e
  `app/Models/Policies/TranslationFilePolicy.php:13-68` — permessi CRUD
  espliciti; `PostPolicy.php` applica la stessa forma a `post.*`.
- `app/Filament/Widgets/LanguageSwitcherWidget.php:24-41,64-103` — widget
  pubblico, lingue supportate e cambio URL.
- `app/Filament/Pages/SettingPage.php:13-31` — impostazioni delle lingue.
- `app/Actions/ReadTranslationFileAction.php:17-48` e
  `app/Actions/WriteTranslationFileAction.php:18-44` — contratto di lettura,
  validazione e scrittura dei file.
