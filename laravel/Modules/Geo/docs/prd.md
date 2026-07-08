# PRD: PTVX Modular Ecosystem

## 📋 Overview
- **Author:** Gemini CLI
- **Status:** Draft
- **Target Release:** Q2 2026

## ❓ Problem Statement
Building large-scale HR systems for Public Administration leads to monolithic, unmaintainable codebases with duplicated logic across different departments (Performance, Presenze, etc.).

## 🎯 Goals & Success Metrics
- **Goal 1:** Modular Isolation -> **Metric:** 100% decoupling between domain modules.
- **Goal 2:** Type Safety -> **Metric:** Zero PHPStan Level 10 errors.
- **Goal 3:** Developer Productivity -> **Metric:** < 1 hour to scaffold a new compliant module.

## 👤 User Stories
- As a **Developer**, I want to extend `XotBaseModel` so that I get automatic multi-tenancy and activity logging.
- As a **System Admin**, I want to toggle modules independently to minimize attack surface.

## 🛠️ Functional Requirements
1. **Module Registry:** Centralized tracking of all installed and active modules.
2. **Standardized UI:** Uniform Filament resources across all modules using `XotBaseResource`.
3. **Queueable Actions:** Business logic encapsulated in Spatie Queueable Actions.

## 🎨 Design & User Experience
Follows Filament v5 standards with "Super Mucca" UI enhancements for accessibility and clarity.

## 🚫 Out of Scope
- Direct Database manipulation without Eloquent/XotBase.
- Hardcoded localized strings.
