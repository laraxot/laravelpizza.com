# _bak — storico notifications (non eseguire)

Laravel non carica sottocartelle di `migrations/`.

Anti-pattern rimosso: `User/.../2026_07_02_000000_create_notifications_table.php` (owner sbagliato, `extends Migration`).

Canon: `../2026_06_10_134000_create_notifications_table.php` (Notify, `XotBaseMigration`).
