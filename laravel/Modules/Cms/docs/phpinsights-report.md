# PHP Insights Report (CMS)

## sintesi esecuzione [DATE]
- Comando: `./vendor/bin/phpinsights analyse Modules/Cms --config-path=phpinsights.php --composer=laravel/composer.lock --no-interaction`
- Score ottenuti: `Code 83.7% · Complexity 97.2% · Architecture 76.5% · Style 84.3%`
- Blocco principale: **Style score < 90%** dovuto a conflitti irrisolti e violazioni PSR / naming.

## finding prioritari
- **File con sintassi non valida** (`[CONFLICT markers]` ancora presenti in molte Blade e test del modulo UI) → PHPStan/Insights non possono raggiungere 100% finché non si sanano i merge conflicts cross-modulo.
- **Setter vietati** (`Welcome::setModel`) e variabili temporanee inutili (`Dashboard::$widgets`, `HasBlocks::$res`).
- **Naming non conforme**: uso esteso di snake_case in proprietà pubbliche (`$view_type`, `$primary_lang`, `$theme_path`, `$lang_dir`...).
- **Classi non `final|abstract`**: componenti Blade/Filament devono essere finalizzati secondo regole Laraxot.
- **Commenti inline errati** (`/** @var list<Block> $blockList */ $blockList = [];`) da convertire in docblock multiline.
- **RouteServiceProvider** e provider vari con ordine proprietà non aderente (`$name` deve essere dichiarato subito dopo la classe secondo Laraxot).

## azioni consigliate
1. **Sanare conflitti residui** nel modulo UI (vedi `grep -R "conflict markers" Modules/UI`) prima di qualsiasi refactor: blocca PHPStan globale.
2. **Rinominare proprietà e variabili** critical: ad es. `$view_type` → `$viewType`; documentare eccezioni nella docs `naming-conventions.md`.
3. **Eliminare setter indiscriminati**: sostituire `setModel()` in `Welcome` con injection nel costruttore o dedicated factory.
4. **Normalizzare componenti**: rendere `PageContent`, `Section`, `ThemeComposer` `final` e spostare logica condivisa in trait.
5. **Ripulire doc comment inline** e applicare Pint dopo i refactor.

## prossimi passi
- Integrare le correzioni sopra e rieseguire PHP Insights. Obiettivo: Style ≥ 90%, Architecture ≥ 85%.
- Aggiornare questa nota e `quality-tooling.md` dopo ogni passaggio per tracciare lo stato.
- Collegare i fix ai relativi documenti tecnici (es. `./naming-conventions.md`, `./filament-integration.md`).
