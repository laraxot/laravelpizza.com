---
title: "MetatagData"
type: note
status: active
tags: [docs, xot, datas, metatag, colors]
qmd: "metatagdata filament colors filament_primary palette"
---
# MetatagData

`Modules\Xot\Datas\MetatagData` e' il DTO delle impostazioni di brand del tenant (logo, favicon, colori, meta).
Si legge da `config/local/<tenant>/metatag.php`.

## Colori Filament: `getFilamentColors()`

Restituisce la palette per `Panel::colors()`. Chiamanti: `ApplyMetatagToPanelAction`, `Cms\FrontPanelProvider`,
`MetatagPage` (opzioni del select) e `getAllColors()`.

1. Parte dalla palette PA: `PaDesignColorsAction::filamentPalette()`.
2. Se `config('metatag.filament_primary')` e' una stringa non vuota, sostituisce solo `primary`:
   - nome Tailwind (`'red'` -> `Filament\Support\Colors\Color::Red`, consigliato: tonalita' calibrate per il contrasto
     dei pulsanti);
   - oppure esadecimale `#rrggbb` (`Color::hex()`).
   Un valore sconosciuto lascia la palette PA invariata.
3. Ritorna la palette.

Un progetto con un proprio marchio cambia cosi' il primario dei pannelli senza toccare la palette PA.

Nota di manutenzione: un merge tra storie aveva lasciato in coda al metodo anche il vecchio
`return app(PaDesignColorsAction::class)->filamentPalette();` (senza override del primario). Era codice irraggiungibile
(`deadCode.unreachable`) e, se fosse stato eseguito, avrebbe annullato `filament_primary`: tenuta solo la versione con
override.
