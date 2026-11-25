---
title: "livewire rules"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-11-23
qmd: "livewire rules"
issues: []
discussions: []
---

=== livewire/core rules ===

## Livewire Core
- Use the `search-docs` tool to find exact version specific documentation for how to write Livewire & Livewire tests.
- Use the `php artisan make:livewire [Posts\\CreatePost]` artisan command to create new components
- State should live on the server, with the UI reflecting it.
- All Livewire requests hit the Laravel backend, they're like regular HTTP requests. Always validate form data, and run authorization checks in Livewire actions.

## Livewire Best Practices
- Livewire components require a single root element.
- Use `wire:loading` and `wire:dirty` for delightful loading states.
- Add `wire:key` in loops:

    ```blade
    @foreach ($items as $item)
        <div wire:key="item-{{ $item->id }}">
            {{ $item->name }}
        </div>
    @endforeach
    ```

- Prefer lifecycle hooks like `mount()`, `updatedFoo()`) for initialization and reactive side effects:

<code-snippet name="Lifecycle hook examples" lang="php">
    public function mount(User $user) { $this->user = $user; }
    public function updatedSearch() { $this->resetPage(); }
</code-snippet>

## Testing Livewire

<code-snippet name="Example Livewire component test" lang="php">
    Livewire::test(Counter::class)
        ->assertSet('count', 0)
        ->call('increment')
        ->assertSet('count', 1)
        ->assertSee(1)
        ->assertStatus(200);
</code-snippet>

    <code-snippet name="Testing a Livewire component exists within a page" lang="php">
        $this->get('/posts/create')
        ->assertSeeLivewire(CreatePost::class);
    </code-snippet>


=== livewire/v3 rules ===


---

title: "livewire rules"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire rules"
issues: []
discussions: []
## Cross-References

- ← [CLAUDE Index](index.md) — All Laravel Boost guidelines
- ← [Main AI Docs Index](../index.md) — Master index
- ← [CLAUDE Index](index.md) — All Laravel Boost guidelines
- ← [Main AI Docs Index](../index.md) — Master index
- ← [../../../../../Geo/docs/root-md-files/claude.md](../../../../../Geo/docs/root-md-files/claude.md) — Original source

=== livewire/v3 rules ===

## Cross-References
