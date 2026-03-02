# Composer and Module Dependency Management in Laraxot

This document outlines the best practices and mandatory rules for managing Composer dependencies within the modular Laraxot framework.

**Riferimento completo pacchetti**: [composer-packages-reference.md](../../../docs/composer-packages-reference.md) Adherence to these guidelines is crucial for maintaining project stability, respecting the modular architecture, and leveraging the `wikimedia/composer-merge-plugin` effectively.

---

## Core Principles

1.  **Modular Dependency Encapsulation**: Each module is treated as a self-contained unit, responsible for its own specific dependencies.
2.  **Immutability of Root `composer.json` for Module Dependencies**: The root `laravel/composer.json` file should only manage core Laravel/framework dependencies and the module merging mechanism, not individual module-specific packages.
3.  **Unified Dependency Resolution**: The `wikimedia/composer-merge-plugin` ensures that all module-specific dependencies are merged and resolved alongside the root project's dependencies.

---

## Mandatory Rules

### Rule 1: Module-Specific Packages Belong in Module `composer.json`

*   **Description**: All new Composer packages that are specific to a particular module (e.g., a calendar package for the `Meetup` module, a payment gateway for a `Billing` module) **must be installed within that module's `composer.json` file**, located at `Modules/{ModuleName}/composer.json`.
*   **Motivation**: This practice ensures proper dependency encapsulation, prevents the root `composer.json` from becoming bloated with module-specific concerns, and aligns with the modular design philosophy. It leverages the `wikimedia/composer-merge-plugin` to correctly integrate these dependencies.
*   **Esempio OAuth/Login (Modules/User/composer.json)**: Package come `socialiteproviders/microsoft`, `socialiteproviders/auth0` vanno nel modulo User perché riguardano autenticazione/login.
*   **Example (`Modules/Meetup/composer.json`)**:
    ```json
    {
        "name": "nwidart/meetup",
        "description": "",
        "authors": [
            {
                "name": "Your Name",
                "email": "your@email.com"
            }
        ],
        "extra": {
            "laravel": {
                "providers": [
                    "Modules\Meetup\Providers\MeetupServiceProvider"
                ],
                "aliases": {

                }
            }
        },
        "autoload": {
            "psr-4": {
                "Modules\Meetup": ""
            }
        },
        "require": {
            "php": "^8.2",
            // Example: A calendar package for the Meetup module
            "vendor/calendar-package": "^1.0"
        }
    }
    ```

### Rule 2: Root `laravel/composer.json` Immutability for Module Dependencies

*   **Description**: The `laravel/composer.json` file **should not be directly modified for adding new module-specific dependencies**. Its primary role is to manage core Laravel framework dependencies, the `nwidart/laravel-modules` package, and the `wikimedia/composer-merge-plugin` configuration for module integration.
*   **Motivation**: Maintaining the integrity and stability of the root `composer.json` is vital for core project functionality. Modifications for module-specific packages should occur at the module level to respect modular design and prevent conflicts.
*   **Reference (`laravel/composer.json` relevant section)**:
    ```json
    "extra": {
        "laravel": {
            "dont-discover": []
        },
        "merge-plugin": {
            "include": [
                "Modules/*/composer.json"
            ]
        }
    },
    "config": {
        // ...
        "allow-plugins": {
            // ...
            "wikimedia/composer-merge-plugin": true
        }
    },
    ```

### Rule 3: Executing `composer go` for Dependency Resolution

*   **Description**: After modifying a module's `composer.json` (or any other change that requires Composer to re-evaluate dependencies), the custom `composer go` script (defined in `laravel/composer.json`) **must be executed from the `laravel/` directory** to update and merge dependencies correctly.
*   **Motivation**: The `composer go` script handles various post-update tasks, including a `composer.phar update -W` which is essential for `wikimedia/composer-merge-plugin` to re-read and merge all module `composer.json` files. This ensures that all module-specific dependencies are installed and properly integrated into the project's autoloader.
*   **Example (`laravel/composer.json` `scripts.go` section)**:
    ```json
    "go": [
        // ...
        "@php -d memory_limit=-1 composer.phar update -W",
        // ...
    ]
    ```

---

## Practical Workflow

1.  Navigate to `Modules/{ModuleName}/`.
2.  Edit `composer.json` to add/remove specific dependencies.
3.  Navigate back to `laravel/`.
4.  Execute `composer go`.

---

## Related Documentation

*   [User Composer Dependencies](../User/docs/composer-dependencies.md)
*   [nWidart/laravel-modules GitHub Repository](https://github.com/nWidart/laravel-modules)
*   [Laravel Modules Official Documentation](https://laravelmodules.com/docs/1/getting-started/introduction)
*   [wikimedia/composer-merge-plugin GitHub Repository](https://github.com/wikimedia/composer-merge-plugin)
*   [Xot Module Philosophy](./filosofia-modulo-xot.md)
