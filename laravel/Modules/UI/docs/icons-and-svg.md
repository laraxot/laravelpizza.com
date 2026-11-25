---
title: "Icone e SVG"
type: reference
module: UI
status: active
updated: 2026-11-25
qmd: "ui icons svg blade-icons x-filament::icon brands flags GetAllIconsAction IconPicker no inline svg"
---

# Icone e SVG

## Regola: mai SVG inline nelle Blade

Un SVG ripetuto in una view e' manutenzione moltiplicata e nessun tema. Si crea il file `.svg` e si richiama con il
componente icone:

```blade
<x-filament::icon icon="ui-google" class="w-5 h-5" />
@svg('ui-brands.github', 'w-5 h-5')
```

- sorgenti: `resources/svg/` del modulo che possiede l'icona (UI: **83 SVG** alla radice piu' `brands/` (31),
  `avatars/` (4 SVG), `flags/` (258 bandiere, nome = codice ISO) e `files/`);
- prefisso del set = alias minuscolo del modulo (`ui`); la registrazione e' automatica
  (`XotBaseServiceProvider::registerBladeIcons()` aggiunge `resources/svg` a Blade Icons): niente provider
  personalizzati, niente `FilamentAsset`, niente `Blade::anonymousComponentPath()`;
- sottocartelle: il separatore e' il punto, come lo produce `GetAllIconsAction`: `brands/github.svg` ->
  `ui-brands.github`; `google.svg` -> `ui-google` (per il login social si preferisce quello in radice);
- le bandiere: `resources/svg/flags/{iso}.svg`; esistono anche `resources/views/svg/flags/{en,it}.blade.php`;
- il set `brands/` oggi contiene: `apple behance bus discord dribbble facebook fb fitness github google google-play ig instagram linkedin m map microsoft paw pinterest reddit rss slack snapchat spotify telegram tiktok twitch twitter vimeo whatsapp youtube` (nome icona `ui-brands.<nome>`); `telegram.svg` esiste anche alla radice.

Il componente `<x-svg tpl="...">` (`View\Components\Svg`) non e' il sistema icone: risolve una view Blade per nome
(`GetViewAction`) e serve per illustrazioni (`resources/views/svg/`, `components/svg/v1`).

## IconPicker e GetAllIconsAction

`Actions\Icon\GetAllIconsAction::execute()` legge per riflessione i set registrati nel factory di Blade Icons
(`sets`), scandisce i path e restituisce `[set => [..., 'icons' => ['prefisso-nome', ...]]]`; con riflessione
impossibile o set non iterabili torna array vuoto. Lo usa `IconPicker` ([form-components.md](form-components.md)) per
il select del pack e la griglia `RadioIcon`. Contratto: [contracts/get-all-icons-action.md](contracts/get-all-icons-action.md).

## Dipendenze

`composer.json` richiede `owenvoke/blade-fontawesome` e `blade-ui-kit/blade-heroicons`; le icone `heroicon-o-*` che
Filament usa di default non servono file nel modulo.

## Problemi gia' visti

- `SvgNotFound`: nome icona non risolto (prefisso o cartella sbagliati, file in un altro modulo) o icona dinamica che
  arriva dalla traduzione di un enum (`transClass`) con chiave mancante;
- icona che "sparisce" dopo lo spostamento dell'SVG: il nome e' `prefisso-cartella.nome`, non il path;
- `bottlecap copy.svg`, `telegram.svg.webp`, `convert.png` e simili in `resources/svg/` sono residui: non sono icone
  (Blade Icons ignora i non-SVG, ma sporcano l'inventario).
