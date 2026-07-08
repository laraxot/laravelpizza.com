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
- [AGENTS.md](../AGENTS.md)
