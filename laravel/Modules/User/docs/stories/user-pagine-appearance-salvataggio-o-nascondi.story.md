---
title: "Pagine Appearance di User: implementare il salvataggio o nasconderle"
type: story
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
module: User
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["decisione dell'utente tra opzione A e B (vedi Decisioni aperte)"]
related: [./debug-calls-removal-user.story.md, ./12.3.remove-dddx-debug.story.md, ../navigation-groups.md, ../../../Xot/docs/stories/test-database-guard.story.md]
tags: [bmad, appearance, filament, cluster, navigazione, tenant-config]
---

# Pagine Appearance di User: implementare il salvataggio o nasconderle

Fase BMAD: Analisi chiusa, in attesa della decisione dell'utente; poi Dev.

## Richiesta
Come maintainer del pannello `user::admin` voglio che ogni voce di menu faccia qualcosa di vero, cosi' che chi preme "Salva" non trovi un errore.
Oggi sei pagine del cluster Appearance sono nel menu e "Salva" lancia `LogicException`: il salvataggio non e' mai stato scritto e nessun codice legge quei valori.

## Scopo
Le sei pagine (Logo, Colors, Background, Alignment, Favicon, CustomCss) erano il pannello "aspetto" copiato da uno scaffold di terze parti (ipotesi, non verificabile: nessun pacchetto in `vendor`; i campi sono quelli tipici di un pannello auth: logo chiaro/scuro, 5 colori, sfondo con overlay, allineamento, favicon, CSS). Dovevano far scegliere a un amministratore come appare il sito. Il file piu' vecchio (`Logo.php`, commit `c8804d010` del 2026-01-20) gia' conteneva `dddx($data)` al posto del salvataggio e `// $this->handleRecordUpdate($this->getUser(), $data)` commentato: la logica non e' mai esistita. Il tema del pannello esiste gia' altrove: `Xot\Filament\Pages\MetatagPage` salva logo, altezza logo e colori nel config tenant `metatag`, che `ApplyMetatagToPanelAction` applica a ogni pannello all'avvio.

