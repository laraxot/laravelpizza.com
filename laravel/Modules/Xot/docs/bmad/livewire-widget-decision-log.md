---
tags: [documentation]
created: 2026-09-26
updated: 2026-10-20
qmd: "livewire widget decision log"
issues: []
discussions: []
title: "Decision log: Livewire → widget"
type: decision-log
module: Xot
status: active
related:
  - ./livewire-widget-project-context.md
  - ./livewire-inventory.md
  - ./livewire-widget-advantages.md
  - ./livewire-to-filament-widgets-brainstorming.md
  - ./livewire-to-filament-widgets-inventory.md
  - ./stories/livewire-to-filament-widgets-fleet.story.md
---

# Decision log

## [2026-10-20] Blueprint di piattaforma e scope definitivo

**Decision:** il piano operativo è consolidato in
[livewire-widget-platform-blueprint.md](./livewire-widget-platform-blueprint.md),
con brainstorming in
[livewire-to-filament-widgets-brainstorming.md](./livewire-to-filament-widgets-brainstorming.md)
e destinazioni Filament in
[livewire-to-filament-widgets-filament-blueprint.md](./livewire-to-filament-widgets-filament-blueprint.md).

La regola è **panel-first**: solo una superficie realmente appartenente al
panel diventa `XotBase*Widget`. Un componente FO, una Page/Resource, un flusso
auth/legal, un adapter di libreria o dead code riceve la destinazione coerente
con il proprio scopo. Il runtime Livewire interno a Filament resta una
dipendenza implementativa e non è un residuo da eliminare.

**Scope:** la migrazione procede per inventario, classificazione, sostituzione,
verifica dei caller e ritiro. L'ordine casuale è ammesso soltanto dentro wave
con ownership disgiunta; non si randomizzano dipendenze, gate o rollback.

## [2026-09-21] Religione in Xot, inventario nei foglia

**Decision:** Xot possiede la legge (`XotBaseWidget`). Ogni modulo scrive il proprio `docs/bmad/livewire-inventory.md`. User resta il pilota identità (Epic 9–10).

## [2026-09-21] Docs only

Nessun PHP in questa sessione.

## [sessione audit successiva] Inventario approfondito + doc canonico vantaggi

**Decision:** il "perché solo widget" vive in un documento canonico piattaforma
([livewire-widget-advantages.md](./livewire-widget-advantages.md)); i doc di modulo
(`advantages-filament-only.md` in User) restano evidenze locali e non vengono duplicati.

**Findings nuovi nell'inventario:** `LivewireComponentsListCommand` (`xot:livewire-list`)
registrato ma `handle()` no-op; `tableto_formx`/`Tableto_formx` file PHP senza estensione
(dead code a tre livelli: autoload, `GetComponentsAction.php:72`, nessun mount); zero
sottoclassi di `XotBaseComponent` repo-wide; `_components.json` di Xot = `[]`; percorso di
deprecation di `RegisterLivewireComponentsAction` subordinato al ritiro degli
`Http/Livewire` dei moduli foglia (rimozione chiamata da `XotBaseServiceProvider::boot()`
riga 44, non svuotamento directory: `GetComponentsAction.php:41-45` la ricreerebbe).

## [2026-10-20] Piano fleet aggiornato

La baseline corrente non è ancora zero: la scansione read-only rileva 28 file
custom Livewire e 7 componenti Volt. Il criterio è stato chiarito: il panel non
crea più custom Livewire, ma non si forza il front-office dentro Filament. La
classificazione canonica è `MIGRATE`, `REUSE`, `KEEP`, `RETIRE`; il dettaglio è
in [livewire-to-filament-widgets-inventory.md](./livewire-to-filament-widgets-inventory.md).

## [2026-10-20 pm] Baseline 27 + fleet ready-for-dev

