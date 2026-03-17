# PRD: Lang Module

## 📋 Overview
- **Author:** Gemini CLI
- **Status:** Approved
- **Target Release:** 1.0.0

## ❓ Problem Statement
Managing translations across 30+ modules leads to missing keys, hardcoded strings, and inconsistent language support.

## 🎯 Goals & Success Metrics
- **Goal 1:** Zero Hardcoded Strings -> **Metric:** `translation-check` tool passes 100%.
- **Goal 2:** Universal Support -> **Metric:** Italian and English provided for 100% of keys.
- **Goal 3:** Dynamic Switching -> **Metric:** Support for 10+ languages with minimal overhead.

## 👤 User Stories
- As a **User**, I want to see the application in my preferred language automatically.
- As a **Developer**, I want to use `trans()` or `__()` and have the keys automatically created if they are missing.

## 🛠️ Functional Requirements
1. **Localization Engine:** mcamara/laravel-localization integration.
2. **Translation Registry:** Discover and register all module-specific `lang/` files.
3. **Admin UI:** Manage translation keys directly from the Filament panel.

## 🎨 Design & User Experience
Transparent language selection via URL prefix (e.g., `/it/admin`, `/en/admin`).

## 🚫 Out of Scope
- Domain-specific logic.
- Hardcoded translations in Blade files.
