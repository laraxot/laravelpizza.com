## PHPStan – Eliminazione property_exists (gennaio 2026)

- **Contesto**: in `ProjectResource\Pages\ManageProjectEmployees` veniva ancora sommato `pivot->importo_attivita_dipendente` senza type checking. Il vecchio `property_exists()` era stato commentato ma il valore rimaneva non validato.
- **Fix**:
  - Guard esplicito su `$pivot` (`is_object`).
  - Lettura dell’importo tramite `isset()`/`is_numeric` per rispettare la regola “mai property_exists su attributi dinamici Eloquent”.
  - Cast a `float` per garantire il tipo restituito a PHPStan livello 10.
- **Verifica**: `php -d memory_limit=4G ./vendor/bin/phpstan analyse Modules/UI --memory-limit=4G --no-progress` (modulo UI come riferimento) + PHPMD sul file modificato.

Risultato: nessun warning residuo sull’azione tabelle del progetto e documentazione aggiornata nella stessa cartella.


