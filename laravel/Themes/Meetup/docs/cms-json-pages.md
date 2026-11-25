---
title: "Pagine pubbliche da JSON del CMS"
type: guide
status: active
theme: Meetup
qmd: "pagine json cms content_blocks slug x-page sottopagine cartelle middleware page data bag creare nuova pagina SushiToJsons"
---

# Pagine pubbliche da JSON del CMS

## Perche' esiste

Ogni pagina pubblica del sito e' un file JSON in `config/local/laravelpizza/database/content/pages/`, resa da `<x-page>`
dentro una pagina Folio generica. Cambiare testi, ordine dei blocchi o protezione di una pagina non richiede di toccare Blade.
Questa pagina dice come e' fatto il JSON, come lo slug diventa una pagina (o un 404), come si creano sotto-pagine e cosa
NON fare. La decisione e' in `adr/public-pages-from-json-via-x-page.md`; le pagine Folio sono in
[folio-routing](folio-routing.md), i blocchi in [blocks-and-components](blocks-and-components.md).

## La regola

Per una nuova pagina pubblica: un JSON e, se servono, nuovi blocchi. Mai un `pages/<slug>.blade.php`, mai un controller o
una rotta in `web.php`/`api.php`. Il motivo: una sola pipeline di rendering (JSON, `x-page`, blocchi), pagine che non
divergono fra loro e contenuti modificabili con review senza deploy del tema.

La cartella del tenant (`config/local/laravelpizza`) e' quella risolta da `APP_URL` ([tenant-theme-resolution](tenant-theme-resolution.md)).
Pagine esistenti: `home`, `about`, `contact`, `events`, `privacy`, `terms`, `cookie-policy`, piu' le sotto-pagine
`events/{view,my,past}.json` e `profile/{view,edit,assistants}.json`. `privacy` e `terms` (con `cookie-policy`) sono pagine
obbligatorie: le linkano cookie bar e registrazione, la loro assenza e' un difetto di contenuto.

## Formato del file

Il modello `Modules\Cms\Models\Page` legge i file come righe (`SushiToJsons` del modulo Tenant) e scrive di nuovo il JSON
quando una pagina viene creata o modificata dal backoffice. Chiavi reali (vedi `events.json`):

```json
{
    "id": "events",
    "title": { "it": "Prossimi eventi - Laravel Pizza Meetups", "en": "Upcoming events - Laravel Pizza Meetups" },
    "slug": "events",
    "middleware": null,
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "events-list",
                "data": {
                    "view": "pub_theme::components.blocks.events.list",
                    "title": "Prossimi eventi",
                    "events_source": "public",
                    "timing": "upcoming",
                    "limit": 50
                }
            }
        ],
        "en": [ ... ]
    },
    "sidebar_blocks": { "it": [], "en": [] },
    "footer_blocks": { "it": [], "en": [] }
}
```

- `title`, `content_blocks`, `sidebar_blocks`, `footer_blocks` sono tradotti: una chiave per lingua. La lingua corrente
  non presente ricade sulla lingua primaria (`primary_lang`, oggi `it`). Una pagina con soli `it`/`en` e' quindi visibile
  in `de` con i blocchi italiani.
- Ogni blocco ha `type` (etichetta libera), `slug` (opzionale), `active` (opzionale, `false` lo salta) e `data`, che
  DEVE contenere `view`: il nome della vista del blocco (`pub_theme::components.blocks.<gruppo>.<nome>`). Senza `view`
  vale `ui::empty`; una vista inesistente lancia `RuntimeException: view not found: ...` e la pagina va in errore.
- Il lato che `x-page` legge e' `side` (`content`, `sidebar`, `footer`) e corrisponde a `<side>_blocks`. Oggi la home
  rende anche `side="sidebar"`, ma `sidebar_blocks` e `footer_blocks` sono vuoti in tutte le pagine.
- Un blocco puo' avere `data.query` (`model`, `scopes`, `orderBy`, `limit`, `wrap_in`): `ResolveBlockQueryAction` esegue la
  query e fonde il risultato in `data`. Le scelte di dominio restano nelle Action, non nel JSON.
- Dentro le stringhe sono ammesse solo due espressioni: `{{ trans('ns::file.chiave') }}` (o `__()`), con chiave letterale, e
  `route('nome', [...])` con argomenti letterali. Qualunque altro `{{ ... }}` resta testo e scrive un warning nel log. Con
  `trans` il JSON non contiene testo hardcoded: `home.json` usa `pub_theme::home.*` ([localization](localization.md)).
- I percorsi interni nei JSON si scrivono senza lingua (`/events`, `/auth/register`): il blocco li localizza con
  `LaravelLocalization::localizeUrl()`.

## Slug, cartelle e sotto-pagine

Una pagina "sotto" un contenitore e' un JSON nella cartella del contenitore; `id` e `slug` nel file sono SOLO l'ultima parte,
il prefisso lo aggiunge il loader:

| File | Slug effettivo | URL | Rotta Folio |
|---|---|---|---|
| `home.json` | `home` | `/{lingua}` | `index.blade.php` |
| `about.json` | `about` | `/{lingua}/about` | `[container0]/index.blade.php` |
| `events.json` | `events` | `/{lingua}/events` | `[container0]/index.blade.php` |
| `events/view.json` | `events.view` | `/{lingua}/events/{slug-evento}` (template del dettaglio) | `[container0]/[slug0]/index.blade.php` |
| `events/my.json` | `events.my` | `/{lingua}/events/my` (`auth`) | idem |
| `profile/edit.json` | `profile.edit` | `/{lingua}/profile/edit` (`auth`) | `profile/[id].blade.php` |
| `profile/view.json` | `profile.view` | `/{lingua}/profile/{id-utente}` | idem |

