# Guida di Installazione Filament 5.x - Laravel Pizza Meetup

**Data**: 2026-02-02  
**Stato**: Documentazione fondamentale per l'installazione di Filament 5.x

---

## 📋 **Introduzione**

Filament 5.x è la versione più recente del pannello di controllo Laravel, che fornisce un'interfaccia di amministrazione moderna e potente per il progetto Laravel Pizza Meetup. Questa guida copre l'installazione completa e la configurazione.

---

## 🎯 **Requisiti di Sistema**

### **Versioni Minime Richieste**
```bash
# PHP: 8.2+
# Laravel: v11.28+
# Tailwind CSS: v4.1+
```

### **Verifica Requisiti**
```bash
# Verifica versione PHP
php -v

# Verifica versione Laravel
php artisan --version

# Verifica versione Tailwind CSS
npm list tailwindcss
```

---

## 🚀 **Installazione Panel Builder**

### **Metodo 1: Installazione Standard**

```bash
# Naviga nella cartella tema
cd laravel/Themes/Meetup/

# Installa Filament Panel Builder
composer require filament/filament:"^5.0"

# Esegui il comando di installazione
php artisan filament:install --panels
```

### **Metodo 2: Windows PowerShell (se necessario)**

```bash
# Se usi Windows PowerShell
composer require filament/filament:"~5.0"
php artisan filament:install --panels
```

### **Verifica Installazione**

Dopo l'installazione, dovrebbe essere creato:
```
laravel/Themes/Meetup/app/Providers/Filament/AdminPanelProvider.php
```

Verifica che il service provider sia registrato in:
```
laravel/Themes/Meetup/bootstrap/providers.php
```

Se non è registrato, aggiungilo manualmente:
```php
// bootstrap/providers.php
return [
    // ... altri service provider
    App\Providers\Filament\AdminPanelProvider::class,
];
```

---

## 👤 **Creazione Utente Admin**

```bash
# Crea un nuovo account utente admin
php artisan make:filament-user
```

Durante l'installazione, potrai configurare:
- Email utente
- Password
- Nome e cognome
- Ruolo (opzionale)

---

## 🎨 **Installazione Componenti Individuali**

Se vuoi usare solo i componenti specifici di Filament:

```bash
# Installa i componenti necessari
composer require
    filament/tables:"^5.0"
    filament/schemas:"^5.0"
    filament/forms:"^5.0"
    filament/infolists:"^5.0"
    filament/actions:"^5.0"
    filament/notifications:"^5.0"
    filament/widgets:"^5.0"
```

### **Metodo 2: Windows PowerShell**
```bash
composer require
    filament/tables:"~5.0"
    filament/schemas:"~5.0"
    filament/forms:"~5.0"
    filament/infolists:"~5.0"
    filament/actions:"~5.0"
    filament/notifications:"~5.0"
    filament/widgets:"~5.0"
```

---

## 🎨 **Installazione Scaffolding**

### **Per Progetti Nuovi**

```bash
# Installa Livewire, Alpine.js e Tailwind CSS
composer require filament/filament:"^5.0"

# Esegui il comando di scaffolding
php artisan filament:install --scaffold

# Installa dipendenze npm
npm install

# Avvia il server di sviluppo
npm run dev
```

### **Per Progetti Esistenti**

```bash
# Installa solo i componenti necessari
composer require filament/filament:"^5.0"

# Esegui il comando di installazione base
php artisan filament:install

# Verifica e aggiorna i file esistenti
```

---

## 🎨 **Installazione Tailwind CSS**

```bash
# Se non hai già Tailwind CSS installato
npm install tailwindcss @tailwindcss/vite --save-dev
```

---

## 🎨 **Configurazione Stili**

### **Importa i CSS di Filament**

Modifica `laravel/Themes/Meetup/resources/css/app.css`:

```css
@import 'tailwindcss';

/* Richiesti da tutti i componenti */
@import '../../vendor/filament/support/resources/css/index.css';

/* Richiesti da actions e tables */
@import '../../vendor/filament/actions/resources/css/index.css';

/* Richiesti da actions, forms e tables */
@import '../../vendor/filament/forms/resources/css/index.css';

/* Richiesti da actions e infolists */
@import '../../vendor/filament/infolists/resources/css/index.css';

/* Richiesti da notifications */
@import '../../vendor/filament/notifications/resources/css/index.css';

/* Richiesti da actions, infolists, forms, schemas e tables */
@import '../../vendor/filament/schemas/resources/css/index.css';

/* Richiesti da tables */
@import '../../vendor/filament/tables/resources/css/index.css';

/* Richiesti da widgets */
@import '../../vendor/filament/widgets/resources/css/index.css';

/* Supporto tema scuro */
@variant dark (&:where(.dark, .dark *));
```

---

## 🎨 **Configurazione Vite**

Aggiungi il plugin `@tailwindcss/vite` alla tua configurazione Vite (`laravel/Themes/Meetup/vite.config.js`):

```javascript
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
})
```

---

## 🎨 **Compilazione Asset**

```bash
# Compila i CSS e JS
npm run dev

# Per produzione
npm run build
```

---

## 🎨 **Configurazione Layout**

### **Crea il Layout Principale**

```bash
# Crea il layout se non esiste
php artisan livewire:layout
```

Questo crea `laravel/Themes/Meetup/resources/views/components/layouts/app.blade.php` con:

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        @filamentStyles
        @vite('resources/css/app.css')
    </head>
    <body class="antialiased">
        {{ $slot }}
        
        @livewire('notifications') {{-- Richiesto solo se usi le notifiche --}}
        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>
```

---

## ⚙️ **Pubblicazione Configurazione**

```bash
# Pubblica il file di configurazione di Filament
php artisan vendor:publish --tag=filament-config
```

Questo crea `laravel/Themes/Meetup/config/filament.php` dove puoi configurare:
- Disco filesystem di default
- Flag di generazione file
- Impostazioni UI predefinite

---

## 🔧 **Configurazione Avanzata**

### **Pannello Admin Personalizzato**

Modifica `laravel/Themes/Meetup/app/Providers/Filament/AdminPanelProvider.php`:

```php
use Filament\Panel;
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => '#57534e', // Nero cappuccino
            ])
            ->font('Inter')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->userMenuItems([
                'account' => MenuItem::make()
                    ->url('/admin/account'),
            ])
            ->navigationGroups([
                'Navigation Group 1',
                'Navigation Group 2',
            ]);
    }
}
```

---

## 🎯 **Accesso al Pannello**

Dopo l'installazione completa:

1. **Accedi al pannello**: `http://127.0.0.1:8000/admin`
2. **Accedi con**: Le credenziali dell'utente admin creato
3. **Configura**: Personalizza il pannello secondo le esigenze del progetto

---

## 🚨 **Errori Comuni e Soluzioni**

### **Errore: Service Provider non registrato**

**Soluzione**:
```bash
# Verifica che il service provider sia registrato
cat laravel/Themes/Meetup/bootstrap/providers.php | grep AdminPanelProvider
```

### **Errore: CSS/JS non caricati**

**Soluzione**:
```bash
# Pulisci cache
php artisan filament:cache-cleanup
npm run dev
```

### **Errore: Livewire non trovato**

**Soluzione**:
```bash
composer require livewire/livewire:"^3.0"
npm install
npm run dev
```

---

## 📚 **Documentazione Correlata**

- [filament-5-resource-creation.md](./02-filament-5-resource-creation.md)
- [filament-5-actions-configuration.md](./03-filament-5-actions-configuration.md)
- [filament-5-customization-guide.md](./04-filament-5-customization-guide.md)

---

## 🎉 **Conclusione**

Hai ora installato e configurato con successo Filament 5.x per il tuo progetto Laravel Pizza Meetup. Il pannello di amministrazione è pronto per essere personalizzato e utilizzato per gestire i contenuti del sito.

**Prossimi Passi**:
1. Personalizza il tema del pannello
2. Crea le tue prime risorse
3. Configura le pagine personalizzate
4. Aggiungi widgets e funzionalità avanzate

---

**Documentazione**: `laravel/Themes/Meetup/docs/03-development/01-filament-5-installation-guide.md`  
**Ultimo Aggiornamento**: 2026-02-02