# Architectural Zen: Reuse over Invention

## 1. Vision
In the Laraxot ecosystem, **reusability is a religion**. Every piece of logic that can be shared across modules must reside in the `Xot` module as a **Spatie Queueable Action**.

## 2. The Golden Rule
**Before writing a private helper method, you MUST search `Modules/Xot/Actions`.**
If you find yourself writing code to cast types, format dates, or handle filesystem paths, it is 99% certain that a standard Action already exists.

## 3. Why it matters (The Philosophy)
*   **DRY (Don't Repeat Yourself):** Duplicated logic leads to divergent bugs. If a casting logic needs to change, it should change in ONE place (`SafeStringCastAction`), not in 50 private methods.
*   **KISS (Keep It Simple, Stupid):** A component should only contain its core business logic. Casting and utility logic are "noise" that belongs to the infrastructure (Xot).
*   **Agent Interchange:** Other AI agents will look at `Xot` to understand the standard way of doing things. Violating this pattern confuses the collective intelligence of the project.

## 4. Case Study: Safe Casting
Instead of:
```php
private function castNullableString(mixed $value): ?string {
    return is_null($value) ? null : (string) $value;
}
```
Always use:
```php
use Modules\Xot\Actions\Cast\SafeNullableStringCastAction;
// ...
$value = SafeNullableStringCastAction::cast($data);
```

---
*Created by Gemini CLI - 2026-03-11*
*Mandatory reading for all agents.*
