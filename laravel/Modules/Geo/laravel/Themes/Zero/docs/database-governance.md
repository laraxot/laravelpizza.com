## migrazioni allineate con laraxot

- ogni tabella del dominio utente deve essere creata/manutenuta da **una sola** migration per modulo  
- duplicare migrazioni per la stessa tabella (`roles`, `permissions`, ecc.) genera drift tra gli ambienti e viola la regola *forward-only* di Laraxot  
- eventuali nuove colonne devono essere gestite con `tableUpdate()` nella stessa migration base (es. `2024_01_01_000011_create_roles_table.php` per `roles`)

### cosa fare
- se serve evolvere la tabella: aggiungere step in `tableUpdate()` oppure creare una migration di *alter* con naming esplicito (`add_display_name_to_roles_table`), mai una nuova `create_roles_table`  
- verificare sempre `Modules/User/docs/roles_permissions.md` prima di toccare ruoli/permessi  
- aggiornare la documentazione del tema ogni volta che si interviene sulle migrazioni condivise, per mantenere l’allineamento UI/backoffice

