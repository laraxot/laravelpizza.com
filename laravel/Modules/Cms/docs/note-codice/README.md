---
title: "Note di codice — Cms"
document_type: index
category: documentation
module: Cms
status: active
updated_at: '2026-11-12'
---

# Note di codice

Appunti che stavano dentro `app/`, spostati qui il 2026-11-12
([module_quaeris_fila5#64](https://github.com/laraxot/module_quaeris_fila5/issues/64)).

## Perche' si sono spostati

In `app/` sta solo codice che gira. Questi file erano note utili — in gran
parte raccolte di link di riferimento messe accanto alla classe che
riguardavano — ma in un posto dove nessuno le cerca: chi guarda nei `docs/`
non le trovava, e chi legge `app/` le trovava senza cercarle.

Il nome di ogni file dice da quale cartella di `app/` viene, cosi' il legame
col codice non si perde: `console-commands-links.md` stava in
`app/Console/Commands/links.md`.

## Non sono stati cancellati

Perche' non erano spazzatura. Dentro ci sono link a documentazione e ad
articoli che qualcuno ha raccolto lavorando su quelle classi. Tre file senza
contenuto — due vuoti e un indice auto-generato di una cartella vuota — sono
stati cancellati; questi no.

## Se aggiungi una nota nuova

Va qui, non accanto alla classe. Se serve che chi legge il codice la trovi,
basta un `@see` nel docblock.
