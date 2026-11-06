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

 43df3e0 (.)


 0440c57 (.)
// WHY: Recupera il nome della relazione 'table' associata all'istanza corrente.
// WHAT: Usa il metodo getRelationValue per ottenere la proprietà 'name' della relazione.
$this->getRelationValue('table')->name;

// WHY: Filtro avanzato per query con ricerca su nome o email.
// WHAT: Applica una where annidata solo se la query string 'q' è presente nella request.



$this->getRelationValue('table')->name


$query->when($request->filled('q'), function (Builder $query) use ($request) {
    $query->where(function (Builder $query) use ($request) {
        $query->where('name', 'like', "%{$request->get('q')}%")
            ->orWhere('email', 'like', "%{$request->get('q')}%");
    });
$this->getRelationValue('table')->name


$this->getRelationValue('table')->name


 cb513be (.)
 43df3e0 (.)

$this->getRelationValue('table')->name


 0440c57 (.)
$query->when($request->filled('q'), function (Builder $query) use ($request) {
    $query->where(function (Builder $query) use ($request) {
        $query->where('name', 'like', "%{$request->get('q')}%")
            ->orWhere('email', 'like', "%{$request->get('q')}%");
    });
$this->getRelationValue('table')->name


$this->getRelationValue('table')->name


 cb513be (.)
$query->when($request->filled('q'), function (Builder $query) use ($request) {
    $query->where(function (Builder $query) use ($request) {
        $query->where('name', 'like', "%{$request->get('q')}%")
            ->orWhere('email', 'like', "%{$request->get('q')}%");
    });

});


});
        $query->where('name', 'like', "%{$request->get('q')}%")
            ->orWhere('email', 'like', "%{$request->get('q')}%");
    });

 origin/dev
 origin/dev


 cb513be (.)
})
 43df3e0 (.)


 cb513be (.)
})
 0440c57 (.)
