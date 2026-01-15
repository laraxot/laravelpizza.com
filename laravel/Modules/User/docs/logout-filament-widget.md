# Implementazione del Logout con Widget Filament

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Implementazione Auth Pages](AUTH_PAGES_IMPLEMENTATION.md)
- [Implementazione Logout](LOGOUT_BLADE_IMPLEMENTATION.md)
- [Analisi Errore Logout](LOGOUT_IMPLEMENTATION_ERROR.md)
- [Struttura Widget](WIDGETS_STRUCTURE.md)
- [Documentazione Auth Tema One](/laravel/Themes/One/docs/AUTH.md)

## Introduzione

Questo documento descrive l'implementazione del logout utilizzando un widget Filament, un approccio che offre maggiore flessibilità e riutilizzabilità rispetto a un'implementazione Volt personalizzata. Questo approccio è particolarmente utile quando si desidera mantenere una pagina di conferma per il logout.

## Struttura del Widget Filament per il Logout

### 1. Classe del Widget

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LogoutWidget extends XotBaseWidget
{
    /**
     * Blade view del widget.
     * IMPORTANTE: quando il widget viene usato con @livewire() direttamente nelle Blade,
     * il path deve essere senza il namespace del modulo.
     */
    protected static string $view = 'filament.widgets.auth.logout';

    /**
     * Stato del widget.
     */
    public bool $isLoggingOut = false;

    /**
     * Costruisce il form del widget.
     */
    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->schema([
                Component::make()
                    ->columnSpan('full')
                    ->extraAttributes(['class' => 'text-center'])
                    ->view('filament.widgets.auth.logout-message'),
            ])
            ->statePath('data');
    }

    /**
     * Azione di logout.
     */
    public function logout(): void
    {
        try {
            $this->isLoggingOut = true;

            // Evento pre-logout
            Event::dispatch('auth.logout.attempting', [Auth::user()]);

            // Esegui il logout
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            // Evento post-logout
            Event::dispatch('auth.logout.successful');

            // Log dell'operazione
            Log::info('Utente disconnesso', [
                'timestamp' => now()
            ]);

            // Reindirizzamento con localizzazione
            $locale = app()->getLocale();
            redirect()->to('/' . $locale)
                ->with('success', __('Logout effettuato con successo'));
        } catch (\Exception $e) {
            Log::error('Errore durante il logout: ' . $e->getMessage());
            $this->isLoggingOut = false;
            session()->flash('error', __('Errore durante il logout'));
        }
    }

    /**
     * Azioni del form.
     */
    public function getFormActions(): array
    {
        return [
            'logout' => Action::make('logout')
                ->color('danger')
                ->size('lg')
                ->extraAttributes(['class' => 'w-full justify-center'])
                ->action(fn () => $this->logout()),
            'cancel' => Action::make('cancel')
                ->color('gray')
                ->size('lg')
                ->extraAttributes(['class' => 'w-full justify-center mt-2'])
                ->url(function () {
                    $locale = app()->getLocale();
                    return '/' . $locale;
                }),
        ];
    }
}
```

### 2. Vista del Widget (filament.widgets.auth.logout.blade.php)

```blade
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-6">
            @if (session('error'))
                <div class="p-4 border border-danger-600 bg-danger-500/10 rounded-lg">
                    <p class="text-danger-600 text-sm">
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            <form wire:submit="logout">
                {{ $this->form }}

                <div class="mt-6 flex flex-col gap-3">
                    <x-filament::button
                        type="submit"
                        color="danger"
                        size="lg"
                        class="w-full justify-center"
                        :disabled="$isLoggingOut">
                        {{ __('Conferma Logout') }}
                    </x-filament::button>

                    <x-filament::button
                        tag="a"
                        :href="'/' . app()->getLocale()"
                        color="gray"
                        size="lg"
                        class="w-full justify-center">
                        {{ __('Annulla') }}
                    </x-filament::button>
                </div>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
```

### 3. Vista del Messaggio (filament.widgets.auth.logout-message.blade.php)

```blade
<div class="text-center">
    <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-900">
        {{ __('Sei sicuro di voler uscire?') }}
    </h2>
    <p class="mt-2 text-sm text-gray-500">
        {{ __('Conferma per effettuare il logout dal sistema.') }}
    </p>
