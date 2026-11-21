---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire inventory"
issues: []
discussions: []
title: "Inventario Http/Livewire → Filament widget — Notify"
type: inventory
module: Notify
status: approved
track: campaign
related:
  - ./livewire-widget-architecture.md
  - ./livewire-widget-project-context.md
  - ./livewire-widget-decision-log.md
  - ./livewire-widget-epics.md
  - ../stories/12.1.notify-notifications-fqcn.story.md
  - ../../User/docs/bmad/livewire-inventory.md
  - ../../Xot/docs/bmad/livewire-widget-project-context.md
---

# Inventario: Livewire HTTP → Filament — modulo Notify

**Solo documentazione. Nessun PHP toccato in questo audit.**

Questo file è la SSoT del modulo Notify per la campagna di conversione Livewire → Filament widget. Formato e metodo ripresi da [Modules/Cms/docs/bmad/livewire-inventory.md](../../Cms/docs/bmad/livewire-inventory.md).

## Metodo (codice, non assunzione)

```bash
find Modules/Notify/app/Http/Livewire Modules/Notify/app/Livewire -type f
find Modules/Notify -iname '*livewire*' -not -path '*/vendor/*'
find Modules/Notify -path '*/vendor/*' -prune -o -name '*.php' -print | xargs grep -l 'extends.*\(Component\|Livewire\)'
grep -rn "@livewire" Modules/Notify/resources/views
grep -rln "<livewire:" Modules/Notify/resources/views
find Modules/Notify/app/Filament/Widgets -type f
ls Modules/Notify/resources/views/pages
grep -rniE 'database.notification|DatabaseNotifications' Modules/Notify Modules/User/app/Providers/Filament
```

## Classi Livewire possedute: zero (con due leftover inerti)

`Modules/Notify/app/Http/Livewire/` contiene:

- `_components.json` = `[]` (nessun componente registrato);
- `Auth/filamentlogin.fila2` e `Auth/FilamentLogin.fila2` — **non sono file `.php`**: estensione `.fila2`, quindi fuori dall'autoload PSR-4 e mai eseguiti. Contenuto identico (8 righe di codice utile): `class FilamentLogin extends Savannabits\FilamentModules\Http\Livewire\Auth\BaseLogin` con `$context = 'filament'` e `$module = 'Notify'` — relitto del pacchetto `savannabits/filament-modules`, oggi non referenziato da nessun file (unico hit "savannabits" nel repo è un `@see` in `Modules/User/app/Filament/Resources/TenantResource.php:6`).

`app/Livewire/` non esiste. Il grep `extends.*(Component|Livewire)` su tutti i `.php` del modulo non restituisce file. **Notify non possiede componenti Livewire.**

## L'unico mount Livewire reale: `DatabaseNotifications` (vendor Filament)

`Modules/Notify/app/Providers/Filament/AdminPanelProvider.php` (43 righe) è il punto in cui la nota "moved into Notify" di `Modules/User/app/Providers/Filament/AdminPanelProvider.php:41-47` **è stata davvero implementata** (a differenza del caso `terms-of-service` → Gdpr, che non è mai avvenuto — vedi inventario Gdpr):

```php
// righe 32-39
if (! XotData::make()->disable_database_notifications) {
    DatabaseNotifications::trigger('notify::livewire.database-notifications-trigger');   // riga 33
    // DatabaseNotifications::databaseNotificationsPollingInterval('30s');              // riga 34 (commentato)
    DatabaseNotifications::pollingInterval('60s');                                       // riga 35
    FilamentView::registerRenderHook('panels::user-menu.before', static fn (): string => Blade::render(
        '@livewire(\'' . DatabaseNotifications::class . '\')',                           // righe 36-38
    ));
}
```

Fatti verificati:

- Il componente montato è `Filament\Notifications\Livewire\DatabaseNotifications` (riga 7 `use`), **classe vendor Filament**, non codice del modulo. Il mount usa già l'FQCN (`DatabaseNotifications::class`, riga 37) — non l'alias stringa `'database-notifications'` del vecchio hook commentato in User.
- Il trigger custom è la vista `notify::livewire.database-notifications-trigger` → `Modules/Notify/resources/views/livewire/database-notifications-trigger.blade.php`: un `<x-filament::icon-button>` con badge `$unreadNotificationsCount` (righe 4-10 del blade; il resto del file è markup commentato).
- Gate: `XotData::make()->disable_database_notifications`, default **`true`** in `Modules/Xot/app/Datas/XotData.php:61` — quindi il blocco è **spento di default** e la campanella appare solo se un progetto spegne il flag.
- Polling: `60s` (riga 35); l'alternativa `30s` resta commentata (riga 34).
- Lo stesso provider registra `SpatieTranslatablePlugin` per `MailTemplateResource` (righe 28-30) — ortogonale a questa campagna.

