---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 19 file oltre target 100.

### `account-deletion.md` — Cancellazione dell'account


# Cancellazione dell'account

`Modules\Gdpr\Actions\Account\DeleteAccountAction` **disattiva** l'utente e **conserva** la prova dei consensi; non cancella ne'
anonimizza nome, email o altri dati personali. Il perche' e' nell'
[ADR](adr/account-deletion-deactivates-and-keeps-proof.md), le invarianti nel [contratto](contracts/delete-account-action.md).

## Come si usa

- **Rotta storica**: `Route::match(['get','post'], '/{lang}/account/delete')`, nome `account.delete`, middleware `auth`
  (`routes/web.php`). POST con `confirm` = `cancella` e `reason` facoltativo (max 1000); risponde con redirect a `/{locale}` e
  flash `gdpr::account.flash.account_deleted`. La vista `resources/views/account/delete.blade.php` usa le chiavi
  `gdpr::account.delete.*`.
- **Uso diretto**: `DeleteAccountAction::

### `admin-panel.md` — Pannello di amministrazione


# Pannello di amministrazione

Pannello `gdpr::admin` (`Providers/Filament/AdminPanelProvider`, estende `XotBasePanelProvider`). Sviluppato su **Filament v5**
(Livewire v4, Schemas) con le basi `XotBase*`: nessuna classe estende direttamente `Filament\*`
(regola e tabella di corrispondenza in `Modules/Xot/docs/xotbase-extension-rules.md`). Un widget Filament si include nelle viste
con `@livewire(\Modules\...\Widget::class)`, non con il tag `<livewire:modulo::widget>`.

## Resource

Ogni resource ha `Pages/{List,Create,Edit}`, `Schemas/{Form,Infolist}` e `Tables/*Table` e restituisce da `getTableColumns()` un
`array<string, Column>`.

| Resource | Modello | Colonne principali | Note |
|---|---|---|---|
| `ConsentResource` | `Consent` | id, `treatment.name`, `subject_id`, date (nascoste di 

### `architecture.md` — Architettura


# Architettura

Misurata sul codice il 2026-11-25: 86 file PHP in `app/`, 45 in `tests/`.

## Mappa di `app/`

| Cartella | Contenuto |
|---|---|
| `Actions/` | Tutta la logica di dominio, Spatie Queueable Action con unico metodo `execute()`. `SaveGdprConsentsAction`, `UpdateGdprConsentsAction`; sottocartelle `Account/` (`DeleteAccountAction`), `Consent/` (`Collect`, `Revoke`, `SaveRegistrationConsentsAction`), `Cookie/` (`GetCookieInventoryAction`), `Registration/` (esito di registrazione), `Validation/` (consensi e dati utente). |
| `Models/` | `Consent`, `Treatment`, `Event` (tabella `gdpr_events`), `Profile`, `BaseModel`, `BaseMorphPivot`, `BasePivot`; `Models/Traits/HasGdpr`; `Models/Policies/*`. |
| `Datas/` | DTO Spatie Data: `GdprData` (flag `cookie_banner_on` dal config tenant `g

### `code-quality.md` — Qualita' del codice e debito noto


# Qualita' del codice e debito noto

## PHPStan

Il livello richiesto dal repository e' il massimo (`laravel/phpstan.neon`: `level: max`, baseline `.neon` disattivata: gli errori si correggono, non si nascondono; lo stesso file e' la fonte se il livello cambia). Le story
[01](stories/01.gdpr-phpstan-fix.story.md), [02](stories/02.gdpr-phpstan-attribute-regression-fix.story.md),
[phpstan-cleanup-gdpr](stories/phpstan-cleanup-gdpr.story.md) e [phpstan-gdpr-fix](stories/phpstan-gdpr-fix.md) sono chiuse
(`done`) e dicono come sono stati azzerati gli errori; [gdpr-sync-phpstan-complete](stories/gdpr-sync-phpstan-complete.story.md)
e' ancora `backlog`.

**Questa pagina non dichiara "0 errori"**: la ricognizione del 2026-11-25 non ha lanciato PHPStan (vietato in quella sessione) e
i vecchi docum

### `consents.md` — Consensi e trattamenti


# Consensi e trattamenti

La regola di fondo (GDPR art. 7 par. 1: il titolare deve poter **dimostrare** il consenso) e' nell'
[ADR sulla prova append-only](adr/consent-proof-is-append-only.md); il comportamento delle Action e' nei
[contratti](contracts/README.md). Qui il modello e come si usa.

## Modello dati

- **`Treatment`** (tabella `treatments`): un trattamento per cui si chiede consenso. Colonne: `name` (unico), `description`,
  `required`, `active`, `weight`, `documentVersion`, `documentUrl`. UUID, soft delete.
- **`Consent`** (tabella `consents`): una scelta di un utente su un trattamento. UUID, soft delete, `user_id` + `user_type`
  (morph: classe dell'utente), `treatment_id`, `type`, `accepted_at` (nullo = rifiuto), `ip_address`, `user_agent`,
  `metadata` (JSON: `document_vers

### `contracts/delete-account-action.md` — DeleteAccountAction


# DeleteAccountAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Account/DeleteAccountAction.php`. Perché disattiva invece di cancellare:
[ADR cancellazione dell'account](../adr/account-deletion-deactivates-and-keeps-proof.md).

## Input

- `__invoke(Request)`: rotta `account.delete` (`Route::match(['get','post'], '/{lang}/account/delete')`, `routes/web.php`), utente
  autenticato, campi `confirm` (deve valere `cancella`) e `reason` (facoltativo, max 1000).
- `execute(BaseUser $user, string $reason = '')`: uso diretto da un'altra Action del progetto ospite.

## Output

- `__invoke`: redirect a `/{locale}` (GET: senza fare nulla; POST: con flash `gdpr::account.flash.account_deleted`).
- `execute`: `void`.

## Invaria

### `contracts/revoke-gdpr-consents-action.md` — RevokeGdprConsentsAction


# RevokeGdprConsentsAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Consent/RevokeGdprConsentsAction.php` (GDPR art. 7 par. 3).

## Input

- L'utente (`Modules\User\Models\BaseUser`).
- Implicito: l'IP della richiesta corrente e l'utente autenticato (`auth()->id()`).

## Output

- Nessuno (`void`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GDPR-REVOKE-INV-1 | Revoca = `UPDATE` di `revoked_at`, `revoked_ip_address`, `updated_by`: nessuna riga viene cancellata (traccia per l'art. 30). | — |

### `contracts/save-gdpr-consents-action.md` — SaveGdprConsentsAction


# SaveGdprConsentsAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/SaveGdprConsentsAction.php`. Perché le righe non si sovrascrivono mai:
[ADR prova del consenso](../adr/consent-proof-is-append-only.md).

## Input

- L'utente registrato (`Modules\User\Models\User`: si leggono solo `id` e classe).
- Le scelte `privacy_accepted`, `terms_accepted`, `marketing_consent` (chiave assente = rifiutato).
- IP e user agent; se mancano, quelli della richiesta corrente.

Chiamata da `Filament/Widgets/Auth/RegisterWidget.php` e `GdprConsentForm.php` (tramite `CollectGdprConsentsAction`) e da
`UpdateGdprConsentsAction`, che delega qui.

## Output

- Nessuno (`void`).


### `conventions.md` — Convenzioni


# Convenzioni

Regole valide per questo modulo, ognuna con il motivo. Le regole generali Laraxot (XotBase, Action, strict types) hanno la loro
documentazione nel modulo Xot; qui solo cio' che cambia o che qui e' gia' costato un guasto.

## Codice

- **Logica = Spatie Queueable Action** in `app/Actions/<Contesto>/<Nome>Action.php`: `use QueueableAction`, unico punto
  d'ingresso pubblico `execute()`, chiamata `app(NomeAction::class)->execute(...)`. Contesti esistenti: `Account`, `Consent`,
  `Cookie`, `Registration`, `Validation`. Non esistono `app/Services/` ne' `app/Support/` e non vanno introdotti; niente
  `*Repository`, niente `new ...Action` inline nei parametri di default. Un'Action non fa da proxy a una relazione Eloquent
  gia' esistente sul modello o sul trait.
- **Classi Filamen

### `cookie-banner.md` — Banner cookie, inventario e terze parti


# Banner cookie, inventario e terze parti

Il banner e' del pacchetto `statikbe/laravel-cookie-consent`, ma traduzioni, vista e iniezione sono del modulo (decisione in
[ADR](adr/cookie-banner-wired-by-the-module.md)). Norma di riferimento: D.Lgs. 196/2003 art. 122 e Linee guida cookie del
Garante (provv. 10.6.2021 n. 231): per i soli cookie tecnici basta l'informativa; i cookie analitici e di marketing richiedono
consenso preventivo, raccolto con "Accetta" e "Rifiuta" di pari peso, senza caselle preselezionate e senza blocco della navigazione.

## Come e' cablato (`GdprServiceProvider::boot()`)

1. **Traduzioni** `cookie-consent::texts.*`: il provider le ricarica in `app->booted()` con `Translator::addLines` per `it`, `en`,
   `de`, `es` da `lang/cookie-consent/<lingua>/texts.php`. Per le

### `data-subject-rights.md` — Diritti dell'interessato, conservazione e accountability


# Diritti dell'interessato, conservazione e accountability

Stato verificato sul codice il 2026-11-25. Il modulo da' gli **strumenti** (tabelle, Action, campi di configurazione); le
decisioni (periodi di conservazione, destino dei contenuti pubblicati, nomina del DPO) sono del titolare e le story
le tengono aperte: DCP-140 `ready-for-dev`, DCP-141 `needs-decision`, DCP-142 `needs-data`.

## Matrice per diritto

| Diritto | Stato | Dove |
|---|---|---|
| Informativa (artt. 12-14) | pagina del progetto ospite; il modulo fornisce solo i link nei consensi | [registration.md](registration.md) |
| Consenso e prova (art. 7) | **fatto** | [consents.md](consents.md) |
| Revoca (art. 7 par. 3, art. 21) | **fatto**, tutti i consensi insieme; nessuna revoca per singolo trattamento | `RevokeGdprConsen

### `database.md` — Database, migrazioni, factory e seeder


# Database, migrazioni, factory e seeder

## Tabelle

Connessione `gdpr` (`BaseModel`). Le migrazioni estendono `XotBaseMigration` (`tableCreate()` + `tableUpdate()`, solo aggiunte
idempotenti con `hasColumn()`).

| Tabella | Modello | Colonne |
|---|---|---|
| `treatments` | `Treatment` | `id` uuid, `active`, `required`, `name` (unico), `description`, `documentVersion`, `documentUrl`, `weight`, timestamp + soft delete |
| `consents` | `Consent` | `id` uuid, `treatment_id` (uuid, nullable), `subject_id` (string, nullable), morph `user` (`user_id` string + `user_type`), `type`, `accepted_at`, `ip_address` (45), `user_agent`, `metadata` json, `revoked_at` (indicizzata), `revoked_ip_address`, `created_by`/`updated_by`, timestamp + soft delete |
| `gdpr_events` | `Event` | `id` uuid, `treatme

### `phpstan.md` — phpstan


See canonical documentation: ../../../Themes/docs/shared-components/phpstan-report.txt

### `registration.md` — Registrazione con consensi


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
   `email` con i secondi 

### `roadmap.md` — Cosa resta da fare


# Cosa resta da fare

Solo lavoro **tracciato da una story o da un debito verificato sul codice**: niente funzioni ipotetiche (backup, data export
automatico, PDF di report, "compliance score") che le vecchie roadmap elencavano senza codice ne' story. Lo stato delle
story e' quello del campo `status` nel loro frontmatter al 2026-11-25.

## Ordine proposto

| # | Intervento | Perche' prima | Fonte | Stato |
|---|---|---|---|---|
| 1 | Cancellazione con anonimizzazione, export dei dati, registro delle richieste (art. 12, 15, 17, 20) | e' il buco legale piu' grande: l'informativa non puo' promettere cio' che il modulo non fa | [DCP-140](stories/dcp-140-diritti-dellinteressato-procedura-e-strumenti.story.md) | `ready-for-dev`, serve la regola scritta sui contenuti pubblicati |
| 2 | Registraz

### `stories/phpstan-cleanup-gdpr.dev.md` — [DEV] PHPStan cleanup — Gdpr


# [DEV] PHPStan cleanup — Gdpr

## Technical Plan

- Nessun cambiamento al codice di produzione
- Distinguere variabili davvero superflue (create solo per effetto) da quelle che indicavano un'asserzione mancante

## Files to Modify

- `tests/Feature/GdprBusinessLogicTest.php`, `tests/Feature/RegisterWidgetTest.php`
- `docs/00-index.md` (write-back)

## Implementation Steps

- [x] Letta `SaveGdprConsentsAction` per confermare la mappatura `terms_accepted -> terms_conditions`
- [x] Tolte le assegnazioni inutili in `GdprBusinessLogicTest`
- [x] Aggiunta l'asserzione sul consenso terms in `RegisterWidgetTest`
- [x] PHPStan + `php -l`


### `stories/phpstan-gdpr-fix.md` — Problema


## Problema
PHPStan errors in Modules/Gdpr

## Solution
1. Analyze with phpstan
2. Fix pattern errors
3. Verify with phpmd + phpinsights + pest
4. Git sync

## Fix applicato — subagent-ai-gdpr-cms (2026-09-10)

- File: `Modules/Gdpr/tests/TestCase.php`
- Errore: `method.notFound` — `setUp()` chiamava `$this->prepareSharedFixcitySqliteForTesting()`,
  metodo mai esistito nel repo (typo/drift rispetto al metodo reale ereditato da
  `Xot\Tests\XotBaseTestCase`).
- Fix: rinominata la call site in `$this->prepareSharedSqliteForTesting()` (metodo reale
  definito in `Modules/Xot/tests/XotBaseTestCase.php:288`), aggiornato anche il commento
  di classe che citava il nome sbagliato.
- Verifica: `cd laravel && ./vendor/bin/phpstan analyse Modules/Gdpr/tests/TestCase.php --no-progress --memory-limi

### `testing.md` — Test


# Test

45 file in `tests/` (verificato 2026-11-25): Pest per i test nuovi, qualche classe PHPUnit storica.

## Come si lanciano

Dalla radice del monorepo, sul database usa-e-getta (clona la sola struttura dai database di sviluppo, nessuna scrittura
sul DB di sviluppo, lo elimina in uscita):

```bash
bash bashscripts/tools/pest-scratch-db.sh Modules/Gdpr/tests/Unit/Providers/CookieConsentWiringTest.php
bash bashscripts/tools/pest-scratch-db.sh Modules/Gdpr/tests
```

Dalla cartella `laravel/`: `vendor/bin/pest Modules/Gdpr/tests --group=<ID>` per le invarianti dei contratti
(es. `--group=GDPR-SAVE-INV-3`, vedi [contracts/README.md](contracts/README.md)). Se `setUp` fallisce con "Unknown database",
si e' osservato che va lanciato con `DB_DATABASE_USER=` vuoto. Mai `RefreshDatabase`, mai `

### `translations.md` — Traduzioni


# Traduzioni

Il modulo usa il namespace `gdpr::` (caricato da `XotBaseServiceProvider`) e il namespace separato `cookie-consent::` (caricato dal
provider, vedi [cookie-banner.md](cookie-banner.md)). Le regole generali (chiavi con prefisso del modulo, mai testo cablato
nell'interfaccia) sono quelle del modulo Lang.

## Cosa c'e' in `lang/`

| Lingua | File |
|---|---|
| `it` (completa) | `account`, `admin_panel_provider`, `consent`, `consents`, `event`, `events`, `gdpr`, `inject_cookie_banner`, `profile`, `profiles`, `register`, `register_widget`, `setting`, `texts`, `treatment`, `treatment_form`, `treatments`, `it.json` |
| `en` | `account`, `consent`, `event`, `gdpr`, `profile`, `register`, `register_widget`, `setting`, `texts`, `treatment`, `en.json` |
| `de` | `account`, `consent`, `e
