# Page Component Alias Rule

## Sintesi

Per il rendering del contenuto pagina usare `<x-page>`.

Non usare `<x-sixteen::page>`.

## Motivo architetturale

- il namespace pubblico stabile e `pub_theme`, non `Sixteen`
- il tema puo cambiare
- l'alias di progetto per il componente pagina e `page`

Quindi la blade deve restare indipendente dal nome del tema attivo.

## Forme corrette

- preferita: `<x-page ... />`
- esplicita: `<x-pub_theme::page ... />`

## Forma vietata

- `<x-sixteen::page ... />`

## Collegamenti

- [layout-runtime-contract.md](./layout-runtime-contract.md)
- [../../Themes/Sixteen/docs/component-page-alias-rule.md](../../Themes/Sixteen/docs/component-page-alias-rule.md)
