---
title: "UI: contratto Filament, ritiro del Toast Livewire e copie risorte"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: UI
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: [xot-test-harness-truth, livewire-to-filament-widgets-fleet]
related: [../../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md, ../../../Xot/docs/stories/code-quality-filament-label-audit.story.md, services-to-actions-ui, docs-organization-ui]
tags: [ui, filament, blueprint, livewire, toast, location-selector, label, sqlite, ratchet-w3]
qmd: "ui filament contratto Toast Livewire ToastWidget LocationSelector to_geo location_selector extends diretti blueprint widget label hardcoded skip sqlite TestCase"
---

# UI: contratto Filament, ritiro del Toast Livewire e copie risorte

Fase BMAD: Plan (scheda di lavoro per domani). Scritta in sola lettura, senza Pest ne' PHPStan. Cifre del 2026-10-20 13:50-14:05 UTC, volatili.

## Richiesta
Ordine permanente dell'utente: migliorare la qualita' del codice con BMAD + second brain + filament blueprint, andando alla sorgente e capendo lo scopo, non il messaggio d'errore.

## Scopo
UI fornisce i pezzi di interfaccia condivisi (widget, colonne, campi) usati dai pannelli e dal front office. Il `Toast` doveva mostrare messaggi di feedback all'utente. La story di migrazione ha gia' creato il gemello Filament `ToastWidget` e lo monta nel layout UI, ma ne' la classe Livewire ne' il widget mostrano nulla: le loro viste sono un `<div>` vuoto. Il vero ascoltatore dell'evento `toast` (Alpine, 439 righe) sta in una vista che nessuna classe rende, e 4 file lanciano comunque `dispatch('toast', ...)`. Ritirare il guscio senza decidere dove vive il toast significa spegnere un feedback che forse non si e' mai visto. Il resto sono contratti del blueprint (basi XotBase, lingua, nessuna logica nei form) e copie tornate col pull.

## Stato misurato
- Toast Livewire: `Modules/UI/app/Http/Livewire/Toast.php` (26 righe, render di `ui::livewire.toast`, 8 righe, `<div>` vuoto). `_components.json` di `Http/Livewire` e' `[]`: l'alias `toast` non e' registrato. Tag: `Modules/User/resources/views/components/layouts/main.blade.php:48` `<livewire:toast />` e `UI/resources/views/components/layouts/main.blade.php.stub:23`. Gemello: `Filament/Widgets/ToastWidget.php` (40 righe, `$isDiscovered = false`, vista `ui::filament.widgets.toast` di 7 righe, vuota), montato da `UI/resources/views/components/layouts/main.blade.php:27`. Test: `tests/Unit/UiGapCloser100Test.php:22,46-48` (Toast) e `:51-52` (ToastWidget). `rg -n 'livewire:toast|ToastWidget' Modules --glob '*.php' --glob '*.blade.php' --glob '*.stub'`.
- Ascoltatore vero: `Modules/User/resources/views/livewire/toast.blade.php` (439 righe, `window.addEventListener('toast', ...)`), nessuna classe lo rende. Dispatcher: `Quaeris/.../ViewQuestionChart.php:77,85`, `User/app/Filament/Widgets/Profile/DeleteAccountWidget.php:35,44`, `User/app/Http/Livewire/Profile/DeleteAccount.php:31,41,52` (`rg -n "dispatch\('toast'" Modules/*/app`). Nel layout User c'e' gia' `@livewire('notifications')` (:49).
- `extends` diretti di Filament in `app/Filament`: 1, `Forms/Components/LocationSelector.php` (`Filament\Schemas\Components\Group`); il censimento ne contava 4, ma `OpeningHoursColumn`, `TimestampColumn`, `SortableIdColumn` estendono ormai `XotBaseTextColumn` (modifiche non committate: `git -C Modules/UI status --short`). Script risolto con gli `use`; controprova su Notify trova `ChannelCheckboxList`.
- `LocationSelector`: in UI esistono `app/Filament/Forms/Components/LocationSelector.php` (420 righe), `LocationSelector.php.to_geo` (377 righe) e `lang/{de,en,it}/location_selector.php` (25 righe ciascuno), tutti tracciati; Geo ha la sua `Geo/app/Filament/Forms/Components/LocationSelector.php` (`extends XotBaseGroup`, chiavi `geo::location_selector`, lang presente). Zero chiamanti della copia UI (`rg -n 'Forms\\Components\\LocationSelector' Modules`). Storia: tolta l'8 ottobre (`0ecaedc4`), tornata col pull del 20 ottobre.
- Blueprint: `docs/bmad/filament-blueprint.md:29` dice "Nessuna Resource tipizzata"; i file Filament sono 74: 12 widget (`Widgets/`), 17 colonne (`Tables/Columns`), 21 form (`Forms`), 2 `Components`, 1 pagina. Nessun elenco.
- Etichette hardcoded: 19 (`Components/Schema/PersonForm.php` 18, `Tables/Columns/IDColumn.php:23`); comando: `rg -nP -e "->(label|placeholder|helperText|heading|description|title)\(\s*['\"][^'\"\$]*[A-Za-z][^'\"\$]*['\"]\s*\)" Modules/UI/app/Filament | rg -v '^\S+:\d+:\s*(//|\*|/\*)'` (senza il secondo `rg` conta anche i commenti: 21). Il censimento diceva 20.
- Skip: 22 (`rg -o 'markTestSkipped|->skip\(' Modules/UI/tests --glob '*Test.php' | wc -l`), quasi tutti su temi che non ci sono (`pub_theme`, Sixteen, Kalshi, TwentyOne; in `laravel/Themes` esiste solo `Zero`): `ComponentReorganizationTest.php` 10, `ComponentFilesExistTest.php` 4, `KalshiHeroComponentTest.php` 2.
- sqlite: `tests/TestCase.php:51` (`$connectionsToTransact` con `sqlite`), `:67` `prepareSharedSqliteForTesting()`, `:133` `str_contains($database, 'fixcity_data.sqlite')` (nome di un altro progetto; esiste `XotBaseTestCase::sharedSqlitePath()` a `:258`).

