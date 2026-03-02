# Collegamenti alla Documentazione sugli Standard di Traduzione

## Problemi Identificati e Correzioni in Corso

Stiamo standardizzando i file di traduzione nel modulo Notify che presentano problemi di conformità con le convenzioni di <nome progetto>. Questo documento fornisce collegamenti rapidi a tutta la documentazione pertinente.

## Documentazione nel Modulo Notify

- [Progresso della Standardizzazione](../../notify/docs/translation_standards_progress.md)
- [Regole di Naming per i File di Traduzione](../../notify/docs/translation_file_naming_rules.md)
- [Guida alla Struttura dei File di Traduzione](../../notify/docs/translation_file_structure_guide.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../notify/docs/translation_conventions.md)
- [Guida alla Correzione dei File di Traduzione](../../notify/docs/translation_file_correction_guide.md)

## Documentazione nel Modulo Lang

- [Regole Generali per le Traduzioni](translation_keys_rules.md)
- [Best Practices per le Traduzioni](translation_keys_best_practices.md)
- [Standardizzazione Traduzioni Modulo Notify](translation_notify_conversion.md)

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