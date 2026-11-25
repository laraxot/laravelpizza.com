---
tags: [documentation]
issues: []
discussions: []
title: "Mai TraitName::staticMethod: preferisci Data/classe concreta"
type: rule
module: Rating
status: accepted
created: 2026-09-23
updated: 2026-09-23
qmd: "HasRatingsTrait::static anti-pattern RatingData Spatie Data"
related:
  - ../../bmad/architecture/rating-entity-helpers-home-in-ratingdata.md
  - ../../bmad/stories/5.234-ratingdata-ratingclass-required-revert-backtrace.story.md
  - ../../../../../../bashscripts/ai/wiki/memories/bmad-workflow.md#improve-migliorabile-bugs-always-bmad
---

# Anti-pattern: `HasRatingsTrait::foo()`

**Vietato** chiamare metodi statici nominando il trait:

```php
// ❌
HasRatingsTrait::formFieldLabel($rating);
HasRatingsTrait::criteriaToXlsFields($ratings);

// ✅
RatingData::formFieldLabel($rating);
RatingData::criteriaToXlsFields($ratings);
```

## Perché

1. I trait non sono tipi di dominio: `TraitName::` confonde ownership e IDE/static analysis.
2. Spatie `Data` (o model concreto) è un punto di chiamata stabile, testabile, documentabile.
3. Ordine utente `04.md`: «evitalo come la peste».

Helper rating puri → `RatingData`. Relazioni/sync host → metodi di istanza sul model che usa il trait.
