---
title: "Seo: metatag della pagina"
type: concept
status: active
module: Seo
tags: [seo, metatag, facade, adapter, dto, contract]
qmd: "seo metatag facade adapter state MetatagData MetatagDataContract Contracts Interfaces datas open graph canonical robots"
related:
  - ./architecture.md
  - ./social-share.md
---

# Metatag della pagina

Titolo, descrizione, robots, canonical e campi Open Graph di ogni pagina del front e del back office passano da un
unico punto: la facade `Modules\Seo\Facades\Metatag`.

## Flusso

```
Metatag::setTitle('...')            facade (app/Facades/Metatag.php)
  -> MetatagFacadeAdapter           coordinatore, singleton (SeoServiceProvider::register)
       -> MergeMetatagDataAction    unisce il frammento allo stato
            -> MetatagState         singleton per richiesta, campo `data: MetatagDataContract`
Metatag::get()                      GetMetatagDataAction -> MetatagState->data
Metatag::set([...])                 ReplaceMetatagDataAction: sostituisce lo stato intero
```

- Tutti i setter (`setTitle`, `setDescription`, `setKeywords`, `setColors`, `setRobots`, `setCanonical`, `setImage`,
  `setLocale`, `setType`, `setSiteName`, `setUrl`, `setAuthor`, `setPublishedTime`, `setModifiedTime`) uniscono un
  frammento (`array_merge` sui dati correnti); `set()` ricrea lo stato da zero. L'API e' quella del vecchio
  `MetatagService`, rimosso: i chiamanti non sono cambiati.
- `MetatagState` e' per richiesta: non c'e' tabella, non si persiste nulla e non serve cache.
- La vista che emette i tag e' il componente Blade `seo::components.head` (`resources/views/components/head.blade.php`):
  `meta robots`, Open Graph (`og:type`, `og:title`, `og:description`, `og:url`, `og:image`, `og:site_name`,
  `og:locale`), Twitter Card `summary_large_image` e un JSON-LD `WebSite` (nome, url, lingua, descrizione).

## `MetatagData`

DTO `Spatie\LaravelData\Data` (`app/Datas/MetatagData.php`), `Wireable` per Livewire. Tiene un array grezzo e lo espone
con getter tipizzati, ognuno con un valore di ripiego:

| Getter | Ripiego |
|--------|---------|
| `getTitle()`, `getDescription()`, `getKeywords()` | stringa vuota |
| `getRobots()` | `index, follow` |
| `getType()` | `website` |
| `getLocale()` | `app()->getLocale()` |
| `getSiteName()` | `config('app.name')` |
| `getCanonical()`, `getImage()`, `getUrl()`, `getAuthor()` | `null` |
| `getPublishedTime()`, `getModifiedTime()` | `null` (oggetto `DateTimeInterface`) |
| `getColors()`, `get($key, $default)`, `has($key)`, `toArray()`, `toLivewire()` | accesso generico ai campi |

Esempio:

```php
use Modules\Seo\Datas\MetatagData;

$metatag = MetatagData::from(['title' => 'Titolo', 'description' => 'Descrizione']);
```

Titolo e descrizione di default del sito stanno nel file `metatag` del tenant (modulo Tenant), non in
`SeoConfigData`; l'indicizzazione del `<head>` e' di Cms.

## `MetatagDataContract`

`app/Contracts/MetatagDataContract.php` fissa cosa puo' leggere un consumatore (facade, Blade, Livewire) senza legarsi
alla classe concreta `MetatagData`; la facade e l'adapter dichiarano `get(): MetatagDataContract`.

- Il contratto sta in `app/Contracts/` e non in `app/Interfaces/`, con suffisso `Contract` (stesso linguaggio di
  `Illuminate\Contracts\*`). Non sta in `Models/Contracts/` perche' `MetatagData` e' un DTO, non un modello Eloquent:
  quella cartella e' per le sole capacita' Eloquent.
- Nuovo contratto nel modulo: file `*Contract.php`, namespace `Modules\Seo\Contracts`, implementazione concreta in
  `Datas/`, `Actions/` o `Models/`, e un test `toBeInstanceOf(*Contract::class)`.
- Test di riferimento: `tests/Unit/Datas/MetatagDataTest.php`, `tests/Feature/MetatagFacadeAdapterTest.php`,
  `tests/Unit/Adapters/MetatagFacadeAdapterExtendedTest.php`, `tests/Unit/Facades/MetatagFacadeTest.php`,
  `tests/Unit/Actions/Metatag/ReplaceMetatagDataActionTest.php`.

## Storia della conversione

`app/Services/MetatagService.php` era un accumulatore con stato per richiesta, registrato come singleton e usato dietro
la facade. Non e' diventato una Action perche' una `QueueableAction` espone un solo `execute()` senza stato e
spezzerebbe la semantica della facade. Stato e coordinamento sono andati in `Adapters/`, le mutazioni in Action.
`MetatagManager`, il vecchio service e i doppioni `app/Data/*` non avevano piu' chiamanti e sono stati rimossi con i
test che coprivano solo loro (issue #64). Resta aperta una domanda di architettura: esiste anche un `MetatagData` in Xot;
Seo tiene il proprio tipo perche' il contratto lo rende sostituibile.
