---
title: BaseSettingPage, pagina impostazioni riusabile per ogni modulo
status: done
module: Xot (owner)
created: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../../Progressioni/docs/stories/setting-page-config.story.md
  - ../../../Tenant/docs/stories/save-tenant-config-list-replace.story.md
---

# BaseSettingPage, pagina impostazioni riusabile per ogni modulo

## Fase BMAD

Solutioning (decisione architetturale condivisa) e Build. Percorso scelto: il piu' piccolo
che basta (BMAD v7, "Choose a Planning Path"). Niente PRD: un solo modulo consumatore oggi,
ma la decisione vale per tutti, quindi va scritta qui, nel modulo che possiede la base.

## Intento

Ogni modulo deve poter avere una pagina Filament che modifica il proprio file di
configurazione per tenant, visibile solo al super-admin, scrivendo solo il form.

## Requisiti

1. Un modulo crea la pagina con una classe `SettingPage extends BaseSettingPage` e il solo
   `getFormSchema()`.
2. I valori letti e salvati passano da una classe Spatie Data del modulo:
   `Modules\{Modulo}\Datas\{Modulo}ConfigData`. La Data tiene i default e i tipi.
3. Il file scritto e' quello del tenant: `config/{tenant}/{modulo}.php`, tramite
   `SaveTenantConfigAction`. Mai `config/{modulo}.php` della base, che vale per tutti i
   tenant.
4. Accesso: solo `super-admin`. `canAccess()` false nasconde anche la voce di menu.
5. Nessuna stringa italiana nel codice: notifica e etichette vengono dai file `lang`.

## Vincoli

- Non toccare le pagine esistenti che fanno lo stesso a mano (`MetatagPage`,
  `SocialiteProviderSettingsPage`): migrarle e' lavoro separato, vedi "Fuori scope".
- La pagina non deve leggere `config()`: con `config:cache` attivo (in produzione lo e',
  `bootstrap/cache/config.php`) un file appena scritto non si vede fino al prossimo
  `config:cache`. Si legge il file del tenant con `GetTenantConfigArrayAction`, come fanno
  gia' `XotData` e `MetatagData`.

## Decisioni

| Decisione | Perche' |
|-----------|---------|
| Convenzione per nome, override possibile | `getConfigName()` = nome modulo minuscolo, `getConfigDataClass()` = `{Modulo}ConfigData`. Il modulo che segue la convenzione non scrive nulla; chi non la segue sovrascrive un metodo. |
| La Data e' il filtro di quello che si salva | `save()` fa `Data::from($state)->toArray()`: tipi e normalizzazione stanno nella Data, non nella pagina. Chiavi non previste dal form non entrano. |
| Merge con il file esistente | `SaveTenantConfigAction` fonde: chiavi scritte a mano nel file del tenant e non gestite dalla pagina restano. |
| Super-admin via `UserContract::hasRole('super-admin')` | Stesso controllo gia' usato in `ListCondizioniLavoros` e `AuthorizeLogAccessAction`. `UserContract` non dichiara `isSuperAdmin()`. |
| Vista unica `xot::filament.pages.base-setting` | Form + azioni. I moduli non creano viste. |
| Slug `setting` | URL uguale in ogni pannello: `/{modulo}/admin/setting`. Il default Filament sarebbe `setting-page`. |
| Dopo `save()`: `dispatch('refresh-sidebar')` e `dispatch('refresh-topbar')` | Sidebar e topbar di Filament sono componenti Livewire separati (`Filament\Livewire\Sidebar`, `Topbar`, ascoltano questi eventi). Il salvataggio e' una richiesta Livewire che ridisegna solo la pagina: un'impostazione che cambia il menu restava visibile fino al cambio pagina. Bug visto il 2026-10-28 con un WorkerType spento in Progressioni. Sta nella base: vale per ogni impostazione di ogni modulo. |
| Stato del form da `getConfigState()` | Una sola lettura, usata da `mount()` e dopo `save()`: dopo il salvataggio il form mostra quello che e' davvero nel file (normalizzato e fuso). |

## File

- `app/Filament/Pages/BaseSettingPage.php`
- `resources/views/filament/pages/base-setting.blade.php`
- `lang/it/base_setting.php`, `lang/en/base_setting.php`
- Test: `tests/Unit/Filament/Pages/BaseSettingPageAccessTest.php` (usa una pagina anonima: Xot non dipende dai moduli foglia)

## Lezione

Un gate di navigazione (`shouldRegisterNavigation`) corretto lato server non basta: va
verificato anche il momento in cui la sidebar viene ridisegnata. Con `->spa()` e azioni
Livewire, la sidebar resta quella del caricamento della pagina.

## Fuori scope

- Migrare `MetatagPage` (fa gia' lo stesso a mano, 100 righe) e
  `SocialiteProviderSettingsPage` (450 righe, scrive in `storage/` per proteggere i secret: non
  e' lo stesso caso, resta com'e').

## Verifica

- PHPStan livello 10 sui file toccati: 0 errori. Nota: `laravel/phpstan-bootstrap.php` (stub
  di una riga richiesto da `phpstan.neon`) e' stato cancellato dal commit `9bf7ec3fed`; senza,
  PHPStan non parte. Per l'analisi e' stato ricreato e poi tolto: va ripristinato o tolto da
  `phpstan.neon` (decisione dell'utente, `phpstan.neon` non si tocca).
- Pint: ok.
- Smoke in sola lettura su 10.100.200.15: rotta `progressioni/admin/setting` registrata; render
  come super-admin con i valori del file; `canAccess()` falso per un utente senza
  `super-admin`. Nessun salvataggio eseguito (regola: niente smoke in scrittura in produzione).
- Pest: **saltato**, macchina 10.100.200.15 = produzione. I test sono scritti e vanno lanciati su
  un ambiente di sviluppo.