- Scrivere `"slug": "profile-edit"` dentro `profile/` produce `profile.profile-edit`, che non corrisponde a nessun URL.
  Niente file piatti con trattino (`events-my.json`): i vecchi indirizzi `/events-my` e `/events-past` reindirizzano con gli
  alias di `config/local/laravelpizza/seo.php`.
- Il dettaglio di un modello (evento) usa sempre il template `{contenitore}.view`; il modello arriva nel data bag, non dallo
  slug. La convenzione `events.<slug-evento>.json` (un JSON per evento) non esiste: `Event::uniqueSlug()` impedisce che un
  evento prenda gli slug riservati `my`, `past`, `view`.
- Uno slug deve essere unico: due JSON con lo stesso slug fanno lanciare `findUniqueBySlug` (`Page slug duplication`) e
  `getBlocksBySlug` (`CMS content collision`).
- Regola completa e motivazioni: `Modules/Cms/docs/cms-subpages-folders.md`.

## Come uno slug diventa una pagina

1. La pagina Folio chiama `<x-page side="content" :slug="..." :data="...">`.
2. `Modules\Cms\View\Components\Page` carica `Page::getBlocksBySlug($slug, $side)`, applica le espressioni consentite, crea
   un `BlockData` per blocco e registra titolo e descrizione per `<x-metatags>` (`ResolvePageMetaAction`: titolo dal modello o
   dalla pagina CMS, descrizione dal modello o dal primo blocco con `description`/`subtitle`).
3. `cms::components.page` include ogni blocco attivo con `array_merge($block->data, $data, ['data' => ...])`.
4. Per le rotte `[container0]/[slug0]` il componente completa la risoluzione se la pagina non ha gia' passato un `item`
   (`ResolvePageAction`); se non c'e' ne' modello ne' pagina CMS risponde 404.

Il contesto di rotta (`container0`, `slug0`, `item`, `event`, futuri `container1`/`slug1`) si passa solo in `:data`, mai
come props dedicate di `x-page`: il componente non impone una struttura di URL e un segmento in piu' non cambia il suo
costruttore. Il `data` della pagina vince sulle chiavi omonime del blocco.

## Protezione di una pagina

`"middleware": ["auth"]` (lista di stringhe, o `null`) la protegge. `PageSlugMiddleware` trova il JSON provando, in ordine,
il percorso stesso (`/events/my` diventa `events.my`), il nome della rotta Folio, `container0.slug0` e gli slug singoli;
poi esegue i middleware dichiarati. Regole di sicurezza gia' nel codice:

- fail-closed: se la protezione non si puo' determinare (slug duplicato, `middleware` non lista, nome non risolvibile) la
  pagina non viene servita, 503, e il log riporta slug e tipo di errore, mai IP o URL;
- `web` nel JSON non ha effetto (lo applica gia' lo stack Folio); usare alias reali (`auth`, `throttle:10,1`) o classi;
- sulla rotta `[container0]/[slug0]` i contenitori `profile`, `user`, `users` rispondono 404 se non c'e' un modello risolto;
  `/profile/{id}` ha la sua pagina (`profile/[id].blade.php`), che risponde 404 per un utente inesistente o eliminato.

Contratto: `Modules/Cms/docs/contracts/page-slug-middleware.md`.

## Creare una pagina

1. `pages/<nome>.json` (o `pages/<contenitore>/<nome>.json`) con `id`, `slug` (ultima parte), `title` e blocchi in tutte le
   lingue che si vogliono servire; aggiungere `"middleware": ["auth"]` se serve.
2. Usare blocchi esistenti ([blocks-and-components](blocks-and-components.md)); se manca un layout, creare un blocco
   riusabile, non una pagina Blade.
3. Linkare con `LaravelLocalization::localizeUrl('/<nome>')`.
4. Aprire `/it/<nome>` e una seconda lingua (guest e, se c'e' `auth`, utente loggato) e controllare titolo e 404.
5. Dopo aver cambiato Blade o config: `php artisan view:clear` e `cache:clear`.

## Errori tipici

| Sintomo | Causa | Fix |
|---|---|---|
| `view not found: pub_theme::components.blocks...` | `data.view` sbagliato o blocco non creato | allineare il nome al file in `components/blocks/` |
| 404 su una pagina che esiste | slug con prefisso sbagliato (`profile-edit`) o file piatto | cartella + slug ultima parte |
| 503 su una pagina | `middleware` non e' una lista di stringhe o nome non risolvibile | correggere il JSON; vedi log `Pagina CMS non servita` |
| `{{ ... }}` stampato letteralmente | espressione non ammessa | usare `trans('ns::file.chiave')` o `route(...)` |
| Pagina vuota con solo header e footer | nessun blocco per la lingua e per la primaria | aggiungere i blocchi in `it` |
| Blocco senza i dati attesi | chiave `data` mancante nel blocco | `"data": { "view": ..., ... }` |

## Da verificare

- Le pagine `about.json` e `contact.json` esistono con blocchi propri; l'elenco "pagine mancanti" dei vecchi piani (menu,
  carrello, chat, dashboard come pagina del sito) non e' un requisito del sito attuale e non e' stato riportato.

## Vedi anche

- [folio-routing](folio-routing.md): quale file Folio serve quale URL
- [blocks-and-components](blocks-and-components.md): i blocchi che il JSON referenzia
- [localization](localization.md): `trans` nei JSON e `localizeUrl`
- [tenant-theme-resolution](tenant-theme-resolution.md): da `APP_URL` alla cartella `config/local/<tenant>`
- [seo-structured-data](seo-structured-data.md): titolo e descrizione delle pagine