</div>
```

## Implementazione nella Pagina di Logout

### Pagina di Logout con Widget Filament (logout.blade.php)

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');
?>

<x-layout>
    <x-slot:title>
        {{ __('Logout') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            @livewire(\Modules\User\Filament\Widgets\LogoutWidget::class)
        </div>
    </div>
</x-layout>
```

## Registrazione del Widget

Per rendere il widget disponibile nell'applicazione, è necessario registrarlo nel provider del modulo User:

```php
// In UserServiceProvider.php - metodo boot()
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;

FilamentView::registerRenderHook(
    'panels::auth.logout',
    fn (): string => Blade::render('@livewire(\'Modules\User\Filament\Widgets\LogoutWidget\')')
);
```

## Vantaggi dell'Approccio con Widget Filament

1. **Riutilizzabilità**: Il widget può essere utilizzato sia nelle pagine Blade che nei pannelli Filament.
2. **Coerenza UI**: Utilizza i componenti UI nativi di Filament, garantendo coerenza visiva.
3. **Manutenibilità**: Separa chiaramente la logica dalla presentazione.
4. **Estensibilità**: Facilmente estensibile per aggiungere funzionalità aggiuntive.
5. **Conformità alle convenzioni**: Segue le convenzioni di <nome progetto> per i widget Filament.

## Alternativa: Logout Immediato

Se non è necessaria una conferma per il logout, è preferibile utilizzare l'approccio "Folio con PHP puro" come descritto in [LOGOUT_BLADE_IMPLEMENTATION.md](LOGOUT_BLADE_IMPLEMENTATION.md), che esegue il logout immediatamente senza richiedere conferma.

## Conclusione

L'implementazione del logout con un widget Filament offre un approccio flessibile e riutilizzabile, particolarmente utile quando si desidera mantenere una pagina di conferma. Tuttavia, per un'esperienza utente più fluida, è generalmente preferibile l'approccio di logout immediato con Folio e PHP puro.
# Implementazione del Logout con Widget Filament

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Implementazione Auth Pages](AUTH_PAGES_IMPLEMENTATION.md)
- [Implementazione Logout](LOGOUT_BLADE_IMPLEMENTATION.md)
- [Analisi Errore Logout](LOGOUT_IMPLEMENTATION_ERROR.md)
- [Struttura Widget](WIDGETS_STRUCTURE.md)
- [Documentazione Auth Tema One](/laravel/Themes/One/docs/AUTH.md)

## Introduzione

Questo documento descrive l'implementazione del logout utilizzando un widget Filament, un approccio che offre maggiore flessibilità e riutilizzabilità rispetto a un'implementazione Volt personalizzata. Questo approccio è particolarmente utile quando si desidera mantenere una pagina di conferma per il logout.

## Struttura del Widget Filament per il Logout