## Verifica del montaggio delle viste del modulo

| Meccanismo | Dove si cerca | Esito |
|---|---|---|
| `@livewire(...)` nelle viste Notify | `grep -rn "@livewire" Modules/Notify/resources/views` | Zero hit |
| `<livewire:` nelle viste Notify | `grep -rln "<livewire:" Modules/Notify/resources/views` | Zero hit |
| Render hook | `AdminPanelProvider.php` | Uno solo: `panels::user-menu.before` → `DatabaseNotifications::class` (righe 36-38), gated righe 32-39 |
| Rotte | `Modules/Notify/routes/web.php` (16 righe) | Solo il commento "Filament will handle all routes for this module" (riga 15): nessuna rotta reale |
| Folio/Volt | `ls Modules/Notify/resources/views/pages` | Cartella assente (esiste `resources/views/livewire/` solo per il trigger) |
| Widget Filament del modulo | `find Modules/Notify/app/Filament/Widgets -type f` | Cartella assente: zero widget Notify |

## Classificazione

| Classe | Alias/hook | Gemello widget | Cluster | Nota |
|---|---|---|---|---|
| `Filament\Notifications\Livewire\DatabaseNotifications` (vendor) | FQCN in hook `panels::user-menu.before` (`AdminPanelProvider.php:36-38`) | n/d | **fuori classificazione** | Codice non posseduto: già un componente Filament/Livewire vendor montato correttamente via FQCN. Non è un `Http\Livewire` del modulo da convertire, e non va forkato in un `NotifyDatabaseNotificationsWidget` (fork ingestibile) |
| `Auth\FilamentLogin` (`.fila2`) | nessuno (file inerti, non `.php`) | n/d | **C, escluso** | Relitto `savannabits/filament-modules` mai eseguito; non è nemmeno PHP autoloadabile |

**Cluster A: zero candidati posseduti.** L'unico Livewire montato nel chrome è vendor, già nella forma corretta (FQCN + render hook). Convertire vorrebbe dire forkare Filament: fuori scope per definizione.

**Cluster B: zero candidati.** Nessun HTTP orfano del modulo con gemello widget.

**Cluster C: 1 relitto escluso.** I due `.fila2` di `Auth/FilamentLogin` sono scarti di una migrazione vecchia; la loro rimozione è igienica ma non è una story di conversione.

## Verdetto

Nessuna story di conversione widget: il solo mount Livewire del modulo è il componente vendor già montato nel modo corretto (FQCN, gated, trigger custom). La story [12.1](../stories/12.1.notify-notifications-fqcn.story.md) (hook FQCN al posto dell'alias stringa) è **già soddisfatta dal codice attuale** — `AdminPanelProvider.php:37` usa `DatabaseNotifications::class`; va solo marcata done, non rilavorata. Il vecchio hook `'database-notifications'` in `Modules/User/.../AdminPanelProvider.php:41-47` resta commentato e **non va riattivato in User**.

Rischio residuo documentato: il flag `disable_database_notifications` è `true` di default, quindi il blocco è dormiente; se un progetto lo attiva, ogni futuro rename della classe vendor impatta il user-menu di tutti i panel che ereditano questo provider.

## Riferimenti correlati (non SSoT, coerenti col verdetto)

- [livewire-widget-architecture.md](./livewire-widget-architecture.md)
- [livewire-widget-brainstorming.md](./livewire-widget-brainstorming.md)
- [livewire-widget-decision-log.md](./livewire-widget-decision-log.md)
- [livewire-widget-epics.md](./livewire-widget-epics.md)
- [livewire-widget-prd.md](./livewire-widget-prd.md)
- [livewire-widget-product-brief.md](./livewire-widget-product-brief.md)
- [livewire-widget-project-context.md](./livewire-widget-project-context.md)
- [livewire-widget-tech-spec.md](./livewire-widget-tech-spec.md)
- [livewire-widget-ux.md](./livewire-widget-ux.md)

## Successo

- [x] Inventario completo del modulo (0 classi `Http\Livewire` reali; 2 `.fila2` inerti catalogati)
- [x] Verifica montaggio in tutto il repo (provider, blade, rotte, Folio)
- [x] Nota "moved into Notify" del provider User verificata e **confermata** con citazioni file:riga
- [x] Hook vendor `DatabaseNotifications` classificato come non-candidato (già FQCN, non posseduto)
- [x] Nessuna nuova story creata; story 12.1 identificata come già soddisfatta dal codice
