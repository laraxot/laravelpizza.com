# Widget di Autenticazione: Namespace delle View

## ⚠️ **Regola Critica**

I widget di autenticazione **DEVONO** usare il namespace `pub_theme::` per le loro view, NON il namespace del modulo `user::`.

## Motivazione

I widget di autenticazione sono parte dell'**interfaccia utente del tema** e devono essere personalizzabili per ogni tema, mantenendo la logica centralizzata nel modulo User.

## Pattern Corretto vs Errato

### ✅ **CORRETTO**
```php
namespace Modules\User\Filament\Widgets\Auth;

class PasswordResetWidget extends XotBaseWidget
{
    // View nel tema - personalizzabile con struttura gerarchica
    protected static string $view = 'pub_theme::filament.widgets.auth.password.reset';

    // Logica centralizzata nel modulo User
    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('email')
                ->label(__('user::auth.password_reset.email_placeholder'))
                ->email()
                ->required(),
        ];
    }
}
```

### ❌ **ERRATO**
```php
namespace Modules\User\Filament\Widgets\Auth;

class PasswordResetWidget extends XotBaseWidget
{
    // SBAGLIATO: view nel modulo invece che nel tema
    protected static string $view = 'user::filament.widgets.auth.password.reset';
}
```

## Widget di Autenticazione da Aggiornare

### Widget Esistenti da Verificare
- [ ] `LoginWidget` - verificare se usa `pub_theme::`
- [ ] `RegistrationWidget` - verificare se usa `pub_theme::`
- [x] `PasswordResetWidget` - **CORRETTO** usa `pub_theme::`

### Struttura Target nel Tema
```
laravel/Themes/One/resources/views/filament/widgets/auth/
├── login.blade.php                    # per LoginWidget
├── registration.blade.php             # per RegistrationWidget
├── password/
│   ├── reset.blade.php               # per PasswordResetWidget
│   └── reset-confirm.blade.php       # per PasswordResetConfirmWidget
├── forgot-password.blade.php          # per ForgotPasswordWidget
└── verify-email.blade.php             # per VerifyEmailWidget
```

## Pattern delle View nel Tema

Le view nel tema devono essere **minimaliste** e focalizzate solo sul layout/styling:

```blade
{{-- laravel/Themes/One/resources/views/filament/widgets/auth/password/reset.blade.php --}}
<x-filament-widgets::widget>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            {{-- Styling specifico del tema --}}
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-[#272C4D]">
                    {{ __('pub_theme::auth.password.reset.title') }}
                </h2>
                <p class="text-gray-600 mt-2">
                    {{ __('pub_theme::auth.password.reset.subtitle') }}
                </p>
            </div>

            {{-- Form renderizzato dal widget --}}
            <div class="space-y-6">
                {{ $this->form }}
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
```

## Vantaggi di Questa Architettura

### 🎨 **Personalizzazione Temi**
- Ogni tema può avere il suo stile per l'autenticazione
- Colori, layout e tipografia personalizzabili
- Mantenimento coerenza con il design del tema

### 🔧 **Manutenzione Centralizzata**
- Logica di business nel modulo User
- Validazioni e security centralizzate
- Un solo punto di verità per la logica

### 🔄 **Flessibilità**
- Facile switch tra temi diversi
- Personalizzazione per brand specifici
- Riutilizzo della logica tra temi

## Traduzioni Dual-Level

I widget di autenticazione usano traduzioni sia dal modulo che dal tema:

### Logica/Validazioni (Modulo User)
```php
Forms\Components\TextInput::make('email')
    ->label(__('user::auth.password_reset.email_placeholder'))
    ->validationMessages([
        'required' => __('user::auth.email.required'),
        'email' => __('user::auth.email.invalid'),
    ]);
```

### UI/Layout (Tema)
```blade
<h2>{{ __('pub_theme::auth.password.reset.title') }}</h2>
<p>{{ __('pub_theme::auth.password.reset.subtitle') }}</p>
```

## Checklist Implementazione

Per ogni nuovo widget di autenticazione:

- [ ] Widget PHP in: `Modules\User\Filament\Widgets\Auth\*Widget.php`
- [ ] Namespace view: `pub_theme::filament.widgets.auth.*`
- [ ] File view: `laravel/Themes/One/resources/views/filament/widgets/auth/*.blade.php`
- [ ] Traduzioni modulo: `user::auth.*` (logica/validazioni)
- [ ] Traduzioni tema: `pub_theme::auth.*` (UI/layout)
- [ ] View minimalista (solo styling)
- [ ] Logica centralizzata nel widget PHP

## Collegamenti
- [Documentazione Root: Widget View Namespaces](../../../docs/frontend/widget-view-namespaces.md)
- [Struttura Temi](../../../docs/tecnico/themes/theme-structure.md)
- [Implementazione Auth Pages](auth-pages-implementation.md)

*Ultimo aggiornamento: Dicembre 2024*
