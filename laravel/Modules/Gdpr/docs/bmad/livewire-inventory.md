---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire inventory"
issues: []
discussions: []
title: "Inventario Http/Livewire → Filament widget — Gdpr"
type: inventory
module: Gdpr
status: approved
track: campaign
related:
  - ./livewire-widget-architecture.md
  - ./livewire-widget-project-context.md
  - ./livewire-widget-decision-log.md
  - ./livewire-widget-epics.md
  - ../stories/12.1.gdpr-owns-legal-pages.story.md
  - ../../User/docs/bmad/livewire-inventory.md
---

# Inventario: Livewire HTTP → Filament — modulo Gdpr

**Solo documentazione. Nessun PHP toccato in questo audit.**

Questo file è la SSoT del modulo Gdpr per la campagna di conversione Livewire → Filament widget. Formato e metodo sono ripresi da [Modules/Cms/docs/bmad/livewire-inventory.md](../../Cms/docs/bmad/livewire-inventory.md) e [Modules/User/docs/bmad/livewire-inventory.md](../../User/docs/bmad/livewire-inventory.md).

## Metodo (codice, non assunzione)

```bash
find Modules/Gdpr/app/Http/Livewire Modules/Gdpr/app/Livewire -type f -name '*.php'
find Modules/Gdpr -iname '*livewire*' -not -path '*/vendor/*'
find Modules/Gdpr -path '*/vendor/*' -prune -o -name '*.php' -print | xargs grep -l 'extends.*\(Component\|Livewire\)'
grep -rn "@livewire" Modules/Gdpr/resources/views
grep -rln "<livewire:" Modules/Gdpr/resources/views
find Modules/Gdpr/app/Filament/Widgets -type f
ls Modules/Gdpr/resources/views/pages
grep -rn 'terms.of.service\|TermsOfService' Modules/Gdpr Modules/User/app/Providers/Filament/AdminPanelProvider.php
```

## Classi Livewire trovate: zero

`Modules/Gdpr/app/Http/Livewire/` esiste ma contiene solo `_components.json` con contenuto `[]` (array vuoto: nessun componente registrato). `Modules/Gdpr/app/Livewire/` non esiste. Il grep `extends.*(Component|Livewire)` su tutti i `.php` del modulo non restituisce nessun file. **Il modulo Gdpr non possiede oggi alcun componente Livewire.**

## La nota "moved into Gdpr" nel provider User NON è implementata

`Modules/User/app/Providers/Filament/AdminPanelProvider.php:34-39` contiene un blocco commentato:

```php
/*-- moved into Gdpr
 * FilamentView::registerRenderHook(
 * PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
 * fn (): string => Blade::render('@livewire(\'terms-of-service\')'),
 * );
 */
```

La verifica mostra che lo spostamento **non è mai avvenuto**:

- Il componente `terms-of-service` vive ancora in User: `Modules/User/app/Http/Livewire/TermsOfService.php` (e il gemello `PrivacyPolicy.php` nella stessa cartella).
- Esistono già i widget sostitutivi in User: `Modules/User/app/Filament/Widgets/TermsOfServiceWidget.php:13-15` ("Sostituisce il vecchio Livewire `Modules\User\Http\Livewire\TermsOfService`") e `Modules/User/app/Filament/Widgets/PrivacyPolicyWidget.php:16-18` (analogo per privacy).
- Il provider Gdpr non registra alcun hook legal: `Modules/Gdpr/app/Providers/Filament/AdminPanelProvider.php` (30 righe) contiene solo `FilamentAsset::register` del CSS cookie-consent (righe 20-26) e `return $panel` (riga 28). Nessun render hook, nessun widget esplicito.

Conclusione: Gdpr non ha "ereditato" `terms-of-service`; l'ownership delle pagine legal resta formalmente in User (componente HTTP orfano + widget gemello già esistente). La decisione BMAD corretta è quella già tracciata: le pagine legal appartengono concettualmente a Gdpr come **pagine/viste**, mai come widget dashboard — vedi story [12.1](../stories/12.1.gdpr-owns-legal-pages.story.md) e il blocco User (Epic 10.4) per il ritiro dell'HTTP.

## Widget Filament esistenti nel modulo: 2 (auth/registration)

`find Modules/Gdpr/app/Filament/Widgets -type f` restituisce due file, entrambi in `Auth/`:

| Widget | File | Estende | Righe | Note |
|---|---|---|---|---|
| `Filament\Widgets\Auth\RegisterWidget` | `app/Filament/Widgets/Auth/RegisterWidget.php` | `XotBaseWidget` (riga 27) | 122 | Form di registrazione GDPR-compliant: proprietà pubbliche validabili (`privacy_accepted`, `terms_accepted`, `marketing_consent`, `first_name`, `email`, `password`…) righe 29-54; `canView() = ! Auth::check()` righe 56-59; `getView()` → `'filament.widgets.auth.register'` righe 61-64 (nome vista **senza** prefisso `gdpr::`, risolta da tema/app); `submit()` righe 72-106 valida consensi (`ValidateGdprConsentAction`) e crea l'utente in transazione `DB::connection('user')` |
| `Filament\Widgets\Auth\GdprConsentForm` | `app/Filament/Widgets/Auth/GdprConsentForm.php` | `XotBaseSchemaWidget` (riga 27) | 122 | Stessa superficie pubblica di `RegisterWidget` (consensi + campi), `canView() = ! Auth::check()` righe 56-59; variante schema-based dello stesso form |

