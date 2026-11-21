---
title: coverage
module: User
---

# Coverage — User

Stato onesto (2026-09-22), campagna git-hygiene/marker-cleanup.

- PHPStan `analyse Modules/User`: 1678 file, **0 errori** (level max, config repo).
- PHPMD (`tools/phpmd.phar Modules/User`): **crash pre-esistente**, fatal error
  `Call to a member function getParent() on null` in
  `PHPMD/Rule/AbstractLocalVariable.php:297` (bug noto phpmd.phar su costrutti del
  modulo, non introdotto da questa sessione — memoria second brain
  `feedback-phpmd-phar-dies-on-dnf-types.md`). Nessun conteggio finding producibile.
- PHPInsights: non eseguito in questa sessione (scope git-hygiene, non code-quality;
  nessun file `.php` di produzione modificato — solo rimozione marker/file morti).
- Pest: **bloccato**, DB `10.100.200.53:3306` irraggiungibile (`nc -z -w3` fallito).
  Blocco infrastrutturale pre-esistente, non introdotto qui (memoria
  `project-test-db-unreachable-drives-skips.md`).
- Coverage numerico: non producibile (Pest bloccato). Nessuna regressione: zero
  codice di produzione toccato (solo doc/README/config con marker + 2 file morti
  rimossi, verificati riga per riga come duplicati/dead code).

Prossimo agente con DB raggiungibile: rilanciare `./vendor/bin/pest` e aggiornare
questo file col numero reale.
