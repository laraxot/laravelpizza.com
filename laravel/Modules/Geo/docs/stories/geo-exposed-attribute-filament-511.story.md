---
title: L'attributo Exposed di Filament non esiste nella versione installata
status: done
owner: Geo
created: 2026-10-29
related:
  - ../../../Tenant/docs/stories/sushi-to-jsons-single-source-cleanup.story.md
---

# L'attributo Exposed di Filament non esiste nella versione installata

## Fase BMAD

Analisi, dopo il pull dei sottomoduli (2026-10-29). In attesa di una decisione dell'utente.

## Problema

Il commit upstream `afc3a419` (2026-10-28, messaggio ".") sostituisce `#[ExposedLivewireMethod]`
con `#[Exposed]` su `searchAddress()` e `reverseGeocode()` in:

- `app/Filament/Forms/Components/Traits/HasCoordinatePicker.php` (righe 235 e 293)
- `app/Filament/Forms/Components/XotBaseCoordinateField.php` (righe 204 e 214)

PHPStan: `attribute.notFound`, 20 errori. 18 vengono dal trait (2 righe per ognuna delle 9 classi
che lo usano), 2 da `XotBaseCoordinateField`.

## Causa

- `Filament\Support\Components\Attributes\Exposed` nasce in Filament **v5.11.0** (2026-10-26).
  Nella stessa versione `ExposedLivewireMethod` diventa deprecato e `extends Exposed`.
- Il progetto ha Filament **v5.10.1** (`laravel/composer.lock`, vincolo `^5.0`), dove `Exposed`
  non esiste.
- In 5.10.1 `InteractsWithSchemas::callSchemaComponentMethod()` restituisce `null` se il metodo
  non ha `#[ExposedLivewireMethod]`. Con `#[Exposed]` la ricerca dell'indirizzo e la geocodifica
  inversa chiamate dal browser restituiscono `null`, senza errori.
- In 5.11.0 il controllo e' `getAttributes(Exposed::class, ReflectionAttribute::IS_INSTANCEOF)`:
  li' funzionano entrambi gli attributi.

Impatto oggi: nessun modulo o tema fuori da Geo usa questi campi in questo progetto.

## Opzioni

1. **Aggiornare Filament a 5.11.0** (`composer update` dei pacchetti `filament/*`, dentro `^5.0`).
   Allinea il progetto a quello che l'upstream usa gia'. Cambia `composer.lock` per tutta l'app e
   va portato in produzione. 5.11.0 ha 3 giorni.
2. **Rimettere `#[ExposedLivewireMethod]`** nei 4 punti. Funziona sia con 5.10.1 sia con 5.11
   (deprecato). Si allontana dall'upstream: al prossimo pull i file possono andare in conflitto.

## Decisione

2026-10-29: l'utente sceglie l'opzione 1, aggiornare Filament.

## Blocco trovato durante l'opzione 1

Dry-run di `composer update "filament/*" livewire/livewire` (nessun comando reale eseguito):

- Serve anche Livewire: `filament/support` 5.11.0 richiede `livewire/livewire ^4.4.8` (installato 4.4.7).
- L'aggiornamento vero e' piccolo: 12 pacchetti `filament/*` da 5.10.1 a 5.11.0, Livewire a 4.4.8,
  e l'installazione di `laravel/head` (lo chiede `Modules/Cms/composer.json` da questo pull).
- Ma il lock e' disallineato: `composer validate` dice che `laravel/head` manca dal lock, e il dry-run
  **rimuove 106 pacchetti** tra cui Pest, PHPUnit, Pint, Larastan, PHPInsights, ide-helper e Debugbar.
  Il motivo: il `composer.json` root ha solo 3 `require` e 2 `require-dev`, e il merge-plugin dai
  `Modules/*/composer.json` porta solo i `require`, non i `require-dev`. Quegli strumenti sono nel lock
  ma oggi nessuno li richiede piu', quindi qualsiasi `composer update` li toglie.

Prima di aggiornare va deciso dove dichiarare gli strumenti di sviluppo. Nuova scelta chiesta all'utente.

2026-10-29: l'utente esegue lui `composer update -W`, poi si riprende. Nessun file di Geo modificato.

## Correzione: le 106 rimozioni non erano reali