Entrambi sono **già** Filament widget (cioè componenti Livewire nel senso Filament del termine): non sono candidati di conversione, sono l'approdo già avvenuto. Sono auto-scoperti nel panel `gdpr::admin` dal `discoverWidgets` di `Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php:134-137`, ma `canView()` li rende invisibili sulla dashboard autenticata (mostrano solo a guest).

## Verifica del montaggio: zero hit in produzione

| Meccanismo | Dove si cerca | Esito |
|---|---|---|
| `@livewire(...)` / `<livewire:` nelle viste del modulo | `grep -rn "@livewire" Modules/Gdpr/resources/views` e `grep -rln "<livewire:"` | Zero hit in entrambi i casi |
| Riferimenti ai due widget fuori dai test | `grep -rn 'RegisterWidget\|GdprConsentForm' Modules app` | Solo test: `Modules/Gdpr/tests/Feature/Auth/RegisterPageTest.php:26` (`Livewire::test(RegisterWidget::class)`), `RegisterPageComprehensiveTest.php:7,340,345`, `RegisterFormValidationTest.php`, `RegistrationTest.php:26`. Nessun blade/provider/rotta di produzione li monta |
| Pagina Folio register | `Modules/User/resources/views/pages/auth/register.blade.php:70` | Monta `@livewire(\Modules\Gdpr\Filament\Widgets\Auth\UserForm::class)` — **classe inesistente**: in `Modules/Gdpr/app/Filament/Widgets/Auth/` ci sono solo `RegisterWidget.php` e `GdprConsentForm.php`, nessun `UserForm`. Riferimento stantio, da correggere quando si interverrà sulla pagina register FO (fuori scope docs) |
| Render hook nel chrome Filament | Lettura integrale di `Modules/Gdpr/app/Providers/Filament/AdminPanelProvider.php` | Nessun hook (solo asset CSS, righe 20-26) |
| Rotta esplicita | `Modules/Gdpr/routes/web.php` (7 righe), `routes/api.php` (7 righe) | Entrambi solo commenti, nessuna rotta |
| Pagina Folio/Volt del modulo | `ls Modules/Gdpr/resources/views/pages` | Cartella assente: nessuna rotta Folio contribuita da Gdpr |

## Classificazione

| Classe | Alias/hook | Gemello widget | Cluster | Nota |
|---|---|---|---|---|
| — | — | — | — | Nessuna classe `Http\Livewire` nel modulo: niente da classificare |

I due widget `Auth/` non entrano nella classificazione A/B/C perché **non sono componenti HTTP da convertire**: sono già Filament widget.

**Cluster A: zero candidati.** Nessun componente Livewire HTTP di Gdpr è montato nel chrome di un panel (e non esiste alcun componente HTTP).

**Cluster B: zero candidati.** Non c'è nessun HTTP orfano con gemello widget da ritirare *in questo modulo* (il caso `TermsOfService`/`PrivacyPolicy` riguarda User, non Gdpr).

**Cluster C: zero componenti.** Niente pagine a tutto schermo da escludere.

## Verdetto

Nessuna story di conversione widget in Gdpr: zero candidati reali nei Cluster A/B/C. Resta valida la story di ownership [12.1](../stories/12.1.gdpr-owns-legal-pages.story.md) (legal pages di pertinenza Gdpr come pagine, non widget) e la dipendenza dal ritiro dei componenti HTTP in User (Epic 10.4). Il riferimento stantio a `Gdpr\...\UserForm` nella pagina Folio register è documentato qui come fatto verificato, non come story.

## Riferimenti correlati (non SSoT, coerenti col verdetto)

- [livewire-widget-architecture.md](./livewire-widget-architecture.md)
- [livewire-widget-brainstorming.md](./livewire-widget-brainstorming.md)
- [livewire-widget-decision-log.md](./livewire-widget-decision-log.md)
- [livewire-widget-epics.md](./livewire-widget-epics.md)
- [livewire-widget-prd.md](./livewire-widget-prd.md)
- [livewire-widget-product-brief.md](./livewire-widget-product-brief.md)
- [livewire-widget-project-context.md](./livewire-widget-project-context.md)
- [livewire-widget-tech-spec.md](./livewire-widget-tech-spec.md)
- [livewire-widget-ux.md](./livewire-widget-ux.md)

## Successo

- [x] Inventario completo del modulo (0 classi `Http\Livewire`, verificato con find + grep)
- [x] Verifica montaggio in tutto il repo (provider, blade, rotte, Folio, test)
- [x] Nota "moved into Gdpr" del provider User verificata e smentita con citazioni file:riga
- [x] 2 widget Filament auth documentati (scoperti, `canView` guest-only, montati solo nei test)
- [x] Nessuna story di conversione creata (zero candidati reali)
