---
tags: [documentation]
issues: []
discussions: []
title: "Helper rating: tipizzare RatingContract, non BaseRating"
type: rule
module: Rating
status: accepted
created: 2026-09-23
updated: 2026-09-23
qmd: "RatingContract formFieldLabel ratingFieldName BaseRating Assert implementsInterface closure fn"
related:
  - ../../../../../../bashscripts/ai/wiki/rules/modules.md
  - ../../../../../../bashscripts/ai/wiki/skills/prefer.md#prefer-contracts-over-abstract-classes
  - ../../../../../../bashscripts/ai/wiki/memories/architecture-models-actions.md#prefer-contracts-over-abstract-classes
  - ../../bmad/architecture/rating-entity-helpers-home-in-ratingdata.md
  - ../../bmad/stories/5.234-ratingdata-ratingclass-required-revert-backtrace.story.md
  - ../../bmad/stories/5.240-ratingcontract-closures-not-baserating.story.md
  - ../../bmad/stories/5.241-prefer-contracts-over-abstract-classes-second-brain.story.md
  - ../../../app/Models/Contracts/RatingContract.php
  - ../../../../../IndennitaResponsabilita/docs/prompts/04.md
---

# Rating: applicazione della legge generale

**SSoT progetto:** [`architecture-models-actions.md#prefer-contracts-over-abstract-classes`](../../../../../../bashscripts/ai/wiki/rules/modules.md)

Qui solo l’esempio Rating.

## Signature

```php
public static function formFieldLabel(RatingContract $rating): string
public function decorateRatingField(RatingContract $rating, Component $component): Component
```

## Closure (04.md 97–101)

```php
->reject(static fn (RatingContract $rating): bool => $rating->parent_id !== null)
```

## Assert

```php
Assert::implementsInterface($ratingClass, RatingContract::class);
```

## Eccezione Eloquent

`class-string<BaseRating>` / `EloquentCollection<int, BaseRating>` OK per scope.
