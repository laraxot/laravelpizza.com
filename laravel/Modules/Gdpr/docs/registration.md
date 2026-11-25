---
title: "Registrazione con consensi"
type: guide
module: Gdpr
updated: 2026-11-25
related:
  - register-widget-copy-ownership.md
  - consents.md
---

# Registrazione con consensi

`Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget` e' il form di registrazione pubblico che registra la prova dei consensi.
Il modulo `User` ha un widget di ripiego senza consensi: dove serve la prova (art. 7) si monta quello di Gdpr.

```blade
@livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
```

Si usa la classe e non il tag `<livewire:gdpr::...>`: in un'architettura modulare il tag da' `ComponentNotFoundException` se il
componente non e' registrato. Di chi sono vista e testi: [register-widget-copy-ownership.md](register-widget-copy-ownership.md).

## Cosa succede all'invio (`submit()`)

1. **Rate limit**: chiave `register|<ip>`, 10 invii ogni 600 secondi (ogni invio conta, valido o no); oltre, errore sul campo
   `email` con i secondi di attesa (`gdpr::register.throttle`).
2. **Validazione Livewire**: `first_name`/`last_name` 2-255, `email` obbligatoria e unica su `user.users`, `password` con
   `Password::defaults()`, `password_confirmation` uguale, `privacy_accepted` e `terms_accepted` `accepted`.
3. **`ValidateGdprConsentAction`**: seconda barriera sui due consensi obbligatori, messaggi tradotti.
4. **`ValidateUserDataAction`**: rifiuta un'email gia' presente prima del vincolo del database, calcola l'hash della password,
   imposta `type = customer_user`, `lang` = locale corrente, `email_verified_at = null` (la verifica arriva solo dal link
   firmato nella mail), e restituisce i dati per `CreateUserAction`. `name` = `first_name` + `last_name`.
5. **Transazione sulla connessione `user`**: `CreateUserAction` (modulo User), `SaveGdprConsentsAction` con le tre scelte
   raccolte da `CollectGdprConsentsAction`, `LogRegistrationAction`. Se il salvataggio dei consensi fallisce la registrazione
   fallisce: nessun utente senza prova.
6. **`HandleSuccessfulRegistrationAction`**: `Auth::login`, invio della mail di verifica (un errore del server di posta viene
   segnalato con `report()` e non fa fallire la registrazione gia' salvata), notifica di successo, `redirectIntended` verso
   l'area personale localizzata (`GetPostLoginUrlAction`, non `route('dashboard')`: nel front office la pagina `/{lang}/dashboard`
   e' del tema).
   In caso di eccezione `HandleRegistrationErrorAction` registra il dettaglio nel log e mostra una notifica generica.

Il log di tentativo (`logRegistrationAttempt`) scrive l'hash SHA-256 dell'email, mai l'indirizzo.

## I due widget

| | `RegisterWidget` | `GdprConsentForm` |
|---|---|---|
| Base | `XotBaseWidget` | `XotBaseSchemaWidget` |
| Rate limit, regole password, `name` | si | no |
| Vista | risolta da `XotBaseWidget::resolveView()`: `pub_theme::filament.widgets.auth.register`, poi `gdpr::filament.widgets.auth.register` | `getView()` fisso a `filament.widgets.auth.register` |
| Uso nel repository | form di registrazione | nessuno fuori dal modulo (grep su moduli, temi, config): variante con la stessa superficie pubblica |

Entrambi: `canView()` e' vero solo per un ospite, `getFormSchema()` e' vuoto (il form e' nella vista Blade), i consensi sono
proprieta' pubbliche Livewire (`privacy_accepted`, `terms_accepted`, `marketing_consent`) e non componenti Filament, cosi' la vista
puo' rendere HTML con i link localizzati ai documenti. Se si scrive una vista di tema: il contratto dei campi e dei testi e' in
[register-widget-copy-ownership.md](register-widget-copy-ownership.md).

## Perche' le Action

Il widget non contiene logica: validazione, raccolta, esito e salvataggio sono Action Spatie separate, singolarmente testabili
(`tests/Unit/Actions/*`). Il widget orchestra chiamate `app(...)->execute(...)`: se una Action cambia firma, i test del widget lo segnalano.

## Chi chiama il modulo dall'esterno

Un modulo ospite che registra un utente per un'altra via (es. iscrizione a un evento con creazione dell'account) chiama
`SaveGdprConsentsAction::execute($user, $consents, $ip, $userAgent)` e basta: stessa prova, stessa versione del documento.

## Pagine legali

Informativa e termini sono pagine del progetto ospite (config del tenant e traduzioni). La story
[12.1](stories/12.1.gdpr-owns-legal-pages.story.md) tiene aperta la decisione se le pagine legali debbano essere del modulo
(come pagine, non come widget KPI). Verificato: in `Modules/Gdpr` non esistono classi Livewire HTTP da convertire; il commento
"moved into Gdpr" nel provider del pannello del modulo `User` descrive uno spostamento che non e' mai avvenuto (i componenti
`TermsOfService` e `PrivacyPolicy` e i widget gemelli sono ancora in `User`).

## Test

`tests/Feature/Register*Test.php`, `RegistrationTest.php`, `RegistrationPageTest.php`, `SimpleRegisterTest.php`,
`tests/Unit/Actions/*`, `RegisterWidgetContractTest.php` (contratto con il tema). Come eseguirli: [testing.md](testing.md).