**Decision:** inventariata di nuovo la fleet: **28** classi applicative
`Http/Livewire`/`app/Livewire` (esclusi test). Il numero 63 del prompt 05 era
rumore View Component. Gemelli Filament già presenti per UI dark-mode, Lang
switcher, Job status/schedule e User Auth* → W0–W1 prioritizzano `REUSE` +
chiusura caller. Story
[livewire-to-filament-widgets-fleet.story.md](./stories/livewire-to-filament-widgets-fleet.story.md)
passa a `ready-for-dev`. Prompt
[05-livewire-to-filament-widgets.md](../../../../../bashscripts/docs/prompts/05-livewire-to-filament-widgets.md)
allineato al conteggio reale. Implementazione non avviata finché non si apre
una wave esplicita.

## [2026-10-20 19:45] DELETE zombie `tableto_formx` / `Tableto_formx`

**Decision:** rimossi i due file senza estensione in `Xot/app/Http/Livewire/`
(importavano `ColumnService`/`PanelService` morti). Gia' classificati dead
nell'inventario sopra; boy scout post-zero Services→Actions li elimina a
riferimenti zero (recuperabili da git del modulo Xot).

<!-- gateguard: append to existing decision-log (not first create); linked from advantages/fleet/brainstorming; user: "non utilizziamo piu' componenti livewire ma utilizziamo al loro posto filament widget" + brainstorming/planning BMAD + filament blueprint -->

## [2026-10-20] Planning refresh: religione panel-first + legal REUSE

**Decision (brainstorm Update + planning):** conferma ordine utente "niente
componenti Livewire custom, al loro posto Filament Widget" interpretato come
**panel-first**, non come "zero Livewire nel monorepo".

- **Perche':** una sola famiglia `XotBase*Widget` per discovery/policy/tenancy/i18n.
- **Cosa non fare:** convertire CMS `Page\Show`, toast FO, o inventare widget
  Gdpr per i testi legali (ownership pagine = story Gdpr 12.1; gemelli UI gia'
  in User).
- **Correzione inventory:** `TermsOfService` e `PrivacyPolicy` HTTP → `REUSE`
  (`TermsOfServiceWidget` / `PrivacyPolicyWidget`); ritiro HTTP in W0 dopo
  caller zero. Il `dddx('wip')` nel Livewire e' codice morto.
- **Artefatti:** brainstorming, inventory, filament-blueprint, fleet W0,
  [livewire-widget-advantages.md](./livewire-widget-advantages.md).
- **Next:** aprire wave W0 esplicita; questa entry non autorizza ancora edit PHP.

## [2026-10-20] Un solo `laravel/phpstan.neon`: solo umano

**Decision:** riaffermazione utente: gate PHPStan = **solo**
`laravel/phpstan.neon`; solo l'umano lo modifica; gli agenti **non** creano
altri `.neon`, non usano `-c`/`--level`, non toccano neon legacy sotto moduli.

**Perche':** un secondo misuratore spezza CI/swarm (verde locale ≠ verde
progetto). UI Filament (`XotBase*`) usa lo stesso gate: nessun neon Filament.

**Canon:** [phpstan-single-neon-config](../wiki/memories/phpstan-single-neon-config.md),
[phpstan-neon-immutable](../../../../../bashscripts/ai/wiki/rules/phpstan-neon-immutable.md),
[11-phpstan](../../../../../bashscripts/docs/prompts/11-phpstan.md).

## [2026-10-20] Reverse brainstorm refresh (planning only)

**Decision:** sessione BMAD Reverse Brainstorming appendata in
[livewire-to-filament-widgets-brainstorming.md](./livewire-to-filament-widgets-brainstorming.md)
(sezione *Reverse brainstorm refresh: sessione planning*). Nessun PHP,
nessun commit, nessun `bmad-output/`.

**Religione ribadita (verificata su disco):**

- panel → solo `XotBase*Widget` + Spatie Actions; vietati nuovi custom
  `Http/Livewire` panel-side;
