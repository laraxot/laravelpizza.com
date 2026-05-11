# Page Component Runtime

## Sintesi

`Page.php` contiene la logica.

`components/page.blade.php` contiene solo il rendering minimo.

## Contratto

### PHP component

[Page.php](../app/View/Components/Page.php) deve:

- comporre lo slug
- caricare i blocchi
- preparare i dati per la view

### Blade

[page.blade.php](../resources/views/components/page.blade.php) deve:

- iterare i blocchi
- includere le view dei blocchi
- non contenere logica applicativa

## Motivazione

Questo mantiene il componente pagina estendibile e permette al tema di overrideare la view senza ricopiare la logica del dominio CMS.

## Collegamenti

- [component-page-alias-rule.md](./component-page-alias-rule.md)
- [layout-runtime-contract.md](./layout-runtime-contract.md)
- [../../Themes/Sixteen/docs/component-page-runtime.md](../../Themes/Sixteen/docs/component-page-runtime.md)
