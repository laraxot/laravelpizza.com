---
title: "Tenant, configurazione e risoluzione del tema pubblico"
type: reference
status: active
theme: Meetup
qmd: "tenant config path local laravelpizza pub_theme xra namespace risoluzione tema getTenantNameAction reverse domain view cache"
---

# Tenant, configurazione e risoluzione del tema pubblico

## Perche' esiste

Il tema pubblico non e' scritto nel codice: si ricava dal **tenant**, cioe' dal dominio. Chi non conosce la catena cerca i JSON
nella cartella sbagliata, modifica il tema sbagliato o non capisce perche' `pub_theme::...` non si risolve. Questa pagina
tiene insieme dominio -> cartella di config -> `pub_theme` -> cartella del tema -> namespace delle view.

## La catena

1. **Dominio**: `.env` ha `APP_URL=http://laravelpizza.local`. Su web conta l'host della richiesta; in console, code e scheduler
   conta `APP_URL` (cosi' un job lavora con la stessa configurazione della richiesta che lo ha creato).
2. **Cartella tenant**: il modulo Tenant (`GetTenantNameAction`) inverte le parti del dominio: `laravelpizza.local` ->
   `['local','laravelpizza']` -> `local/laravelpizza` -> `laravel/config/local/laravelpizza/`.
3. **`config/local/laravelpizza/xra.php`**: la chiave `pub_theme` (qui `'Meetup'`) dice quale tema pubblico usare.
4. **Tema**: `laravel/Themes/Meetup`. Le view sono sotto il namespace `pub_theme::` (anche `meetup::`), le traduzioni sotto
   `pub_theme::`.

`XotData::make()->pub_theme` espone il tema attivo (`XotData::make()` legge `xra` del tenant con `GetTenantConfigArrayAction`);
`getPubThemeViewPath('pages')` restituisce `Themes/<tema>/resources/views/pages`.

Regola: i percorsi e i nomi dei temi non si scrivono a mano nel codice; si derivano da `XotData` o dal namespace `pub_theme::`.
Cambiando `APP_URL`, host o tenant puo' cambiare anche il tema.

## Perche' il dominio e' invertito

La gerarchia va dal generale allo specifico: `config/{ambiente}/{tenant}/`. Lo stesso tenant convive su piu' ambienti
(`config/local/laravelpizza`, un domani `config/com/laravelpizza`) e lo stesso ambiente ospita piu' tenant (nel repo:
`local/laravelpizza` e `local/pizza`). Non c'e' una tabella di mapping: il filesystem e' la mappa. Il percorso
**`config/laravelpizza.local/` e' sbagliato**: non e' mai letto, una copia li' e' un residuo da eliminare.

Regole di `GetTenantNameAction` (verificate sul codice):

- toglie `www.`, slugga ogni parte, le inverte, e verifica che la cartella esista in `config/`;
- se il dominio ha tre o piu' parti e la cartella non esiste, riprova senza la parte piu' specifica (un sottodominio ricade
  sul tenant del dominio padre: `foo.laravelpizza.local` -> `local/laravelpizza`);
- se l'host e' un symlink verso un'altra cartella di config, usa il percorso reale (la chiave di config e' quella reale);
- con `SERVER_NAME` pari a `127.0.0.1`, `::1` o `localhost` (tipico di `php artisan serve` e dei proxy) legge l'header `Host`;
  in console non c'e' richiesta, quindi `APP_URL`;
- se nessuna cartella corrisponde, il tenant e' `localhost` (`config/localhost/`) e le pagine CMS rispondono 404.

Nel repo esistono `config/local/laravelpizza/`, `config/local/pizza/`, `config/localhost/`: un ambiente con un dominio diverso
(staging, produzione) ha bisogno della sua cartella o di un symlink verso quella locale.

## Cosa contiene la cartella del tenant

```
config/local/laravelpizza/
  xra.php, xot.php, app.php, database.php, auth.php, seo.php, metatag.php, middleware.php, modules.php, ...   override per gruppo
  database/content/pages/*.json, pages/events/, pages/profile/   pagine del CMS (git)
  database/content/sections/{header,footer}.json                 sezioni
  database/content/page_contents/*.json, pages.json              altri contenuti del CMS
  lang/                                                          traduzioni specifiche del tenant
```

- **Override**: `ResolveTenantConfigValueAction` carica la config base (`config/app.php`), cerca quella del tenant
  (`local.laravelpizza.app`) e le unisce con `array_replace_recursive`: il tenant vince, si scrive solo la differenza.
  Il risultato viene riscritto con `Config::set()`, quindi le successive chiamate `config()` della stessa richiesta vedono i
  valori del tenant. Dopo aver cambiato un file: `php artisan config:clear`.
- **Contenuti JSON**: sono dati del sito, versionati in git insieme alla config. Durante i test vengono letti da una copia
  usa-e-getta in `storage/framework/testing/tenant-content/` (un test non deve riscrivere i file del repo).
- Le connessioni database per modulo non si scrivono qui: le aggiunge `TenantServiceProvider` ([regola di progetto](theme-rules.md)).

### Chiavi di `xra.php` che riguardano il tema

