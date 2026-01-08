# Migrazioni del modulo Activity

Questo documento descrive le migrazioni del database per il modulo Activity. Ogni migrazione include un docblock e un type hint `Blueprint $table` per migliorare la leggibilità e l'analisi statica con PHPStan.

## 2023_03_31_103350_create_activity_table.php
- Crea la tabella `activity` con i campi:
  - `id`, `log_name`, `description`, `subject`, `causer`, `properties`, `batch_uuid`, `event`, indici su `log_name`
- Utilizza una closure tipizzata e documentata:
  ```php
  /**
   * @param Blueprint $table
   */
  function (Blueprint $table) {
      // definizione colonne...
  }
  ```

## 2023_10_30_103350_create_stored_events_table.php
- Crea la tabella `stored_events` per l'Event Sourcing con i campi:
  - `id`, `aggregate_uuid`, `aggregate_version`, `event_version`, `event_class`, `event_properties`, `meta_data`, `created_at`
- Docblock e type hint già presenti

## 2023_10_31_103350_create_snapshots_table.php
- Crea la tabella `snapshots` con i campi:
  - `id`, `aggregate_uuid`, `aggregate_version`, `state`
- Docblock e type hint già presenti

## Collegamenti tra versioni di migrations.md
* [migrations.md](../../../Gdpr/docs/migrations.md)
* [migrations.md](../../../Notify/docs/migrations.md)

