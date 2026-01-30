# Implementazione Tema e Layout

## Obiettivi
- Personalizzare theme_one_fila3
- Creare componenti riutilizzabili
- Implementare dark/light mode
- Configurare traduzioni

## Passi Implementativi

### 1. Personalizzazione Tema
1. Setup theme_one_fila3
   ```bash
   composer require laraxot/theme_one_fila3
   php artisan vendor:publish --tag=theme_one_fila3
   ```

2. Configurare tema
   ```php
   // config/theme.php
   return [
       'name' => 'il progetto',
       'version' => '1.0.0',
       'assets' => [
           'css' => [
               'app.css',
               'custom.css',
           ],
           'js' => [
               'app.js',
               'custom.js',
           ],
       ],
   ];
   ```

### 2. Componenti Riutilizzabili
1. Creare struttura componenti
   ```php
   // resources/views/components/
   ├── buttons/
   ├── cards/
   ├── forms/
   ├── modals/
   └── tables/
   ```

2. Implementare componenti base
   ```php
   // resources/views/components/buttons/primary.blade.php
   <button {{ $attributes->merge(['class' => 'btn btn-primary']) }}>
       {{ $slot }}
   </button>
   ```

### 3. Dark/Light Mode
1. Configurare tema
   ```php
   // config/filament.php
   'dark_mode' => [
       'enabled' => true,
       'default' => false,
   ],
   ```

2. Implementare toggle
   ```php
   // resources/views/components/theme-toggle.blade.php
   <button x-data @click="$store.theme.toggle()">
       <span x-show="$store.theme.isDark">🌙</span>
       <span x-show="!$store.theme.isDark">☀️</span>
   </button>
   ```

### 4. Traduzioni
1. Setup module_lang_fila3
   ```bash
   composer require laraxot/module_lang_fila3
   php artisan vendor:publish --tag=module_lang_fila3
   ```

2. Configurare lingue
   ```php
   // config/language.php
   return [
       'available_locales' => [
           'it' => 'Italiano',
           'en' => 'English',
       ],
       'default_locale' => 'it',
   ];
   ```

## Testing
1. Unit Tests
   ```php
   // tests/Unit/ThemeTest.php
   class ThemeTest extends TestCase
   {
       // Implementazione test
   }
   ```

2. Feature Tests
   ```php
   // tests/Feature/ThemeTest.php
   class ThemeTest extends TestCase
   {
       // Implementazione test
   }
   ```

## Note Implementative
- Implementare lazy loading per assets
- Ottimizzare immagini
- Implementare cache per assets
- Gestire fallback per componenti
- Implementare error boundaries
- Gestire stati di caricamento
- Implementare animazioni fluide 