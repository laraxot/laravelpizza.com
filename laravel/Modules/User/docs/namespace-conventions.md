# Convenzioni di Namespace nel Modulo User

## Principi Fondamentali
### Regola d'Oro: Separazione Modulo vs Tema
**I widget e componenti del modulo User DEVONO sempre usare il namespace `user::`**
```php
// ✅ CORRETTO - Widget del modulo User
class PasswordResetWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.auth.password.reset';
}
// ❌ ERRATO - Widget del modulo User che usa namespace tema
    protected static string $view = 'pub_theme::filament.widgets.auth.password.reset';
```
## Mappatura Namespace → Directory
### Modulo User (`user::`)
user::filament.widgets.auth.password.reset
↓
/Modules/User/resources/views/filament/widgets/auth/password/reset.blade.php
### Tema One (`pub_theme::`)
pub_theme::filament.widgets.auth.password.reset
/Themes/One/resources/views/filament/widgets/auth/password/reset.blade.php
## Quando Usare Cosa
### `user::` - Sempre per il Modulo User
- **Widget Filament del modulo User**
- **Pagine specifiche del modulo User**
- **Componenti del modulo User**
- **Layout specifici dell'autenticazione**
### `pub_theme::` - Solo per Override del Tema
- **Override di view del modulo nel tema**
- **Personalizzazioni specifiche del progetto**
- **Layout globali del sito**
## Esempi Pratici
### Widget di Autenticazione
// Modulo User - sempre user::
namespace Modules\User\Filament\Widgets\Auth;
class LoginWidget extends XotBaseWidget
    protected static string $view = 'user::filament.widgets.auth.login';
class PasswordResetWidget extends XotBaseWidget
class RegisterWidget extends XotBaseWidget
    protected static string $view = 'user::filament.widgets.auth.register';
### Override nel Tema (se necessario)
Se si vuole personalizzare l'aspetto di un widget User nel tema:
1. **Creare la view override nel tema**:
   ```
   /Themes/One/resources/views/filament/widgets/auth/password/reset.blade.php
2. **Il widget rimane nel modulo con namespace user::**:
   ```php
   // Widget rimane nel modulo User
   protected static string $view = 'user::filament.widgets.auth.password.reset';
3. **Laravel risolve automaticamente l'override** se configurato correttamente
## Struttura Directory Corretta
### Modulo User
Modules/User/
├── app/
│   └── Filament/
│       └── Widgets/
│           └── Auth/
│               ├── LoginWidget.php          # view: user::filament.widgets.auth.login
│               ├── PasswordResetWidget.php  # view: user::filament.widgets.auth.password.reset
│               └── RegisterWidget.php       # view: user::filament.widgets.auth.register
└── resources/
    └── views/
        └── filament/
            └── widgets/
                └── auth/
                    ├── login.blade.php
                    ├── register.blade.php
                    └── password/
                        └── reset.blade.php
### Tema One (Override opzionali)
Themes/One/
                    ├── login.blade.php      # Override di user::filament.widgets.auth.login
                        └── reset.blade.php  # Override di user::filament.widgets.auth.password.reset
## Errori Comuni da Evitare
### ❌ Errore 1: Confondere Namespace
// SBAGLIATO - Widget del modulo User che usa pub_theme::
class UserWidget extends XotBaseWidget
    protected static string $view = 'pub_theme::filament.widgets.user.profile';
    //                               ^^^^^^^^^^
    //                               Dovrebbe essere user::
### ❌ Errore 2: Struttura Directory Piatta
// SBAGLIATO - Non segue struttura Laravel
protected static string $view = 'user::filament.widgets.auth.password-reset';
//                                                                ^^^^^^^^^^^^
//                                                                Dovrebbe essere password.reset
### ❌ Errore 3: Widget nel Posto Sbagliato
// SBAGLIATO - Widget del modulo User nel namespace del tema
namespace Modules\User\Filament\Widgets;
class SomeWidget extends XotBaseWidget
    protected static string $view = 'pub_theme::some.view';
    //                               ^^^^^^^^^^^
    //                               Modulo User deve usare user::
## Checklist Pre-Implementazione
Prima di creare/modificare un widget nel modulo User:
- [ ] Il widget è nel namespace `Modules\User\Filament\Widgets\`?
- [ ] Il view path usa il namespace `user::`?
- [ ] La struttura directory segue le convenzioni Laravel? (`password/reset`, non `password-reset`)
- [ ] La view esiste nella posizione corretta nel modulo User?
- [ ] Non sto confondendo namespace modulo (`user::`) con namespace tema (`pub_theme::`)?
## Troubleshooting
### View Not Found
Se ricevi errore "View not found":
1. **Verifica il namespace**: Deve essere `user::` per modulo User
2. **Verifica il path**: Deve seguire struttura gerarchica (`auth/password/reset`)
3. **Verifica che la view esista** in `Modules/User/resources/views/`
### Override Non Funziona
Se l'override del tema non funziona:
1. **Mantieni il namespace `user::`** nel widget
2. **Crea la view override** in `Themes/One/resources/views/`
3. **Configura correttamente** il sistema di override del tema
## Collegamenti
- [Documentazione Laravel View](https://laravel.com/project_docs/views)
- [Regole Struttura Directory Auth](../../../.windsurf/rules/translations.md#regola-critica-struttura-directory-auth-laravel)
- [Documentazione Tema One](../../../Themes/One/project_docs/README.md)
- [Documentazione Laravel View](https://laravel.com/docs/views)
- [Documentazione Tema One](../../../Themes/One/docs/README.md)
---
*Documento creato: Dicembre 2024*
*Ultimo aggiornamento: Dicembre 2024*
# Convenzioni di Namespace nel Modulo User

## Principi Fondamentali

### Regola d'Oro: Separazione Modulo vs Tema

**I widget e componenti del modulo User DEVONO sempre usare il namespace `user::`**

```php
// ✅ CORRETTO - Widget del modulo User
class PasswordResetWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.auth.password.reset';
}

