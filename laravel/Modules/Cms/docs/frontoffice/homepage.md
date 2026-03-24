# Homepage Architecture & Management

## Contratto corrente TwentyOne

La homepage frontoffice del tema TwentyOne deve restare un entrypoint minimale.

Struttura canonica:

- x-layouts.app
- @volt('home')
- x-page side="content" slug="home"

Motivo:

- la route Blade non deve contenere landing hardcoded;
- il tema deve restare agnostico e riusabile;
- il contenuto deve vivere nei blocchi CMS e nei JSON della pagina;
- il backoffice deve poter configurare i blocchi tramite Builder di Filament.

## Flusso di rendering

1. Folio risolve la route della homepage.
2. Il file pages/index.blade.php delega a Volt e x-page.
3. x-page carica i blocchi della pagina con slug home.
4. I blocchi arrivano da content_blocks e possono essere mantenuti come JSON e gestiti da backoffice.
5. Le viste dei blocchi devono usare namespace pubblicati e stabili, ad esempio pub_theme::..., non namespace interni temporanei del tema.

## Builder-first

Per homepage, lista mercati e pagine editoriali la preferenza e:

- JSON come sorgente di composizione;
- blocchi CMS riusabili;
- configurazione Filament Builder;
- tema senza copy di dominio hardcoded nei route file.

## Nota sui namespace view

Per i blocchi widget del tema pubblicato usare pub_theme::filament.widgets.predict-table.

Non usare TwentyOne::filament.widgets.predict-table nei JSON pagina, perche il runtime CMS si aspetta il namespace pubblicato del tema.
