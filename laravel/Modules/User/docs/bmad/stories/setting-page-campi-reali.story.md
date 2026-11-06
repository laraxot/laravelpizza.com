---
title: SettingPage di User con campi reali
status: done
module: User
type: story
created: 2026-11-04
related:
  - ../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md
  - ./setting-page.story.md
---

# SettingPage di User con campi reali

## Fase BMAD

Build. Contratto e matrice: story madre in Xot. Supera [setting-page](./setting-page.story.md) ("pagina senza campi").

## Campi esposti

| Campo | Default | Lettore | Decisione |
|-------|---------|---------|-----------|
| `create_personal_team` | `false` | `app/Observers/UserObserver.php` `created()` | esposto. Era `config('user.create_personal_team', false)` |
| `passport_enable_password_grant` | `true` | `app/Providers/PassportServiceProvider.php` `configurePasswordGrant()` (gira in `boot()`) | esposto. Era `config('user.passport.enable_password_grant', true)`; `Passport::$passwordGrantEnabled` e' letto da Passport quando costruisce il server di autorizzazione, quindi il flag ha effetto reale. Si applica al prossimo avvio |

Il boot non puo' rompersi per un file mancante: `UserConfigData::make()` passa da `GetTenantConfigArrayAction`, che su file
assente o illeggibile restituisce `[]`, e la Data riempie i default. Coperto da due test (file finto vuoto e boot completo del
provider).

## Campi di Codex sostituiti

Il working tree e il repo contenevano `registration_enabled` e `email_verification_required` (default `true`), aggiunti senza
lettore, poi un `enabled` senza lettore. Verifica:

- `email_verification_required`: nessun codice lo legge.
- `registration_enabled`: l'unico punto e' `Http/Middleware/EnsureRegistrationEnabled`, che legge `auth.registration_enabled`
  (un altro file di config, non `user`) e **non e' registrato da nessuna parte** (nessun riferimento in rotte, provider o
  alias). Un interruttore su di lui non fermerebbe nessuna registrazione. La registrazione via Socialite ha il suo
  `socialite.registration` (`IsRegistrationEnabledAction`) e la sua pagina.
- `enabled`: nessun lettore.

Rimossi tutti e tre.

## Lasciato fuori

- `passport.register_routes`: nominato nel brief, il lettore esiste (`configureRoutes()`), ma con Passport 13.10
  `Passport::routes()` non esiste piu' (`method_exists` e' falso), quindi il flag non fa niente. Un campo che non cambia nulla
  e' una bugia nel menu. Per renderlo vero servirebbe `Passport::ignoreRoutes()` chiamato prima del boot del provider di
  Passport (ordine dei provider): fuori scopo, da decidere a parte. Il lettore resta com'e' (`config('user.passport.register_routes', true)`).
- `passport.tokens`, `passport.models`, `passport.client_model`, `passport.scopes`: strutture di sicurezza (durata dei token,
  classi, scope OAuth). Non si cambiano da un form. Restano in `config/passport.php` del modulo.
- Password/OTP e Socialite: hanno pagine proprie.

## Lettori cambiati

- `app/Observers/UserObserver.php`: `UserConfigData::make()->create_personal_team`.
- `app/Providers/PassportServiceProvider.php`: `UserConfigData::make()->passport_enable_password_grant`.

## Test e gate

- `tests/Unit/Datas/UserConfigDataTest.php` (esteso, 10 test, 2 gia' esistenti): default, override del tenant, file mancante,
  `configurePasswordGrant()` segue il valore salvato, boot del provider senza file `user.php`, chiavi dello schema uguali alle
  proprieta' della Data, nessuna struttura Passport o campo inventato nella Data, etichette `it` e `en`.
- `tests/Support/FakeTenantUserConfig.php` (nuovo): seam di test. Il contenitore risolve `GetTenantConfigArrayAction`,
  quindi si sostituisce l'istanza e `UserConfigData::make()` legge un file finto.
- `tests/Unit/UserExecuteCoverage50Test.php`: il test `user observer e passport token user relation` pilotava
  `config(['user.create_personal_team' => ...])`, ora la Data. Resta verde. Nello stesso file 5 test sono rossi per
  ragioni estranee (`ReflectionException`, `RouteNotFoundException` su risorse Filament e Socialite).
- PHPStan livello max: 0 errori sui file toccati. Pint: pulito.
