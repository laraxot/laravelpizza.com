# Collegamenti agli Standard di Traduzione

## Documentazione Principale
- [Regole Generali Traduzioni](translation_standards.md)
- [Best Practices Filament](filament_translation_best_practices.md)
- [Struttura File Traduzione](translation_file_structure.md)

## Moduli Specifici
- [Modulo User - Traduzioni](laravel/Modules/User/docs/translations.md)
- [Modulo Performance - Traduzioni](laravel/Modules/Performance/docs/translation_guidelines.md)
- [Modulo UI - Componenti](laravel/Modules/UI/docs/components.md)
- [Modulo Xot - Regole Base](laravel/Modules/Xot/docs/translation_rules.md)

## Esempi e Fix
- [Fix Traduzioni Performance](laravel/Modules/Performance/docs/organizzativa-migration-errors.md)
- [Fix Traduzioni Xot Base](laravel/Modules/Xot/docs/xot_base_translation_fix.md)
- [Fix Traduzioni Notify Send Email](laravel/Modules/Notify/docs/send_email_translation_fix.md)
- [Fix Traduzioni UI Opening Hours](laravel/Modules/UI/docs/opening_hours_translation_fix.md)

## Traduzioni Temi
- [Tema One - Opening Hours](laravel/Themes/One/lang/) - Traduzioni multilingue per il tema principale
- [Tema One - Language Switcher](laravel/Themes/One/docs/language-switcher-implementation.md) - Implementazione completa del selettore lingua
- **Regola**: Tutti i temi devono avere traduzioni complete in IT/EN/DE
- **Struttura**: `laravel/Themes/{ThemeName}/lang/{locale}/navigation.php`

## Regole Critiche
- **Struttura Espansa**: Tutti i campi devono avere `label`, `placeholder`, `tooltip`, `helper_text`
- **Sintassi Moderna**: Usare `[]` invece di `array()`
- **Strict Types**: Sempre `declare(strict_types=1);`
- **Sincronizzazione Lingue**: Tutti i file `lang/en/` devono avere le stesse voci di `lang/it/`
- **Naming Convention**: Tutti i file e cartelle docs in minuscolo (eccetto README.md)
- **Traduzioni Temi**: Tutti i temi devono supportare IT/EN/DE con struttura identica

## Script di Manutenzione
- [Fix Convenzioni Naming Docs](bashscripts/fix_docs_naming_convention.sh)
- [Fix Traduzioni Inglesi](bashscripts/fix_all_english_translations.sh)
- [Sincronizzazione Traduzioni](bashscripts/sync_translations.sh)

## Collegamenti Correlati
- [Convenzioni Laraxot](laraxot_conventions.md)
- [Best Practices Filament](filament_best_practices.md)
- [PHPStan Fixes](phpstan_fixes.md)

*Ultimo aggiornamento: gennaio 2025*
