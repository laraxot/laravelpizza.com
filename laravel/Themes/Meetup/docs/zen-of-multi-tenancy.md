# The Zen of Multi-Tenancy: Laraxot Philosophy

## 🧘 The Essence of Tenant Identity

In the Laraxot methodology, a Tenant is not merely a database record; it is a **contextual state** that governs every aspect of the application's behavior. The identity of a tenant is derived from its domain, flowing from the outside in.

### The Rule of Inversion
Identity follows the structure of DNS, but inverted for logical grouping on the filesystem.
- **Domain**: `laravelpizza.local`
- **Identity**: `local/laravelpizza`
- **Philosophy**: Group by top-level (or environment) first, then by specific identity. This transforms a flat list of tenants into a hierarchical, manageable tree.

## ⛪ The Religious Tenets of Configuration

1. **Hierarchy over Autonomy**: A tenant always inherits from the base, but its overrides are absolute.
2. **Context Agnosticism**: A system that is tenant-aware in the browser but blind in the console is a "multi-personality" disaster. Consistency is the only path to salvation.
3. **DRY is Sacred**: Never repeat a configuration that can be inherited. Only define the delta.
4. **KISS is the Path**: If a configuration resolution logic requires a complex state machine, you have strayed from the light. `Arr::first(explode('.', $key))` is the simplicity we seek.

## ⚔️ The Great Debate: Console vs. Web

A furious debate occurred regarding the `runningInConsole()` bypass.
- **The Whisper of Doubt**: "Console is for admins! Speed over awareness!"
- **The Shout of Reason**: "Queue workers ARE console! Schedulers ARE console! If the task can't see the tenant, the task is a ghost!"

**The Winner**: The Shout of Reason. The bypass was cast out. The system is now unified, consistent, and robust across all execution environments.

## 🍵 The Zen of `config/local/laravelpizza/`

Why this path?
1. **Predictability**: It matches the `GetTenantNameAction` result exactly.
2. **Security**: Separating by environment (`local`, `prod`) prevents accidental cross-pollination of secrets.
3. **Simplicity**: No complex mapping tables. The filesystem *is* the map.

---

> [!IMPORTANT]
> To understand the tenant, one must understand the domain. The domain is the seed; the configuration is the fruit.