Dopo il `composer update -W` vero, Pest, PHPUnit, Pint, Larastan, PHPInsights, PHPMD, ide-helper e
Debugbar sono ancora installati (`packages-dev` del lock, binari in `vendor/bin`). Le rimozioni del
dry-run erano un artefatto: probabilmente il merge-plugin applica i `require-dev` dei moduli in un
secondo passaggio, che `--dry-run` non esegue. Lezione: con il merge-plugin il dry-run non basta per
giudicare cosa viene rimosso.

Altro fatto utile: `laravel/composer.lock` e' ignorato dal `.gitignore` root (riga 46) e non e'
tracciato dal 2026-09-03, quindi l'aggiornamento non produce nulla da committare.

## Verifica (2026-10-29)

- `composer validate`: valido. Nel lock: `filament/*` 5.11.0, `livewire/livewire` 4.4.8, `laravel/head` 0.2.2.
- In `vendor/filament/schemas/src/Concerns/InteractsWithSchemas.php:107` il controllo e'
  `getAttributes(Exposed::class, ReflectionAttribute::IS_INSTANCEOF)`: `searchAddress()` e
  `reverseGeocode()` sono di nuovo chiamabili dal browser.
- PHPStan, `./vendor/bin/phpstan analyse` da `laravel/`: **0 errori in Geo**, totale 5.
- Pest `tests/Unit/Filament/Forms/Components/MapPickerTest.php`: 18/18.

## Effetto collaterale

Filament 5.11 depreca `Widget::isLazy()` (sostituto `isLazyLoaded()`): 3 nuovi errori PHPStan
`staticMethod.deprecated` nei test di Quaeris (`QuestionChartDataTableWidgetTest.php:247`,
`QuestionChartItemWidgetTest.php:483`, `QuestionChartStatsOverviewWidgetTest.php:156`). Fuori dal
modulo Geo.

## 2026-11-05: ritorno di `ExposedLivewireMethod` e vincolo `^5.11`

Il rischio dell'opzione 2 si e' avverato al contrario. Il commit upstream `d14913d0` (Marco Xot, 2026-11-05,
"#[Exposed] inesistente (Filament 5)") ha rimesso `#[ExposedLivewireMethod]` nei 4 punti: sul suo ambiente
Filament e' sotto 5.11, dove `Exposed` non esiste. Qui (filament 5.11.0) PHPStan ha dato 45 errori
`attribute.deprecated`/`attribute.deprecatedClass` piu' 1 `classConstant.deprecatedClass` nella guardia
aggiunta in `CoordinatePickerRefactorTest`.

Causa vera: i `composer.json` dichiaravano `filament/filament: ^5.0`, quindi un ambiente sotto 5.11 era
"valido" anche se il codice (Geo, Xot `XotBaseChartWidget`, widget Quaeris) usa le API di 5.11.

Correzione:
- `Modules/Xot/composer.json`: `filament/filament` da `^5.0` a `^5.11` (Xot possiede la dipendenza; Livewire
  `^4.4.8` arriva da `filament/support`). Composer ora chiede l'aggiornamento invece di lasciare un vendor
  vecchio dove `#[Exposed]` spegne in silenzio `searchAddress()`/`reverseGeocode()`.
- `#[Exposed]` di nuovo in `HasCoordinatePicker` (235, 293) e `XotBaseCoordinateField` (203, 213); tenuta la
  formattazione Pint di `d14913d0`.
- Guardia nel test: `getAttributes(Exposed::class, ReflectionAttribute::IS_INSTANCEOF)`, lo stesso controllo
  di `InteractsWithSchemas.php:107`. Sotto 5.11 il test fallisce di proposito con la cura nel commento.

Verifica: PHPStan Geo/Notify/Quaeris 0 errori, PHPStan dell'intero progetto 0 errori; Pest
`CoordinatePickerRefactorTest` 8/8; Pint passed; PHPMD solo finding preesistenti gia' documentati in
[quality-gate-closure](./quality-gate-closure.story.md) (`BooleanArgumentFlag`, `CyclomaticComplexity`).

Da fare fuori da qui: chi ha Filament sotto 5.11 lancia `composer update "filament/*" livewire/livewire`;
la produzione deve avere filament >= 5.11 e livewire >= 4.4.8 prima del deploy.

## 2026-11-11: stessi errori, vendor indietro rispetto al lock (nessun cambio di codice)

