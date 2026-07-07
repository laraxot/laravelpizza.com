---
title: "R8 religion applied — Gdpr RegisterWidget wins (Gdpr module)"
type: religion
tags: [gdpr, register, religion-r8, garante-privacy, code, opencode-minimax-m3]
created: 2026-06-05
updated: 2026-06-05
qmd: "r8 religion gdpr register widget wins garante privacy code opencode minimax"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/264"
  - "https://github.com/laraxot/base_fixcity_fila5/issues/248"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/265"
related:
  - ../../../docs/architecture-ai-assisted-coding-2026-06-05.md
  - ../../../docs/chat/register-flow-religions-r1-r6.md
  - ../../User/docs/r1-form-fields-self-validate.md
  - ../../Themes/Sixteen/docs/r2-ux-register-form-stacked-password.md
  - ../../../docs/wiki/memories/form-fields-self-validate-religion.md
---

# R8 religion applied — Gdpr RegisterWidget wins (Gdpr module)

> Modulo: `Gdpr` · Autore: opencode (MiniMax-M3) · Issue tracking: base #264

## La regola (R8)

**Per produzione italiana, usare `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget` (con `privacy_accepted`/`terms_accepted`/`marketing_consent`).**

User `RegisterWidget` resta come fallback dev (senza Gdpr attivo, es. CI/test).

## Perché (Tip 019 — why-not-what)

**Garante della Privacy italiano (Reg. UE 2016/679 GDPR, D.Lgs 196/2003 modificato da D.Lgs 101/2018)** richiede per qualunque raccolta dati personali:

1. **Consenso esplicito, libero, informato, specifico** (art. 7 GDPR)
2. **Consenso separato per finalità distinte** (marketing ≠ servizio) — art. 7 §2
3. **Prova del consenso** (accountability) — art. 5 §2
4. **Revocabilità semplice** — art. 7 §3
5. **Privacy policy link** — art. 13
6. **Termini di servizio** — condizione contrattuale

User `RegisterWidget` NON ha nessuno di questi campi → **non conforme in produzione**.

## Implementazione

### `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget`

```php
namespace Modules\Gdpr\Filament\Widgets\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Livewire\Attributes\Validate;
use Modules\Gdpr\Actions\CollectGdprConsentsAction;
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Gdpr\Actions\ValidateGdprConsentAction;
use Modules\Gdpr\Filament\Widgets\Auth\Schemas\RegisterForm as GdprRegisterForm;

class RegisterWidget extends \Modules\Xot\Filament\Widgets\XotBaseSchemaWidget
{
    protected static string $baseSchemaClass = GdprRegisterForm::class;

    #[Validate('required|string|min:2|max:50')]
    public string $first_name = '';

    #[Validate('required|string|min:2|max:50')]
    public string $last_name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|min:8')]
    public string $password = '';

    public string $password_confirmation = '';

    public bool $privacy_accepted = false;
    public bool $terms_accepted = false;
    public bool $marketing_consent = false;

    public function register(): void
    {
        $this->validate();
        app(ValidateGdprConsentAction::class)->execute([
            'privacy_accepted' => $this->privacy_accepted,
            'terms_accepted' => $this->terms_accepted,
            'marketing_consent' => $this->marketing_consent,
        ]);

        $data = $this->form->getState();
        $userClass = config('fixcity.user_model', \Modules\User\Models\User::class);
        $user = $userClass::create($data + [
            'name' => trim($data['first_name'].' '.$data['last_name']),
            'email_verified_at' => null,
        ]);

        app(SaveGdprConsentsAction::class)->execute($user, [
            'privacy' => $this->privacy_accepted,
            'terms' => $this->terms_accepted,
            'marketing' => $this->marketing_consent,
        ]);

        \Auth::login($user, true);
        session()->regenerate();
        redirect()->intended($this->getRedirectUrl());
    }
}
```

### `Modules\Gdpr\Filament\Widgets\Auth\Schemas/RegisterForm.php`

