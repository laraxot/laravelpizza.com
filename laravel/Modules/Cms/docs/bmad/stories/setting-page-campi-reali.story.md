---
title: "SettingPage di Cms: il tema del sito pubblico"
status: done
module: Cms
type: story
qmd: "Cms SettingPage tema pub_theme xra ConfigData Select temi installati"
related:
  - ../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md
---

# SettingPage di Cms: il tema del sito pubblico

## Fase BMAD

Build, dentro la story madre di Xot [setting-page-campi-reali](../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md).
Richiesta dell'utente (testuale): "nei SettingPage il metodo getFormSchema non puo restituire [] in ogni modulo c'e'
qualcosa da settare.. per esempio nel cms potevi configurare quale tema utilizzare".

## Cosa si configura davvero

| Campo | Default | Chi lo legge | Decisione |
|-------|---------|--------------|-----------|
| `pub_theme` | `''` (nessun default oggi: `XotData::$pub_theme` e' obbligatorio) | `XotData::make()->pub_theme`, usato da `CmsServiceProvider` e dai percorsi di viste e asset di `XotData` | Select dei temi installati |
| `register_pub_theme` | `false` (come `XotData`) | `CmsServiceProvider::register()` e `boot()` | Toggle |

Entrambi vivono nel file `xra` del tenant, quello che `XotData` legge. Un `cms.php` non avrebbe cambiato il tema
effettivo: per questo `CmsConfigData::tenantConfigName()` ritorna `xra` e la pagina ne ripete il valore in
`getConfigName()`. Il merge di `SaveTenantConfigAction` conserva le altre chiavi del file.

## Lasciato fuori

- `adm_theme`: nessuno chiama `registerNamespaces('adm_theme')` e `register_adm_theme` non ha lettori; le due Action che
  costruiscono nomi `adm_theme::` (`GetStyleClassAction`, `GetViewThemeByViewAction`) non hanno chiamanti. Il valore del
  tenant locale (`AdminLTE`) non corrisponde a nessun tema installato: una Select lo avrebbe rifiutato al primo salvataggio.
- `disable_frontend_dynamic_route`: l'unico lettore e' la proprieta' di `XotData`, nessun codice la consulta.
- `page_middleware_allowlist` e `container0_models`: superficie di sicurezza, restano nel config del modulo.

## Perche' una Select e non un campo di testo

Un tema inesistente fa cercare viste in `Themes/<nome>/resources/views` che non c'e'. `ListInstalledThemesAction`
elenca le cartelle di `Themes/` con `resources/views` (esclude `Themes/public`), quindi il form non puo salvare un
nome che rompa il boot.

## Verifica

- Pest `Modules/Cms/tests/Unit/Datas/CmsConfigDataTest.php`: 5 test, 11 asserzioni. RED prima (4 falliti, classi
  mancanti), GREEN dopo. Cartella `tests/Unit/Datas` intera: 52 passati.
- PHPStan livello max sui 4 file toccati: 0 errori. Pint: passed.
- Prova del funzionamento: il test confronta le chiavi dello schema con le proprieta' pubbliche della Data e controlla che
  `Four` sia installato e `public`/`AdminLTE` no.

## Coordinamento

Il batch di Codex del 2026-11-04 (20:31) aveva messo `pub_theme` e `adm_theme` come campi di testo anche nella
SettingPage di Xot. Il tema pubblico ha un solo proprietario, Cms; Xot tiene i flag di `xra` che non sono temi.
