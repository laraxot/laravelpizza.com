# GEMINI.md - Project Overview

## Project Overview

This is a modular PHP/Laravel application built around a custom architecture, likely designed for business or enterprise solutions, indicated by the presence of numerous specialized modules (e.g., `UI`, `Lang`, `Xot`, `Notify`, `User`, `Performance`, `Progressioni`).

The project heavily leverages the Filament admin panel framework for its user interfaces and backend management. A core focus is placed on:
-   **Modular Development**: Functionality is encapsulated within distinct Laravel Modules.
-   **User Interface (UI)**: Extensive use of Blade components and custom Filament widgets, with an emphasis on responsive design and a consistent design system.
-   **Internationalization (I18n)**: A robust, automated translation system is implemented, ensuring content is available in multiple languages (IT, EN, DE) and simplifying translation management for developers.
-   **Code Quality**: Strict adherence to code standards, including PHPStan level 10 compliance, is a primary goal.

## Building and Running

The project utilizes standard Laravel and Node.js tooling for development and deployment.

**General Workflow:**

1.  **Enable Modules:** Activate necessary custom modules.
    ```bash
    php artisan module:enable <ModuleName>
    ```
2.  **Publish Configurations:** Publish module-specific configurations.
    ```bash
    php artisan vendor:publish --tag=<module-tag-name>-config
    ```
3.  **Compile Assets:** Build frontend assets (e.g., JavaScript, CSS).
    ```bash
    npm install
    npm run build
    ```
4.  **Run Migrations/Seeders:** (If applicable) Update the database schema and populate with initial data.
    ```bash
    php artisan migrate
    php artisan db:seed
    ```
5.  **Serve Application:** Run the Laravel development server.
    ```bash
    php artisan serve
    ```

**Testing:**

-   **PHP Unit Tests:**
    ```bash
    php artisan test
    ```
-   **PHPStan Compliance:** Analyze code for static analysis issues.
    ```bash
    ./vendor/bin/phpstan analyze Modules/<ModuleName> --level=10
    ```
    *(Note: Ensure relevant modules are specified for analysis)*

## Development Conventions

The project follows a set of strict conventions to maintain code quality, consistency, and ease of maintenance.

### 1. Translation Standards (Lang Module)

-   **Automated Translations**: Translations for Filament components (Fields, Columns, Actions, etc.) are handled automatically by the `LangServiceProvider` and `AutoLabelAction`.
-   **Never Use `->label()`, `->placeholder()`, `->helperText()` Directly**: Developers **must not** manually set labels, placeholders, or helper texts in Filament components. The system automatically fetches them from translation files.
-   **Expanded Translation Structure**: All translation files must follow a hierarchical, expanded structure:
    ```php
    'field_name' => [
        'label' => 'Label Text',
        'placeholder' => 'Placeholder Text',
        'helper_text' => 'Helper Text',
        'description' => 'Description',
    ],
    ```
-   **`TransTrait` in Enums**: Enums used in Filament components (e.g., `TableLayoutEnum`) should implement `HasColor`, `HasIcon`, `HasLabel` and use `TransTrait` for automatic translation of labels and colors via `transClass()`.
-   **Language Synchronization**: Translation files for all supported locales (IT, EN, DE) must be kept synchronized. New entries must be added to all language files.
-   **Strict Types**: All PHP files related to translations (and ideally all PHP files) should include `declare(strict_types=1);`.
-   **PHPStan Level**: Translation-related code adheres to PHPStan level 9+ (with the project aiming for Level 10 compliance).

### 2. Code Quality

-   **PHPStan Level 10 Compliance**: All core and production-ready code is expected to pass PHPStan static analysis at level 10.
-   **PHPMD / PHP Insights**: While not explicitly detailed in the analyzed `README.md`, the mention of code quality and extensive PHPStan usage implies that other static analysis tools like PHPMD or PHP Insights are likely used or should be integrated for comprehensive code quality checks.
-   **Modular Structure**: Code is organized logically within Laravel Modules. Each module is self-contained and adheres to its own set of internal conventions documented in its `docs/` folder.

### 3. Documentation

-   **Markdown Files**: Extensive use of Markdown (`.md`) files within `docs/` directories for each module (e.g., `Modules/UI/docs/`, `Modules/Lang/docs/`).
-   **Clear Structure**: Documentation is well-structured with clear headings, code examples, best practices, troubleshooting guides, and a roadmap.
-   **Critical Rules**: Important rules and anti-patterns are highlighted using "REGOLA CRITICA" or "❌ MAI" markers.

## Current Status (January 2025)

-   **PHPStan Compliance**: Core files are certified at PHPStan level 10.
-   **Translation Standards**: All translation files are certified for standards compliance.
-   **Component Reusability**: Over 50 Blade components and 20 Filament widgets are reusable.
-   **Design System**: A coherent design system is in place.
-   **Responsive Layout**: 100% of components are responsive.
-   **Test Coverage**: Approximately 95% test coverage.
-   **Performance Score**: 97/100.

## Agent Behavior & Methodology (Super Cow Mode)

**Core Directives:**
-   **Prioritization**: The Agent **ALWAYS** chooses the priority. Do not wait for user input to decide the next best step.
-   **Memory Updates**: Continuously update `GEMINI.md` and `docs/` to reflect new learnings, rules, and patterns.
-   **Super Cow Methodology**: Adhere strictly to the "Super Cow" philosophy:
    -   **Deep Analysis**: Understand the "why" and "business logic" before acting.
    -   **Documentation**: Docs are the memory. Update them *before* and *after* implementation.
    -   **Quality**: PHPStan Level 10, PHPMD, PHP Insights. No compromises.
    -   **Files**: Create/Edit `.md` files ONLY in existing `docs/` folders.
    -   **Naming**: No dates or uppercase in `.md` filenames (except `README.md`).

**Golden Rules:**
1.  **Never extend Filament directly** -> Use `XotBase`.
2.  **Never use hardcoded labels** -> Use `LangServiceProvider`.
3.  **Docs First**: Read -> Plan -> Document -> Implement -> Verify -> Document.