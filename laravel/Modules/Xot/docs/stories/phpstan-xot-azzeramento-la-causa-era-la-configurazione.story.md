---
id: story-phpstan-xot-azzeramento
slug: phpstan-xot-azzeramento-la-causa-era-la-configurazione
epic: 227
epic_title: "Azzeramento delle segnalazioni PHPStan dei moduli"
title: "PHPStan su Xot: da 193 a 0, e nessuna delle 193 era un difetto del codice"
description: "Le 193 segnalazioni attribuite a Modules/Xot non venivano dal codice di Xot: venivano dall'analizzatore mal configurato. phpstan.neon elencava a mano quattro estensioni, quindi pestphp/pest-plugin-phpstan non era registrata e dentro le closure di Pest $this restava sconosciuto; nel frattempo phpstan/extension-installer, dichiarata proprio da Modules/Xot/composer.json, ha generato la sua configurazione e la duplicazione ha impedito a PHPStan di partire del tutto. Registrate le estensioni una volta sola, Xot misura 0 senza una riga di codice cambiata. Verificato che l'ambito sia reale con due file sonda."
document_type: story
category: bmad
type: story
status: done
priority: high
module: Xot
scope: module:Xot
created: '2026-11-19'
updated: '2026-11-19'
tags: [xot, phpstan, qualita, configurazione, pest, analisi-statica]
github:
  repository: https://github.com/laraxot/base_quaeris_fila5
  issues: https://github.com/laraxot/base_quaeris_fila5/issues/227
related:
  - ../contracts/xotbase-classes.md
  - ../../../Quaeris/docs/stories/phpstan-quaeris-azzeramento-e-verifica.story.md
  - ../../../../../docs/audits/phpstan-configurazione.md
qmd: "phpstan xot azzeramento la causa era"
---

# PHPStan su Xot: da 193 a 0

## Story

Come **chi deve modificare il modulo delle classi base senza rompere gli altri diciotto**, voglio
**che l'analizzatore statico dica la verita' su Xot**, cosi' che **le sue segnalazioni servano a
trovare difetti invece che a misurare la propria configurazione**.

## Numeri

| Momento | Xot | Come misurato |
|---|---|---|
| Prima (riportato nella consegna) | 193 | configurazione con gli `includes` manuali |
| Durante l'indagine | **l'analisi non partiva** | `exit 1`, nessun file analizzato |
| Dopo | **0** | `analyse Modules/Xot Modules/Quaeris`, `exit 0` |

Comando di misura, da `laravel/`:

```bash
COMPOSER_ALLOW_SUPERUSER=1 ./vendor/bin/phpstan analyse Modules/Xot Modules/Quaeris \
    --memory-limit=-1 --no-progress
```

## Che cosa e' successo davvero

### Primo fatto: l'analizzatore non partiva

Il primo tentativo di misura e' finito cosi', in meno di un minuto e senza analizzare niente:

```
These files are included multiple times:
- vendor/larastan/larastan/extension.neon
- vendor/nesbot/carbon/extension.neon
- vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon
- vendor/pestphp/pest/extension.neon
```

Uscita `1`, nessuna riga di risultato. Non e' un avviso: PHPStan si ferma.

La causa e' in due pezzi che si sono incontrati:

1. `phpstan.neon` elencava a mano quelle quattro estensioni;
2. `phpstan/extension-installer` — dichiarata da **`Modules/Xot/composer.json`**, cioe' da questo
   modulo — registra da sola l'`extension.neon` di ogni pacchetto che ne pubblica uno.

Finche' `vendor/phpstan/extension-installer/src/GeneratedConfig.php` e' rimasto vuoto la
duplicazione non esisteva, perche' da root composer disattiva i plugin senza
`COMPOSER_ALLOW_SUPERUSER=1` e extension-installer non aveva mai generato la propria
configurazione. Appena un `composer` e' girato con i plugin attivi, il file si e' popolato e la
duplicazione e' diventata bloccante.

