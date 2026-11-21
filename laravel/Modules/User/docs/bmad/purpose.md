---
title: "User — scopo del modulo e come raggiungerlo meglio"
type: concept
status: active
created: 2026-10-06
tags: [user, purpose, autenticazione, autorizzazione, rbac, tenant, team]
qmd: "user scopo modulo autenticazione autorizzazione rbac spatie permission tenant team multi-tenancy identita profilo oauth"
updated: 2026-10-06
issues:
  - "https://github.com/laraxot/module_user_fila5/issues/110"
discussions:
  - "https://github.com/laraxot/module_user_fila5/discussions/104"
---

# User — perche' esiste

## Lo scopo in una frase

**User centralizza l'autenticazione, l'autorizzazione RBAC e la gestione della multi-tenancy, fornendo modelli e trait condivisi che tutti gli altri moduli usano per identificare chi agisce e in quale contesto.**

## L'evidenza

- `User`, `Team`, `Tenant`: modelli base per identity, gruppi, isolamento
- `HasTeams`, `HasTenants`, `HasAuthenticationLog`: trait di autenticazione e autorizzazione
- 666 file PHP, 57 Action, 26 Widget: qui l'interfaccia conta — login, profilo, gestione team sono superfici che l'utente tocca davvero
- OAuth completo (`OauthClient`, `OauthAccessToken`, `OauthRefreshToken`, `OauthAuthCode`, `OauthPersonalAccessClient`)
- `AuthenticationLog`, `Device`: tracciamento accessi e dispositivi
- `Feature` (Pennant): funzionalita' attivabili per utente o contesto
- `BaseUser`, `BaseProfile`: classi base per estensione

## La distinzione che regge tutto: utente ≠ profilo ≠ dipendente

Sono tre cose diverse:

| Concetto | Cos'e' | Dove vive |
|---|---|---|
| **User** | credenziali e permessi | User |
| **Profile** | dati della persona come utente della piattaforma | User |
| **Dipendente** | persona nell'organico dell'ente, matricola e storia | Sigma |

Un utente puo' non essere un dipendente. Un dipendente puo' non avere un utente. Il collegamento e' una relazione, non un'identita'.

**Corollario:** nei PHPDoc, i riferimenti a creatore/aggiornatore vanno tipizzati su `Modules\Xot\Contracts\ProfileContract`, **mai** sulla classe concreta di un modulo verticale.

## Come raggiungerlo meglio

### 1. README con informazioni corrette

Badge e versioni riportano: Laravel `^13.0`, PHP `^8.3`, Filament `^5.0`, PHPStan `max` con 0 errori (verificato 2026-09-02).

### 2. Documentazione proporzionata

666 file PHP e 56 righe di README. Serve una mappa in `docs/index.md`: login, ruoli/permessi, team, profilo, OAuth, feature flag.

### 3. Permessi come contratto, non deduzione

`docs/permissions.md` con matrice ruolo → permessi → effetto concreto. Test che verifichi i permessi usati nelle Policy.

**Gap confermato (2026-09-22):** 30+ classi Policy (Team, User, Profile, Role, Device, Feature, SocialProvider, Tenant) non hanno permessi: ogni `can('x')` nega in silenzio.

### 4. Separare Team e multi-tenancy

`Team` (qui) e `Tenant` (modulo Tenant) sono due meccanismi di separazione. Va dichiarato quale e' il confine dei dati e quale l'organizzazione.

### 5. Usare AuthenticationLog

Dati di accesso e dispositivi esistono gia' in UI (`AuthenticationLogResource`, `RecentLoginsWidget`, `DeviceResource`). Manca euristica di anomalia (nuovo dispositivo, orario inusuale).

## Confini — cosa **non** appartiene a User

- I **dati di servizio** del dipendente (matricola, categoria, struttura): Sigma
- Le **valutazioni**: moduli di dominio
- L'**infrastruttura Filament**: Xot
- Le **notifiche**: Notify. User decide *chi* puo' ricevere, non *come* si spedisce

## Collegamenti

- `laravel/Modules/Tenant/docs/purpose.md` — l'altro asse di separazione
- `laravel/Modules/Xot/docs/purpose.md` — `ProfileContract` e le classi base
- `docs/bmad/module-excellence-prd.md` — gap verso "perfezione assoluta" (Epic 12/13/14)
- `docs/bmad/decision-log.md` — correzioni e aggiornamenti (2026-09-22)
