https://ajaxray.com/blog/lets-beautify-filament-3-login-page/

https://www.codef.site/blog/laravel/how-to-customize-laravel-filament-login-page

https://v2.filamentphp.com/tricks/customizing-filament-breezy-registration-profile-page

### Versione HEAD

# Implementazione Login Personalizzato

> **Collegamenti Correlati:**
> - [Passport Integration](passport.md) - Integrazione OAuth2 con Passport
> - [Socialite Integration](socialite.txt) - Integrazione con provider social
> - [Two Factor Authentication](two_factor.txt) - Autenticazione a due fattori
> - [Filament Best Practices](FILAMENT_BEST_PRACTICES.md) - Best practices Filament
> - [User Profile Models](user_profile_models.md) - Modelli del profilo utente

## Implementazione con Filament

```php
// In Modules/User/app/Filament/Widgets/Auth/LoginWidget.php
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Form;

class LoginWidget extends XotBaseWidget
{
    protected static string $view = 'filament.widgets.auth.login-form';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->autocomplete(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Checkbox::make('remember')
                    ->label('Remember me'),
            ])
            ->statePath('data');
    }

    public function login(): void
    {
        $data = $this->form->getState();

        if (Auth::attempt($data)) {
            $this->redirect('/dashboard');
        }

        $this->addError('email', 'Invalid credentials');
    }
}
```

## Best Practices

1. Utilizzare XotBaseWidget per l'estensione
2. Implementare validazione robusta
3. Gestire errori in modo user-friendly
4. Implementare rate limiting
5. Logging delle attività di login

## Collegamenti Utili

- [Documentazione Filament](https://filamentphp.com/docs)
- [Best Practices Filament](FILAMENT_BEST_PRACTICES.md)
- [User Profile Models](user_profile_models.md)

### Versione Incoming

---
