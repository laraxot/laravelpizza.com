# Scopo test fixtures Geo

## GeoMapDatasetFixture

Simula dataset geo (mappe, categorie) nei test delle azioni map widget, senza DB reale.

## HandlesCoordinatesProbe

Espone i metodi protetti del trait `HandlesCoordinates` (validazione coordinate, distanza Haversine, formattazione) per i test in `tests/Unit/Traits/HandlesCoordinatesTest.php`. Il trait di produzione non persiste su Eloquent: non va testato con `save()` su classi plain.

## HasAddressTestModel

Fixture canonica per il trait `HasAddress` (morph verso `Address`); sostituisce i vecchi test su `HasAddresses` (trait rimosso).

## Story correlata

- [phpstan-geo-unit-tests-scope.story.md](./phpstan-geo-unit-tests-scope.story.md)
