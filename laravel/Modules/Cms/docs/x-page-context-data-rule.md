# X-Page Context Data Rule

## Regola

Il componente `Modules\Cms\View\Components\Page` non deve avere props dedicate per singole variabili di contesto route-specifiche come `container0` o `slug0`.

Il contesto runtime deve passare attraverso:

- `data`

cioe' un array estendibile che puo' contenere oggi:

- `container0`
- `slug0`

e domani anche:

- `container1`
- `slug1`
- `container2`
- `slug2`

senza cambiare la signature del componente.

## Motivazione

- evita accoppiamento del componente `x-page` a uno specifico pattern route;
- mantiene il componente riusabile per pagine a profondita variabile;
- elimina duplicazione tra props dedicate e chiavi gia' presenti in `$data`;
- rispetta DRY e KISS.

## Contratto di render

Il `render()` di `Page` deve passare alla view:

- i parametri interni (`blocks`, `side`, `slug`, `data`);
- lo spread di `...$this->data` per rendere disponibili in view le chiavi contestuali senza introdurre nuove props dedicate.

Le chiavi interne del componente devono avere precedenza sulle chiavi utente in caso di collisione.

## Esempio di collisione gestita

Se `data` contiene:

- `side`
- `slug`

queste chiavi non devono ridefinire il comportamento strutturale del componente.

Il componente puo' esporre `...$data` alla view per comodita', ma i valori canonici di:

- `blocks`
- `side`
- `slug`
- `data`

devono restare quelli costruiti internamente da `Page`.
