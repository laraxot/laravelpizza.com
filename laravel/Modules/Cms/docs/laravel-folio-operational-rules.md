# Laravel Folio Operational Rules

## Fonte

Studio basato su:

- documentazione ufficiale Laravel Folio
- repository ufficiale `laravel/folio`

## Regole operative per questo progetto

### 1. Folio-first sul frontoffice

Le pagine frontoffice del CMS e del tema devono essere rappresentate come pagine Folio nei path montati, non come route controller duplicate.

### 2. Parametri dal filename

Usare il naming Folio quando il path lo richiede:

- `[slug]`
- `[id]`
- `[...segments]`

Questo evita parsing manuale inutile dei segmenti.

### 3. Model binding da filename

Se il caso d'uso e' compatibile, Folio puo' risolvere implicit binding direttamente dal filename. Va preferito a wiring manuale disperso.

### 4. Middleware nel posto giusto

- middleware di gruppo: nel mount `Folio::path(...)->middleware(...)`
- middleware specifici: dentro la page con `middleware(...)`

Non usare il Blade page come luogo dove compensare middleware mancanti.

### 5. Named routes con disciplina

`name()` va usato quando una pagina necessita davvero integrazione con `route()`. Non tutte le pagine devono essere nominate per forza.

### 6. Render hook con moderazione

`render()` serve per modellare la response o arricchire la view con dati aggiuntivi. Non deve diventare un contenitore di business logic pesante.

### 7. Route cache

Folio va considerato compatibile con la route cache del framework. Non va escluso dai workflow di deploy.
