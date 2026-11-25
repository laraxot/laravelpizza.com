---
title: "Topic laravel-folio"
type: digest
status: active
qmd: "digest ceiling 100 laravel-folio"
---

# Topic laravel-folio

Sintesi automatica di 3 documenti (chiave `laravel-folio`).

## Laravel Folio Governance

_Fonte: `laravel-folio-governance.md`_

# Laravel Folio Governance

## Contesto

Nel progetto il frontoffice CMS e i temi pubblici usano Laravel Folio come router file-based. Questo significa che la struttura dei file Blade non e' una comodita' estetica: e' la definizione stessa delle route pubbliche.

## Regole operative

- Se una pagina puo' esistere come file Folio, non va duplicata in `routes/web.php`.
- Il provider che monta Folio e' il punto corretto per URI prefix, domain routing e middleware condivisi.
- `index.blade.php` rappresenta il root della directory; usarlo evita slug di comodo o redirect artificiali.
- Le variabili di route vanno espresse tramite filename dinamici (`[slug]`, `[id]`, `[...segments]`).
- Se il dominio lo consente, preferire implicit model binding via filename a resolver personalizzati sparsi.
- Le pagine Blade non devono farsi carico di riparare mount o middleware errati.

## `render()` e `name()`

- `name()` e' utile solo per route che richiedono URL generation stabile.
- `render()` e' appropriato per arricchire la response o passare dati alla view, non per concentrare business logic o ricostruire a mano il contesto di routing.

## Dynamic Theme Paths

Per supportare l'architettura modulare di Laraxot, il mount point di Folio non deve essere hardcoded.
L'unico owner è `Modules\Cms\Providers\FolioVoltServiceProvider` — **non** `App\Providers\FolioServiceProvider`
(istruizione: scomodare `laravel/app/Providers/FolioServiceProvider.php` è sbagliato; basta Cms).
Il path tema si risolve 

## Laravel Folio Operational Rules

_Fonte: `laravel-folio-operational-rules.md`_

# Laravel Folio Operational Rules

## Fonte

Studio basato su:

- documentazione ufficiale Laravel Folio
- repository ufficiale `laravel/folio`

## Regole operative per questo progetto

### 1. Folio-first sul frontoffice

Le pagine frontoffice del CMS e del tema devono essere rappresentate come pagine Folio nei path montati, non come route controller duplicate.

### 2. Parametri dal filename

Usare il naming Folio quando il path lo richiede:

- `[slug]`
- `[id]`
- `[...segments]`

Questo evita parsing manuale inutile dei segmenti.

### 3. Model binding da filename

Se il caso d'uso e' compatibile, Folio puo' risolvere implicit binding direttamente dal filename. Va preferito a wiring manuale disperso.

## laravel/folio — owner Cms

_Fonte: `wiki/concepts/laravel-folio-module-dependency.md`_

# laravel/folio — owner Cms

## Regola

| Pacchetto | Owner | Vietato in |
|-----------|-------|------------|
| `laravel/folio` | `Modules/Cms/composer.json` | `laravel/composer.json`, `Modules/Xot/composer.json` |

## Perché Cms

- `FolioVoltServiceProvider` registra `Folio::path()` sui temi
- `SetFolioLocale`, rotte FO, `ResolvePageAction` vivono in Cms
- Folio è **contratto frontoffice CMS**, non infrastruttura Xot

## Evidenza codice

- `Modules/Cms/app/Providers/FolioVoltServiceProvider.php` — bootstrap Folio
- `Modules/Cms/app/Http/Middleware/SetFolioLocale.php` — locale FO

## Workflow fix

```bash
# require in Modules/Cms/composer.json → "laravel/folio": "^1.2"
rm -rf laravel/Modules/Cms/vendor
cd laravel && php -d memory_limit=-1 composer.phar update -W
ls laravel/vendor/laravel/folio
```

## Anti-pattern
