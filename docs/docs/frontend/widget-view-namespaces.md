# Regole per i Namespace delle View nei Widget

## Distinzione Critica: Widget Auth vs Widget Normali

### 🔑 **Regola Fondamentale**

- **Widget di Autenticazione** (login, registrazione, password reset): DEVONO usare `pub_theme::`
- **Widget Normali/Funzionali**: possono usare il namespace del modulo (`user::`, `<nome progetto>::`, etc.)

### 🎯 **Motivazione**

I widget di autenticazione sono parte dell'**interfaccia utente del tema** e devono essere **personalizzabili visivamente** per ogni tema diverso, mantenendo la logica centralizzata nel modulo.

## Widget di Autenticazione (pub_theme::)

### Esempi di Widget Auth
- `LoginWidget`
- `RegistrationWidget`
- `PasswordResetWidget` → `pub_theme::filament.widgets.auth.password.reset`
- `PasswordResetConfirmWidget` → `pub_theme::filament.widgets.auth.password.reset-confirm`
- `ForgotPasswordWidget`
- `VerifyEmailWidget`

### Pattern Corretto
```php
namespace Modules\User\Filament\Widgets\Auth;

class PasswordResetWidget extends XotBaseWidget
{
    // ✅ CORRETTO: View nel tema con struttura gerarchica
    protected static string $view = 'pub_theme::filament.widgets.auth.password.reset';

    // Logica del widget rimane nel modulo
    public function getFormSchema(): array
    {
        // Logica centralizzata qui
    }
}

class PasswordResetConfirmWidget extends XotBaseWidget
{
    // ✅ CORRETTO: View nel tema con struttura gerarchica
    protected static string $view = 'pub_theme::filament.widgets.auth.password.reset-confirm';

    // Logica del widget rimane nel modulo
    public function confirmPasswordReset(): void
    {
        // Logica centralizzata qui
    }
}
```

### Struttura File del Tema
```
laravel/Themes/One/resources/views/filament/widgets/auth/
├── login.blade.php                    # LoginWidget view
├── registration.blade.php             # RegistrationWidget view
├── password/
│   ├── reset.blade.php               # PasswordResetWidget view
│   └── reset-confirm.blade.php       # PasswordResetConfirmWidget view
├── forgot-password.blade.php          # ForgotPasswordWidget view
└── verify-email.blade.php             # VerifyEmailWidget view
```

### Pattern della View nel Tema
```blade
{{-- pub_theme::filament.widgets.auth.password.reset --}}
<x-filament-widgets::widget>
    <div class="max-w-4xl mx-auto">
        {{-- Contenuto personalizzabile per il tema --}}
        <div class="space-y-6">
            {{ $this->form }}
        </div>
    </div>
</x-filament-widgets::widget>
```

## Widget Funzionali (namespace modulo)

### Esempi di Widget Funzionali
- `DoctorAppointmentsWidget`
- `PatientStatsWidget`
- `StudioFilterWidget`
- `RecentLoginsWidget`

### Pattern Corretto
```php
namespace Modules\<nome progetto>\Filament\Widgets;

class DoctorAppointmentsWidget extends XotBaseWidget
{
    // ✅ CORRETTO: View nel modulo per logica funzionale
    protected static string $view = '<nome progetto>::filament.widgets.doctor-appointments';

    // Logica specifica del modulo
}
```

## Checklist di Implementazione

### ✅ Widget di Autenticazione
- [ ] Widget PHP nel modulo: `Modules\User\Filament\Widgets\Auth\*`
- [ ] View nel tema: `pub_theme::filament.widgets.auth.*`
- [ ] File fisico: `laravel/Themes/One/resources/views/filament/widgets/auth/*.blade.php`
- [ ] Logica centralizzata nel widget PHP
- [ ] View minimalista per styling del tema
- [ ] Traduzioni sia in `user::` che in `pub_theme::`

### ✅ Widget Funzionali
- [ ] Widget PHP nel modulo: `Modules\ModuleName\Filament\Widgets\*`
- [ ] View nel modulo: `modulename::filament.widgets.*`
- [ ] File fisico: `laravel/Modules/ModuleName/resources/views/filament/widgets/*.blade.php`
- [ ] Logica specifica del modulo
- [ ] Traduzioni del modulo: `modulename::`

## Errori Comuni da Evitare

### ❌ Widget Auth con namespace modulo
```php
// SBAGLIATO per widget di autenticazione
protected static string $view = 'user::filament.widgets.auth.password.reset';
```

### ❌ Widget Funzionale con namespace tema
```php
// SBAGLIATO per widget funzionali
protected static string $view = 'pub_theme::filament.widgets.doctor-appointments';
```

### ❌ Logica duplicata nella view del tema
```blade
{{-- SBAGLIATO: logica nella view del tema --}}
<x-filament-widgets::widget>
    @if($this->emailSent)
        {{-- Logica complessa qui = ERRORE --}}
    @endif
</x-filament-widgets::widget>
```

## Vantaggi di Questa Architettura

### 🎨 **Temi Personalizzabili**
- Ogni tema può avere il suo stile per l'autenticazione
- Layout e colori personalizzabili per brand diversi
- Mantiene coerenza con il design del tema

### 🔧 **Logica Centralizzata**
- Business logic rimane nel modulo User
- Manutenzione semplificata
- Nessuna duplicazione di codice

### 🔒 **Sicurezza Coerente**
- Validazioni e controlli di sicurezza centralizzati
- Policy e autorizzazioni uniformi
- Nessun rischio di dimenticare controlli in temi diversi

## Collegamenti
- [Struttura Temi](../tecnico/themes/theme-structure.md)
- [Widget Autenticazione](../../laravel/modules/user/docs/auth-widgets.md)
- [Implementazione Temi](../frontend/theme-implementation.md)

