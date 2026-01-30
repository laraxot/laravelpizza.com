# Conversione Livewire Auth/Login a Filament LoginWidget

## Analisi del componente Livewire
Il componente `Login` (Livewire) definito in `Modules/User/Http/Livewire/Auth/Login.php.to_widget`:
- Usa `InteractsWithForms` per schema form e validazione.
- Definisce proprietà `$email`, `$password`, `$remember` e regole di validazione.
- Monta il form in `mount()` con `makeForm()` e `getFormSchema()`.
- `authenticate()` usa `Auth::attempt()`, `session()->regenerate()` e `addError()`.
- `render()` restituisce la view `pub_theme::livewire.auth.login` con layout custom.
## Proposta di LoginWidget
```php
namespace Modules\User\Filament\Widgets;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
class LoginWidget extends XotBaseWidget
{
    protected static string $view = 'user::livewire.auth.login';
    public array $data = [
        'email' => '',
        'password' => '',
        'remember' => false,
    ];
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('data.email')
                ->label('Email')
                ->email()
                ->required()
                ->placeholder('Inserisci la tua email'),
            TextInput::make('data.password')
                ->label('Password')
                ->password()
                ->placeholder('Inserisci la tua password'),
            Checkbox::make('data.remember')
                ->label('Ricordami'),
        ];
    }
    public function mount(): void
        $this->form->fill($this->data);
    public function submit(): RedirectResponse
        $state = $this->form->getState()['data'];
        $remember = $state['remember'] ?? false;
        if (Auth::attempt(
            ['email' => $state['email'], 'password' => $state['password']],
            $remember
        )) {
            session()->regenerate();
            return redirect()->intended();
        }
        $this->addError('data.email', __('Le credenziali non sono corrette.'));
}
```
## Motivazioni e Trade-off
- **Riuso**: schema e logica di validazione già definiti in Livewire sono mappati in `getFormSchema`, `mount` e `submit`.
- **Coerenza**: estensione `XotBaseWidget` garantisce uniformità con altri widget Filament.
- **Rate Limiting**: è possibile aggiungere `WithRateLimiting` per throttling.
**Vantaggi**:
- Unico widget integrato con l'admin Filament.
- Logica custom concentrata nel widget, stesse regole di validazione.
**Svantaggi**:
- Ciclo di vita differente: Livewire puro vs Filament Widgets.
- Alcune funzionalità (es. `render()`) non sono necessarie nel widget.
## Collegamenti
- [WIDGETS_STRUCTURE.md](../WIDGETS_STRUCTURE.md) — Regole di struttura per i widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md) — Best practices per risorse e widget Filament.
- [login-improvements.md](../../../Themes/TwentyOne/project_docs/login-improvements.md) — Analisi e miglioramenti della pagina di login nel tema TwentyOne.
- [login-improvements.md](../../../Themes/TwentyOne/docs/login-improvements.md) — Analisi e miglioramenti della pagina di login nel tema TwentyOne.
# Conversione Livewire Auth/Login a Filament LoginWidget

## Analisi del componente Livewire

Il componente `Login` (Livewire) definito in `Modules/User/Http/Livewire/Auth/Login.php.to_widget`:
- Usa `InteractsWithForms` per schema form e validazione.
- Definisce proprietà `$email`, `$password`, `$remember` e regole di validazione.
- Monta il form in `mount()` con `makeForm()` e `getFormSchema()`.
- `authenticate()` usa `Auth::attempt()`, `session()->regenerate()` e `addError()`.
- `render()` restituisce la view `pub_theme::livewire.auth.login` con layout custom.

## Proposta di LoginWidget

```php
namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginWidget extends XotBaseWidget
{
    protected static string $view = 'user::livewire.auth.login';

    public array $data = [
        'email' => '',
        'password' => '',
        'remember' => false,
    ];

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('data.email')
                ->label('Email')
                ->email()
                ->required()
                ->placeholder('Inserisci la tua email'),

            TextInput::make('data.password')
                ->label('Password')
                ->password()
                ->required()
                ->placeholder('Inserisci la tua password'),

            Checkbox::make('data.remember')
                ->label('Ricordami'),
        ];
    }

    public function mount(): void
    {
        $this->form->fill($this->data);
    }

    public function submit(): RedirectResponse
    {
        $state = $this->form->getState()['data'];
        $remember = $state['remember'] ?? false;

        if (Auth::attempt(
            ['email' => $state['email'], 'password' => $state['password']],
            $remember
        )) {
            session()->regenerate();

            return redirect()->intended();
        }

        $this->addError('data.email', __('Le credenziali non sono corrette.'));
    }
}
```

## Motivazioni e Trade-off

- **Riuso**: schema e logica di validazione già definiti in Livewire sono mappati in `getFormSchema`, `mount` e `submit`.
- **Coerenza**: estensione `XotBaseWidget` garantisce uniformità con altri widget Filament.
- **Rate Limiting**: è possibile aggiungere `WithRateLimiting` per throttling.

**Vantaggi**:
- Unico widget integrato con l'admin Filament.
- Logica custom concentrata nel widget, stesse regole di validazione.

**Svantaggi**:
- Ciclo di vita differente: Livewire puro vs Filament Widgets.
- Alcune funzionalità (es. `render()`) non sono necessarie nel widget.

## Collegamenti
- [WIDGETS_STRUCTURE.md](../WIDGETS_STRUCTURE.md) — Regole di struttura per i widget Filament nel modulo User.
- [filament_best_practices.md](filament_best_practices.md) — Best practices per risorse e widget Filament.
- [login-improvements.md](../../../Themes/TwentyOne/docs/login-improvements.md) — Analisi e miglioramenti della pagina di login nel tema TwentyOne.
