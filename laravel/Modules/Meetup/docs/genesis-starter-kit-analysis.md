# Analisi Genesis Starter Kit - TALL Stack con Folio + Volt

## Data: 2025-01-27

## Panoramica

**Genesis** è uno starter kit per il TALL Stack (Tailwind CSS, Alpine.js, Laravel, Livewire) costruito con **Laravel Folio** e **Livewire Volt**. È stato creato da TheDevDojo e rappresenta un esempio pratico e completo di come utilizzare Folio e Volt insieme in un'applicazione reale.

**Repository**: [thedevdojo/genesis](https://github.com/thedevdojo/genesis)  
**Articolo Laravel News**: [Genesis is a Starter Kit for the TALL Stack](https://laravel-news.com/genesis-starter-kit)

---

## Caratteristiche Principali

### Stack Tecnologico

- **Laravel**: Framework PHP
- **Livewire 3**: Framework per componenti reattivi
- **Volt**: API funzionale per Livewire (riduce boilerplate)
- **Folio**: Sistema di routing file-based
- **Tailwind CSS**: Framework CSS utility-first
- **Alpine.js**: Framework JavaScript minimale
- **Vite**: Build tool per assets

### Pagine Incluse

Genesis include le seguenti pagine pre-configurate:

1. **Home Page** (`index.blade.php`)
   - Middleware: `redirect-to-dashboard` (redirect utenti autenticati)
   - Layout: Marketing

2. **About Page** (`about.blade.php`)
   - Pagina semplice con breadcrumbs component

3. **Authentication Pages** (`auth/`)
   - `login.blade.php` - Login
   - `register.blade.php` - Registrazione
   - `verify.blade.php` - Verifica email
   - `password/confirm.blade.php` - Conferma password
   - `password/reset.blade.php` - Reset password
   - `password/[token].blade.php` - Reset con token

4. **Dashboard Page** (`dashboard/index.blade.php`)
   - Middleware: `auth`, `verified`
   - Layout: App

5. **Profile Edit Page** (`profile/edit.blade.php`)
   - Middleware: `auth`, `verified`
   - Sezioni: Update profile, Update password, Delete profile

6. **Learn Page** (`learn/index.blade.php`)
   - Mostra README.md del progetto

---

## Struttura File

### Routing Folio

Genesis utilizza Folio per il routing automatico. Le rotte vengono create automaticamente dalla struttura delle directory:

```
resources/views/pages/
├── index.blade.php              → GET /
├── about.blade.php              → GET /about
├── auth/
│   ├── login.blade.php         → GET /auth/login
│   ├── register.blade.php       → GET /auth/register
│   ├── verify.blade.php        → GET /auth/verify
│   └── password/
│       ├── confirm.blade.php   → GET /auth/password/confirm
│       ├── reset.blade.php     → GET /auth/password/reset
│       └── [token].blade.php   → GET /auth/password/{token}
├── dashboard/
│   └── index.blade.php         → GET /dashboard
├── profile/
│   └── edit.blade.php          → GET /profile/edit
└── learn/
    └── index.blade.php         → GET /learn
```

**Comando utile**: `php artisan folio:list` per vedere tutte le rotte generate.

### Layouts

Genesis include tre layout principali:

1. **`components/layouts/main.blade.php`**
   - Layout base con struttura HTML principale
   - Contiene `<html>`, `<head>`, `<body>`
   - Usato come base per altri layout

2. **`components/layouts/marketing.blade.php`**
   - Layout per pagine marketing (homepage, blog, etc.)
   - Estende `main.blade.php`
   - Include header e footer marketing

3. **`components/layouts/app.blade.php`**
   - Layout per pagine applicazione (utenti autenticati)
   - Estende `main.blade.php`
   - Include header e footer app

**Utilizzo**:
```blade
<x-layouts.app>
    <!-- Contenuto app -->
</x-layouts.app>

<x-layouts.marketing>
    <!-- Contenuto marketing -->
</x-layouts.marketing>

<x-layouts.main>
    <!-- Contenuto base -->
</x-layouts.main>
```

### UI Components

Genesis fornisce una libreria di componenti Blade riutilizzabili in `resources/views/components/ui/`:

#### Componenti Base
- `button.blade.php` - Bottone
- `checkbox.blade.php` - Checkbox
- `input.blade.php` - Input field
- `select.blade.php` - Select dropdown
- `link.blade.php` - Link
- `logo.blade.php` - Logo (facile da personalizzare)
- `modal.blade.php` - Modal dialog
- `nav-link.blade.php` - Navigation link
- `placeholder.blade.php` - Placeholder
- `text-link.blade.php` - Text link
- `light-dark-switch.blade.php` - Toggle tema chiaro/scuro

#### Componenti App/Marketing
- `app/header.blade.php` - Header per pagine app
- `marketing/header.blade.php` - Header per pagine marketing
- `marketing/breadcrumbs.blade.php` - Breadcrumbs

---

## Pattern di Implementazione

### Pattern 1: Pagina Semplice con Volt

**Esempio**: `pages/about.blade.php`

```blade
<x-layouts.marketing>
    @volt('about')
        <div>
            <h1>About</h1>
            <!-- Contenuto -->
        </div>
    @endvolt
</x-layouts.marketing>
```

**Caratteristiche**:
- Layout marketing
- Componente Volt inline
- Nessuna logica complessa

### Pattern 2: Pagina con Middleware

**Esempio**: `pages/dashboard/index.blade.php`

```blade
<?php
use function Livewire\Volt\state;

middleware(['auth', 'verified']);

state(['user' => fn() => auth()->user()]);
?>

<x-layouts.app>
    @volt('dashboard')
        <div>
            <h1>Welcome, {{ $user->name }}!</h1>
            <!-- Dashboard content -->
        </div>
    @endvolt
</x-layouts.app>
```

**Caratteristiche**:
- Middleware definito in PHP
- State management con Volt
- Layout app per utenti autenticati

### Pattern 3: Pagina con Route Model Binding

**Esempio**: `pages/profile/edit.blade.php`

```blade
<?php
use function Livewire\Volt\state;

middleware(['auth', 'verified']);

state(['user' => fn() => auth()->user()]);
?>

<x-layouts.app>
    @volt('profile-edit')
        <form wire:submit="updateProfile">
            <!-- Form fields -->
        </form>
    @endvolt
    
    function updateProfile(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ]);
        
        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        
        session()->flash('message', 'Profile updated!');
    }
</x-layouts.app>
```

---

## Lezioni Apprese

### 1. Separazione Layout

Genesis dimostra l'importanza di separare i layout:
- **Marketing**: Per pagine pubbliche (homepage, about, blog)
- **App**: Per pagine autenticate (dashboard, profile)
- **Main**: Per casi speciali (auth pages)

### 2. Middleware a Livello Pagina

Folio permette di definire middleware direttamente nelle pagine:

```php
middleware(['auth', 'verified']);
```

Questo è più pulito e leggibile rispetto a definire middleware nelle rotte.

### 3. Componenti UI Riutilizzabili

Genesis fornisce una libreria completa di componenti UI che possono essere facilmente personalizzati. Il componente `logo.blade.php` è particolarmente utile perché può essere aggiornato una volta per applicare il logo in tutta l'applicazione.

### 4. Volt per Logica Semplice

Volt è perfetto per logica semplice direttamente nelle pagine. Per logica più complessa, Genesis potrebbe utilizzare Actions o Services.

### 5. Testing

Genesis include test di base per la funzionalità di autenticazione. Ogni pagina in `resources/views/pages` ha un file di test corrispondente in `tests/Feature`.

---

## Installazione

### Via Laravel Installer

```bash
laravel new my-app --using=devdojo/genesis
```

### Via Composer

```bash
composer create-project --prefer-dist laravel/laravel genesis-app
cd genesis-app
composer require devdojo/genesis
php artisan genesis:install
```

### Setup Assets

```bash
npm install
npm run dev
```

---

## Comandi Utili

### Lista Rotte Folio

```bash
php artisan folio:list
```

Output esempio:
```
GET / ................................................ index.blade.php
GET /about ........................................... about.blade.php
GET /auth/login ................................. auth/login.blade.php
GET /auth/register ........................... auth/register.blade.php
GET /dashboard ............................. dashboard/index.blade.php
GET /profile/edit ............................. profile/edit.blade.php
```

### Testing

```bash
./vendor/bin/pest
```

### Clear View Cache

```bash
php artisan view:clear
```

Utile quando si vedono numeri di riga stampati nelle view (bug noto di Folio/Volt in beta).

---

## Troubleshooting

### Problema: Numeri di riga nelle view

**Causa**: Cache view non aggiornata (Folio/Volt in beta)

**Soluzione**:
```bash
php artisan view:clear
```

### Problema: Errori NPM su localhost:5173

**Causa**: Versione NPM non aggiornata

**Soluzione**:
```bash
npm upgrade
```

### Problema: APP_URL diverso da Vite

**Causa**: Configurazione inconsistente tra Laravel installer e composer

**Soluzione**:
1. Usa `composer create-project` invece di `laravel new`
2. Imposta `APP_URL=http://127.0.0.1:8000` in `.env`
3. Avvia server: `npm run dev` e `php artisan serve`

---

## Riferimenti

- [GitHub Repository](https://github.com/thedevdojo/genesis)
- [Wiki Genesis](https://github.com/thedevdojo/genesis/wiki)
- [Laravel News Article](https://laravel-news.com/genesis-starter-kit)
- [Folio Documentation](https://laravel.com/docs/folio)
- [Volt Documentation](https://livewire.laravel.com/docs/volt)

---

## Applicabilità al Progetto Laravel Pizza Meetups

### Cosa Possiamo Adottare

1. **Struttura Layout**: Separare layout marketing/app come in Genesis
2. **Componenti UI**: Creare libreria componenti simile
3. **Pattern Middleware**: Usare middleware a livello pagina
4. **Testing**: Seguire pattern di test per pagina

### Differenze con il Nostro Progetto

- **Moduli**: Il nostro progetto usa `nwidart/laravel-modules`, Genesis no
- **Filament**: Il nostro progetto usa Filament per admin, Genesis no
- **Temi**: Il nostro progetto ha sistema temi, Genesis no

### Raccomandazioni

1. Studiare la struttura dei componenti UI di Genesis
2. Adottare pattern di middleware a livello pagina
3. Creare componenti riutilizzabili simili
4. Implementare testing per ogni pagina Folio

---

**Versione**: 1.0  
**Ultimo Aggiornamento**: 2025-01-27
