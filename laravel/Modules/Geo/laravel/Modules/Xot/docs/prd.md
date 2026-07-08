# PRD: Xot Core Framework

## 📋 Overview
- **Author:** Gemini CLI
- **Status:** Approved
- **Target Release:** 1.0.0 (L12 Compatible)

## ❓ Problem Statement
Developing multiple isolated modules requires a shared "language" and set of base classes to avoid logic duplication and architectural drift.

## 🎯 Goals & Success Metrics
- **Goal 1:** 100% Type Safety -> **Metric:** Zero PHPStan L10 errors.
- **Goal 2:** Universal Adoption -> **Metric:** All project modules extend `XotBase*`.
- **Goal 3:** Performance -> **Metric:** < 5ms framework overhead.

## 👤 User Stories
- As a **Module Developer**, I want to extend `XotBaseServiceProvider` so that my module is automatically discovered and registered.
- As an **AI Agent**, I want to see standardized `XotBaseModel` properties so I can generate type-safe code.

## 🛠️ Functional Requirements
1. **Base Abstractions:** Provide `XotBaseModel`, `XotBaseResource`, `XotBasePage`, etc.
2. **Standard Actions:** Reusable business logic like `GeneratePdfAction`, `ExecuteArtisanCommandAction`.
3. **Module Registry:** Dynamic discovery of all `laravel/Modules/` subdirectories.

## 🎨 Design & User Experience
Focuses on Developer Experience (DX). Provides clear error messages and strict typing to prevent common Laravel pitfalls.

## 🚫 Out of Scope
- Domain-specific logic (HR, Finance, etc.).
- Direct UI components (handled by the UI module).