## Lavoro
1. **Decidere dove vive il toast**, poi ritirare il guscio. Opzione A: convertire i 4 file dispatcher a `Filament\Notifications\Notification::make()->...->send()` (gia' montato nel layout) e cancellare vista orfana da 439 righe, `Toast.php`, `ui::livewire.toast`, tag e riga di stub, test `UiGapCloser100Test.php:46-48`. Opzione B: portare l'ascoltatore nella vista di `ToastWidget`. Rischio basso per A, medio per B; i dispatcher sono in Quaeris e User (altri owner).
2. **Cartella `UI/app/Http/Livewire`**: dopo il punto 1 resta solo `_components.json`; la guardia `Xot/tests/Unit/NoLivewireDirectoriesInModulesTest.php` vuole la cartella assente. Rischio basso.
3. **`LocationSelector` e coda** (5 file): cancellare dalla copia UI classe, `.to_geo`, 3 lang (Geo ha il proprio, nessun chiamante); poi `extends` diretti = 0. Rischio basso, ma il prossimo pull li riporta di nuovo: avvisare chi sincronizza (decisione 2).
4. **Blueprint**: aggiungere a `docs/bmad/filament-blueprint.md` l'elenco dei 12 widget, delle colonne e dei campi, togliere "Nessuna". Rischio nullo.
5. **19 etichette**: chiavi in `lang/<locale>/` di UI, `->label()` tolto dove la risoluzione e' automatica; `helperText('schema.org: name')` e' nota tecnica, decidere se e' testo utente. Coordinare con `code-quality-filament-label-audit`.
6. **22 skip su temi assenti**: i test descrivono temi di altri progetti. Spostarli nel tema o cancellarli, non lasciarli verdi per salto.
7. **sqlite**: `TestCase.php:133` usare `sharedSqlitePath()`; sqlite -> MySQL `_test` segue la decisione 1 di `xot-test-harness-truth`.

## Acceptance criteria
- [ ] `rg -n 'livewire:toast' Modules --glob '*.php' --glob '*.blade.php' --glob '*.stub'` non stampa nulla.
- [ ] `ls Modules/UI/app/Http/Livewire` fallisce.
- [ ] Ogni `dispatch('toast'` in `Modules/*/app` e' sparito o ha un ascoltatore montato (comando del Stato misurato).
- [ ] Lo script `extends` diretti stampa 0 su UI.
- [ ] `ls Modules/UI/app/Filament/Forms/Components/LocationSelector.php*` fallisce; `ls Modules/UI/lang/*/location_selector.php` fallisce.
- [ ] Il comando delle etichette (con il filtro dei commenti) stampa 0; `rg -n 'Nessuna' Modules/UI/docs/bmad/filament-blueprint.md` non stampa nulla.
- [ ] `rg -n 'fixcity_data' Modules/UI/tests` non stampa nulla.

## Verifica
Rilanciare i comandi di "Stato misurato"; per ogni zero, ripetere il `rg` su un caso noto (es. `rg -n 'livewire:toast' Modules/User` deve trovare la riga 48 prima della modifica). Dopo la cancellazione, `rg -w` sui nomi in `app`, `resources`, `routes`, `config`, `tests`; PHPStan mirato sui file toccati, in coda.

## Vincoli
- Nessun Pest/PHPUnit finche' la guardia DB non e' dentro e l'utente non ha confermato che i DB `*_test` sono usa-e-getta.
- PHPStan solo mirato e in coda `flock` di `11-phpstan.md`; un solo run completo a swarm fermo e a RAM libera. `laravel/phpstan.neon` immutabile.
- Un solo agente per modulo che edita PHP (UI qui; User e Quaeris per i dispatcher). Forward-only. Pest resta Pest.
- Niente nuovi `*Service`; logica in Spatie QueueableAction con `execute()`. Niente `mixed`, `@var`, ignore di comodo.

## Decisioni aperte
1. Toast: A (Notifiche Filament) o B (ascoltatore nel widget)? Proposta: A, perche' `@livewire('notifications')` e' gia' nel layout. 2. `LocationSelector` in UI: cancellare davvero (e come impedire che il pull lo riporti) o tenerlo come fonte e togliere quello di Geo? 3. Test su temi assenti: spostare nel tema o cancellare. 4. `helperText('schema.org: ...')`: testo tecnico o da tradurre.

## Come ripartire
1. Rilancia i comandi di "Stato misurato"; scrivi le differenze in una nota datata in fondo. Chiedi la decisione 1 all'utente.
2. Esegui le voci 3 e 4 (cancellazione della copia `LocationSelector` dopo `rg -w` con due metodi, aggiornamento del blueprint): rischio basso.
3. Con la decisione 1, converti i dispatcher un modulo alla volta e solo dopo ritira `Toast.php`.
