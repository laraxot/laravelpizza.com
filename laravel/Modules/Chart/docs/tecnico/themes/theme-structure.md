# Struttura dei Temi e Gestione delle Viste

## Namespace `pub_theme::`

Il namespace `pub_theme::` è un alias che punta al tema attualmente attivo nel sistema. Per esempio, se il tema attivo è "One", il namespace `pub_theme::` punterà a `/laravel/Themes/One/resources/views/`.

### Struttura Directory del Tema

```
laravel/Themes/One/
├── resources/
│   └── views/
│       ├── auth/           # Viste per l'autenticazione
│       ├── components/     # Componenti riutilizzabili
│       ├── filament/       # Viste specifiche per Filament
│       │   ├── layouts/    # Layout Filament
│       │   ├── pages/      # Pagine Filament
│       │   ├── widgets/    # Widget Filament
│       │   └── wizard/     # Componenti Wizard
│       ├── layouts/        # Layout generali
│       ├── livewire/       # Componenti Livewire
│       └── pages/          # Pagine generali
```

### Esempi di Utilizzo

```php
// Nel codice
view('pub_theme::filament.wizard.submit-button')

// Corrisponde al file fisico
/laravel/Themes/One/resources/views/filament/wizard/submit-button.blade.php
```

## Best Practices

1. **Organizzazione delle Viste**
   - Mantenere una struttura coerente tra i temi
   - Utilizzare sottodirectory per organizzare le viste per funzionalità
   - Seguire le convenzioni di naming di Laravel

2. **Traduzioni**
   - Utilizzare il namespace del tema per le traduzioni
   - Esempio: `{{ __('pub_theme::auth.login.title') }}`
   - Le traduzioni sono in `/laravel/Themes/One/lang/`
   - **Traduzioni Autenticazione**: Sistema completo implementato per login, registrazione, reset password
   - [Documentazione Completa Traduzioni Auth](../../laravel/Themes/One/docs/auth-translations.md)

3. **Componenti Filament**
   - I componenti specifici di Filament dovrebbero essere nella directory `filament/`
   - Utilizzare sottodirectory per organizzare i componenti (wizard, widgets, etc.)
   - Mantenere la coerenza con la struttura di Filament

4. **Gestione dei Temi**
   - Ogni tema dovrebbe essere un modulo Laravel completo
   - Mantenere le dipendenze specifiche del tema nel suo `composer.json`
   - Utilizzare il service provider del tema per registrare viste e asset

## Configurazione del Tema

Il tema attivo è configurato nel file `config/themes.php`:

```php
return [
    'active' => 'One',
    'path' => base_path('Themes'),
];
```

## Service Provider del Tema

Ogni tema dovrebbe avere il proprio service provider che registra:

```php
public function boot()
{
    // Registra le viste
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'pub_theme');
    
    // Registra le traduzioni
    $this->loadTranslationsFrom(__DIR__.'/../lang', 'pub_theme');
    
    // Registra gli asset
    $this->publishes([
        __DIR__.'/../public' => public_path('themes/one'),
    ], 'theme-assets');
}
```

## Convenzioni di Naming

1. **Viste**
   - Utilizzare kebab-case per i nomi dei file
   - Esempio: `submit-button.blade.php`

2. **Componenti**
   - Utilizzare PascalCase per i nomi delle classi
   - Esempio: `SubmitButton.php`

3. **Traduzioni**
   - Utilizzare dot notation per le chiavi
   - Esempio: `wizard.submit.label`

## Debugging

Per verificare il percorso corretto di una vista:

```php
// Nel codice
dd(view()->getFinder()->find('pub_theme::filament.wizard.submit-button'));

// Nel terminale
php artisan view:clear
php artisan cache:clear
```

## REGOLA CRITICA: Separazione Namespace Modulo vs Tema

⚠️ **ASSOLUTA SEPARAZIONE** tra namespace di moduli e temi:

### Principio Fondamentale
- **`pub_theme::`** è ESCLUSIVAMENTE per il tema One
- **Moduli** usano il proprio namespace (`user::`, `cms::`, `<nome progetto>::`)
- **MAI** mescolare namespace tra modulo e tema

### Esempi Corretti vs Errati

#### ✅ CORRETTO - Widget Auth usano pub_theme::
```php
// File: Modules/User/app/Filament/Widgets/Auth/PasswordResetWidget.php
namespace Modules\User\Filament\Widgets\Auth;

class PasswordResetWidget extends XotBaseWidget
{
    protected static string $view = 'pub_theme::filament.widgets.auth.password.reset';
    //                               ^^^^^^^^^^^
    //                               Widget AUTH usa namespace TEMA
}
```

#### ✅ CORRETTO - Widget Funzionali usano namespace modulo
```php
// File: Modules/User/app/Filament/Widgets/UserStatsWidget.php  
namespace Modules\User\Filament\Widgets;

class UserStatsWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.user.stats';
    //                               ^^^^^^
    //                               Widget FUNZIONALE usa namespace MODULO
}
```

### Mappatura Namespace
| Contesto | Namespace | Utilizzo |
|----------|-----------|----------|
| **Tema One** | `pub_theme::` | Layout globali, override, personalizzazioni tema |
| **Modulo User** | `user::` | Widget, pagine, componenti del modulo User |
| **Modulo Cms** | `cms::` | Widget, pagine, componenti del modulo Cms |
| **Modulo <nome progetto>** | `<nome progetto>::` | Widget, pagine, componenti del modulo <nome progetto> |

### Override del Tema (Pattern Corretto)
Il tema può sovrascrivere le view dei moduli mantenendo l'indipendenza:

1. **Widget rimane nel modulo** con namespace modulo:
   ```php
   // Modules/User/.../PasswordResetWidget.php
   protected static string $view = 'user::filament.widgets.auth.password.reset';
   ```

2. **Tema crea override opzionale**:
   ```
   /Themes/One/resources/views/filament/widgets/auth/password/reset.blade.php
   ```

3. **Laravel risolve automaticamente l'override** se configurato

### Motivazioni Architetturali
1. **Indipendenza Moduli**: Funzionano senza dipendenze dal tema
2. **Manutenibilità**: Cambio tema non rompe moduli
3. **Testabilità**: Moduli testabili senza tema specifico
4. **Deployment**: Moduli disaccoppiabili dal tema
5. **Scalabilità**: Facile aggiungere nuovi temi senza toccare moduli

## Note Importanti

1. Il namespace `pub_theme::` è un alias che punta al tema attivo
2. Le viste nel tema hanno la precedenza sulle viste del modulo
3. Le traduzioni nel tema hanno la precedenza sulle traduzioni del modulo
4. I componenti Filament nel tema possono estendere quelli di base
5. **CRITICO**: I widget dei moduli NON devono mai usare `pub_theme::` 