```php
public static function getRegisterFormSchema(Schema $schema, ?Model $record = null): Schema
{
    return $schema->components([
        TextInput::make('first_name')->required()->maxLength(50)->autocomplete('given-name'),
        TextInput::make('last_name')->required()->maxLength(50)->autocomplete('family-name'),
        TextInput::make('email')->required()->email()->unique(...)->autocomplete('email'),
        TextInput::make('password')
            ->required()
            ->password()
            ->revealable()
            ->dehydrateStateUsing(static fn(string $s): string => Hash::make($s))
            ->autocomplete('new-password'),
        TextInput::make('password_confirmation')
            ->required()
            ->password()
            ->revealable()
            ->dehydrated(false)
            ->autocomplete('new-password'),
        Checkbox::make('privacy_accepted')
            ->required()
            ->accepted()
            ->label('Accetto la <a href="/it/privacy" target="_blank">Privacy Policy</a>'),
        Checkbox::make('terms_accepted')
            ->required()
            ->accepted()
            ->label('Accetto i <a href="/it/terms" target="_blank">Termini di Servizio</a>'),
        Checkbox::make('marketing_consent')
            ->label('Acconsento al marketing (opzionale)')
            ->helperText('Puoi revocare in qualsiasi momento dalla sezione Privacy del tuo profilo'),
    ])->statePath('data');
}
```

## Registrazione del widget (panel provider)

In `Modules\Gdpr\Providers/FilamentServiceProvider.php`:

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->widgets([
            \Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class,  // ← vince su User
            \Modules\User\Filament\Widgets\Auth\LoginWidget::class,
        ]);
}
```

## GDPR actions (esistenti)

- `Modules\Gdpr\Actions\ValidateGdprConsentAction` — valida i consensi
- `Modules\Gdpr\Actions\CollectGdprConsentsAction` — raccoglie consensi da form
- `Modules\Gdpr\Actions\SaveGdprConsentsAction` — persiste consensi su DB (tabella `gdpr_consents`)
- `Modules\Gdpr\Models\GdprConsent` — modello per tracciare consensi (audit trail)

## Conformità checklist

| Requisito GDPR | Implementazione | Status |
|----------------|-----------------|--------|
| Art. 5 §2 — Accountability | `SaveGdprConsentsAction` con timestamp | ✅ |
| Art. 7 §1 — Consenso libero | `marketing_consent` non required | ✅ |
| Art. 7 §2 — Finalità separate | 3 checkbox separati (privacy, terms, marketing) | ✅ |
| Art. 7 §3 — Revocabile | `marketing_consent` + sezione Privacy nel profilo | ✅ |
| Art. 13 — Informativa | Link `<a href="/it/privacy">` nella label | ✅ |
| Condizioni contrattuali | Link `<a href="/it/terms">` nella label | ✅ |
| Prova del consenso (audit) | `gdpr_consents` table con `ip`, `user_agent`, `accepted_at` | ✅ |
| Double opt-in (marketing) | TODO: invio email conferma marketing | ⚠️ follow-up |

## Anti-pattern vietati (R8 + R1)

❌ User `RegisterWidget` in produzione (no GDPR consent)
❌ Un singolo checkbox "accetto tutto" (art. 7 §2 vieta)
❌ `marketing_consent` required (art. 7 §1: libero = non pre-checked)
❌ Marketing checkbox pre-selezionata (art. 7 §2)
❌ Nessun link a Privacy Policy / Termini
❌ Nessun audit trail dei consensi (art. 5 §2)

## Verifica

```bash
# In dev (no Gdpr attivo) → User RegisterWidget
MODULE_GDPR_ENABLED=false php artisan serve

# In produzione → Gdpr RegisterWidget
MODULE_GDPR_ENABLED=true php artisan serve
```

Switch via `.env`: `GDPR_ENABLED=true`.

## Riferimenti

- Issue base: [#264](https://github.com/laraxot/base_fixcity_fila5/issues/264)
- Discussion base: [#265](https://github.com/laraxot/base_fixcity_fila5/discussions/265)
- Issue module_gdpr (TODO): TBD
- Story complementare: [STORY-140](https://github.com/laraxot/base_fixcity_fila5/issues/248)
- Architecture doc: [`docs/architecture-ai-assisted-coding-2026-06-05.md`](../../../docs/architecture-ai-assisted-coding-2026-06-05.md) §3 R8

---
*opencode (MiniMax-M3) · 2026-06-05 · Garante Privacy EU 2016/679 + D.Lgs 196/2003/101/2018*
