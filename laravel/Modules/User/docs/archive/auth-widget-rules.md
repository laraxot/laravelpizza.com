# Regole per Widget di Autenticazione

## ERRORE CRITICO DA NON RIPETERE MAI

**NON usare mai componenti Blade senza verificarne l'esistenza nella documentazione ufficiale!**

### Componenti Filament NON Disponibili

❌ **NON USARE MAI**:
- `x-filament::layouts.card`
- `x-filament::section`
- `x-filament::input.wrapper`
- `x-filament::input`
- `x-filament::button`
- `x-filament::link`

### Componenti Disponibili nel Progetto

✅ **USA QUESTI**:
- `x-layouts.main`, `x-layouts.guest`, `x-layouts.app`
- `x-ui.button`, `x-ui.input`, `x-ui.checkbox`, `x-ui.link`
- `x-button`, `x-input`, `x-checkbox`, `x-input-label`

**SEMPRE verificare l'esistenza dei componenti prima dell'uso!**

## REGOLA CRITICA - PRIORITÀ ASSOLUTA

**Per i form di autenticazione utilizzare SEMPRE widget Filament, NON Volt!**

### Esempi Corretti

```blade
{{-- Login --}}
@livewire(Modules\User\Filament\Widgets\Auth\LoginWidget::class)

{{-- Register --}}
@livewire(Modules\User\Filament\Widgets\Auth\RegisterWidget::class)

{{-- Password Reset --}}
@livewire(Modules\User\Filament\Widgets\Auth\PasswordResetWidget::class)
```

### Esempi ERRATI

```blade
{{-- NON usare Volt per form di autenticazione --}}
@volt('auth.login')
@volt('auth.register')
@volt('auth.password-reset')
```

## Motivazioni

### Perché Widget Filament

1. **Controllo Avanzato**: Maggiore controllo su validazione e comportamento
2. **Integrazione**: Perfetta integrazione con l'ecosistema Filament
3. **Estendibilità**: Facilmente estendibili per funzionalità avanzate:
   - Autenticazione a due fattori (2FA)
   - Captcha
   - Login social (Google, Facebook, etc.)
   - Rate limiting
4. **Sicurezza**: Gestione errori e sicurezza integrate
5. **Manutenibilità**: Codice più organizzato e manutenibile

### Quando Usare Volt

Volt deve essere usato SOLO per:
- Pagine semplici senza form complessi
- Logica di presentazione
- Componenti di navigazione
- Pagine statiche con logica minima

## Struttura Widget di Autenticazione

### Directory Structure

```
Modules/User/app/Filament/Widgets/Auth/
├── BaseAuthWidget.php          # Widget base per autenticazione
├── LoginWidget.php             # Widget di login
├── RegisterWidget.php          # Widget di registrazione
├── PasswordResetWidget.php     # Widget reset password
├── ForgotPasswordWidget.php    # Widget password dimenticata
└── LogoutWidget.php            # Widget di logout
```

### Implementazione Base

```php
<?php

namespace Modules\User\Filament\Widgets\Auth;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LoginWidget extends XotBaseWidget
{
    protected static string $view = 'pub_theme::filament.widgets.auth.login';
    
    public ?array $data = [];
    
    public function getFormSchema(): array
    {
        return [
            // Definizione form Filament
        ];
    }
    
    public function authenticate(): void
    {
        // Logica di autenticazione
    }
}
```

## Best Practices

1. **Estendere sempre XotBaseWidget**: Tutti i widget di auth devono estendere `XotBaseWidget`
2. **View Template**: Usare view template nel tema corrente (`pub_theme::`)
3. **Validazione**: Utilizzare la validazione integrata di Filament
4. **Sicurezza**: Implementare rate limiting e protezione CSRF
5. **Localizzazione**: Supportare traduzioni per tutti i testi
6. **Accessibilità**: Seguire le linee guida di accessibilità

## Regole di Naming

- Widget: `{Action}Widget.php` (es. `LoginWidget.php`)
- View: `filament.widgets.auth.{action}` (es. `filament.widgets.auth.login`)
- Metodi: `{action}()` (es. `authenticate()`, `register()`)

## Testing

Ogni widget deve avere test corrispondenti:

```
tests/Feature/Filament/Widgets/
├── LoginWidgetTest.php
├── RegisterWidgetTest.php
└── PasswordResetWidgetTest.php
```

## Collegamenti

- [Widget Structure](widgets_structure.md)
- [Filament Best Practices](filament_best_practices.md)
- [Authentication Architecture](authentication.md)
- [Security Guidelines](security_guidelines.md)
