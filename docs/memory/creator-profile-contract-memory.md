# Memory: Creator Uses ProfileContract

- `@property` e `@property-read` per `creator` non devono puntare a `Modules\\*\\Models\\Profile`.
- Tipo canonico: `\Modules\Xot\Contracts\ProfileContract|null`.
- Regola estesa anche a `updater` e `deleter` nelle annotazioni audit.
