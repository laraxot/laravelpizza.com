# 📚 **Indice Documentazione Modulo Lang**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 1.5.0

## 🎯 **Lettura Essenziale**
1. [README.md](./README.md) - Panoramica del sistema di internazionalizzazione.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Traduzioni AI e centralizzazione.
3. [philosophy.md](./philosophy.md) - La lingua come infrastruttura: filosofia Laraxot.

## 🏗️ **Configurazione e Setup**
- 🌍 **[Locale Management](./locale-management.md)** - Gestione delle lingue attive e default.
- 🛣️ **[Route Localization](./laravel-localization-folio-integration.md)** - Integrazione con Folio e Volt per URL localizzati.
- ⚙️ **[Service Provider](./lang-service-provider-improvements.md)** - Architettura del caricamento dinamico delle traduzioni.

## 🏷️ **Naming & Standards**
- 🚫 **[No Hardcoded Labels](./filament-label.md)** - Perché non usiamo mai `->label()` o `->placeholder()`.
- 🗂️ **[Translation Keys](./translation-keys-best-practices.md)** - Convenzioni per la struttura delle chiavi (module::file.key).
- 📜 **[Enum Translation](./enum-translation-pattern-implementation.md)** - Pattern per la traduzione automatica degli Enum.

## 🚀 **Funzionalità Avanzate**
- ⚡ **[Auto-Registration](./autoregistration-commands.md)** - Comandi Artisan per scoprire e registrare nuove chiavi.
- 🤖 **[Automatic Translations](./automatic-translations.md)** - (DAB) Integrazione con motori di traduzione esterna.
- 📝 **[Translation File Editor](./translation-file-editor.md)** - UI per la modifica dei file `.php` di lingua.

## 🧪 **Qualità e Testing**
- ✅ **[PHPStan Analysis](./phpstan-analysis-lang.md)** - Report di conformità Level 10.
- 🔬 **[Testing Guidelines](./testing.md)** - Verifica della presenza delle chiavi di traduzione.
- 🐒 **[Chaos Monkey Translation Fallbacks](./chaos-monkey-translation-fallbacks.md)** - Protocollo di recovery su regressioni i18n.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./docs-naming-convention-fix.md)** - Rimozione dei 260+ file obsoleti.

## 📦 **Pacchetti Composer**
- [Riferimento completo](../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md)
- [Package Dependency Chaos Map](./package-dependency-chaos-map.md)
- `mcamara/laravel-localization` - URL localizzati
- `lara-zeus/spatie-translatable` - Campi Filament tradotti
- `rinvex/countries` - Dati paesi
- `spatie/laravel-sluggable` - Slug multilingua

## 🔗 **Moduli Correlati**
- [Xot](../../Xot/docs/README.md) - Base framework e classi `XotBaseChartWidget`.
- [UI](../../UI/docs/README.md) - Componenti Blade e Filament che consumano le traduzioni.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*
# Documentation Index

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)
