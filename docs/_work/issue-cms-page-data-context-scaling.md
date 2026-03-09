## Context
Refactor `Modules/Cms/app/View/Components/Page.php` for scalable routing context.

Problem: constructor currently supports explicit `container0`/`slug0` props and `resolveContext()`. This does not scale cleanly to future nested routing (`container1`, `slug1`, `container2`, `slug2`, ...).

## Goal
Use only the generic `$data` context payload and remove rigid context handling from constructor.

## Planned changes
1. Remove `container0` / `slug0` constructor params from `Page` component.
2. Remove `resolveContext()` method.
3. Build `view_params` with spread context (`...$this->data`) while keeping canonical keys (`blocks`, `side`, `slug`, `data`).
4. Keep block include merge (`array_merge($data, $block->data)`) unchanged.
5. Update places still passing `:container0`/`:slug0` into `<x-page>` to pass `:data="[...]"`.
6. Add/update Pest tests for multi-level context forwarding (`container1`, `slug1`).

## Acceptance
- Existing routes keep working.
- Context keys beyond `container0/slug0` reach block views.
- Pest tests green.