### 1. Classe del Widget

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LogoutWidget extends XotBaseWidget
{
    /**
     * Blade view del widget.
     * IMPORTANTE: quando il widget viene usato con @livewire() direttamente nelle Blade,
     * il path deve essere senza il namespace del modulo.
     */
    protected static string $view = 'filament.widgets.auth.logout';

    /**
     * Stato del widget.
     */
    public bool $isLoggingOut = false;

    /**
     * Costruisce il form del widget.
     */
    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->schema([
                Component::make()
                    ->columnSpan('full')
                    ->extraAttributes(['class' => 'text-center'])
                    ->view('filament.widgets.auth.logout-message'),
            ])
            ->statePath('data');
    }

    /**
     * Azione di logout.
     */
    public function logout(): void
    {
        try {
            $this->isLoggingOut = true;

            // Evento pre-logout
            Event::dispatch('auth.logout.attempting', [Auth::user()]);

            // Esegui il logout
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            // Evento post-logout
            Event::dispatch('auth.logout.successful');

            // Log dell'operazione
            Log::info('Utente disconnesso', [
                'timestamp' => now()
            ]);

            // Reindirizzamento con localizzazione
            $locale = app()->getLocale();
            redirect()->to('/' . $locale)
                ->with('success', __('Logout effettuato con successo'));
        } catch (\Exception $e) {
            Log::error('Errore durante il logout: ' . $e->getMessage());
            $this->isLoggingOut = false;
            session()->flash('error', __('Errore durante il logout'));
        }
    }

    /**
     * Azioni del form.
     */
    public function getFormActions(): array
    {
        return [
            'logout' => Action::make('logout')
                ->color('danger')
                ->size('lg')
                ->extraAttributes(['class' => 'w-full justify-center'])
                ->action(fn () => $this->logout()),
            'cancel' => Action::make('cancel')
                ->color('gray')
                ->size('lg')
                ->extraAttributes(['class' => 'w-full justify-center mt-2'])
                ->url(function () {
                    $locale = app()->getLocale();
                    return '/' . $locale;
                }),
        ];
    }
}
```

### 2. Vista del Widget (filament.widgets.auth.logout.blade.php)

```blade
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-6">
            @if (session('error'))
                <div class="p-4 border border-danger-600 bg-danger-500/10 rounded-lg">
                    <p class="text-danger-600 text-sm">
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            <form wire:submit="logout">
                {{ $this->form }}

                <div class="mt-6 flex flex-col gap-3">
                    <x-filament::button
                        type="submit"
                        color="danger"
                        size="lg"
                        class="w-full justify-center"
                        :disabled="$isLoggingOut">
                        {{ __('Conferma Logout') }}
                    </x-filament::button>

                    <x-filament::button
                        tag="a"
                        :href="'/' . app()->getLocale()"
                        color="gray"
                        size="lg"
                        class="w-full justify-center">
                        {{ __('Annulla') }}
                    </x-filament::button>
                </div>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
```

### 3. Vista del Messaggio (filament.widgets.auth.logout-message.blade.php)

```blade
<div class="text-center">
    <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-900">
        {{ __('Sei sicuro di voler uscire?') }}
    </h2>
    <p class="mt-2 text-sm text-gray-500">
        {{ __('Conferma per effettuare il logout dal sistema.') }}
    </p>
</div>
```

## Implementazione nella Pagina di Logout

### Pagina di Logout con Widget Filament (logout.blade.php)

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');
?>

<x-layout>
    <x-slot:title>
        {{ __('Logout') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            @livewire(\Modules\User\Filament\Widgets\LogoutWidget::class)
        </div>
    </div>
</x-layout>
```

## Registrazione del Widget

Per rendere il widget disponibile nell'applicazione, è necessario registrarlo nel provider del modulo User:

```php
// In UserServiceProvider.php - metodo boot()
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;

FilamentView::registerRenderHook(
    'panels::auth.logout',
    fn (): string => Blade::render('@livewire(\'Modules\User\Filament\Widgets\LogoutWidget\')')
);
```

## Vantaggi dell'Approccio con Widget Filament

1. **Riutilizzabilità**: Il widget può essere utilizzato sia nelle pagine Blade che nei pannelli Filament.
2. **Coerenza UI**: Utilizza i componenti UI nativi di Filament, garantendo coerenza visiva.
3. **Manutenibilità**: Separa chiaramente la logica dalla presentazione.
4. **Estensibilità**: Facilmente estensibile per aggiungere funzionalità aggiuntive.
5. **Conformità alle convenzioni**: Segue le convenzioni di <nome progetto> per i widget Filament.

## Alternativa: Logout Immediato

Se non è necessaria una conferma per il logout, è preferibile utilizzare l'approccio "Folio con PHP puro" come descritto in [LOGOUT_BLADE_IMPLEMENTATION.md](LOGOUT_BLADE_IMPLEMENTATION.md), che esegue il logout immediatamente senza richiedere conferma.

## Conclusione

L'implementazione del logout con un widget Filament offre un approccio flessibile e riutilizzabile, particolarmente utile quando si desidera mantenere una pagina di conferma. Tuttavia, per un'esperienza utente più fluida, è generalmente preferibile l'approccio di logout immediato con Folio e PHP puro.
