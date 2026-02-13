# Eccezioni Regola XotBase - Pagine Autenticazione

## Scopo

Questo documento spiega quando e perché è giustificato estendere direttamente le classi Filament invece di usare XotBase per le pagine di autenticazione.

## Regola Generale

**REGOLA FONDAMENTALE**: MAI estendere classi Filament direttamente. SEMPRE usare classi XotBase.

## Eccezioni Giustificate

### Pagine di Autenticazione Filament Standard

Le seguenti pagine estendono direttamente le classi Filament perché sono pagine di autenticazione standard che non necessitano delle funzionalità aggiuntive di XotBase:

#### 1. Login

```php
namespace Modules\User\Filament\Pages\Auth;

class Login extends \Filament\Auth\Pages\Login
{
    use HasRoutes;
    protected static string $routePath = 'newlogin';
    protected string $view = 'filament-panels::pages.auth.login';
}
```

**Motivazione**:
- Pagina di autenticazione standard Filament
- Non necessita traduzioni automatiche XotBase
- Non necessita funzionalità aggiuntive XotBase
- Route personalizzata tramite `HasRoutes` trait

#### 2. Register

```php
namespace Modules\User\Filament\Pages\Auth;

class Register extends \Filament\Auth\Pages\Register
{
    // Personalizzazioni minime se necessarie
}
```

**Motivazione**:
- Pagina di registrazione standard Filament
- Comportamento standard senza customizzazioni XotBase
- Mantiene compatibilità con sistema autenticazione Filament

#### 3. EditProfile

```php
namespace Modules\User\Filament\Pages\Auth;

class EditProfile extends \Filament\Auth\Pages\EditProfile
{
    public static ?string $title = 'Profilo Utente';
    
    public function getFormSchema(): array
    {
        return [
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            ...PasswordData::make()->getPasswordFormComponents('new_password'),
        ];
    }
}
```

**Motivazione**:
- Pagina di modifica profilo standard Filament Auth
- Estende funzionalità base senza necessità XotBase
- Personalizzazione form tramite `getFormSchema()`

#### 4. PasswordExpired

```php
namespace Modules\User\Filament\Pages\Auth;

class PasswordExpired extends \Filament\Pages\Page implements HasForms
{
    use InteractsWithFormActions;
    use InteractsWithForms;
    use NavigationPageLabelTrait; // Solo trait per traduzioni
    
    protected static bool $shouldRegisterNavigation = false;
    protected string $view = 'user::filament.auth.pages.password-expired';
}
```

**Motivazione**:
- Pagina speciale di autenticazione per password scaduta
- **NON deve apparire nella navigazione** (`shouldRegisterNavigation = false`)
- Usa solo `NavigationPageLabelTrait` per traduzioni (non tutto XotBasePage)
- Logica business specifica per gestione password scaduta
- Non necessita funzionalità aggiuntive XotBase (rilevamento modello, autorizzazioni avanzate, etc.)

## Pattern Comune

Tutte queste pagine condividono:
- Sono pagine di **autenticazione** (non pagine admin standard)
- Non necessitano **navigazione** standard
- Non necessitano **rilevamento modello automatico** XotBase
- Usano **traduzioni** tramite trait specifici quando necessario
- Mantengono **compatibilità** con sistema autenticazione Filament

## Quando Usare XotBasePage

Usare `XotBasePage` per:
- Pagine admin standard
- Pagine che necessitano traduzioni automatiche
- Pagine che necessitano rilevamento modello
- Pagine che necessitano autorizzazioni avanzate
- Pagine che devono apparire nella navigazione

## Quando Estendere Page Direttamente

Estendere `Filament\Pages\Page` direttamente solo per:
- Pagine di autenticazione speciali (come PasswordExpired)
- Pagine che NON devono apparire nella navigazione
- Pagine con logica business molto specifica che non beneficia di XotBase

## Documentazione Correlata

- [Regole XotBase](../../../bashscripts/docs/xotbase_critical_rules.md)
- [XotBasePage Implementation](../../../Xot/docs/xotbasepage_implementation.md)
- [Filament Namespace Rules](./filament-namespace-rules.md)

---

**Ultimo aggiornamento**: 2025-12-17
