---
title: "queueable action testing"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "queueable action testing"
issues: []
discussions: []
---

# Testare le QueueableAction: convenzione di chiamata

Documenta la correzione PHPStan (livello max) del modulo Geo che ha eliminato
50 errori, per la maggior parte `new.noConstructor` nei test.

## Il problema

Le Action del modulo usano il trait `Spatie\QueueableAction\QueueableAction` e
**non dichiarano un costruttore**. Le dipendenze vengono risolte dal container a
runtime con `app(...)`, non iniettate:

```php
final class CalculateDistanceAction implements CalculateDistanceActionContract
{
    use QueueableAction;

    public function execute(LocationData $origin, LocationData $destination): array
    {
        $response = app(CalculateDistanceMatrixAction::class)->execute(/* ... */);
        // ...
    }
}
```

I test istanziavano invece l'Action con `new`, passando uno stub al costruttore
inesistente:

```php
// ERRATO — l'Action non ha costruttore
$action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub($response));
```

PHPStan lo segnala come `new.noConstructor`:
> Class ... does not have a constructor and must be instantiated without any parameters.

## La convenzione corretta

Poiché l'Action risolve le proprie dipendenze via `app()`, il test deve:

1. **Bindare lo stub nel container** al posto della dipendenza reale.
2. **Risolvere l'Action dal container** con `app()` — mai con `new`.

```php
function makeCalculateDistanceAction(CalculateDistanceMatrixActionStub $stub): CalculateDistanceAction
{
    app()->instance(CalculateDistanceMatrixAction::class, $stub);

    return app(CalculateDistanceAction::class);
}
```

Vale anche per le catene di Action: `FilterCoordinatesInRadiusAction` risolve
`CalculateDistanceAction`, che a sua volta risolve `CalculateDistanceMatrixAction`.
Bindare solo la dipendenza foglia (il matrix stub) pilota l'intera catena, senza
`new` da nessuna parte.

Gli stub restano sottoclassi dell'Action reale che sovrascrivono `execute()`
(o il metodo protetto usato come seam, es. `getPlaces()`): sono un fixture
legittimo, non una violazione del pattern.

## Regola generale

> Le Action con `QueueableAction` si invocano SEMPRE via
> `app(NomeAction::class)->execute(...)`, mai con `new NomeAction(...)`.
> Nei test, le dipendenze si sostituiscono con `app()->instance(Dipendenza::class, $stub)`,
> non passandole al costruttore.

## Altre correzioni incluse

- **`@phpstan-ignore property.defaultValue` obsoleti** (`LatLngWidget`,
  `LocationWidget`, `WebbingbrasilMap`): l'errore sottostante era già risolto,
  quindi l'ignore non trovava più corrispondenza (`ignore.unmatchedIdentifier`,
  non ignorabile). Rimossi. In `LocationWidget` eliminato anche un `@var
  view-string` duplicato.
- **`Dashboard::getWidgets()`**: il tipo di ritorno PHPDoc `list<class-string>`
  non era compatibile (covariante) con quello del genitore
  `XotBaseDashboard::getWidgets(): array<string, mixed>`. Allineato a
  `array<class-string>`, coerente con i Dashboard degli altri moduli.
- **Test convertiti a Pest**: sostituite le asserzioni `PHPUnit\Framework\Assert`
  con `expect()` / `->toThrow()`. Le aspettative sui messaggi di
  `ElevationException` (risposta vuota e struttura non valida) sono state
  corrette al messaggio realmente emesso da `ElevationException::invalidResponse()`
  — «Risposta non valida dal servizio di elevazione» — invece di messaggi
  inesistenti nel codice.

## Note ambientali

- L'unico residuo PHPStan in scope-modulo è l'avviso di config non ignorabile
  «Ignored error pattern #@mixin contains unknown class# was not matched»:
  è un artefatto dello scoping a singolo modulo (`laravel/phpstan.neon`, immutabile),
  non un errore di codice del modulo Geo.
- I test basati su `TestCase` (Calculate/Filter) non girano per un problema
  d'ambiente pre-esistente e trasversale al repo: `.env.testing` impone
  `DB_CONNECTION=mysql` mentre `phpunit.xml` imposta `DB_DATABASE=:memory:`,
  producendo «Unknown database ':memory:'» nel setup DB. I corpi dei test qui
  convertiti non usano il DB (usano stub bindati nel container); i test
  `LightTestCase` (Elevation, IPGeolocation) passano.