Correzione (fatta in parallelo da un'altra sessione sullo stesso branch, verificata qui): togliere
gli `includes` manuali e lasciare che extension-installer registri le estensioni **una volta sola**.
`bleedingEdge.neon` resta elencato a mano perche' non appartiene a un pacchetto e nessuno lo
registra al posto nostro.

### Secondo fatto: mancava l'estensione che spiega Pest a PHPStan

Gli `includes` manuali elencavano `pestphp/pest/extension.neon`, che contiene **cinque righe**: due
classi dichiarate `universalObjectCratesClasses`. Non elencavano
`pestphp/pest-plugin-phpstan/extension.neon`, che e' l'estensione vera e che extension-installer
registra. Fra i servizi che quest'ultima porta:

- `TestClosureThisTypeExtension` e `UsesHookClosureThisTypeExtension` — legano `$this` dentro le
  closure di `it()`, `test()`, `beforeEach()` al `TestCase` della suite;
- `TestCaseDynamicPropertyTypeExtension` — tipizza le property dinamiche del `TestCase`;
- `PestInternalClassAccessIgnoreExtension` e `ArchExpectationPropertyIgnoreExtension` — tolgono il
  rumore sulle classi `@internal` di Pest e sulle catene `arch()`.

Senza quell'estensione, dentro una closure di Pest `$this` e' sconosciuto. Da li' discende per
intero il profilo delle 193 segnalazioni descritto nella consegna, file per file:

| File | Segnalazioni | Perche' |
|---|---|---|
| `tests/Unit/HostApp/FeatureFlagsTest.php` | 34 | vedi sotto |
| `tests/Feature/Filament/Widgets/EnvWidgetTest.php` | 25 | `$this->envPath` e `$this->originalEnvContent`, scritte in `beforeEach` e lette nei test: con `$this` sconosciuto diventano `property.notFound` |
| `tests/Arch/ArchitectureTest.php` | 21 | catene `arch()->preset()->php()->ignoring(...)`, che `ArchExpectationPropertyIgnoreExtension` copre |

`FeatureFlagsTest` e' il caso piu' istruttivo. Ogni test comincia cosi':

```php
if (! class_exists(FeatureFlags::class)) {
    $this->markTestSkipped('Host app senza App\Support\FeatureFlags.');
}
```

`App\Support\FeatureFlags` **non esiste in questo progetto** — verificato:

```
php -r 'require "vendor/autoload.php"; var_dump(class_exists("App\\Support\\FeatureFlags"));'
bool(false)
```

Con `$this` legato al `TestCase`, PHPStan sa che `markTestSkipped()` ha tipo di ritorno `never`
(`vendor/phpunit/phpunit/src/Framework/Assert.php:3299`), quindi il ramo «classe assente» non
prosegue, quindi dopo l'`if` la classe **esiste** e le 34 chiamate statiche sono corrette. Con `$this`
sconosciuto quella catena si spezza al primo anello e ognuna delle 34 chiamate diventa
`class.notFound`.

Il test era gia' scritto bene. Era l'analizzatore a non saperlo leggere.

## Perche' il numero era zero e non ho dovuto toccare il codice

Nessuna delle tre forme sopra e' un difetto del codice di Xot: sono tutte conseguenze di un solo
pacchetto non registrato. Non c'era niente da correggere nei test ne' nelle classi base, e la
regola della consegna — *capire a cosa serviva quel codice prima di farlo tacere* — qui ha prodotto
come risposta che il codice andava bene e lo strumento no.

**Nessun `@phpstan-ignore` aggiunto, nessun `mixed` introdotto, nessuna firma allargata.**

## Lo zero e' vero: verifica dell'ambito

Uno zero puo' voler dire «nessun difetto» oppure «nessun file analizzato», e le due cose si
distinguono solo misurandole. Due file sonda temporanei, con un errore evidente ciascuno:

- `Modules/Xot/app/ZzPhpstanScopeProbe.php` — un metodo `: int` che ritorna una stringa;
- `Modules/Quaeris/tests/Unit/ZzPhpstanScopeProbeTest.php` — un metodo `: string` che ritorna un int.

Risultato dello stesso comando di misura: **2 segnalazioni, una per sonda**, entrambe
`return.type`. Una terza sonda in forma di file Pest senza namespace
(`Modules/Xot/tests/Unit/ZzProbe2Test.php`, con una chiamata statica a una classe inesistente) e'
stata segnalata come `class.notFound` mentre `FeatureFlagsTest.php`, analizzato nello stesso
comando, restava a zero: i file Pest sono analizzati, le classi sconosciute sono segnalate, e lo
zero di `FeatureFlagsTest` e' il risultato del restringimento di `class_exists()`, non di
un'esclusione. Tutte e tre le sonde sono state cancellate subito dopo la misura.

## Che cosa cambia per gli altri moduli

La correzione non e' in Xot, e' nella configurazione di tutto il monorepo: vale per **tutti e
diciannove i moduli** contemporaneamente. In particolare:

- finche' gli `includes` erano duplicati **nessuno** poteva misurare niente: ogni conteggio preso in
  quella finestra vale zero come informazione;
- ogni modulo che ha test Pest con stato in `$this` o con catene `arch()` vedra' sparire le stesse
  tre forme di segnalazione senza modifiche al codice. Chi sta correggendo quei file a mano sta
  correggendo sintomi;
- la voce `ignoreErrors` su `method.internalClass` per il namespace `Pest\` in `phpstan.neon` e' ora
  ridondante: `PestInternalClassAccessIgnoreExtension` fa gia' lo stesso lavoro. Non e' stata tolta
  qui perche' appartiene a un'altra sessione in corso sullo stesso file.

## Difetti veri trovati, non corretti qui

1. **Il comando di verifica della consegna non limita niente.**
   `./vendor/bin/pest --test-directory=Modules/Xot/tests` non esegue i test di Xot: esegue
   **l'intera suite dei diciannove moduli**, perche' `phpunit.xml` dichiara una sola testsuite
   `Application` su `Modules/*/tests` e `--test-directory` non la restringe. Misurato: lanciato per
   Quaeris, ha eseguito test di Cms, AI e Activity. La forma che funziona vuole anche il percorso
   come argomento:

   ```bash
   ./vendor/bin/pest --test-directory=Modules/Xot/tests Modules/Xot/tests
   ```

   Il solo argomento posizionale non basta: Pest cerca `laravel/tests/`, che non esiste, e muore con
   `FatalException`.

2. **`XotBaseServiceProvider::registerConfig()` non e' ricorsiva** (`File::glob($configPath.'/*.php')`).
   Gia' nota, ora scritta nel contratto delle classi base.

3. **`XotBaseMigration::tableUpdate()` crea la tabella se manca**, con la sola closure di
   aggiornamento. Gia' nota e tracciata in una issue aperta, ora scritta nel contratto.

Nessuna delle tre e' stata corretta in questa story: la prima appartiene alla configurazione dei
test, le altre due cambiano il comportamento di classi base e vanno affrontate con la verifica sui
moduli consumatori che il contratto adesso prescrive.

## Acceptance Criteria

- [x] `analyse Modules/Xot` non riporta segnalazioni
- [x] l'ambito dell'analisi e' verificato con file sonda, non dedotto dallo zero
- [x] nessun `@phpstan-ignore` aggiunto
- [x] nessun `mixed` introdotto
- [x] nessuna firma di classe `XotBase*` modificata, quindi nessun rischio per i moduli consumatori
- [x] la suite di Xot gira e il suo esito e' confrontato con quello precedente
- [x] la suite di un modulo consumatore (Quaeris) gira
- [x] il contratto delle classi `XotBase*` e' scritto in `docs/contracts/xotbase-classes.md`
- [x] la causa e' scritta in modo che un altro agente possa riprodurla

## Riferimenti

- [Contratto delle classi XotBase](../contracts/xotbase-classes.md)
- [Audit: perche' i conteggi PHPStan non tornavano](../../../../../docs/audits/phpstan-configurazione.md)
- [Story gemella su Quaeris](../../../Quaeris/docs/stories/phpstan-quaeris-azzeramento-e-verifica.story.md)
