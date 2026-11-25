---
qmd: "mixed type ultima spiaggia"
issues: []
discussions: []
title: "Mixed (tipo di dato) - Solo come Ultima Spiaggia"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
<<<<<<< HEAD
<<<<<<< .merge_file_tIedlY
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_NMAMg9
updated: 2026-08-24
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_tIedlY
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_NMAMg9
---

# Mixed (tipo di dato) - Solo come Ultima Spiaggia

**Regola critica**: Il tipo `mixed` in PHP deve essere usato **SOLO come ultima spiaggia**.

## Preferenze (in ordine)

1. **Union types** - `string|int|null`
2. **Generics** - `Collection<int, User>`, `array<string, Component>`
3. **Interfacce** - `ArrayAccess`, `Iterator`
4. **Classi base** - `object`, `array`
5. **mixed** - solo quando non esiste alternativa (es. API esterne senza tipo garantito)

## Collegamenti

- [array-keys-mixed-property-exists.mdc](../.cursor/rules/array-keys-mixed-property-exists.mdc)
- [filament-array-typing.mdc](../.cursor/rules/filament-array-typing.mdc)
- [critical-rules-and-memories](../laravel/Modules/Xot/docs/critical-rules-and-memories.md)
<<<<<<< HEAD
<<<<<<< .merge_file_tIedlY
- [agents.md](../agents.md)
=======
<<<<<<< HEAD
<<<<<<< HEAD
- [agents-2.md](../agents-2.md)
=======
<<<<<<< HEAD
- [agents.md](../agents.md)
=======
- [agents-2.md](../agents-2.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
- [agents.md](../agents.md)
=======
- [agents-2.md](../agents-2.md)
=======
<<<<<<< HEAD
- [agents.md](../agents.md)
=======
- [agents-2.md](../agents-2.md)
>>>>>>> .merge_file_NMAMg9
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
