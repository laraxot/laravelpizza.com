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

*
# Collegamenti alla Documentazione sugli Standard di Traduzione

## Problemi Identificati e Correzioni in Corso

Stiamo standardizzando i file di traduzione nel modulo Notify che presentano problemi di conformità con le convenzioni di <nome progetto>. Questo documento fornisce collegamenti rapidi a tutta la documentazione pertinente.

## Documentazione nel Modulo Notify

- [Progresso della Standardizzazione](../../Notify/docs/TRANSLATION_STANDARDS_PROGRESS.md)
- [Regole di Naming per i File di Traduzione](../../Notify/docs/TRANSLATION_FILE_NAMING_RULES.md)
- [Guida alla Struttura dei File di Traduzione](../../Notify/docs/TRANSLATION_FILE_STRUCTURE_GUIDE.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../Notify/docs/TRANSLATION_CONVENTIONS.md)
- [Guida alla Correzione dei File di Traduzione](../../Notify/docs/TRANSLATION_FILE_CORRECTION_GUIDE.md)

## Documentazione nel Modulo Lang

- [Regole Generali per le Traduzioni](TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Traduzioni](TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Standardizzazione Traduzioni Modulo Notify](TRANSLATION_NOTIFY_CONVERSION.md)

## Riepilogo dei Problemi

1. **Naming File Non Standard**
   - Alcuni file utilizzano convenzioni di naming non conformi
   - Esempio: `send_whats_app.php` invece di `send_whatsapp.php`

2. **Struttura File Incompleta**
   - Mancanza di `declare(strict_types=1);`
   - Sezione `resource` assente
   - Struttura gerarchica incompleta

## Correzioni Implementate

- ✅ Creazione di documentazione dettagliata sugli standard
- ✅ Correzione del file `send_whats_app.php` → `send_whatsapp.php`
- ✅ Correzione della struttura di `send_netfun_sms.php`
- ✅ Identificazione di tutti i file non conformi da correggere

## Prossimi Passi

1. Completare la correzione dei file rimanenti
2. Verificare la coerenza tra le versioni in italiano e inglese
3. Testare tutte le funzionalità che utilizzano questi file di traduzione

**Nota**: Questo lavoro è in corso e verrà continuato nei prossimi giorni per garantire la conformità di tutti i file di traduzione agli standard di <nome progetto>.
