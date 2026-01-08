# Creazione di un Tema per il CMS

## Introduzione

Questa guida descrive come creare un nuovo tema per il CMS utilizzando una combinazione di tecnologie moderne tra cui Tailwind CSS e Vite. Il tema è strutturato come un pacchetto Composer indipendente che può essere facilmente installato e configurato.

## Prerequisiti

1. Node.js e npm installati
2. Accesso alla directory dei temi
3. Conoscenza base di Vite e Tailwind CSS
4. PHP 8.1+
5. Laravel v10.0+

## Passo 1: Struttura del Tema

Un tema è organizzato come un pacchetto Composer con la seguente struttura:

```
theme-name/
├── composer.json
├── package.json
├── vite.config.ts
├── tailwind.config.js
├── postcss.config.js
├── theme.json
├── index.html
├── config/
│   └── theme.php
├── src/
│   └── ThemeServiceProvider.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       └── pages/
├── public/
└── laravel/
    └── routes/
        └── web.php
```

## Passo 2: Configurazione Base

1. **composer.json**
```json
{
    "name": "<directory progetto>/theme-name",
    "description": "Tema per il progetto",
    "type": "theme",
    "license": "proprietary",
    "autoload": {
        "psr-4": {
            "il progetto\\Themes\\ThemeName\\": "src/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "il progetto\\Themes\\ThemeName\\ThemeServiceProvider"
            ]
        }
    },
    "require": {
        "php": "^8.1",
        "laravel/framework": "^10.0"
    }
}
```

2. **package.json**
```json
{
    "name": "<directory progetto>/theme-name",
    "private": true,
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "preview": "vite preview"
    },
    "devDependencies": {
        "@tailwindcss/forms": "^0.5.7",
        "@tailwindcss/typography": "^0.5.10",
        "autoprefixer": "^10.4.16",
        "postcss": "^8.4.32",
        "postcss-import": "^15.1.0",
        "tailwindcss": "^3.3.6",
        "vite": "^5.0.10"
    }
}
```

## Passo 3: Configurazione di Vite

```typescript
// vite.config.ts
import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
    root: './',
    publicDir: 'public',
    build: {
        outDir: 'public/build',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                css: 'resources/css/app.css'
            }
        }
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js')
        }
    }
});
```

## Passo 4: Configurazione di Tailwind

```javascript
// tailwind.config.js
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
```

## Passo 5: Service Provider

```php
<?php

namespace il progetto\Themes\ThemeName;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/theme.php', 'theme'
        );
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'theme');
        $this->loadRoutesFrom(__DIR__.'/../laravel/routes/web.php');
    }
}
```

## Passo 6: Configurazione del Tema

```php
<?php

return [
    'name' => 'Theme Name',
    'version' => '1.0.0',
    'author' => 'il progetto Team',
    'description' => 'Tema per il progetto',
    'active' => true,
    'assets' => [
        'css' => 'public/build/css/app.css',
        'js' => 'public/build/js/app.js',
    ],
];
```

## Passo 7: Installazione e Build

1. **Installazione delle Dipendenze**
```bash
composer install
npm install
```

2. **Build degli Asset**
```bash
npm run build
```

## Troubleshooting

### Problemi Comuni

1. **Errori di Build**
   - Verificare le versioni delle dipendenze
   - Controllare la configurazione di Vite
   - Assicurarsi che tutti i file necessari siano presenti

2. **Problemi di Stile**
   - Verificare la configurazione di Tailwind
   - Controllare l'ordine degli import CSS
   - Assicurarsi che i plugin siano configurati correttamente

## Risorse Utili

- [Documentazione Laravel](https://laravel.com/docs)
- [Documentazione Vite](https://vitejs.dev/guide/)
- [Documentazione Tailwind CSS](https://tailwindcss.com/docs)

# Creazione di un Tema Frontoffice

## Introduzione

Questa documentazione descrive come creare un nuovo tema frontoffice per il CMS. Il tema deve seguire le best practices di Filament e Laravel.

## Struttura

```
Modules/
└── User/
    └── Filament/
        └── Widgets/
            └── Auth/
                ├── RegisterWidget.php
                ├── LoginWidget.php
                └── ResetPasswordWidget.php
```

## Regole per i Widget Filament

1. **Posizionamento**
   - I widget Filament vanno sempre nella directory `Filament/Widgets/`
   - Non confondere con i componenti Livewire che vanno in `Http/Livewire/`
   - Ogni widget deve estendere `Filament\Widgets\Widget`

2. **Struttura**
   - Usare il namespace corretto: `Modules\{Module}\Filament\Widgets\{Category}`
   - Definire la vista con `protected static string $view`
   - Implementare il form con `public function form(Form $form): Form`

3. **Best Practices**
   - Utilizzare i componenti Filament per la UI
   - Seguire il design system di Filament
   - Implementare le validazioni integrate
   - Usare le notifiche di Filament

4. **Sicurezza**
   - Validare sempre gli input
   - Usare password hashing
   - Implementare rate limiting
   - Proteggere le rotte

5. **Performance**
   - Ottimizzare le query
   - Usare il caching
   - Minimizzare le richieste HTTP
   - Implementare lazy loading

## Esempio di Widget

```php
<?php

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Modules\User\Models\User;

class RegisterWidget extends Widget
{
    protected static string $view = 'user::filament.widgets.auth.register';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(User::class),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->same('password_confirmation'),
                TextInput::make('password_confirmation')
                    ->label('Conferma Password')
                    ->password()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function register(): void
    {
        $data = $this->form->getState();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        auth()->login($user);

        Notification::make()
            ->title('Registrazione completata con successo')
            ->success()
            ->send();

        $this->redirect(route('dashboard'));
    }
}
```

## Viste

Le viste dei widget devono utilizzare i componenti Filament:

```php
<x-filament-panels::page>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <x-filament::widget>
                <x-filament::form wire:submit="register">
                    {{ $this->form }}
                    
                    <x-filament::button type="submit">
                        Registrati
                    </x-filament::button>
                </x-filament::form>
            </x-filament::widget>
        </div>
    </div>
</x-filament-panels::page>
```

## Registrazione

I widget devono essere registrati nel Service Provider:

```php
public function boot(): void
{
    Filament::registerWidgets([
        RegisterWidget::class,
        LoginWidget::class,
        ResetPasswordWidget::class,
    ]);
}
```

## Troubleshooting

### Problemi Comuni

1. **Errori di Validazione**
   - Verificare le regole di validazione
   - Controllare i messaggi di errore
   - Assicurarsi che i campi siano correttamente configurati

2. **Problemi di Stile**
   - Verificare la configurazione di Filament
   - Controllare l'ordine degli import CSS
   - Assicurarsi che i componenti siano correttamente stilizzati

## Risorse Utili

- [Documentazione Filament Forms](https://filamentphp.com/docs/forms)
- [Documentazione Filament Widgets](https://filamentphp.com/docs/widgets)
- [Best Practices Filament](https://filamentphp.com/docs/best-practices)
