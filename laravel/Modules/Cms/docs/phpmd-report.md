# PHPMD Report (CMS)

## esecuzione 2025-11-12
- Comando: `./vendor/bin/phpmd Modules/Cms text Modules/Cms/phpmd.ruleset.xml`
- Risultato: **non concluso** per numero elevato di violazioni + file non parsabili.

## punti critici individuati
- **Nomenclatura**: centinaia di proprietà/variabili in snake_case (`$view_type`, `$module_dir`, `$theme_path`, `$primary_lang`, `$view_params`...). Necessaria una campagna di refactor mirata con aggiornamento docs (`naming-conventions.md`).
- **Test corrotti**: duplicati in minuscolo (`tests/Feature/Auth/*test.php`) eliminati, ma restano file camel case con contenuti duplicati e costrutti non validi (`PasswordUpdateTest.php`, `LoginWidgetTest.php`, `CmsContentManagementTest.php`, `HomepageFilamentBlocksArchitectureTest.php`, `ResourceExtensionTest.php`).
- **Coupling elevato** in pagine Filament (`Footer.php`, `Headernav.php`, `FrontPanelProvider.php`). Serve estrazione di servizi/datas per ridurre dipendenze.
- **Unused imports/variabili** e parametri non utilizzati in policy e provider.
- **else anti-pattern**: numerosi metodi segnalati (Home/Welcome pages, middleware, Livewire componenti) richiedono early return.

## azioni immediate raccomandate
1. **Ripristino test Pest**: riscrivere i file corrotti usando come riferimento le versioni upper-case corrette, rimuovendo duplicati e commenti residui.
2. **Piano di rinomina**: mappare proprietà/parametri snake_case e pianificare refactor con aggiornamento docs/translation keys.
3. **Ridurre coupling** nelle pagine Filament spostando la logica in Actions o Datas riusabili.
4. **Documentare regole** e aggiornare `quality-tooling.md` con checklist PHPMD.
5. **Rieseguire PHPMD** dopo ogni step per monitorare la riduzione delle violazioni.

## follow-up suggeriti
- Creare task dedicati in `todo_application.md` per ciascuna macro-area (naming, test, coupling).
- Integrare PHPMD nel CI (read-only) per evitare regressioni.
- Collegare i fix ai relativi documenti (es. `./architecture-xotdata-pattern.md`, `./filament-integration.md`).
