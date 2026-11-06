---
title: "fix login"
type: note
status: draft
updated: 2026-10-19
tags: [docs, user, auth-setup]
qmd: "fix login user"
---
Local verification only: the user hash matches the supplied test password and the account is active on the local `user` connection. Production requires a non-destructive verification/update on the production host; do not claim the live login is fixed until the deployed config cache, user database, and browser flow have been checked together.

## Correzione DB devices (2026-10-18)
- Errore: `Table 'fixcity_data.devices' doesn't exist` (il sito usava connessione `fixcity` invece di `user`).
- Fix: `Modules/User/app/Models/Device.php` → `protected $connection = 'user';`.
- Migrazione riparativa: `database/migrations/2026_10_18_180001_repair_devices_table.php` applicata su connessione `user` (`fixcity_user`).
