# Geo Vite build contract

## Scopo

Rendere `npm run build` del modulo Geo ripetibile e stabile, evitando errori dovuti a entry Vite non allineate ai file reali.

## Errore reale osservato

Comando:

- `cd laravel/Modules/Geo && npm run build`

Errore iniziale:

- `Could not resolve entry module "resources/css/app.css"`

Secondo errore emerso dopo il primo fix:

- `coordinate-picker-lit.js (48:40): Expected ';', '}' or <eof>`

## Root cause

1. `vite.config.js` puntava a un CSS entry inesistente (`resources/css/app.css`).
2. `buildDirectory` era impostata a `assets/chart`, incoerente con il modulo Geo.
3. `coordinate-picker-lit.js` conteneva un blocco `constructor` non chiuso prima dei metodi successivi.

## Fix implementato

In `laravel/Modules/Geo/vite.config.js`:

- `buildDirectory: 'assets/geo'`
- input CSS corretto su `resources/css/filament/map-picker.css`
- input JS esplicito `resources/js/components/coordinate-picker-lit.js`

In `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js`:

- chiusura corretta del `constructor`.

## Verifica

Comando finale:

- `cd laravel/Modules/Geo && npm run build`

Esito:

- build completata con successo
- output in `public/assets/*`
- manifest generato in `public/manifest.json`

## Regole anti-regressione

1. Ogni path in `laravel(... input: [...])` deve corrispondere a un file esistente.
2. `buildDirectory` deve riflettere il dominio modulo (`assets/geo` per Geo).
3. Dopo modifica JS dei web component, rieseguire sempre `npm run build`.
4. In caso di errore parser Rollup, verificare prima parentesi/chiarezza blocchi classe.

## Riferimenti

- [map picker runtime asset governance](./map-picker-runtime-asset-governance.md)
- [filament admin panel map visibility contract](./filament-admin-panel-map-visibility-contract.md)
