---
title: "SettingPage nei 5 moduli di Trade che non l'hanno: AI, Cms, Gdpr, Seo, Trade"
status: in-progress
module: Xot (guardia), AI, Cms, Gdpr, Seo, Trade
type: story
qmd: "SettingPage ogni modulo AI Cms Gdpr Seo Trade BaseSettingPage ConfigData guardia EveryModuleHasSettingPageTest"
related:
  - ./setting-page-tutti-i-moduli.story.md
  - ../../stories/module-setting-pages.epic.md
  - ../../../../Tenant/docs/bmad/stories/tenant-service-removed-config-reference.story.md
---

# SettingPage nei 5 moduli di Trade che non l'hanno

## Fase BMAD

Build. Richiesta dell'utente: ogni modulo deve avere sempre `app/Filament/Pages/SettingPage.php`.

## Perche' (ricostruito dal second brain e dal codice)

La story `setting-page-tutti-i-moduli` ha gia' deciso la regola: la pagina Impostazioni sta in tutti i moduli,
anche senza campi. `BaseSettingPage` richiede `Modules\{Modulo}\Datas\{Modulo}ConfigData` (altrimenti
`getConfigDataClass()` fa `Assert::notNull` e la pagina va in errore al primo `mount()`), quindi la pagina vuota
e' pronta a ricevere il primo campo senza rifare la struttura. La guardia
`Xot/tests/Unit/Filament/Pages/EveryModuleHasSettingPageTest.php` enumera da sola i moduli con `app/`.

Stato verificato: 9 moduli su 14 hanno gia' il pattern (Activity, Job, Lang, Media, Notify, Tenant, UI, User, Xot).
Mancano AI, Cms, Gdpr, Seo, Trade: sono i moduli propri di questo repo, creati dopo la story originale.
`graphify-out` in `Modules/` non e' un modulo (nessun `app/`).

## Requisiti

Per ciascuno dei 5 moduli, come in Activity:

1. `app/Datas/{Modulo}ConfigData.php`: nessuna proprieta', solo `MakesFromTenantConfig`.
2. `app/Filament/Pages/SettingPage.php`: estende `BaseSettingPage`, `getFormSchema()` vuoto.
3. `lang/it/setting.php` e `lang/en/setting.php` (navigazione, titolo, azioni).
4. Test della Data nel modulo.

Nessun segreto esposto. Nessun default inventato: un campo si aggiunge solo quando un valore cambia davvero.

## Casi particolari

- AI ha gia' `lang/it/setting.php` con una chiave `fields.version` generata in automatico: va unito, non
  sovrascritto.
- Trade ha gia' `SettingsPage` (plurale, slug `settings`) con il wizard degli account exchange, lavoro attivo
  dell'utente: non si tocca. La nuova `SettingPage` (singolare, slug `setting`) e' la pagina di config tenant;
  la label di navigazione e' distinta per non avere due voci "Impostazioni" nel pannello.
- Seo non ha `AdminPanelProvider`: la classe esiste (richiesta della guardia) ma non compare in un menu finche'
  il modulo non ha un pannello. Non e' compito di questa story crearlo.

## Verifica

- RED: guardia filtrata sui 5 moduli fallisce per file mancanti.
- GREEN: stessa guardia, 20 casi passano.
- Pest dei test nuovi, PHPStan livello max sui file nuovi, Pint.

## Blocchi d'ambiente trovati e risolti (agente claude)

Senza questi tre punti nessun test e nessun `artisan` partiva in questo checkout, quindi nessun gate era
verificabile.

1. `config/local/trade/modules.php` referenziava `TenantService` rimosso: risolto, vedi la story Tenant
   collegata.
2. `config/localhost/xra.php` (tenant dei test, perche' `.env.testing` ha `APP_URL=http://localhost`) dichiarava
   `pub_theme => 'BsItalia'`, tema che in questo repo non esiste (c'e' solo `Four`): ora `Four`.
   Resta da verificare `adm_theme => 'AdminLTE'` (anch'esso assente) in `config/localhost/xra.php` e nel
   `config/xra.php` globale, che ha ancora `pub_theme => 'BsItalia'`.
3. `TestDatabaseGuard` (salvaguardia dei dati sacri, non si tocca) rifiuta il boot perche' `config/database.php`
   legge `DB_DATABASE` sia per `sqlite` sia per `mysql`, e `.env.testing` mette in `DB_DATABASE` il path del file
   sqlite: la connessione `mysql` sembra puntare a un DB non `_test`. Per far partire Pest basta un override del
   solo processo, senza modificare ne' la guardia ne' `.env.testing`:
   `DB_DATABASE=trade_test ./vendor/bin/pest --test-directory=Modules/<Mod>/tests ...`
   (`TestCase::setUp()` riassegna comunque ogni connessione sqlite al file condiviso). Fix duraturo da decidere
   con l'utente: il repo gemello usa MySQL `*_test`, questo sqlite.

## Coordinamento con altri agenti

- Agente `codex`, task `SettingPage-every-module-and-phpstan-remediation`, ha i lock (17:27 UTC del 2026-11-04) su
  `SettingPage.php`, `{Modulo}ConfigData.php` e `lang/{it,en}/setting.php` di AI, Cms, Gdpr, Seo, Trade.
  Questi file sono suoi: claude non li modifica.
- Nota per codex, verificata con `php -l`: i file PHP di Cms, Gdpr, Seo e Trade (SettingPage e ConfigData)
  hanno `namespace Modules\\Gdpr\\Filament\\Pages;` con backslash raddoppiati e non si caricano (ParseError alla
  riga 5). Quelli di AI sono a posto. Finche' restano cosi' rompono il boot dei pannelli Filament e quindi anche
  Pest e PHPStan di tutti.
- Divisione proposta: codex chiude i 20 file e la guardia verde; claude verifica in modo indipendente (lint,
  guardia, PHPStan sui file nuovi) e prende la campagna PHPStan sui moduli non toccati da codex, con lock per
  file e moduli in ordine casuale.
