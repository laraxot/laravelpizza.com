---
title: Nested Resource
description: Nested Resource
extends: _layouts.documentation
section: content
---

# Nested Resource {#nested-resource}

## Installazione

Per creare una nested resource su Filament, e quindi una route annidata, come ad esempio:

```bash
http://sito.com/categories/{category}/products/{product}/variations
```

utilizziamo questo pacchetto:

```bash
https://github.com/laraxot/filament-nested-resources.git
```

Per utilizzare il pacchetto bisogna installarlo come package. 

Quindi segui la seguente procedura:

- Nella cartella "laravel" crea la sotto-cartella "packages"

- Nella cartella packages esegui il seguente comando da terminale:

```bash
git submodule add https://github.com/laraxot/filament-nested-resources.git
```

- Nel file composer.json della cartella "laravel" aggiungi le seguenti linee:

Dentro alla sezione "require":

```php
"sevendays-digital/filament-nested-resources": "*",
```

Dentro alla sezione "repositories":

```php
{
    "type": "path",
    "url": "./packages/sevendays-digital/filament-nested-resources"
}
```

Poi dentro al file .gitmodules

```bash
[submodule "packages/sevendays-digital/filament-nested-resources"]
	path = packages/sevendays-digital/filament-nested-resources
	url = https://github.com/laraxot/filament-nested-resources.git
```

Ok, a questo punto il pacchetto dovrebbe funzionare.

## Utilizzo

Il pacchetto può essere utilizzato principalmente in due modi diversi.

### Relazioni hasOne, hasMany (dove l'inversa è BelogsTo)

- Nella Filament Resource figlia, estendi NestedResource al posto di Resource

- inserisci il parent nel metodo getParent

```php
use SevendaysDigital\FilamentNestedResources\Columns\ChildResourceLink;
use SevendaysDigital\FilamentNestedResources\NestedResource;

class ChildModelResource extends NestedResource
{
    public static function getParent(): string
    {
        return ParentModelResource::class;
    }
}
```

- per ogni pagina (List, Edit, Create) della Filament Resource, devi usare questo Trait:

```php
use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;
```

- nella Resource Padre, aggiungi questo bottone alla tabella:

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            ChildResourceLink::make(ChildModelResource::class),
        ]);
}
```

- aggiungi la relazione al modello che corrisponde alla Resource Genitore (hasOne, hasMany)

- aggiungi la relazione INVERSA al modello che corrisponde alla Resource Figlia (BelongsTo)

### Relazioni belongsToMany (molti a molti)

- Nella Filament Resource figlia, estendi NestedResource al posto di Resource

- inserisci il parent nel metodo getParent

```php
use SevendaysDigital\FilamentNestedResources\Columns\ChildResourceLink;
use SevendaysDigital\FilamentNestedResources\NestedResource;

class ChildModelResource extends NestedResource
{
    public static function getParent(): string
    {
        return ParentModelResource::class;
    }
}
```

- per ogni pagina (List, Edit, Create) della Filament Resource, devi usare questo Trait:

```php
use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;
```

- nella Resource Padre, aggiungi questo bottone alla tabella:

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            ChildResourceLink::make(ChildModelResource::class),
        ]);
}
```

- aggiungi la relazione al modello che corrisponde alla Resource Genitore (belongsToMany)

- aggiungi la relazione INVERSA al modello che corrisponde alla Resource Figlia (belongsToMany)

- IN AGGIUNTA A QUELLO CHE HO SCRITTO SOPRA, aggiungi questo scope al modello FIGLIO

```php
public function scopeOfMODELLO_PADRE($query,$parent)
    {
        return $query->whereRelation('ModelloPadrePlurale', 'ModelloPadrePlurale.key', $parent);
    }
```

### Accedere al genitore

Quando hai bisogno del genitore nel contesto di Livewire, come ad esempio nel form, puoi aggiungere il secondo argomento al tuo metodo di form:

```php
public static function form(Form $form, ?Event $parent = null): Form;
```

Dove Event è il modello che dovrebbe essere il genitore.

### Barra laterale

Per impostazione predefinita, quando sei in un "contesto", la barra laterale registrerà la voce di menu per tale risorsa.

Quindi, se ti trovi all'interno di un Progetto che ha documenti, la barra laterale mostrerà i documenti quando sei su un progetto o su un livello più profondo.

Se non desideri questo comportamento, puoi impostare **shouldRegisterNavigationWhenInContext** su **false** nella risorsa figlia.

### Note

Assicurati semplicemente di impostare uno slug personalizzato per le risorse in modo che generi percorsi univoci.

https://filamentphp.com/docs/2.x/admin/resources/getting-started#customizing-the-url-slug
