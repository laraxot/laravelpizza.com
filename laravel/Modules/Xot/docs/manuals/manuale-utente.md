---
title: "Manuale utente — Xot (pannello amministrazione)"
type: user-manual
status: active
module: Xot
screenshots: assets/*.webp (catturati 2026-11-25 dall'istanza di prova isolata, DB senza dati)
updated: 2026-11-25
qmd: "manuale utente xot pannello admin"
---

# Xot — pannello di amministrazione

## Scopo

Xot è il framework Laraxot / XotBase. Non ha un front office proprio: il suo
contributo visibile all'utente è il **pannello Filament `xot/admin`**, usato per
controllare moduli, log, cache, sessioni, salute dell'applicazione e impostazioni
generali. Le pagine sotto descritte sono quelle verificate con screenshot reali.

Gli screenshot provengono da un'istanza di prova con database usa-e-getta: le
tabelle sono vuote tranne i log e i moduli (16 moduli, 2 file di log). Dove una
lista è vuota è indicato «Nessun risultato», che è lo stato reale della prova e
non un difetto.

## Accesso

- URL di accesso: `/xot/admin/login` (pagina di login del pannello, screenshot `login`).
- Il pannello richiede autenticazione; dopo il login l'utente va alla dashboard.
- **Dashboard e ruoli:** `MainDashboard::mount()` (`app/Filament/Pages/MainDashboard.php`)
  mostra i moduli per cui l'utente ha il ruolo `<modulo>::admin`
  (`User/app/Models/Traits/HasModules.php`). Se l'utente non ha nessun modulo,
  la dashboard reindirizza alla home pubblica `/{locale}`. Con un solo modulo
  reindirizza direttamente a `/<modulo>/admin`. Nella prova l'utente sintetico non
  aveva ruoli `<modulo>::admin`: la dashboard non è stata catturata (vedi Difetti).
- Health e Ambiente (`EnvPage`) sono riservate al super-admin
  (`SuperAdminOnlyTrait`).

## Attori

| Attore | Accesso verificato nel codice |
|---|---|
| Ospite | Nessuno: il pannello reindirizza al login. |
| Utente con ruolo `<modulo>::admin` | Vede la dashboard e le risorse del proprio modulo. |
| Super-admin | Pagine di sistema: Health, Ambiente, Artisan Commands Manager, Impostazioni. |

## Menu laterale

Il menu raggruppa le voci in: **Sistema** (Artisan Commands Manager),
**Admin** (Health Page, Lock Cache, Ambiente, Extra, Log, Meta Tag, Moduli,
Sessione, Cache), **Sviluppo** (Test), **Configurazione** (Impostazioni).
I badge numerici accanto alle voci mostrano il conteggio dei record (es. Moduli 16,
Log 2).

## Pagine

### Moduli — `/xot/admin/modules` (screenshot `modules`)

Lista dei moduli Laraxot.

- Colonne visibili: **Name**, **Description**, **Status** (icona booleana),
  **Priority**. La colonna **path** è nascosta di default (`ModulesTable.php`).
- Azioni di riga: visualizza, modifica, elimina. Pulsante **Nuovo** / **Crea Module**
  per creare un record.
- Form di modifica: `ModuleForm.php`; sola lettura: `ModuleInfolist.php`.

### Log — `/xot/admin/logs` (screenshot `logs`)

Elenco dei file di log dello storage.

- Colonne: **Name** (es. `laravel`, `browser`), **Size**.
- Filtro **Level name** (valori Tutti / livelli), pulsante **Applica filtri** e **Reimposta**.
- Azioni di riga: **Vedi** (apre `/xot/admin/logs/{record}`) ed **Elimina**.
  Non verificato a fondo cosa cancelli l'azione Elimina: leggere `LogResource/Tables/LogsTable.php` prima di usarla.

### Cache — `/xot/admin/caches` (screenshot `caches`)

Elenco delle voci di cache gestite dal pannello.

- Colonne: **Key**, **Expiration**. Nella prova la lista era vuota.
- Pulsanti di intestazione (presenti, **non eseguiti** durante la cattura):
  **Nuovo**, **Route:list**, **Icons:cache**, **Filament:cache components**,
  **Filament:clear cached components**. Eseguono comandi Artisan/Filament:
  verificare la definizione in `CacheResource/Pages/ListCaches.php` prima di usarli.

### Lock Cache — `/xot/admin/cache-locks` (screenshot `cache-locks`)

Elenco dei lock della cache (`CacheLockResource`).

- Colonne: **Chiave** (key), **Scadenza** (expiration). La colonna **Proprietario**
  (owner) è nascosta di default.
- Pulsante **Crea Cache Lock** per creare un lock manuale (`CacheLockForm.php`).
- Nella prova la lista era vuota.

### Sessione — `/xot/admin/sessions` (screenshot `sessions`)

Elenco delle sessioni utente registrate nel database (`SessionResource`).

- Colonne: **Utente** (user_id), **Indirizzo IP** (ip_address), **Ultima attività**
  (last_activity). Nascoste di default: user agent e identificativo.
- Pulsante **Crea Session** presente. Nella prova la lista era vuota.

### Health Page — `/xot/admin/health-page` (screenshot `health-page`, solo super-admin)

Controlli di salute dell'applicazione (`HealthPage.php`, check Spatie Health).

- Titolo **Salute applicazione** e sottotitolo con la descrizione dei controlli.
- Pulsante **Aggiorna**: esegue tutti i check e salva i risultati (`refresh()`).
  Non è stato premuto durante la cattura, perché scrive i risultati nello store.
- Nella cattura il corpo della pagina era vuoto prima di premere **Aggiorna**.
- Vista: `resources/views/filament/pages/health.blade.php`, che mostra «Ultimo controllo».

### Impostazioni — `/xot/admin/setting` (screenshot `setting`)

Impostazioni generali del pannello (`SettingPage.php`, `lang/it/setting.php`).

| Campo | Tipo | Significato |
|---|---|---|
| Modulo principale | Select (obbligatorio) | Modulo il cui pannello è quello predefinito. Default nella prova: Meetup. |
| Lingua primaria | Select (obbligatorio) | Lingua dei contenuti usata quando manca la traduzione (nella prova: italiano). |
| Forza https | Toggle | Genera URL https. Ignorato in locale (localhost, 127.0.0.1). |
| Nascondi le notifiche del pannello | Toggle | Attivo: nessuna campanella nei pannelli. Spento: la campanella legge le notifiche dal database. |

Pulsante **Salva**.

### Artisan Commands Manager — `/xot/admin/artisan-commands-manager` (screenshot `artisan-commands-manager`)

Pagina con pulsanti che lanciano comandi Artisan (`ArtisanCommandsManager.php`).

- Pulsanti visibili: **Migrazione Database**, **Aggiorna Filament**,
  **Ottimizza Filament**, **Cache delle View**, **Cache della Configurazione**,
  **Cache delle Route**, **Cache degli Eventi**, **Riavvia Code**,
  **Composer Dump Autoload**, **Importa Vecchi Template Email/SMS**.
- Ogni pulsante esegue il comando in modo sincrono (`executeCommand`). Alcuni
  richiedono conferma. **Migrazione Database** modifica lo schema del database.
- Non eseguiti durante la cattura. Prima di usarli leggere la documentazione dei
  singoli comandi.

### Ambiente — `/xot/admin/env-page` (non catturata)

Pagina del file `.env` per il super-admin (`EnvPage.php`, `Widgets/EnvWidget.php`).
Non è stata catturata: vedi Difetti noti, punto 3. Campi: gruppi Generale (app_url,
debugbar, Google Maps, token Telegram), SMS (driver, token Netfun), Mail (mailer,
host, porta, cifratura, utente, password, mittente). Il salvataggio chiama
`config:clear`.

## Difetti noti

1. **Dashboard non catturabile con l'utente di prova.** `MainDashboard::mount()`
   reindirizza a `/it` quando `getModules()` è vuoto (`MainDashboard.php`, riga 39-49).
   Nella prova lo screenshot `dashboard` ha restituito «redirect a /it».
   Causa: l'utente non ha il ruolo `<modulo>::admin`, non un errore di pagina.
   Il manuale non documenta la dashboard con screenshot.

2. **Password in chiaro nel form Ambiente.** `EnvWidget.php` (riga ~173) usa
   `TextInput::make('mail_password')` senza `->password()`; stesso problema per
   `google_maps_api_key`, `telegram_bot_token` e `netfun_token`. Il valore del
   `.env` viene mostrato in chiaro a chiunque abbia accesso alla pagina e allo
   schermo. Non corretto: cambia il comportamento del form. Da correggere
   aggiungendo `->password()->revealable()`.

3. **Ambiente non fotografata.** Per il punto 2, lo screenshot della pagina
   Ambiente non è stato prodotto: avrebbe mostrato segreti in chiaro.

4. **Etichette in inglese residue.** Corrette nella stessa modifica:
   `lang/it/cache_locks.php` (key, owner, expiration) e `lang/it/sessions.php`
   (user_id, ip_address, last_activity, user_agent). Restano in inglese:
   «Crea Session», «Modifica Session», «Elimina Session» (`lang/it/session.php`,
   righe 55-63); «Level name» nel filtro dei log; «Crea Module» (`ModuleResource`, pulsante di intestazione).

5. **Chiavi di traduzione grezze in Health (corrette).** La pagina mostrava
   `xot::health.heading` e `xot::health.sub_heading`, e il titolo della finestra
   `xot::health.title`: `NavigationPageLabelTrait` cerca le chiavi al primo livello
   di `lang/it/health.php`, che le aveva solo sotto `pages.health_check_results`.
   Aggiunte al primo livello in `lang/it/health.php`. `lang/en/health.php` ha lo
   stesso problema e non è stato toccato.

6. **Refuso nel testo Impostazioni (corretto).** «Il suo pannello e' quello
   predefinito» in `lang/it/setting.php` (riga 19) è diventato «è».

## Fonti verificate

- Screenshot: `assets/login.webp`, `modules.webp`, `logs.webp`, `caches.webp`,
  `cache-locks.webp`, `sessions.webp`, `health-page.webp`, `setting.webp`,
  `artisan-commands-manager.webp` (aperti e verificati a vista; manifest
  `screenshots.json` con data, HTTP e sha256).
- Codice letto: `app/Filament/Pages/{MainDashboard,HealthPage,SettingPage,EnvPage,ArtisanCommandsManager}.php`,
  `app/Filament/Widgets/EnvWidget.php`,
  `app/Filament/Resources/{ModuleResource,LogResource,CacheResource,CacheLockResource,SessionResource}/Tables/*.php`,
  `User/app/Models/Traits/HasModules.php`, `lang/it/{health,setting,sessions,cache_locks}.php`.
- Route: `php artisan route:list --path=xot/admin` (prefisso `filament.xot::admin.*`).
