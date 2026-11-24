---
title: "livewire v3 rules"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_uNrwd1
updated: 2026-11-23
=======
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> .merge_file_o4PdDV
qmd: "livewire v3 rules"
issues: []
discussions: []
---

## Livewire 3

### Key Changes From Livewire 2
- These things changed in Livewire 2, but may not have been updated in this application. Verify this application's setup to ensure you conform with application conventions.
    - Use `wire:model.live` for real-time updates, `wire:model` is now deferred by default.
    - Components now use the `App\Livewire` namespace (not `App\Http\Livewire`).
    - Use `$this->dispatch()` to dispatch events (not `emit` or `dispatchBrowserEvent`).
    - Use the `components.layouts.app` view as the typical layout path (not `layouts.app`).

### New Directives
- `wire:show`, `wire:transition`, `wire:cloak`, `wire:offline`, `wire:target` are available for use. Use the documentation to find usage examples.

### Alpine
- Alpine is now included with Livewire, don't manually include Alpine.js.
- Plugins included with Alpine: persist, intersect, collapse, and focus.

### Lifecycle Hooks
- You can listen for `livewire:init` to hook into Livewire initialization, and `fail.status === 419` for the page expiring:

<code-snippet name="livewire:load example" lang="js">
document.addEventListener('livewire:init', function () {
    Livewire.hook('request', ({ fail }) => {
        if (fail && fail.status === 419) {
            alert('Your session expired');
        }
    });

    Livewire.hook('message.failed', (message, component) => {
        console.error(message);
    });
});
</code-snippet>

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev


---

title: "livewire v3 rules"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire v3 rules"
issues: []
discussions: []
## Cross-References

- ← [CLAUDE Index](index.md) — All Laravel Boost guidelines
- ← [Main AI Docs Index](../index.md) — Master index
- ← [CLAUDE Index](index.md) — All Laravel Boost guidelines
- ← [Main AI Docs Index](../index.md) — Master index
- ← [../../../../docs/CLAUDE.md](../../../../docs/../../../../docs/CLAUDE.md) — Original source

<<<<<<< HEAD
=======
=======
## Cross-References
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
