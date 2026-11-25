---
tags: [documentation]
created: 2026-09-26
qmd: "README"
issues: []
discussions: []
title: "BMAD Rating: Select altro / note"
type: index
module: Rating
updated: 2026-09-16
status: draft
---

# BMAD: Rating Select «altro»

## Kit BMAD owner (canonico)

- [BMAD Planning](./bmad-planning.md)
- [BMAD Brainstorming](../bmad-brainstorming.md)
- [Filament blueprint](./filament-blueprint.md)
- [Project context](./project-context.md)
- [Decision log](./decision-log.md)

## Kit BMAD owner (canonico)

- [BMAD Planning](./bmad-planning.md)
- [BMAD Brainstorming](../bmad-brainstorming.md)
- [Filament blueprint](./filament-blueprint.md)
- [Project context](./project-context.md)
- [Decision log](./decision-log.md)

Pack documentazione per `HasRatingsTrait`: rating con figli → **Group(Select + Textarea)**, note obbligatoria solo su «altro».

## Contratto rapido (canon 2026-09-16)

1. Con figli: **Select + Textarea sempre visibili**, affiancati (2 colonne) in un `Fieldset`
   Filament (`Fieldset::setUp()` chiama già `columns(2)` di suo: vedi
   [layouts#fieldset-component](https://filamentphp.com/docs/5.x/schemas/layouts#fieldset-component);
   `columnSpan(2)` sul wrapper così nel form parent a 2 colonne il blocco le occupa entrambe).
   Select è `->required()` (no `nullable()`, tensione contraddittoria con required).
   Un tentativo intermedio con `Section` è stato scartato (niente `columns(2)` di default,
   pensata per aree più grandi/collassabili, non per una coppia di campi sempre accoppiati).
2. Select → `pivot.value`; Textarea → `pivot.note` (`ratingFieldName(..., 'note')`).
3. Textarea **required** solo se è selezionata l'opzione «altro»; **mai** nascosta (un
   tentativo di nasconderla finché non si sceglie «altro» è stato scartato su richiesta
   esplicita dell'utente: deve vedersi sempre).
4. «Altro» in coda alle options: chiave **`'other'`** (`OTHER_OPTION_KEY`). Placeholder Select → stato **`null`**. Label = `trans('rating::fields.altro')`.
   La vecchia sentinella `''` collassava a `null` via `blank('')` in `select.js`
   (vendor `OptionStateCast.php:17,62` → `if ($this->isNullable && blank($state)) { return null; }`),
   quindi `selectIsOther()` non scattava mai a runtime e la Textarea non diventava mai obbligatoria.
   `'other'` è stringa non vuota → non passa `blank()` → resta distinguibile per tutto il ciclo JS→Livewire→PHP.
   Fix 2026-09-16.
5. Gate: `selectIsOther($value)` → `$value === 'other'` (=== `OTHER_OPTION_KEY`). **Mai** `blank()`.
   Textarea: `$get($select)` sul **Component** Select (non path `isAbsolute`: toglie `data.`).
6. Select con figli: validazione **`Rule::in(chiavi options)`**, **non** `RuleEnum` numeric
   (altrimenti `'other'` fallisce prima che la note sia required: story **5.152** / **5.156**).
7. Identificatori codice **inglese**; host decora con `->label($label)` sul `Fieldset` (stesso
   pattern di `->label()` sui `Field` singoli: `Fieldset` usa lo stesso trait `HasLabel`).
8. **Pass-through pivot generico nel trait** (2026-09-16, story 5.147): `hydrateRatingsFormData()`/
   `syncRatingsFormData()`: fill/save di `value`+`note` per qualunque host, incluso il remap
   dell'opzione «altro» e la normalizzazione `''`/`null` → `null` (mai `0`). Prima duplicato
   (parziale, con bug) in `CompilaIndennitaResponsabilita.php`.

## Navigazione

| Artefatto | Path |
|-----------|------|
| Architecture (SSoT contratto) | [architecture/rating-select-altro-note.md](architecture/rating-select-altro-note.md) |
| **Spec codice proposto** | [architecture/rating-select-altro-implementation-spec.md](architecture/rating-select-altro-implementation-spec.md) |
| Epic | [epics/rating-select-altro.md](epics/rating-select-altro.md) |
| Brainstorming | [brainstorming/rating-select-altro-note-obbligatoria.md](brainstorming/rating-select-altro-note-obbligatoria.md) |
| Story 5.99 | [stories/5.99-select-altro-note-obbligatoria.story.md](stories/0045-select-altro-note-obbligatoria.story.md) |
| Story 5.141 D-8 filtro | [stories/5.141-has-rating-values-filter-note.story.md](stories/0005-has-rating-values-filter-note.story.md) |
| Story 5.142 review gate | [stories/5.142-review-gate-select-altro-impl.story.md](stories/0006-review-gate-select-altro-impl.story.md) |
| Story 5.143 lang altro | [stories/5.143-lang-fields-altro.story.md](stories/0007-lang-fields-altro.story.md) |
| Story 5.144 rename EN | [stories/5.144-rename-select-is-other.story.md](stories/0008-rename-select-is-other.story.md) |
| Story 5.146 Section/Fieldset UI | [stories/5.146-select-textarea-section-ui.story.md](stories/0011-select-textarea-section-ui.story.md) |
| **Story 5.147 pivot fill/save nel trait** | [stories/5.147-hydrate-sync-ratings-form-data.story.md](stories/0012-hydrate-sync-ratings-form-data.story.md) |
| Story 5.148 Fieldset UI | [stories/5.148-fieldset-always-visible-two-columns.story.md](stories/0013-fieldset-always-visible-two-columns.story.md) |
| Story 5.149 confine Compila↔trait | [stories/5.149-compila-vs-trait-reusable-boundary.story.md](stories/0014-compila-vs-trait-reusable-boundary.story.md) |
| Story 5.151 validation UI | [stories/5.151-human-validation-attribute.story.md](stories/0015-human-validation-attribute.story.md) |
| Design SSoT | [../stories/rating-altro-option-conditional-textarea-design.story.md](../stories/0063-rating-altro-option-conditional-textarea-design.story.md) |
| Smoke IR | ../../../IndennitaResponsabilita/docs/bmad/stories/5.140-compila-altro-note-smoke.story.md _(riferimento non presente nel repository, verificato 2026-10-14)_ |

## GitHub

| | |
|--|--|
| Design | https://github.com/laraxot/module_rating_fila5/issues/57 |
| Impl | https://github.com/laraxot/module_rating_fila5/issues/58 |
| Discussion | https://github.com/laraxot/module_rating_fila5/discussions/59 |
| D-8 filtro | https://github.com/laraxot/module_rating_fila5/issues/60 |
| Review gate impl | https://github.com/laraxot/module_rating_fila5/issues/61 |
| Lang fields.altro | https://github.com/laraxot/module_rating_fila5/issues/62 |
| Rename EN identifiers | https://github.com/laraxot/module_rating_fila5/issues/63 |
| Section/Fieldset UI Select+note | https://github.com/laraxot/module_rating_fila5/issues/64 |
| **Refactor pivot fill/save → trait** | https://github.com/laraxot/module_rating_fila5/issues/65 |
| Confine Compila↔trait (5.149) | https://github.com/laraxot/module_rating_fila5/issues/67 |
| IR Compila (pass-through pivot) | https://github.com/provtv/module_indennitaresponsabilita_fila5/issues/36 |
| IR Compila review (host+label EN) | https://github.com/provtv/module_indennitaresponsabilita_fila5/issues/37 |

## Stub superseded / anti-drift

| File | Nota |
|------|------|
| brainstorming/rating-other-option-note-required.md _(riferimento non presente nel repository, verificato 2026-10-14)_ | Pointer EN obsoleto |
| [stories/5.99-select-altro-textarea-obbligatoria.story.md](stories/0046-select-altro-textarea-obbligatoria.story.md) | Bozza intermedia → pointer |
| [../stories/5.99-rating-select-altro-textarea-obbligatoria.story.md](../stories/0052-rating-select-altro-textarea-obbligatoria.story.md) | Bozza `ALTRO_KEY='altro'` → pointer |
| ../../../../docs/stories/5.109-… _(riferimento non presente nel repository, verificato 2026-10-14)_ | is_altro/migration → superseded |
| [stories/5.145-refactor-host-rating-to-trait.story.md](stories/0009-refactor-host-rating-to-trait.story.md) | Bozza pivot fill/save (nomi diversi) → pointer a 5.147. **Numero 5.145 riusato** da due story diverse nello stesso giro (questa e Section UI, ora 5.146): se citi "5.145" verifica su disco quale intendi |
| `docs/*.md` con `<<<<<<<` (≈33 file fuori bmad) | Debito merge: non SSoT; vedi [../index.md](../index.md) |

**Regola swarm:** se un agente rivendica «utente ha confermato `'altro'` stringa», verificare
`docs/prompts/01.md` (*chiave "" o null*) e i commenti **più recenti** su #57/#58 prima di
riscrivere il pack. Canone: `'other'` + placeholder `null` + `selectIsOther`.
