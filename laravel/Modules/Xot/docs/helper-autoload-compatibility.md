# Helper Autoload Compatibility

## Problema

Nel modulo `Xot` alcuni tool e alcuni percorsi legacy cercano ancora:

- `Modules/Xot/helpers/Helper.php`
- `Modules/Xot/helpers/Helper.php`

Su filesystem case-sensitive questi due path non sono equivalenti.

## Regola

- il file helper operativo deve restare disponibile nel path usato da Composer
- se tool o integrazioni cercano anche il path storico con `Helpers/`, mantenere un bridge sottile invece di duplicare logica

## Scelta applicata

- helper attivo: `Modules/Xot/helpers/Helper.php`
- bridge compatibilita': `Modules/Xot/helpers/Helper.php`

## Perche'

- sblocca `artisan`
- sblocca `phpstan`
- evita una seconda copia divergente del file helper
- mantiene il fix DRY/KISS
