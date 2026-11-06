---
title: "[STORY] PHPStan sottosistema Head/SEO: laravel/head non installato"
type: story
module: Cms
status: blocked-human-decision
priority: high
created: 2026-11-05
updated: 2026-11-05
tags: [bmad, phpstan, seo, head, schema-org, laravel-head, composer]
related:
  - "./seo-head-component.story.md"
  - "../seo-head-architecture.md"
---

# [STORY] PHPStan sottosistema Head/SEO: laravel/head non installato

## Scopo del sottosistema

`<x-cms::head>` (`Modules\Cms\View\Components\Head`) compone il `<head>` del front office:
risolve brand, titolo, descrizione, canonical, robots, hreflang e icone, li scrive sul manager
di `laravel/head` (`Laravel\Head\Facades\Head`) e la view `cms::components.head` li rende con `@head`.

`Modules\Cms\Actions\Head\BuildHeadSchemaAction` costruisce i dati strutturati schema.org del head:
sulla home `Organization` + `WebSite` (con `@id` indipendente dalla lingua), sulle pagine interne
l'entita' di pagina (con `isPartOf` verso il `WebSite`) + `BreadcrumbList`. Il componente passa il
risultato a `Head::schema()`. I due test in `tests/Unit/Actions/Head/` fissano il contratto
(`BuildHeadSchemaActionTest`, `HeadSeoPolicyTest`).

## Causa dei 50 errori PHPStan

Le 30 `class.notFound` (e le 20 conseguenti `method.nonObject`, `return.type`, `offsetAccess`) hanno
un'unica radice: il pacchetto **`laravel/head`** (namespace `Laravel\Head\{Schema,Facades}`) non e' installato
in questo checkout.

- Dichiarato in `laravel/Modules/Cms/composer.json` (`"laravel/head": "^0.2.2"`), unito al root dal merge-plugin.
- Assente da `laravel/composer.lock` (tracciato in git) e da `laravel/vendor/` (`vendor/laravel/` non lo contiene).
- Nessuna classe rinominata o spostata: `Organization`, `WebSite`, `Breadcrumbs`, `SchemaObject`, `Facades\Head`
  esistono con questi nomi in `laravel/head` v0.2.2.
- Compatibilita': il pacchetto richiede `illuminate/* ^13.17`; qui il framework e' v13.34.0 (PHP 8.4), quindi installabile.
- Le docs (`seo-head-architecture.md`, `seo-head-component.story.md`) dicevano «gia' installata / in `vendor/`»:
  vero nell'ambiente di sviluppo originale, falso in questo checkout (lock e vendor non allineati). Corrette.

Impatto oltre PHPStan: senza il pacchetto `@head` e il componente vanno in errore a runtime e i due test
falliscono con `Class "Laravel\Head\Schema\Organization" not found`.

## Fix

Nessuna modifica logica ai 4 file: il codice e' corretto. Non si creano classi inventate ne' si aggiungono
`@phpstan-ignore`/baseline (la correzione corretta e' l'installazione della dipendenza gia' dichiarata).
Sui 4 file e' stato applicato solo `pint` (Yoda/phpdoc normalizzati dalla config del repo, nessun cambio di comportamento).

**Azione richiesta (decisione umana, tocca `composer.lock` tracciato e `vendor/`):**

```bash
cd laravel && composer update laravel/head --with-dependencies --no-scripts
# poi verificare
./vendor/bin/phpstan analyse Modules/Cms/app/Actions/Head Modules/Cms/app/View/Components/Head.php \
  Modules/Cms/tests/Unit/Actions/Head --memory-limit=-1 --no-progress
```

## Verifica (2026-11-05)

| Scenario | Esito |
|----------|-------|
| PHPStan sullo stato reale (pacchetto assente) | 50 errori: 22 `BuildHeadSchemaAction`, 16 `Head.php`, 7 `BuildHeadSchemaActionTest`, 5 `HeadSeoPolicyTest` |
| PHPStan con `Laravel\Head\` visibile (`-a` verso copia read-only di `laravel/head` v0.2.2 del progetto gemello, nessun file del repo toccato) | 0 errori, exit 0 |
| Pest dei 2 test con lo stesso shim come `--bootstrap` | 9 passati, 34 asserzioni |
| Pest dei test senza shim (stato reale) | falliscono: `Class "Laravel\Head\Schema\Organization" not found` |
| `php -l` e `pint` sui 4 file | puliti |

Lo shim e' fuori dal repo (scratchpad di sessione): non e' una soluzione, solo la prova che il codice e' corretto
una volta installata la dipendenza.

## Acceptance criteria

- [x] Causa identificata: dipendenza dichiarata ma non installata/locked.
- [x] Codice dei 4 file verificato contro l'API reale di `laravel/head` v0.2.2 (0 errori PHPStan, 9 test verdi).
- [x] Docs allineate allo stato reale.
- [ ] `composer update laravel/head` eseguito da un umano (aggiorna `composer.lock` e `vendor/`).
- [ ] PHPStan sui 4 file a 0 errori senza shim dopo l'installazione.