Fase BMAD: Verify. Bonifica PHPStan, cluster Geo. Il codice e' giusto; l'ambiente no.

Misura, `analyse Modules/Geo` con il vendor com'e': **21 errori**, exit 1. 20 `attribute.notFound`
(`HasCoordinatePicker` 235 e 293 ripetuti per le 9 classi che usano il trait = 18; `XotBaseCoordinateField` 203 e
213 = 2) e 1 `class.notFound` in `CoordinatePickerRefactorTest.php:89`. E' un solo difetto.

Causa, verificata:
- `vendor/composer/installed.json` ha `filament/*` **v5.10.3** (vendor installato il 2026-10-26, mai toccato dopo);
  `composer.lock` (aggiornato dal sync il 2026-11-11) ha **v5.11.2**; `Modules/Xot/composer.json` chiede `^5.11.2`.
  Sul lock il vendor e' indietro di 123 pacchetti (anche `laravel/framework` 13.38.0 contro 13.42.0 e
  `larastan/larastan` 3.13.2 contro 3.14.0).
- In 5.10.3 esiste solo `ExposedLivewireMethod`; `Exposed` c'e' da 5.11.0. Controllo in
  `InteractsWithSchemas::callSchemaComponentMethod`: 5.10.3 righe 101-103, `getAttributes(ExposedLivewireMethod::class)`;
  5.11.2 (letto nel vendor di `base_predict_fila5`) riga 107,
  `getAttributes(Exposed::class, ReflectionAttribute::IS_INSTANCEOF)`, con `ExposedLivewireMethod extends Exposed`
  deprecato. Un metodo senza l'attributo giusto fa `return null`: nessuna eccezione, nessun log.
- Quindi `#[Exposed]` e' l'attributo corretto per il vincolo dichiarato. Tornare a `#[ExposedLivewireMethod]`
  riaprirebbe il ping-pong del 2026-11-05 (45 deprecazioni sotto 5.11), non e' la correzione.

Cosa funziona oggi con il vendor 5.10.3:
- `LocationPicker`: `location-picker.blade.php:59` chiama `$wire.callSchemaComponentMethod(id, 'reverseGeocode', ...)`.
  Con `Exposed` sconosciuto Filament risponde `null` e l'indirizzo si svuota in silenzio (ramo `else`). E' l'unica
  vista Geo che usa il percorso Livewire; nessun modulo o tema fuori da Geo la usa.
- I picker Lit (`CoordinatePicker`, usato da `Fixcity/TicketForm`, e gli altri) non chiamano questi metodi dal
  server: `ctx.searchAddress` non e' definito e `resolveAddressResults()` (`map-picker-search.js:237`,
  `map/controls/search.js:215`) ricade su `fetch` diretto a Nominatim dal browser. Non toccati dal vendor vecchio.
- Aperta, decisione di prodotto: la regola «NO client-side geocoding» di
  [filament-geo-pickers-philosophy](../filament-geo-pickers-philosophy.md) non descrive questi picker Lit.

Prova (vendor di sviluppo non toccato; `Exposed.php` copiato da `base_predict_fila5`, 5.11.2, identico a quello di
5.11.1, e caricato solo per la prova):
- PHPStan `Modules/Geo` con `-a <Exposed.php>`: **0 errori, exit 0**.
- Pest `CoordinatePickerRefactorTest` (via `pest-scratch-db`): vendor com'e' **7 passed, 1 failed** (`Class
  "Filament\Support\Components\Attributes\Exposed" not found`, riga 89); con `Exposed` caricata **8 passed**. Il test
  e' valido: replica il controllo di Filament e fallisce se il metodo ha l'attributo sbagliato o nessuno.

Cura (da decidere dall'utente, tocca tutto il progetto): allineare il vendor al lock, `cd laravel && composer
install` (parte dal lock, senza solver; provarlo prima con `--dry-run`), non `composer update -W` (blocchi noti in
[phpstan-modules-zero-errors](../../../Xot/docs/stories/phpstan-modules-zero-errors.story.md)). Stesso ping-pong e
stessa guardia (`InstalledVendorSatisfiesXotConstraintsTest`) in
[filament-5-11-2-filter-form-naming](../../../Xot/docs/stories/filament-5-11-2-filter-form-naming.story.md).
