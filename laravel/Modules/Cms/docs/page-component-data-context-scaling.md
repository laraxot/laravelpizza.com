# Page Component Data-Context Scaling

## Problema

Il componente `Modules\Cms\View\Components\Page` non deve codificare il contesto routing su coppie fisse (`container0`, `slug0`) perche' il routing dinamico puo' crescere (`container1`, `slug1`, ...).

## Pattern corretto

- Il contesto runtime entra in `<x-page>` attraverso un unico payload `:data="[...]"`.
- `Page` deve inoltrare il payload ai block come context trasparente.
- Il merge block resta: `array_merge($data, $block->data)`.

## Conseguenze architetturali

- `resolveContext()` diventa ridondante.
- Il costruttore di `Page` non deve ricevere props specifiche per singoli segmenti.
- `view_params` deve includere `...$this->data` (senza perdere chiavi canoniche `blocks`, `side`, `slug`, `data`).

## Contratto

- Qualsiasi chiave messa in `data` dalla route page deve essere disponibile nel block include.
- Il componente `Page` non deve assumere quanti segmenti `containerN/slugN` esistano.
