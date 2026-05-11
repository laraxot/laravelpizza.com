# Policy Inheritance Rule

## ⚖️ Decision: Base Policy Hierarchy

We maintain two main levels of base policies to ensure DRY principles while keeping modular separation.

### 1. `XotBasePolicy` (Global Level)
- **Location:** `laravel/Modules/Xot/app/Models/Policies/XotBasePolicy.php`
- **Purpose:** Contains universal authorization logic applicable to the entire project.
- **Key Feature:** Implements the `before()` method for `super-admin` access.
- **When to use:** Extend this for policies that only require global role checks and basic structure.

### 2. `UserBasePolicy` (User Level)
- **Location:** `laravel/Modules/User/app/Models/Policies/UserBasePolicy.php`
- **Purpose:** Contains logic specific to models owned by or related to users.
- **Key Feature:** Should provide generic helpers for "is owner" checks.
- **When to use:** Extend this for policies belonging to models that are directly linked to a `user_id`.

## 🔄 Separation of Concerns

- **Separation:** Keep them separate to avoid bloating `Xot` with User-specific logic. `Xot` is the foundation; `User` is a functional module.
- **Generic Policies:** Policies for specific modules (e.g., `Fixcity`) should extend `XotBasePolicy` by default unless they need standard user-ownership logic provided by `UserBasePolicy`.

## 🛠️ Improvements Needed
- **Genericity:** `UserBasePolicy` currently contains `Ticket` type-hints. This is a violation of KISS/DRY for a *Base* policy.
- **Fix:** Refactor `UserBasePolicy` to use `Model` or a generic `UserOwnedContract` to handle ownership checks without module-specific dependencies.

## 🧘 Zen of Policies
*Simple rules, clear hierarchy, zero redundancy.*
