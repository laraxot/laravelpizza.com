---
title: "Blocchi del page builder e integrazione con Cms"
type: reference
module: UI
status: active
updated: 2026-11-25
qmd: "ui blocks page builder GetAllBlocksAction Render Block ResolveLocalizedBlockData Cms optional Filament Blocks"
---

# Blocchi e integrazione con Cms

UI definisce *come si compone* una pagina da blocchi; il contenuto e la localizzazione vivono in Cms (dipendenza
**opzionale**, vedi [ADR 0004](adr/0004-optional-cms-delegation-for-block-data.md) e
[ADR 0005](adr/0005-ui-blocks-use-cms-localization.md)).

## Definizione dei blocchi

`app/Filament/Blocks/` contiene 14 blocchi per il Builder di Filament: `Category`, `Contact`, `Heading`, `Hero`, `Image`,
`ImageSpatie`, `ImagesGallery`, `Navigation`, `Page`, `Paragraph`, `Post`, `Slider`, `Title`, `VideoSpatie`.
Due stili coesistono: classi che estendono `XotBaseBlock` (`Category`, `Contact`, `Navigation`, `Page`, `Post`) e
fabbriche statiche `Nome::make(string $name = '...', string $context = 'form'): Block`. Gli upload dei blocchi:
[media-upload.md](media-upload.md).

Ogni modulo puo' avere i propri blocchi in `Modules/<M>/app/Filament/Blocks/`: la scoperta e' per convenzione di cartella
([ADR 0001](adr/0001-block-discovery-by-filament-blocks-folder.md)).

## Catena di resa

```
Filament/Blocks/*  ->  GetAllBlocksAction   (catalogo ComponentFileData: name snake_case senza _block, class, module, path)
x-render.blocks (v1/v2) -> x-render.block -> View\Components\Render\Block
Render\Block -> GetLocalizedBlockDataAction -> Cms (se presente) | pass-through
              -> view Blade indicata in block.data.view
```

| Artefatto | Ruolo |
|---|---|
| `Actions\Block\GetAllBlocksAction` | `File::glob(Modules/*/.../Filament/Blocks/*.php)`; contratto in [contracts/get-all-blocks-action.md](contracts/get-all-blocks-action.md); nessun caller PHP diretto, serve a inventario/tooling |
| `View\Components\Render\Block` | prende `$block` (`type`, `data.view`), usa `ui::empty` se manca il tipo; se la view non esiste mostra `ui::alert` con **solo vista e tipo** (mai il contenuto: [ADR 0003](adr/0003-missing-block-view-shows-type-not-content.md)) |
| `Actions\Block\GetLocalizedBlockDataAction` | normalizza i dati e delega a Cms; contratto in [contracts/resolve-localized-block-data-action.md](contracts/resolve-localized-block-data-action.md) |
| `View\Components\Blocks\Hero\Simple`, `View\Components\Page\WithSidebar` | componenti Blade di resa |

Le view dei blocchi stanno in `resources/views/components/blocks/` (`hero`, `slider`, `paragraph`, `title`, `cta`,
`feature_sections`, `pricing`, `testimonials`, `stats`, `newsletter`, ... piu' blocchi applicativi come
`user_profile`, `documents_list`, `appointment_booking`: residui di progetti specifici, non parte del design system).

## Confine con Cms

- UI non importa classi `Modules\Cms\*` (verificato: 0 riferimenti in `app/`); la delega avviene a runtime se Cms c'e'.
- UI non autorizza dati di dominio ([ADR 0006](adr/0006-ui-does-not-authorize-domain-data.md)).
- La documentazione del frontend (frontoffice, temi, compilazione) sta in Cms; qui solo i componenti. Le traduzioni sono
  centralizzate in Lang ([translations.md](translations.md)).
- Esempio di blocco `widget` da JSON: vedi `RedirectWidget` in [widgets.md](widgets.md).

Test: `tests/Unit/Actions/Block/GetAllBlocksActionTest.php`, `GetLocalizedBlockDataActionTest.php`,
`tests/Unit/View/RenderBlockMissingViewTest.php`.