- Livewire runtime Filament non è residuo;
- FO Folio/Volt/Blade resta quando lo scopo non è widget di panel;
- `TermsOfService` / `PrivacyPolicy` → **`REUSE`** dei gemelli
  `TermsOfServiceWidget` / `PrivacyPolicyWidget` (non `KEEP` FO);
- baseline: **28** classi applicative.

**Direzione per le wave:** fallimenti prioritari = misclassificazione legal
twins, confusione runtime≠residuo, FO forzato in panel, create invece di
REUSE, dominio nel widget, ritiro con caller vivi. Insight operativi:
correggere inventory legal → REUSE; W0–W1 caller-closure; gate “zero”
esplicito; Action boundary su ogni MIGRATE; W3/W4 seriali dopo foglie.

## [2026-10-20 sera] Allineamento al canone 2026-05

**Fase BMAD:** Document (riverifica sul disco con `rg -P` e `find`, con controprova; nessun PHP).

**Decision:** la direttiva di oggi ("non utilizziamo piu' componenti livewire ma
utilizziamo al loro posto filament widget") ripete il canone dell'utente del
2026-05-28 e non lo estende. Il canone dice: niente Livewire puro, Livewire solo
dentro i widget Filament, front office incluso. Le voci di questo log che
leggono l'ordine come "panel-first, FO resta KEEP" (planning refresh e reverse
brainstorm del 2026-10-20) sono piu' deboli del canone e per il front office
sono **superate**. Restano valide: il runtime Livewire interno a Filament non
e' un residuo; il sostituto e' `XotBase*Widget`, mai `Filament\Widgets\Widget`
diretto; il dominio sta in Action.

**Perche' (fonti):**

- `bashscripts/ai/wiki/rules/no-standalone-livewire-classes.md` riga 20: "Non
  utilizziamo livewire puro. Lo utilizziamo solo dentro widget di Filament."
  (utente, 2026-05-28);
- `bashscripts/ai/wiki/concepts/no-pure-livewire-outside-filament-widgets.md`
  riga 19: niente Livewire/Volt standalone nel front office (Folio, pagine CMS,
  blocchi tema);
- `stories/lw2fw-01.livewire-to-filament.story.md` riga 37: nessuna directory
  `Modules/*/app/Http/Livewire/`, con guardia
  `Xot/tests/Unit/NoLivewireDirectoriesInModulesTest.php`;
- vantaggi (discovery, auth/tenancy, i18n, test, Action):
  [livewire-widget-advantages.md](./livewire-widget-advantages.md).

**Conteggi riverificati (sera):**

- 23 classi custom vive, non 28: `find Modules \( -path '*/Http/Livewire/*.php'
  -o -path '*/app/Livewire/*.php' \) ! -path '*/tests/*'` (senza il filtro
  `tests` sono 25; Themes 0). Le 5 di W0 (Lang `Change`/`Switcher`, UI
  `DarkModeSwitcher`, User `TermsOfService`/`PrivacyPolicy`) sono cancellate
  e ora anche committate (`e9f84faa1`); prima erano solo `D` nel working tree.
- 21 cartelle: 19 `app/Http/Livewire` piu' `UI/app/Livewire` e
  `User/app/Livewire`. Dodici delle 19 non contengono nulla oltre a `.gitkeep`
  e `_components.json` (cache di `GetComponentsAction`): sopravvivono a ogni
  ritiro di classi, quindi lo stato finale va misurato sulle cartelle.
- zero chiamanti di produzione per FQCN delle 23 (le sole occorrenze sono le
  dichiarazioni `namespace`; controprova: la stessa regex le trova tutte). Per
  alias resta un solo tag reale, `<livewire:toast />` in
  `User/resources/views/components/layouts/main.blade.php:48`, mentre
  `UI\Filament\Widgets\ToastWidget` e' gia' montato in
  `UI/resources/views/components/layouts/main.blade.php:27`. Altri tag per alias
  (`@livewire('test')` in Xot `admin/index/acts/test.blade.php`, wrapper Geo
  `form_search_address_categories.blade.php`) puntano a uno stub (Geo `Test`) o
  a un wrapper che nessuna vista usa; la raggiungibilita' della vista Xot
  "acts" non e' verificata a runtime.
