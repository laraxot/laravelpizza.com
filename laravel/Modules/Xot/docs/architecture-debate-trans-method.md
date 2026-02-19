# architecture debate: the trans method

## context

in laraxot, xot is the central abstraction layer that enforces conventions and prevents drift across modules.
translation is not just a feature: it is part of governance (no hardcoded labels, consistent keys, predictable ui).

this debate emerged because php/filament frequently mixes static helpers, traits, and inheritance, which can easily lead to **method signature collisions** (especially with `trans()`).

related docs:

- [trait conflict resolution](./trait-conflict-resolution.md)
- [filosofia modulo xot](./filosofia_modulo_xot.md)
- [quality tools zen](./quality-tools-zen.md)

## the furious internal debate

### position a (strict canon): one trans is the law

- **claim**: there must be a single canonical `trans()` contract in the filament/xot layer.
- **reason**:
  - `trans()` is a foundational primitive.
  - if every trait ships its own `trans()` signature, php will accept it until it doesn’t (collision), and then failures are catastrophic.
  - a single contract enables type-safety, predictable behavior, and prevents “magic divergence”.

### position b (local freedom): every trait can define its own trans

- **claim**: traits should be self-contained and can define `trans()` as needed.
- **reason**:
  - local convenience.
  - fewer dependencies between traits.
  - easier drop-in reuse.

## winner: position a (one trans is the law)

### why it wins

- **dry**: one canonical implementation prevents duplicated translation policies.
- **kiss**: one mental model for `trans()` reduces cognitive load.
- **robustness**: avoids signature collisions across inheritance chains.
- **tooling alignment**: supports phpstan level 10 by keeping contracts stable.

## practical rule (the actionable policy)

- use `TransTrait` **only** when the class is allowed to own the canonical `trans()` contract.
- for traits that only need function-based translations, use `TransFuncTrait` (no `trans()` inside).
- if a trait might be mixed into classes that already define `trans()`, it must not define `trans()`.

### decision log (implementation alignment)

- `NavigationLabelTrait` must use `TransFuncTrait` (as documented).
- any new trait should avoid defining `trans()` unless it is explicitly part of the canonical translation layer.

## consequences

- fewer fatal collisions.
- translation conventions remain centralized.
- future filament upgrades are handled by adjusting xot once, not in every module.
