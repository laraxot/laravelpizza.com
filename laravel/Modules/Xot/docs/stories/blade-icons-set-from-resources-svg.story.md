---
title: "Le icone dei moduli si registrano da resources/svg, non da resources/assets/../svg"
type: story
module: Xot
created: '2026-11-19'
updated: '2026-11-19'
status: review
---

# Le icone dei moduli si registrano da `resources/svg`

Fase BMAD: dev (bugfix). I commit li fa l'utente.

## Sintomo

In locale `/admin` va in 500:

```
BladeUI\Icons\Exceptions\SvgNotFound
Svg by name "tenant-icon" from set "default" not found.
resources/views/vendor/filament-panels/components/sidebar/item.blade.php:60
```

`tenant-icon` viene da `Modules/Tenant/config/config.php` (`'icon' => 'tenant-icon'`) e il
file `Modules/Tenant/resources/svg/icon.svg` esiste. "set default" vuol dire che il prefisso
`tenant-` non corrisponde a nessun set registrato.

## Causa

`XotBaseServiceProvider::registerBladeIcons()` (da `54dc8a2315`, marco76tv, 2026-10-06) non
guardava `resources/svg`: lo ricavava dal generator `assets` di nwidart,
`resources/assets` + `'/../svg'`. Su Linux `a/../b` si risolve solo se `a` esiste, quindi un
modulo **senza** `resources/assets` non registrava il suo set, e il `catch (\Throwable)` lo
taceva.

Il 2026-11-17 il commit `9b5dbe67` di Tenant (marco76tv, `.`) ha tolto lo scaffold vuoto
`resources/assets` (`js/app.js`, `sass/app.scss`, `.gitkeep`). Insieme e' sparito il set
`tenant`. Misurato su tutti i moduli: i 9 con `resources/assets` hanno il set, i 10 senza no
(AI, Chart, CloudStorage, DbForge, Geo, Lang, Limesurvey, Quaeris, Setting, Tenant), e tutti
hanno `resources/svg`. La cache `bootstrap/cache/blade-icons.php` scritta da
`php artisan optimize` (dentro `bashscripts/lib/deploy.sh`) fotografa lo stesso buco.

## Decisione

La regola documentata e' gia' quella giusta (`docs/` di Xot, sezione icone: "SVG files go in
`Modules/<Module>/resources/svg/` … `registerBladeIcons()` registers that folder with the
lower-case module name as prefix"). Il codice si allinea: `module_path($this->name,
'resources/svg')`, come `registerViews()` fa per `resources/views`. Non si ricreano le cartelle
`resources/assets` tolte di proposito.

Blade Icons legge le icone dai `paths` registrati a runtime (`Factory::contents()`), non dalla
cache: con la correzione `tenant-icon` si risolve anche senza rigenerare la cache, che va
comunque pulita perche' l'elenco delle icone sia completo.

## Guardia

`Modules/Xot/tests/Unit/ModuleSvgIconSetsAreRegisteredTest.php`: per ogni modulo abilitato con
almeno un `.svg` in `resources/svg`, l'icona `<modulo minuscolo>-<file>` si risolve con
`Factory::svg()`. Senza la correzione fallisce per i 9 moduli abilitati senza `resources/assets`.

Il test usa `XotBaseTestCase` e non `TestCase`: con le `DatabaseTransactions` di `TestCase`
ogni test Xot si ferma nel `setUp` (`SQLiteDatabaseDoesNotExistException` su
`database/test_data.sqlite`, la transazione parte prima che il percorso sia impostato), e
questo test non usa il database.

## Acceptance criteria

- [x] Test guardia rosso prima della correzione (6 moduli abilitati: `chart-chart-icon`,
  `dbforge-db-icon`, `geo-archive-box`, `lang-favicon`, `quaeris-logo`,
  `tenant-building-animated`), verde dopo.
- [x] PHPStan sul provider e sul test: 0 errori.
- [x] Pint: passato. PHPMD (cleancode, codesize, design; Xot non ha un ruleset suo): 13 prima,
  13 dopo, le stesse (preesistenti); 0 sul test.
- [x] Applicazione reale (`artisan tinker`, cache attuali): `tenant-icon`, `quaeris-logo`,
  `geo-archive-box`, `user-device` si risolvono.
- [ ] `/admin` in locale si apre (verifica dell'utente nel browser).

## Log verifiche

```
DB_HOST=127.0.0.1 APP_*_CACHE=<inesistenti> pest --no-coverage --test-directory=Modules/Xot/tests ModuleSvgIconSetsAreRegisteredTest
 prima:  1 failed  (+ chart-chart-icon, dbforge-db-icon, geo-archive-box, lang-favicon, quaeris-logo, tenant-building-animated)
 dopo:   1 passed (1 assertions)

php artisan tinker: svg('tenant-icon') OK (226 byte), quaeris-logo OK, geo-archive-box OK, user-device OK
```

## Note

- La cache `bootstrap/cache/blade-icons.php` (e config/eventi) l'ha scritta `php artisan optimize`
  dentro `bashscripts/lib/deploy.sh` alle 10:43 del 2026-11-19, senza i 10 set. Non serve per
  disegnare le icone, ma l'elenco completo (`GetAllIconsAction`, `icons:cache`) la usa: va
  rigenerata (`php artisan optimize:clear` in locale).
- Il commento "Blade UI Kit default set may already contain prefixes like geo" e il controllo
  `svg($prefix.'::non-existent-test')` non sono toccati: con il set `geo` registrato non c'e'
  collisione (la guardia lo prova per Geo).
