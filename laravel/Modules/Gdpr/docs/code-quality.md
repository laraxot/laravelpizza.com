---
title: "Qualita' del codice e debito noto"
type: status
module: Gdpr
updated: 2026-11-25
---

# Qualita' del codice e debito noto

## PHPStan

Il livello richiesto dal repository e' il massimo (`laravel/phpstan.neon`: `level: max`, baseline `.neon` disattivata: gli errori si correggono, non si nascondono; lo stesso file e' la fonte se il livello cambia). Le story
[01](stories/01.gdpr-phpstan-fix.story.md), [02](stories/02.gdpr-phpstan-attribute-regression-fix.story.md),
[phpstan-cleanup-gdpr](stories/phpstan-cleanup-gdpr.story.md) e [phpstan-gdpr-fix](stories/phpstan-gdpr-fix.md) sono chiuse
(`done`) e dicono come sono stati azzerati gli errori; [gdpr-sync-phpstan-complete](stories/gdpr-sync-phpstan-complete.story.md)
e' ancora `backlog`.

**Questa pagina non dichiara "0 errori"**: la ricognizione del 2026-11-25 non ha lanciato PHPStan (vietato in quella sessione) e
i vecchi documenti che lo affermavano indicavano due livelli diversi (9 e 10) senza data. Prima di dirlo: `./vendor/bin/phpstan
analyse Modules/Gdpr` da `laravel/`, e registrare l'esito nella story che si chiude.

Uso di `mixed` nel codice (grep del 2026-11-25): 14 righe in 9 file (`RegisterWidget` 3, `Profile` 2, `HasGdpr` 2,
`ValidateUserDataAction` 2, e una ciascuno in `GdprConsentForm`, `InjectCookieBanner`, `Consent`, `GdprData`,
`SaveRegistrationConsentsAction`). La riduzione e' tracciata in
[gdpr-mixed-type-reduction](stories/gdpr-mixed-type-reduction.story.md); la politica `mixed` e' [l'ADR 0015 del modulo Xot](../../Xot/docs/adr/0015-mixed-solo-come-ultima-spiaggia.md). Mai
introdurre una baseline per nascondere errori.

Regole di scrittura utili per non reintrodurre errori: `getTableColumns()` restituisce `array<string, Column>`; i `$model` delle
tabelle sono dichiarati ([audit](stories/xotbaseresourcetable-model-audit-gdpr-batch.story.md)); gli attributi PHP (`#[Override]`)
non si perdono nei merge ([story 02](stories/02.gdpr-phpstan-attribute-regression-fix.story.md)).

## Test

Vedi [testing.md](testing.md): 45 file; debito su `DeleteAccountAction` e `RevokeGdprConsentsAction`.

## Debito noto, per gravita'

| Gravita' | Cosa | Dove |
|---|---|---|
| Alta | `consents` modificabile dal pannello: la prova non e' protetta dal database | [admin-panel.md](admin-panel.md) |
| Alta | Transazione su `user` che deve coprire scritture su `gdpr`: ok solo se stesso database | [architecture.md](architecture.md) |
| Alta | Cancellazione non anonimizza, nessun export, nessun registro richieste | [data-subject-rights.md](data-subject-rights.md) |
| Media | `ConsentResource` e `ProfileResource` duplicati tra standalone e cluster | [admin-panel.md](admin-panel.md) |
| Media | `GdprConsentForm` e `RegisterWidget` sono due varianti della stessa superficie: tenerne una | [registration.md](registration.md) |
| Media | `SaveRegistrationConsentsAction` salta in silenzio i trattamenti mancanti; listener senza chi lo dispatchi | [consents.md](consents.md) |
| Media | `config/config.php` contiene valori non letti da nessun codice | [architecture.md](architecture.md) |
| Bassa | I link legali del form di registrazione sono `url('/'.app()->getLocale().'/privacy')`/`'/terms'`, non `LaravelLocalization::localizeUrl()` come chiede la regola del repository | [registration.md](registration.md) |
| Bassa | Piu' file `create_consents_table`/`create_treatments_table` per una tabella | [database.md](database.md) |
| Bassa | Traduzioni `fr`/`ru`/`es` incomplete, banner senza `fr`/`ru` | [translations.md](translations.md) |
| Bassa | Commenti `moved into Gdpr` nel provider del pannello `User` descrivono uno spostamento mai avvenuto | [registration.md](registration.md) |

## Come si controlla prima di dire "fatto"

PHPStan sul modulo, Pint, Pest del modulo ([testing.md](testing.md)), `python3
bashscripts/tools/docs/check-php-docs-refs.py --module Gdpr` (nessun `@see` o `@contract` rotto) e verifica che nessun
file contenga marcatori di conflitto (`grep -rlE '^(<<<<<<<|>>>>>>>)( |$)' app tests config database lang resources routes docs`).
Un mirror automatico ha gia' riportato indietro il provider e le migrazioni: dopo ogni sincronizzazione rileggere
`GdprServiceProvider` e lanciare `CookieConsentWiringTest` ([cookie-banner.md](cookie-banner.md)).
