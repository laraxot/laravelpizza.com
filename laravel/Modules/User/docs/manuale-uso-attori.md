---
title: "Manuale d'uso per attori — User"
type: note
qmd: "manuale uso attori duso user"
---
# Manuale d'uso per attori — User

## Scopo e perimetro

Il modulo User gestisce identità, autenticazione web, profilo, ruoli, permessi,
team, tenant associati e accesso ai pannelli Filament. Questo manuale descrive
solo capacità verificabili nel codice installato. Un ruolo, un permesso e
l'accesso a un pannello sono controlli distinti: avere un nome di ruolo seedato
non implica automaticamente la possibilità di eseguire ogni operazione.

## Attori e capacità effettive

| Attore | Capacità verificabili |
|---|---|
| Ospite | Può raggiungere login, registrazione, recupero password e verifica email, secondo configurazione e stato delle rotte. Può avviare il social login solo quando il provider è configurato. Non dispone di profilo, team o permessi autenticati. |
| Utente autenticato | Può effettuare logout e, nelle pagine abilitate dal pannello, aggiornare nome, email e password. Può vedere la dashboard User quando il relativo pannello lo ammette. L'accesso ai pannelli dipende dai ruoli presenti. |
| Utente in gruppo/team o ruolo | Può operare sul team corrente e sulle membership solo se le policy e i permessi applicabili lo consentono. La membership ha un ruolo sul pivot e permessi JSON; non è una concessione globale. |
| Admin | Il ruolo `admin` consente l'accesso al pannello `admin` insieme a `super-admin` e `restaurant::admin`. Le operazioni su utenti e configurazione restano soggette alle policy e ai permessi effettivi; `admin` non equivale a `super-admin`. |
| Super-admin | Entra nei pannelli previsti dal controllo User e supera i bypass `before()` delle policy compatibili. Può accedere alle funzioni riservate al super-admin, compreso Pulse e la gestione del ruolo super-admin, nei punti in cui tali funzioni sono esposte. |
| Operatore | Un ruolo `<modulo>::operator` permette l'ingresso al pannello del modulo corrispondente, con le capacità ridotte definite dalle policy di quel modulo. User non dichiara un CRUD operativo uniforme per tutti gli operatori. |
| Moderatore | `moderator` è un ruolo presente nei seeder e alcuni permessi di moderazione sono presenti nel catalogo. Non è però una capacità universale: le azioni concrete dipendono dalla policy e dal modulo della risorsa. |

## Flussi operativi

### Accesso locale

1. L'ospite apre il login localizzato e invia email e password.
2. Se non ha un account, usa la registrazione; se lo ha perso, avvia il reset.
3. Quando richiesto dall'applicazione, completa la verifica dell'email.
4. Dopo l'autenticazione entra solo nei pannelli per i quali possiede un ruolo
   ammesso. Un account cancellato è escluso dal provider di autenticazione.

Le rotte web del modulo espongono anche il logout. La disponibilità concreta è
vincolata a configurazione, middleware e stato dell'account.

### Social login

Il flusso è disponibile per `google`, `microsoft` e `github`, ma solo se per il
provider sono configurati `client_id`, `client_secret` e `redirect`.

1. L'ospite avvia `/{lang}/auth/login/{provider}`.
2. Il provider restituisce il callback all'applicazione.
3. Il modulo valida provider e identità, nega gli utenti non ammessi e accede
   all'utente esistente; può registrare un nuovo utente solo se la registrazione
   è abilitata.
4. Eventuali ruoli automatici dipendono dalla configurazione del dominio email;
   non sono una promessa generale del social login.

### Area personale e backoffice

Un utente autenticato usa la pagina profilo per modificare nome, email e
password. Gli utenti autorizzati possono usare le risorse User per consultare o
gestire utenti, ruoli, permessi, team e associazioni tenant, ma ogni azione è
mediata dalla relativa policy. I widget di cambio team e social login sono
funzioni del chrome del pannello, non un'escalation di privilegi.

## Prerequisiti

- account attivo e autenticazione web per le funzioni riservate;
- ruolo e/o permesso richiesto dalla policy della risorsa o del pannello;
- membership e team esistenti per i flussi di gruppo;
- provider social configurato per Google, Microsoft o GitHub;
- configurazione di registrazione, email e reset funzionante per i relativi
  flussi.

## Limiti

- I ruoli seedati (`super-admin`, `admin`, `moderator`, `editor`, `user`,
  `guest`, e gli ulteriori ruoli creati da `UserSeeder`) sono dati iniziali, non
  una matrice universale di autorizzazioni.
- `moderator` e `operator` non hanno capacità uniformi attraverso i moduli.
- Il super-admin non rende valido un account cancellato: il controllo di stato
  precede l'accesso al pannello.
- Il social login non funziona senza credenziali/redirect del provider e non
  assegna automaticamente ruoli in ogni caso.

## Fonti verificabili

- `app/Models/BaseUser.php` — accesso ai pannelli e super-admin/operator.
- `app/Models/User.php`, `app/Models/Role.php`, `app/Models/Team.php` e
  `app/Models/Membership.php` — identità, ruoli e membership.
- `app/Models/Policies/BaseUserPolicy.php` — autorizzazione sulle operazioni
  utente.
- `routes/web_tall.php` e `routes/socialite.php` — flussi web e provider.
- `app/Actions/Socialite/ProcessCallbackAction.php` e
  `app/Actions/Socialite/IsProviderConfiguredAction.php` — callback e
  prerequisiti social.
- `app/Filament/Pages/MyProfilePage.php`, `app/Filament/Pages/Auth/EditProfile.php`
  e `app/Filament/Resources/UserResource.php` — area personale e backoffice.
- `database/seeders/RoleSeeder.php`, `database/seeders/UserSeeder.php` e
  `database/seeders/PermissionSeeder.php` — dati iniziali, non sostitutivi
  delle policy.
