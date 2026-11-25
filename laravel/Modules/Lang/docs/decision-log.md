---
type: decision-log
title: "Decision Log: Lang"
links: {github_issue: "#XXX", discussion: "#XXX"}
status: draft
updated: 2026-10-08
tags: [docs, lang]
qmd: "decision log   lang lang"
---
# Decision Log: Lang

## Decisions

### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `acc43fc4`
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con `acc43fc4` (07/10 06:38), l'ultimo commit prima del re-import `f80d2ee6` (07/10 13:01).
- **Over**: Fermarsi ai 15 file della voce sotto, scelti con un confronto basato sul monorepo.
- **Because**: Ogni contenuto sovrascritto o eliminato e' stato verificato come gia' esistente prima del 07/10 (645 su 645).
  - 408 toccati solo dagli eventi del 07/10: contenuto da `acc43fc4`. Molti differivano solo nel permesso registrato nel commit.
  - 237 aggiunti solo dalle copie vecchie: eliminati. 218 sono `*.svg_Zone.Identifier` in `resources/svg/flag` (scarti Windows: le 266 bandiere restano, usate da `NationalFlagSelect`), altri `*_Zone.Identifier`, la cartella legacy `resources/lang`, `Http/Livewire/Lang/{Change,Switcher}` (ritirati il 21/09), `app/Filament/LangBasePanelProvider.php` (doppione di `app/Providers/Filament/LangBasePanelProvider.php`, quello usato).
  - Lavoro nuovo di Marco l'08/10 (story `2026-10-08-services-to-actions-lang`, commit `82ba42b3`, `a5317b55`): `TranslatorService` e `TranslatorAction` restano eliminati, i tre test che li usavano uniti a tre vie (conflitto in `LangFinalGapsTest` risolto con `TranslatorAdapter` di Marco). Nessun riferimento residuo alle due classi, nemmeno da altri moduli.
  - I 13 file del ripristino di stamattina erano gia' identici ad `acc43fc4` nel contenuto.
- **Verifica**: `php -l` pulito, nessun marcatore di conflitto; PHPStan su `Modules` senza errori in Lang; `php artisan about` si avvia. Pest prima/dopo a blocchi: nessun peggioramento, ma i test Lang falliscono tutti in entrambi gli stati con 0 asserzioni (`tests/Pest.php` del modulo non caricato lanciando dalla root), quindi non danno segnale.

### 2026-10-08: Ripristino dei file regrediti dal re-import del 07/10
- **Choose**: Ripristinare dallo stato del monorepo al 06/10 (`51570adf3`) 15 file: `lang/it/txt.php`, `lang/en/{txt,edit_translation_file,widgets,translations,nationalities,header,countries,auth,view_translation_file,lang_base_list_records,lang_base_edit_record,lang_base_create_record}.php`, `LanguageSwitcherWidget` e la sua vista.
- **Over**: Tenere le versioni portate dal commit `f80d2ee6` (07/10 13:01, senza genitori, 1918 file), re-import da una copia vecchia.
- **Because**: Confronto per chiave, non per righe (le righe gonfiano le perdite per la sola riformattazione): `en/txt.php` aveva perso 740 voci su 782, `en/edit_translation_file.php` 213 su 274, `it/txt.php` tornava alla chiave grezza `txt` al posto di "Testo"; le voci "nuove" erano solo il segnaposto vecchio `navigation.group => 'Missing Group'`. `LanguageSwitcherWidget` attuale coincideva con la versione del 10/09, prima della conversione a widget del 21/09. Nessun commit successivo al re-import tocca questi file. Criterio: contenuto attuale identico byte per byte a una versione più vecchia già sostituita; per ogni file controllata la storia completa (`--full-history`) per non perdere commit successivi.
- **Verifica**: `php -l`; PHPStan su `Modules` senza errori in Lang; test Lang prima/dopo identici.
## Open Questions

