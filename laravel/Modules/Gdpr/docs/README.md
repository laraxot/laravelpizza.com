---
title: "Modulo Gdpr"
type: readme
module: Gdpr
updated: 2026-11-25
---

# Modulo Gdpr

Prova dei consensi, cookie banner, registrazione con consensi e cancellazione dell'account (GDPR artt. 7, 17 e 13-14) per i
progetti Laraxot. Pacchetto Composer `laraxot/module_gdpr_fila5`, namespace `Modules\Gdpr`, provider `GdprServiceProvider` e
`Providers\Filament\AdminPanelProvider` (pannello `gdpr::admin`).

Il modulo e' condiviso tra progetti: possiede i **meccanismi** (tabelle, Action, banner, form di registrazione), non i testi
legali, i recapiti del titolare o le scelte di conservazione, che sono del progetto ospite (config del tenant, traduzioni, tema).

## Cosa fa oggi (verificato sul codice)

| Funzione | Dove | Pagina |
|---|---|---|
| Prova dei consensi: una riga `consents` per scelta, revoca con `revoked_at` | `Actions/SaveGdprConsentsAction`, `Actions/Consent/*`, trait `HasGdpr` | [consents.md](consents.md) |
| Registrazione con tre consensi (privacy, termini, marketing) | `Filament/Widgets/Auth/RegisterWidget` | [registration.md](registration.md), [register-widget-copy-ownership.md](register-widget-copy-ownership.md) |
| Cancellazione dell'account (soft delete + revoca) | `Actions/Account/DeleteAccountAction`, rotta `account.delete` | [account-deletion.md](account-deletion.md) |
| Banner cookie e inventario dei cookie | `GdprServiceProvider`, `Http/Middleware/InjectCookieBanner`, `Actions/Cookie/GetCookieInventoryAction` | [cookie-banner.md](cookie-banner.md) |
| Back office di trattamenti, consensi, eventi, profili | `Filament/Resources/*`, `Filament/Pages/SettingPage` | [admin-panel.md](admin-panel.md) |

Non c'e' ancora: export dei dati dell'interessato, registro delle richieste, job di purga, DPIA, procedura di violazione
(vedi [data-subject-rights.md](data-subject-rights.md) e [roadmap.md](roadmap.md)).

## Dipendenze

- Pacchetto: `statikbe/laravel-cookie-consent` (il modulo ne sostituisce traduzioni e vista del banner).
- Moduli: `Xot` (base: `XotBaseServiceProvider`, `XotBaseResource`, `XotBaseMigration`), `Tenant` (config per tenant),
  `User` (utente, `CreateUserAction`, token), `UI`. `Activity` e' opzionale (cancellazione dell'account).

## Dove leggere

- Mappa di tutti i documenti: [00-index.md](00-index.md).
- Perche' il codice e' fatto cosi': [adr/README.md](adr/README.md). Cosa promettono le Action: [contracts/README.md](contracts/README.md).
- Regole per chi tocca il modulo: [conventions.md](conventions.md). Debito noto: [code-quality.md](code-quality.md).
