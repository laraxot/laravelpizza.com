---
title: "tips"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "tips"
issues: []
discussions: []
---

# Tips

# Tips e Snippets Utili

## Relazioni
```php
// WHY: Recupera il nome della relazione 'table' associata all'istanza corrente.
// WHAT: Usa il metodo getRelationValue per ottenere la proprietà 'name' della relazione.
$this->getRelationValue('table')->name;
```

## Query Builder
```php
// WHY: Filtro avanzato per query con ricerca su nome o email.
// WHAT: Applica una where annidata solo se la query string 'q' è presente nella request.
$query->when($request->filled('q'), function (Builder $query) use ($request) {
    $query->where(function (Builder $query) use ($request) {
        $query->where('name', 'like', "%{$request->get('q')}%")
            ->orWhere('email', 'like', "%{$request->get('q')}%");
    });
});
```
