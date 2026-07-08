---
title: "XotBaseResourceTable Columns Enforcement — Rating Module"
type: concept
sources: []
confidence: high
created: 2026-05-07
updated: 2026-05-07
tags: [xotbase, filament, tables, enforcement]
related:
  - ../../../../../../docs/wiki/concepts/xotbase-table-columns-enforcement.md
---

# Rating Module: XotBaseResourceTable Columns

4 Table files populated with columns from rating models.

Resources: RatingMorph, Rating

- **RatingMorphsTable**: id, model_id, model_type, rating_id, user_id, note, value, is_winner (polymorphic fields)
- **RatingsTable**: id, user_id, value, related_type, title, color, icon, txt, rule, is_disabled, is_readonly, order_column, slug (extends BaseRating)
