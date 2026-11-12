# Sotto-pagine CMS: una cartella per contenitore

Regola: **una pagina che sta "sotto" un contenitore è un file JSON nella cartella del contenitore**.

```
config/local/<tenant>/database/content/pages/
├── home.json                 slug "home"          -> /{lingua}
├── events.json               slug "events"        -> /{lingua}/events
├── events/
│   ├── view.json             slug "view" -> "events.view"   dettaglio di un evento (/events/{slug-evento})
│   ├── my.json               slug "my"   -> "events.my"     /{lingua}/events/my     (middleware auth)
│   └── past.json             slug "past" -> "events.past"   /{lingua}/events/past
└── profile/
    ├── view.json             slug "view" -> "profile.view"  profilo pubblico (/profile/{id-utente})
    └── edit.json             slug "edit" -> "profile.edit"  /{lingua}/profile/edit  (middleware auth)
```

Nel JSON della sottocartella `id` e `slug` sono **solo l'ultima parte** (`"slug": "edit"`): il prefisso lo aggiunge
`SushiToJsons::collectRowsFromJsonFiles()` (modulo Tenant), che legge `pages/**.json` e, per un file in
`a/b/x.json`, espone `id` e `slug` come `a.b.<valore>`. Scrivere `"slug": "profile-edit"` dentro `profile/`
produce `profile.profile-edit`, che non corrisponde a nessun URL.

## Come l'URL trova il file

| URL | Rotta Folio del tema | Pagina CMS |
|---|---|---|
| `/it/events/my` | `pages/[container0]/[slug0]/index.blade.php` | prima un evento con slug `my`; se non c'è, `events.my` (404 se manca anche quello) |
| `/it/profile/edit` | `pages/profile/[id].blade.php` | `profile.edit` se esiste; altrimenti `{id}` è un utente e la pagina è `profile.view` |
| `/it/about` | `pages/[slug].blade.php` | `about` |

`PageSlugMiddleware` applica il `middleware` dichiarato nel JSON (es. `["auth"]`). Il primo candidato che prova è
**il percorso stesso** (`/profile/edit` -> `profile.edit`): il nome della rotta Folio (`profile.view`) indica la
pagina generica del contenitore e, controllato per primo, nascondeva l'`auth` della sotto-pagina.

`Event::uniqueSlug()` non assegna mai a un evento lo slug di una sotto-pagina di `events` (`my`, `past`, `view`):
l'evento renderebbe irraggiungibile la pagina.

## Creare una sotto-pagina

1. `pages/<contenitore>/<nome>.json` con `"id": "<nome>"`, `"slug": "<nome>"`, titolo e blocchi in tutte le lingue.
2. Se serve l'accesso: `"middleware": ["auth"]`.
3. Link con `LaravelLocalization::localizeUrl('/<contenitore>/<nome>')`.
4. Un test che apre `/{lingua}/<contenitore>/<nome>` (ospite e loggato se ha `auth`).

Niente file piatti con il trattino (`events-my.json`) e niente varianti con il trattino nei resolver: una sola
convenzione. I vecchi indirizzi `/events-my` e `/events-past` reindirizzano (301) ai nuovi tramite gli alias in
`config/local/laravelpizza/seo.php`.

Perché questa regola è stata scritta: [lessons/flattened-cms-subpages-error-analysis.md](lessons/flattened-cms-subpages-error-analysis.md).
