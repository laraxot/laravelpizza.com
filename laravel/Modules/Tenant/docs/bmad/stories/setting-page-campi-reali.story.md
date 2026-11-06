---
title: "SettingPage di Tenant: l'identita' del tenant nel file metatag"
status: done
module: Tenant
type: story
qmd: "Tenant SettingPage metatag TenantConfigData title logo_height MetatagData ApplyMetatagToPanelAction"
related:
  - ../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md
  - ./setting-page.story.md
---

# SettingPage di Tenant: l'identita' del tenant nel file metatag

## Fase BMAD

Build, dentro la story madre di Xot [setting-page-campi-reali](../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md).
Sostituisce [setting-page](./setting-page.story.md) (form vuoto, poi tre campi senza lettore). Richiesta dell'utente
(testuale): "nei SettingPage il metodo getFormSchema non puo restituire [] in ogni modulo c'e' qualcosa da settare".

## Cosa si configura davvero

| Campo | Default | Chi lo legge | Decisione |
|-------|---------|--------------|-----------|
| `title` | `''` (come `MetatagData`) | `MetatagData::getBrandName()`: `ApplyMetatagToPanelAction` (nome del brand di ogni pannello Filament, chiamata da `XotBasePanelProvider` e `XotBaseMainPanelProvider`), `Cms\Head::resolveBrand()` (dopo la traduzione del tema), `BuildPageSchemaAction` | TextInput obbligatorio |
| `logo_height` | `'2em'` (come `MetatagData`) | `MetatagData::getBrandLogoHeight()`: `ApplyMetatagToPanelAction` (`brandLogoHeight`) | TextInput con lunghezza CSS semplice (`\d{1,3}(\.\d{1,2})?(px\|em\|rem)`) |

Il file e' `config/{tenant}/metatag.php`, quello che `MetatagData::make()` (Xot) legge con `GetTenantConfigArrayAction`. Per questo
`TenantConfigData::tenantConfigName()` ritorna `metatag` e la pagina ne ripete il valore in `getConfigName()`: un `tenant.php`
non lo leggerebbe nessuno. Il merge di `SaveTenantConfigAction` conserva le altre chiavi del file.

Deviazione dal contratto, dichiarata: il lettore vivo e' `MetatagData` di Xot e non `TenantConfigData::make()`, e Xot non e'
modificabile da questa story. I default sono quindi due (Data e `MetatagData`); un test li confronta (`MetatagData::from([])`),
cosi' non possono divergere in silenzio.

## Lasciato fuori

- `enabled`, `domain_routing`, `default_locale` (bozza di Codex): nessun lettore in tutto il repository. Un interruttore su
  risoluzione del tenant o instradamento per dominio sarebbe un'arma contro se stessi: il tenant si sceglie da `SERVER_NAME` e dalle
  cartelle di `config/` (`GetTenantNameAction`, in `LoadConfiguration`, prima che qualunque file di impostazioni esista), quindi un valore
  scritto qui non potrebbe nemmeno spegnerla, ma farebbe credere che si possa. Un test impedisce che compaiano di nuovo.
- `description`: `MetatagData::make()` la sostituisce con la traduzione `metatag.description` del tenant
  (`config/{tenant}/lang/{lingua}/metatag.php`), quindi un valore nel file non viene mai letto. Il solo altro lettore e' la vista RSS di
  Xot, che nessuna rotta usa.
- `sitename`, `subtitle`, `keywords`, `author` (previsti dalla matrice di Xot): li leggono solo `cms::components.metatags` e
  `ui::metatags` (`ThemeComposer::metatags()`), che nessun layout di questo repository include. Un progetto che li usa li legge dal
  file a mano: nessuna regressione.
- `logo_header`, `logo_header_dark`, `favicon`: hanno un lettore vivo, ma sono percorsi che `AssetAction` risolve e copia in `public/`
  senza protezione da `..`. Come testo libero sarebbero una superficie di scrittura (anche se solo per il super-admin). Servirebbe una
  Select di asset noti.
- `colors`: li modifica gia' la `MetatagPage` di Xot; un esadecimale sbagliato colpisce ogni pannello. Nota per Xot: quella pagina e
  questa scrivono nello stesso file e il merge le tiene compatibili, ma sono due interfacce per `metatag`.
- Dati dell'ente (`GetEnteDataAction`, `config('ente')`): sono l'impostazione di tenant piu' sensata del modulo, ma in questo repository
  nessun layout li legge (il footer che li usa sta nei progetti consumatori). Senza un lettore verificabile qui non entrano.

## Verifica

- Pest `Modules/Tenant/tests/Unit/Datas/TenantConfigDataTest.php`: 19 test, 39 asserzioni (default uguali a `MetatagData`, valore del file
  del tenant, il valore arriva a `MetatagData::getBrandName()`/`getBrandLogoHeight()` e al `Panel` tramite `ApplyMetatagToPanelAction`,
  campi = proprieta', nessun interruttore sul tenant, schema della lunghezza CSS e regola di validazione reale, etichette it/en).
- L'intera suite Tenant ha 15 fallimenti che non toccano questi file (`GetTenantNameActionTest`, `GetEnteDataActionTest`,
  `ApplicationPublicPathCoverageTest`, fixture `SushiToJson*` che non hanno piu' i metodi privati che i test riflettono, `config/local/fixcity`
  assente): 210 passati.
- PHPStan livello max sui file toccati: 0 errori. Pint: passed.
- Non verificato: il rendering del form nel pannello (nessun browser). Il test controlla schema, chiavi, etichette e regole.

## Regressione dal pull del 2026-11-05

Il commit `.` `697c93ad` del modulo (2026-11-05 06:50 UTC) ha riscritto solo `TenantConfigData` con la bozza scartata (`enabled`,
`domain_routing`, `default_locale`, file `tenant.php`), lasciando `SettingPage` e il test sulla versione `metatag`: il HEAD del modulo
era incoerente (`getConfigName()` avrebbe dato `tenant`, default del trait `MakesFromTenantConfig`). Nel rebase del mono
(`335a04e8a8 pull submodules` su `ba49a440`) il file era in conflitto add/add: risolto con il lato upstream del mono, identico a
`982440f0`. Verifica: `TenantConfigDataTest` 19/19, PHPStan 0 errori sui file. Da committare anche nel repo del modulo (Tenant risulta
`M app/Datas/TenantConfigData.php`), altrimenti il prossimo pull lo riporta indietro.
