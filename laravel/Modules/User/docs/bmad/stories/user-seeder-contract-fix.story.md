---
title: "User seeders: contratto ?Command + null-safe"
type: story
status: completed
updated: 2026-10-21
tags: [phpstan, user, seeder, contract, fix]
qmd: "user   seeders `getconsolecommand()` user"
---
# User: seeders `getConsoleCommand()`
**Problema**: `RolesSeeder` / `UserMassSeeder` dichiaravano `getConsoleCommand()` senza dichiarare il tipo di ritorno; chiamavano `$this->getConsoleCommand()` assumendo non-null ma il contratto Laravel è `?Command`.
**Fix**: `private function getConsoleCommand(): ?Command` + `?->info()`.
**Check**: `bg_198` incluso; no errori su file toccati.