// ❌ ERRATO - Widget del modulo User che usa namespace tema
class PasswordResetWidget extends XotBaseWidget
{
    protected static string $view = 'pub_theme::filament.widgets.auth.password.reset';
}
```

## Mappatura Namespace → Directory

### Modulo User (`user::`)
```
user::filament.widgets.auth.password.reset
↓
/Modules/User/resources/views/filament/widgets/auth/password/reset.blade.php
```

### Tema One (`pub_theme::`)
```
pub_theme::filament.widgets.auth.password.reset
↓
/Themes/One/resources/views/filament/widgets/auth/password/reset.blade.php
```

## Quando Usare Cosa

### `user::` - Sempre per il Modulo User
- **Widget Filament del modulo User**
- **Pagine specifiche del modulo User**
- **Componenti del modulo User**
- **Layout specifici dell'autenticazione**

### `pub_theme::` - Solo per Override del Tema
- **Override di view del modulo nel tema**
- **Personalizzazioni specifiche del progetto**
- **Layout globali del sito**

## Esempi Pratici

### Widget di Autenticazione

```php
// Modulo User - sempre user::
namespace Modules\User\Filament\Widgets\Auth;

class LoginWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.auth.login';
}

class PasswordResetWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.auth.password.reset';
}

class RegisterWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.auth.register';
}
```

### Override nel Tema (se necessario)

Se si vuole personalizzare l'aspetto di un widget User nel tema:

1. **Creare la view override nel tema**:
   ```
   /Themes/One/resources/views/filament/widgets/auth/password/reset.blade.php
   ```

2. **Il widget rimane nel modulo con namespace user::**:
   ```php
   // Widget rimane nel modulo User
   protected static string $view = 'user::filament.widgets.auth.password.reset';
   ```

3. **Laravel risolve automaticamente l'override** se configurato correttamente

## Struttura Directory Corretta

### Modulo User
```
Modules/User/
├── app/
│   └── Filament/
│       └── Widgets/
│           └── Auth/
│               ├── LoginWidget.php          # view: user::filament.widgets.auth.login
│               ├── PasswordResetWidget.php  # view: user::filament.widgets.auth.password.reset
│               └── RegisterWidget.php       # view: user::filament.widgets.auth.register
└── resources/
    └── views/
        └── filament/
            └── widgets/
                └── auth/
                    ├── login.blade.php
                    ├── register.blade.php
                    └── password/
                        └── reset.blade.php
```

### Tema One (Override opzionali)
```
Themes/One/
└── resources/
    └── views/
        └── filament/
            └── widgets/
                └── auth/
                    ├── login.blade.php      # Override di user::filament.widgets.auth.login
                    └── password/
                        └── reset.blade.php  # Override di user::filament.widgets.auth.password.reset
```

## Errori Comuni da Evitare

### ❌ Errore 1: Confondere Namespace
```php
// SBAGLIATO - Widget del modulo User che usa pub_theme::
class UserWidget extends XotBaseWidget
{
    protected static string $view = 'pub_theme::filament.widgets.user.profile';
    //                               ^^^^^^^^^^
    //                               Dovrebbe essere user::
}
```

### ❌ Errore 2: Struttura Directory Piatta
```php
// SBAGLIATO - Non segue struttura Laravel
protected static string $view = 'user::filament.widgets.auth.password-reset';
//                                                                ^^^^^^^^^^^^
//                                                                Dovrebbe essere password.reset
```

### ❌ Errore 3: Widget nel Posto Sbagliato
```php
// SBAGLIATO - Widget del modulo User nel namespace del tema
namespace Modules\User\Filament\Widgets;
class SomeWidget extends XotBaseWidget
{
    protected static string $view = 'pub_theme::some.view';
    //                               ^^^^^^^^^^^
    //                               Modulo User deve usare user::
}
```

## Checklist Pre-Implementazione

Prima di creare/modificare un widget nel modulo User:

- [ ] Il widget è nel namespace `Modules\User\Filament\Widgets\`?
- [ ] Il view path usa il namespace `user::`?
- [ ] La struttura directory segue le convenzioni Laravel? (`password/reset`, non `password-reset`)
- [ ] La view esiste nella posizione corretta nel modulo User?
- [ ] Non sto confondendo namespace modulo (`user::`) con namespace tema (`pub_theme::`)?

## Troubleshooting

### View Not Found
Se ricevi errore "View not found":

1. **Verifica il namespace**: Deve essere `user::` per modulo User
2. **Verifica il path**: Deve seguire struttura gerarchica (`auth/password/reset`)
3. **Verifica che la view esista** in `Modules/User/resources/views/`

### Override Non Funziona
Se l'override del tema non funziona:

1. **Mantieni il namespace `user::`** nel widget
2. **Crea la view override** in `Themes/One/resources/views/`
3. **Configura correttamente** il sistema di override del tema

## Collegamenti

- [Documentazione Laravel View](https://laravel.com/docs/views)
- [Regole Struttura Directory Auth](../../../.windsurf/rules/translations.md#regola-critica-struttura-directory-auth-laravel)
- [Documentazione Tema One](../../../Themes/One/docs/README.md)

---

*Documento creato: Dicembre 2024*
*Ultimo aggiornamento: Dicembre 2024*