| Chiave | Valore in laravelpizza | Effetto |
|---|---|---|
| `pub_theme` | `Meetup` | tema pubblico |
| `register_pub_theme` | `true` | se `false` il Cms non registra namespace e view del tema |
| `main_module` | `Meetup` | modulo di dominio principale |
| `primary_lang` | `it` | lingua di default |
| `post_login_path` | `/events/my` | pagina dopo login e registrazione |
| `gravatar` | `false` | niente richieste a terzi per gli avatar (iniziali al posto della foto) |
| `contact_email` | `env('CONTACT_EMAIL')` | casella dei messaggi del modulo Contatti |
| `disable_frontend_dynamic_route` | `false` | rotte dinamiche del front office attive |

## Dal nome del tema alle view

Due provider registrano lo stesso tema (e' voluto, non un doppione da togliere):

- `Modules\Cms\Providers\CmsServiceProvider` (solo se `register_pub_theme`): aggiunge il namespace di view `pub_theme` su
  `Themes/<tema>/resources/views`, carica le traduzioni da `Themes/<tema>/lang` sotto `pub_theme`, **antepone** la cartella
  delle view del tema a `view.paths` (una view senza namespace, come `filament.widgets.auth.register`, si risolve prima nel tema),
  imposta `livewire.view_path` e `livewire.class_namespace` sul tema e registra i componenti anonimi (sotto).
- `Themes\Meetup\Providers\ThemeServiceProvider` (dichiarato in `composer.json` del tema): `loadViewsFrom` per `pub_theme` e
  `meetup`, `loadTranslationsFrom` per `pub_theme`, piu' la rotta `events.book`.

`theme.json` del tema (`name: Meetup`, `type: pub`, `aliases: ["meetup"]`) descrive il tema al Cms.

### Componenti Blade anonimi: due sintassi

`Blade::anonymousComponentPath()` e' registrato sulla cartella `components/` del tema **due volte**: senza prefisso e con il
prefisso `pub_theme`.

```blade
<x-layouts.app> ... </x-layouts.app>          {{-- senza prefisso: components/layouts/app.blade.php --}}
<x-pub_theme::ui.accordion> ... </x-pub_theme::ui.accordion>   {{-- con prefisso: components/ui/accordion.blade.php --}}
```

- Il percorso e' **relativo a `components/`**: `<x-pub_theme::layouts.main>` e' giusto, `<x-pub_theme::components.layouts.main>` no
  (e' l'errore classico: "Unable to locate a class or view for component [pub_theme::components.layouts.main]"; lo stesso errore
  faceva fallire `php artisan view:cache` con `[pub_theme::ui.logo]` quando il prefisso non era registrato correttamente).
- Senza prefisso, un componente omonimo di un modulo registrato prima puo' vincere su quello del tema (e' il caso di
  `layouts.guest` del modulo UI). Se un nome e' ambiguo, usare il prefisso `pub_theme::`.
- `@include('pub_theme::components.blocks.hero.main')` e i `data.view` dei JSON usano invece il nome completo della view,
  con `components.` incluso.

## Nuovo tenant o nuovo tema

1. Tenant: copiare `config/local/laravelpizza/` in `config/{ambiente}/{tenant}/` e adattare `xra.php`, contenuti e lingua.
2. Tema: creare `Themes/<Nome>/` con `theme.json`, `composer.json` (provider), `resources/views`, `lang`, `package.json`; impostare
   `'pub_theme' => '<Nome>'`.
3. Asset: `public_html/themes/<Nome>` e' un symlink relativo a `../../laravel/Themes/<Nome>/public`, tracciato da git; mai copie
   ([assets-and-build](assets-and-build.md)). Guardia: `ThemePublicSymlinkTest` in `Modules/Meetup/tests/Unit/Architecture/`.

## Verifica rapida

```php
// php artisan tinker
app(\Modules\Tenant\Actions\GetTenantNameAction::class)->execute();   // "local/laravelpizza"
\Modules\Xot\Datas\XotData::make()->pub_theme;                       // "Meetup"
```

## Errori tipici

| Sintomo | Causa | Fix |
|---|---|---|
| Tutte le pagine CMS danno 404 | tenant risolto a `localhost`: dominio senza cartella in `config/` | creare la cartella tenant o il symlink, controllare `APP_URL` e l'header `Host` |
| Modifica a un JSON o a `xra.php` senza effetto | file nella cartella sbagliata (`config/laravelpizza.local/`) o config in cache | usare `config/local/laravelpizza/`; `php artisan config:clear` |
| `View [pub_theme::...] not found` | `register_pub_theme` a `false`, file mancante o nome sbagliato in `data.view` | verificare `xra.php`, il file in `Themes/Meetup/resources/views`, `php artisan optimize:clear` |
| `Unable to locate a class or view for component [pub_theme::components...]` | `components.` di troppo nel tag `<x-pub_theme::...>` | togliere `components.` |
| Il tema "sbagliato" risponde su un altro dominio | `pub_theme` diverso nel `xra.php` di quel tenant | e' previsto: ogni tenant sceglie il suo tema |

## Vedi anche

- [architecture](architecture.md) - il flusso di rendering che parte da qui
- [theme-rules](theme-rules.md) - regole sul namespace, sui componenti e sul build
- [assets-and-build](assets-and-build.md) - build e symlink degli asset
- [cms-json-pages](cms-json-pages.md) - formato dei JSON in `database/content`