- 143 file in `*/Filament/Widgets` (l'inventory dice ~168).
- Volt: 7 classi Cms in `app/Http/Volt` e `User/app/View/Pages/ProfileEditVoltComponent`;
  15 pagine Folio con `use Livewire\Volt\Component`, tutte in
  `User/resources/views/pages` (piu' `genesis/power-ups` con `@volt` inline);
  nessun Volt Blade fuori da User; `profile/edit` e' di 714 righe.

**Cosa resta aperto:** solo Volt/Folio, cioe' l'unica superficie FO non-widget
con traffico reale (le 15 pagine di User, `profile/edit`, `area-personale/*`).
Nessun `KEEP` ha un uso reale: Toast ha il gemello gia' montato (REUSE+RETIRE);
Cms `Page\Show`, Geo `FormSearchAddressCategories`, Media `Card\Video\Clip`
non hanno chiamanti. Il verdetto `KEEP` nasceva da "e' forma di FO", non da un
uso. Decisioni di prodotto aperte: Auth `Verify` e `Passwords\Confirm`
(MIGRATE o RETIRE), address search FO. Dettaglio per componente nella
[nota di verifica della story](./stories/livewire-to-filament-widgets-fleet.story.md).

**Incoerenze documentali trovate (da sanare, non da cancellare):**

1. due sezioni "Wave 4" nel piano di parallelizzazione, e Job e' W1 nella story
   ma Wave 2 nel piano;
2. la voce "Baseline 27" sopra dice "implementazione non avviata", mentre la story
   segna W0 `DONE`: la voce e' storica;
3. il prompt 05 si contraddice (`KEEP` per switcher, toast, logout, form
   pubblici contro la tabella W0 che impone `REUSE`);
4. `no-standalone-livewire-classes.md` riga 28 ammette `@volt` inline in Folio,
   mentre il concept `no-pure-livewire-outside-filament-widgets.md` (riga 25) lo
   vieta come sostituto di layout o componente UI;
5. lw2fw-01 ha l'AC "nessuna directory" spuntato (riga 46) ma le cartelle sono
   21; la guardia non copre `UI/app/Livewire`;
6. test di ritiro con attese opposte (lettura statica, non eseguiti): Geo
   `HttpLivewireTestRetiredTest` (righe 22-24) pretende
   `FormSearchAddressCategories` viva, Xot `NoLivewireDirectoriesInModulesTest`
   pretende zero cartelle, Job `JobExecuteCoverage50Test` (299-304) e User
   `RetiredChromeLivewireTest` pretendono classi assenti che sono presenti;
7. i file ritirati tornano con i pull: `git log --diff-filter=AD` mostra D e A
   alternati per `User/.../Team/Change.php` (D 2026-09-21, A 2026-09-24),
   `Geo/.../Test.php` (D 2026-09-21, A 2026-09-24) e `Job/.../Job/Status.php`
   (D 2026-10-06, A 2026-10-08).

**Stesso schema dei Service:** lo stato finale richiesto e' una condizione sulle
cartelle (nessuna `app/Http/Livewire` ne' `app/Livewire`), non solo sulle classi;
vedi `bmad-output/epic-services-to-queueable-actions.md` (righe 23 e 60) e il
fenomeno dei file ritirati che tornano dal pull di `laraxot/dev`.

**Next:** nessuna wave aperta; questa voce non autorizza edit PHP. Ordine
aggiornato W1 stabilizzare, W2 ritiri a rischio basso, W3 auth, W4 Volt/Folio,
W5 guardia: vedi la nota di verifica della story.
