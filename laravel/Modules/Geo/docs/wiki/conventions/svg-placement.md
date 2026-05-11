# SVG File Placement Convention

## Regola: Posizionamento degli file SVG

Tutti gli file SVG utilizzati nel progetto devono essere posizionati nella seguente struttura:
```
laravel/Modules/{nome-modulo}/resources/svg/{nome-file}.svg
```

Esempi corretti:
- `laravel/Modules/Geo/resources/svg/custom-marker.svg`
- `laravel/Modules/UI/resources/svg/geo-icon.svg`
- `laravel/Modules/Xot/resources/svg/location-map.svg`

## Motivazione

1. **Organizzazione modulare**: Gli asset appartengono al modulo che li utilizza
2. **Evita conflitti**: Nomi di file unici per modulo
3. **Manutenzione semplificata**: Facile individuare asset per modulo
4. **Coerenza con Laravel**: Segue la struttura delle risorse Laravel

## Verifica

Prima di effettuare il commit, verificare che:
- Gli SVG non siano posizionati in `public/` o `resources/` globale
- Non esistano duplicati tra moduli
- I percorsi nei componenti corrispondano alla struttura sopra

## Esempio di utilizzo in componente

```javascript
// In un componente Geo
const icon = L.icon({
    iconUrl: '/resources/svg/custom-marker.svg',
    iconSize: [35, 45],
    iconAnchor: [17, 45]
});
```

## Eccezioni

Gli SVG condivisi tra più moduli devono essere posizionati nel modulo più specifico che li utilizza, oppure documentati eccezionalmente in `laravel/resources/svg/shared/` con approvazione esplicita.

## Riferimenti

- [Asset Management Guidelines](/docs/wiki/concepts/asset-management)
- [Laravel Documentation: Assets](https://laravel.com/docs/mix)
- [Geo Module SVG Assets](/docs/wiki/concepts/svg-asset-architecture)