---
title: "Architettura del modulo Gdpr"
type: architecture
module: Gdpr
updated: 2026-11-25
---

# Architettura

Misurata sul codice il 2026-11-25: 86 file PHP in `app/`, 45 in `tests/`.

## Mappa di `app/`

| Cartella | Contenuto |
|---|---|
| `Actions/` | Tutta la logica di dominio, Spatie Queueable Action con unico metodo `execute()`. `SaveGdprConsentsAction`, `UpdateGdprConsentsAction`; sottocartelle `Account/` (`DeleteAccountAction`), `Consent/` (`Collect`, `Revoke`, `SaveRegistrationConsentsAction`), `Cookie/` (`GetCookieInventoryAction`), `Registration/` (esito di registrazione), `Validation/` (consensi e dati utente). |
| `Models/` | `Consent`, `Treatment`, `Event` (tabella `gdpr_events`), `Profile`, `BaseModel`, `BaseMorphPivot`, `BasePivot`; `Models/Traits/HasGdpr`; `Models/Policies/*`. |
| `Datas/` | DTO Spatie Data: `GdprData` (flag `cookie_banner_on` dal config tenant `gdpr`), `GdprConfigData` (durata della scelta, banner informativo, pagina policy), `CookieData`, `CookieInventoryData`. |
| `Enums/` | `ConsentType` (14 tipi, 3 obbligatori: privacy, termini, verifica eta'), `CookieCategory` (`necessary`, `analytics`, `marketing`). |
| `Filament/` | Resource di `Consent`, `Event`, `Profile`, `Treatment`; cluster `Profile`; pagine `Dashboard`, `EditProfile`, `SettingPage`; widget di registrazione in `Widgets/Auth/`. |
| `Http/Middleware/` | `InjectCookieBanner`. Non ci sono controller ne' classi Livewire HTTP (`Http/Livewire` contiene solo `_components.json` vuoto). |
| `Listeners/` | `SaveGdprConsents`, adattatore sottile verso `SaveRegistrationConsentsAction`. |
| `Providers/` | `GdprServiceProvider` (minimo, estende `XotBaseServiceProvider`, aggiunge banner cookie), `EventServiceProvider`, `RouteServiceProvider`, `Filament/AdminPanelProvider` (registra il CSS del banner). |

Non esistono `app/Services/` ne' `app/Support/`: vedi [conventions.md](conventions.md).

## Flussi principali

- **Registrazione**: `RegisterWidget::submit()` valida, crea l'utente e salva i consensi in un'unica transazione sulla
  connessione `user`: [registration.md](registration.md).
- **Prova del consenso**: solo INSERT, una riga per scelta; la revoca aggiorna `revoked_at`: [consents.md](consents.md).
- **Cancellazione**: `DeleteAccountAction` disattiva l'account e conserva la prova: [account-deletion.md](account-deletion.md).
- **Banner**: il provider sostituisce traduzioni e vista del pacchetto statikbe e mette `InjectCookieBanner` nel gruppo `web`:
  [cookie-banner.md](cookie-banner.md).

## Rotte

`routes/web.php` ha una sola rotta, `account.delete` (`GET|POST /{lang}/account/delete`, middleware `auth`). `routes/api.php` e'
vuoto. Le pagine pubbliche (registrazione, informative) non sono rotte del modulo: le ospita il tema o il CMS del progetto.

## Connessioni di database

`BaseModel` e `Profile` usano la connessione `gdpr`. Le connessioni per modulo non si dichiarano a mano in `config/database.php`:
le aggiunge `TenantServiceProvider::registerDB()` come copia della connessione di default. La registrazione apre la transazione
su `user`: le scritture su `gdpr` sono coperte dal rollback solo se le due connessioni puntano allo stesso database (difetto
noto, vedi il contratto di [DeleteAccountAction](contracts/delete-account-action.md)).

## Configurazione

- `config/config.php` (chiave `gdpr.config.*`): sezioni `cookie.extra` (cookie non tecnici dichiarati da un modulo),
  `retention`, `processing_register`, `data_subject_rights`, `security_measures`, `dpo`, e blocchi di esempio di un settore
  specifico (`insurance_consents`, `privacy_documents`). Sono valori di partenza da sovrascrivere nel config del tenant, non
  politiche del modulo: nessun codice li fa rispettare (verificato: nessuna lettura di `retention` ne' di `data_subject_rights`).
- `config/consent.php`: elenco dei trattamenti (`gdpr.privacy`, `gdpr.marketing`) nel formato del pacchetto
  `foothing/laravel-gdpr-consent`; non e' letto dalle Action del modulo, che creano i trattamenti da sole.
- Dal pannello (`SettingPage`, salvata nel config del tenant): `consent_lifetime` (default 180 giorni, minimo 180),
  `info_banner`, `policy_path` (default `/cookie-policy`).

## Risorse pubbliche

CSS del banner `resources/dist/cookie-consent.css` (registrato con `FilamentAsset`, copiato da `php artisan filament:assets`),
icone in `resources/svg/` (set `gdpr`, usate come `gdpr-icon`).