## Stato misurato
Misure del 2026-10-20 tra 13:41 e 13:50 UTC, da `laravel/Modules/User`.
- 6 pagine, 601 righe: `wc -l app/Filament/Clusters/Appearance/Pages/*.php`. Corpo di `updateData()` / `updateLogo()` = `throw new \LogicException('<Classe>::<metodo>() non implementato')` (Logo.php:64, Favicon.php:66, Colors.php:70, Background.php:74, CustomCss.php:66, Alignment.php:81). La modifica e' nel working tree, non committata: `git status --short app/Filament/Clusters/Appearance` mostra 6 `M`.
- Il brief diceva che solo Favicon e CustomCss copiano i campi di Background: sono TRE. Alignment.php:61-64, Favicon.php:46-49, CustomCss.php:46-49 hanno `background_color`, `background`, `overlay_color`, `overlay_opacity`, identici a Background.php:54-57. Alignment ha una vista Alpine con `data.heading` / `data.container` (alignment.blade.php) che il form non contiene, e stringhe inglesi fisse ("Heading Alignment", "Preview").
- Lettori delle chiavi: `rg -P -n -e '\b(button_color|button_text_color|input_text_color|input_border_color|logo_dark|custom_css)\b' Modules Themes config app resources -g '!**/docs/**' -g '!Modules/User/app/Filament/Clusters/Appearance/**'` = 0 righe; `git grep -n -w` sugli stessi path = 0 nel codice (2 hit solo in docs). Controprova: `rg -c '\bbutton_color\b' app/Filament/Clusters/Appearance/Pages/Colors.php` = 1. `text_color`, `background_color`, `overlay_*` esistono solo come campi dei blocchi Cms e in `config/localhost/appearance.php` (chiavi `footer`/`headernav`, non nostre).
- La palette del pannello non e' per-tenant: `Xot/app/Support/PaDesignColors.php:22` ritorna colori fissi; `MetatagData::getThemeColors()` e `getAllColors()` non hanno chiamanti (`rg -P '(getAllColors|getThemeColors)\(' Modules Themes`: solo le definizioni).
- Logo: editor e lettore gia' esistono. `MetatagPage::schema()` ha `logo_header`, `logo_header_dark`, `logo_height` (campi di testo con percorso) e `ApplyMetatagToPanelAction::execute()` applica `brandLogo`, `brandLogoHeight`, `favicon` a ogni pannello (chiamata da `XotBasePanelProvider.php:76`). Favicon: il lettore c'e' (`MetatagData::getFavicon()`, default `/favicon.ico`) ma `MetatagPage` NON ha il campo `favicon` (`rg -n favicon app/Filament/Pages/MetatagPage.php` in Xot = 0; controprova: `rg -c logo_header` = 2): e' l'unico gruppo con un lettore e senza editor.
- Menu: il cluster `Appearance` (`Modules/User/app/Filament/Clusters/Appearance.php`, 17 righe) non ha `shouldRegisterNavigation`. In Filament `Cluster::shouldRegisterNavigation()` = `parent && canAccessClusteredComponents()` e quest'ultima guarda `canAccess()`, non `shouldRegisterNavigation()` delle pagine (`vendor/filament/filament/src/Clusters/Cluster.php`). Quindi `shouldRegisterNavigation(): false` sulle sei pagine nasconde solo il sotto-menu: la voce del cluster resta.
- Accesso: `rg -c 'canAccess|shouldRegisterNavigation' app/Filament/Clusters/Appearance.php app/Filament/Clusters/Appearance/Pages/` = nessuna corrispondenza (rc=1; controprova: `MyProfilePage.php:43` ha `protected static bool $shouldRegisterNavigation = false;`). Il pannello `user::admin` richiede il ruolo `user::admin` (`BaseUser::canAccessPanel`, righe 320-338).
- Esiste un secondo cluster `Appearance` nel modulo Cms (Footer, Headernav, Breadcrumb) che salva davvero: `SaveTenantConfigAction::execute('appearance', ...)`, pannello `cms::admin`, slug diverso nell'URL del pannello. Non c'e' collisione.
- Test attuale: `tests/Feature/Filament/Clusters/AppearanceClusterTest.php`, 7 test, l'ultimo ("unimplemented save handlers fail loudly...") pretende `LogicException` da tutti e sei i metodi.

## Lavoro
Opzione B (raccomandata), in ordine:
1. `app/Filament/Clusters/Appearance.php`: aggiungere `protected static bool $shouldRegisterNavigation = false;` (stesso modello di `MyProfilePage.php:43`). Nasconde la voce di menu; le pagine restano raggiungibili da URL e "Salva" continua a dare l'errore esplicito. Rischio: nullo, una riga.
2. Se si vuole chiudere anche l'URL: `public static function canAccess(): bool { return false; }` nelle sei pagine (sei righe, ripetute: `XotBasePage` non ha `canAccess`). Con `canAccess` falso su tutte, anche il cluster sparisce da solo. Scegliere 1 oppure 1+2.
3. `AppearanceClusterTest.php`: aggiungere un test per riflessione (come i test gia' presenti) che il valore di default di `shouldRegisterNavigation` sul cluster e' `false`. Il test dei `LogicException` resta valido.
Costo B: 1 file di app, 1 file di test.

Opzione A (solo se serve davvero un aspetto per tenant):
1. Una Action `Modules\User\Actions\Appearance\SaveAppearanceAction` (QueueableAction, `execute(string $group, array $data)`) che chiama `SaveTenantConfigAction::execute('appearance', [$group => $data])`; lettura con `ResolveTenantConfigValueAction`. Niente Service.
2. Riscrivere i form: Favicon (solo `favicon`), CustomCss (solo `custom_css`, area di testo), Alignment (`heading`, `container`) e Background (`background_color`, `background`, `overlay_color`, `overlay_opacity`); togliere i campi duplicati.
3. Sostituire in ogni pagina il `LogicException` con `getState()` + Action + `Notification` (modello: `Pages\Password`), chiavi in `lang/{it,en,de}`, togliere le stringhe fisse di alignment.blade.php.
4. Un lettore per ogni gruppo, altrimenti il salvataggio non cambia nulla: favicon in `metatag.favicon` (`SaveTenantConfigAction::execute('metatag', ['favicon' => ...])`, lettore gia' attivo: il gruppo piu' economico); logo in `metatag` duplicherebbe `MetatagPage` (meglio non costruirlo); colori in `PaDesignColors` (modulo Xot, oggi fissi); sfondo/allineamento/CSS in un render hook del login (Xot o tema).
5. Il CSS personalizzato e' HTML iniettato nelle pagine: solo super-admin, validazione, review di sicurezza.
Costo A: 1 Action, 6 pagine, 6 viste, 18 file lang, 6 test, piu' 2-3 file in Xot/tema per i lettori. Rischio: alto per CSS e per l'ambiguita' di sorgente (due editor per lo stesso valore).

## Acceptance criteria
- [ ] L'utente ha scelto A o B per iscritto in questa story.
- [ ] B: `rg -n 'shouldRegisterNavigation = false' app/Filament/Clusters/Appearance.php` ritorna 1 riga.
- [ ] B: nessun `throw new \LogicException` e' raggiungibile da una voce di menu (verifica per riflessione nel test).
- [ ] A: ogni pagina salva e rilegge lo stesso valore; per ogni chiave esiste un lettore (`rg -P` > 0 fuori da `Clusters/Appearance`).
- [ ] `php -l` sui file toccati senza errori; PHPStan gated sui file toccati a zero.
- [ ] `AppearanceClusterTest` aggiornato; eseguito solo a guardia DB dentro.

## Verifica
- `cd laravel/Modules/User && rg -n "LogicException" app/Filament/Clusters/Appearance/Pages | wc -l` atteso 6 (B lo lascia a 6, A lo porta a 0). Controprova: `rg -c 'non implementato' tests/Feature/Filament/Clusters/AppearanceClusterTest.php` = 1.
- `cd laravel && php -l Modules/User/app/Filament/Clusters/Appearance.php` atteso "No syntax errors".
- Menu reale (solo a guardia dentro): `Appearance::shouldRegisterNavigation()` falso; non eseguire `artisan`.

## Vincoli
- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: non toccare il cluster Cms `Appearance`; non duplicare `MetatagPage`; le 6 pagine non si cancellano (storia), si nascondono o si completano.

## Decisioni aperte
1. A o B. Raccomando B ora: nessun tenant ha chiesto aspetto personalizzato, i lettori mancano e Logo/Favicon/Colors sono gia' coperti o da progettare in Xot. Per decidere serve sapere: (a) un amministratore deve cambiare sfondo/allineamento/CSS del login? (b) quei valori vanno nel tenant (`config/<tenant>/appearance.php`) o nel tema?
2. B1 (solo menu) o B1+B2 (anche URL chiuso). Raccomando B1+B2: un "Salva" che da errore non deve essere raggiungibile.
3. Se si sceglie A: il CSS personalizzato e' ammesso? Raccomando no, finche' non c'e' una revisione di sicurezza.

## Come ripartire
1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel/Modules/User && rg -n "LogicException" app/Filament/Clusters/Appearance/Pages` e rileggere "Stato misurato": i numeri vanno rimisurati.
2. Con B deciso: `bashscripts/lock/check.sh laravel/Modules/User/app/Filament/Clusters/Appearance.php`, poi aggiungere la proprieta' e il test per riflessione in `AppearanceClusterTest.php`.
3. `php -l` sui due file, PHPStan gated su `Modules/User/app/Filament/Clusters/Appearance.php` e sul test, poi annotare l'esito in questa story e aggiornare `status`.
