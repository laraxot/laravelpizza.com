# Filament 5 – riferimento per il tema Meetup

Riferimento ufficiale: [Filament 5 – Installation](https://filamentphp.com/docs/5.x/introduction/installation).

## Requisiti Filament 5

- **PHP** 8.2+
- **Laravel** 11.28+
- **Tailwind CSS** v4.1+

## Due modalità di utilizzo

1. **Panel builder** – pannello completo (es. admin): `composer require filament/filament:^5.0` + `php artisan filament:install --panels`. Crea `app/Providers/Filament/AdminPanelProvider.php`. Nel nostro progetto il panel admin è registrato a livello applicazione (non nel tema).
2. **Componenti singoli** – uso di tabelle, form, azioni, notifiche, widget dentro view Blade/Livewire. Si installano i pacchetti necessari (tables, schemas, forms, infolists, actions, notifications, widgets).

## Setup nel progetto

- **Applicazione** (`laravel/composer.json`): `filament/filament: ^5.0` (panel builder).
- **Tema Meetup** (`laravel/Themes/Meetup/composer.json`): componenti singoli `filament/actions`, `filament/forms`, `filament/infolists`, `filament/notifications`, `filament/schemas`, `filament/support`, `filament/tables`, `filament/widgets` (tutti ^5.x).

Il tema non installa il panel builder; usa i componenti Filament (form, tabelle, notifiche, widget) dove servono nelle view del tema (es. login, notifiche flash).

## CSS Filament nel tema

In **`Themes/Meetup/resources/css/app.css`** sono importati gli stili Filament come da [docs ufficiali – Configuring styles](https://filamentphp.com/docs/5.x/introduction/installation#configuring-styles):

- `filament/support` – base per tutti i componenti
- `filament/actions`, `filament/forms`, `filament/infolists`, `filament/notifications`, `filament/schemas`, `filament/tables`, `filament/widgets`

Dopo modifiche a CSS: dalla cartella del tema eseguire `npm run build` e `npm run copy`. Vedi [theme-resolution-and-workflow](theme-resolution-and-workflow.md) e [development-workflow-css-js-changes](development-workflow-css-js-changes.md).

## Layout e Blade

Per usare componenti Filament (es. notifiche flash) nelle view del tema servono nel layout:

- In `<head>`: `@filamentStyles` e gli asset Vite (es. `@vite('resources/css/app.css')`).
- Prima di `</body>`: `@filamentScripts`, `@vite('resources/js/app.js')`; se usi notifiche Filament: `@livewire('notifications')`.

Il layout principale del tema (`layouts/main.blade.php`) e i layout delle pagine pubbliche devono includere questi blade directive dove si usano componenti Filament. Il panel admin usa il proprio layout Filament (gestito da `AdminPanelProvider`).

## Estensioni Filament (moduli)

Nel progetto **non** si estendono direttamente le classi Filament (Resource, Page, Widget). Si estendono le astrazioni **XotBase** del modulo Xot:

- `Filament\Resources\Resource` → `Modules\Xot\Filament\Resources\XotBaseResource`
- `Filament\Pages\Page` → `Modules\Xot\Filament\Pages\XotBasePage`
- `Filament\Widgets\Widget` → `Modules\Xot\Filament\Widgets\XotBaseWidget`

Le risorse Filament (admin) vivono nei **moduli** (es. `Modules/Meetup/app/Filament/`), non nel tema. Il tema fornisce solo view opzionali per widget/auth (es. `Themes/Meetup/resources/views/filament/widgets/auth/login.blade.php`).

## Riferimenti

- [Installation (ufficiale)](https://filamentphp.com/docs/5.x/introduction/installation)
- [What is Filament? (overview)](https://filamentphp.com/docs/5.x/introduction/overview)
- [theme-resolution-and-workflow](theme-resolution-and-workflow.md) – build e copy del tema
- [architecture-folio-volt-filament](architecture-folio-volt-filament.md) – ruolo di Folio, Volt e Filament
- [critical-rules-and-patterns](critical-rules-and-patterns.md) – regole stack (Filament solo admin)
- Modulo Xot: estensioni XotBase e regole Filament
