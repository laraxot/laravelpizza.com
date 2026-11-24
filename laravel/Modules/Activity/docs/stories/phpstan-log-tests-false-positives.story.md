---
id: "227.1"
epic: 227
title: "Le 183 segnalazioni PHPStan di Activity erano l'analizzatore senza l'estensione di Pest"
slug: phpstan-log-tests-false-positives
status: done
scope: module:Activity
github:
  repository: https://github.com/laraxot/base_quaeris_fila5
  issues: https://github.com/laraxot/base_quaeris_fila5/issues/227
description: "Le 183 segnalazioni su Modules/Activity erano tutte costrutti Pest che l'analizzatore non vedeva, non difetti del modulo: phpstan/extension-installer non aveva mai generato la sua configurazione, quindi pest-plugin-phpstan era spento. Nessuna funzionalita' persa, nessun difetto di sicurezza nella lettura dei log."
document_type: story
category: bmad
created: 2026-11-19
updated: 2026-11-19
---

# 227.1 Activity — 183 segnalazioni PHPStan, zero difetti

## Il numero

| Momento | Activity | Job | Configurazione |
|---------|----------|-----|----------------|
| Rilevazione iniziale | 183 | 85 | `phpstan.neon` con gli `includes` manuali, `GeneratedConfig.php` vuoto |
| Dopo la correzione della configurazione | 0 | 0 | `phpstan.neon` senza gli `includes` manuali, extension-installer attivo |

Misurato da `laravel/` con cache fredda:

```bash
COMPOSER_ALLOW_SUPERUSER=1 ./vendor/bin/phpstan analyse Modules/Activity Modules/Job \
    --memory-limit=-1 --no-progress
```

## La causa

Pest dichiara nelle proprie `Functions.php`:

```php
/** @param-closure-this TestCall  $closure */
function beforeEach(?Closure $closure = null): BeforeEachCall
```

Per PHPStan, quindi, `$this` dentro `it()`, `test()`, `describe()`, `beforeEach()` e
`afterEach()` e' un `Pest\PendingCalls\TestCall`, non il TestCase a cui Pest lega davvero
la closure a runtime. Ogni `$this->base`, `$this->dir`, `$this->jobContainer` diventa
`property.notFound`; il valore diventa `mixed` e si propaga in `argument.type` e in
`binaryOp.invalid` sulle concatenazioni di percorso. Ogni `$this->createUnitMock()`,
`$this->requirePage()`, `$this->artisan()` diventa `method.notFound`.

A correggere quell'annotazione serve `pestphp/pest-plugin-phpstan`, che e' installato:
la sua `TestClosureThisTypeExtension` risolve `$this` al TestCase legato dal file
(`uses(TestCase::class)`), e la sua `TestCaseDynamicPropertyTypeExtension` tipizza le
proprieta' assegnate negli hook.

L'estensione era spenta. `phpstan/extension-installer` registra da solo l'`extension.neon`
di ogni pacchetto, ma da root Composer disattiva i plugin se manca
`COMPOSER_ALLOW_SUPERUSER=1`: `vendor/phpstan/extension-installer/src/GeneratedConfig.php`
era rimasto vuoto, e l'unica estensione Pest attiva era quella del pacchetto `pest`, che
contiene solo due `universalObjectCratesClasses` e non tocca `$this`.

Verifica diretta (la stessa closure, in due contesti di analisi):

```php
beforeEach(function (): void { \PHPStan\dumpType($this); });
// con l'estensione spenta:  Pest\PendingCalls\TestCall
// con l'estensione accesa:  Modules\Activity\Tests\TestCase
```

Le 183 segnalazioni erano quindi **tutte** la stessa cosa detta in 12 file: l'analizzatore
leggeva i test di Pest senza sapere che cos'e' Pest. Stesso schema, e stessa misura, del
commento gia' presente in testa a `phpstan.neon` a proposito di larastan.

La configurazione e' stata corretta in parallelo da un altro agente (rimozione degli
`includes` manuali, ormai duplicati da extension-installer: con entrambi, PHPStan si
rifiuta di partire con `These files are included multiple times`). Questa story **non**
rivendica quella correzione: documenta perche' i 183 non erano difetti di Activity.

## Acceptance Criteria

1. [x] `phpstan analyse Modules/Activity` esce con zero segnalazioni, con cache fredda.
2. [x] Nessun `@phpstan-ignore`, nessuna voce di baseline, nessun `mixed` aggiunto per
       ottenere il punto 1.
3. [x] Verificato che nessuna delle `method.notFound` segnalava una funzionalita' persa:
       `createUnitMock()`, `skipTest()`, `requirePage()`, `markTestSkipped()` esistono
       tutte (`XotBaseTestCase`, `Modules\Activity\Tests\TestCase`).
4. [x] Tolti dai file toccati gli `/** @var TestCase $this */` inline: erano il tentativo
       di tacitare la stessa causa, non funzionavano (`treatPhpDocTypesAsCertain: false`,
       infatti restavano le `property.notFound` su `TestCase::$user`) e le regole del
       repository vietano l'inline `@var` per sovrascrivere un tipo inferito.
5. [x] Tolti `use Mockery;` e `use Throwable;` dai due file di test **senza namespace**
       (`LogDownloadPageTest`, `LogViewerPageTest`): li' sono import di nomi globali, cioe'
       rumore. Negli altri file di Activity gli stessi import servono, perche' quei file
       hanno un `namespace`.
6. [x] Corretto il commento in testa a `ResolveLogFilePathActionTest`: diceva di usare
       `Tests\TestCase` (root), cartella sciolta nel commit `63f7bebfe`.
7. [x] `pest --test-directory=Modules/Activity/tests` resta verde.

## Sicurezza — la lettura dei log dal pannello

`ResolveLogFilePathAction` e' l'unico punto che trasforma input dell'utente in un percorso
su disco. E' stato riletto riga per riga proprio perche' le segnalazioni ci passavano
sopra. **Non e' stato modificato**: le garanzie ci sono gia' e i test le coprono.

Dettaglio in [concepts/log-viewer-sicurezza.md](../wiki/concepts/log-viewer-sicurezza.md).

## Resta aperto

- In `Modules/Job/tests/Feature/` ci sono ancora ~70 `/** @var TestCase $this */` inerti
  (`TaskBusinessLogicTest`, `TaskFrequenciesIntegrationTest`,
  `GetTaskFrequenciesActionIntegrationTest`, `JobBatchBusinessLogicTest`). Sono in file che
  non avevano segnalazioni: toglierli e' meccanico, ma e' churn su file che altri agenti
  stanno toccando, quindi non e' stato fatto qui.
- La configurazione PHPStan e' in mano a chi sta facendo l'audit in
  `docs/audits/phpstan-configurazione.md`: finche' `phpstan.neon` non e' committato, la
  misura "zero" vale sull'albero di lavoro, non su `origin/dev`.
