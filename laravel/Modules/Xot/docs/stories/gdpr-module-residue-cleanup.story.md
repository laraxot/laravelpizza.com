---
title: Pulire i riferimenti residui al modulo Gdpr rimosso
status: open
owner: Xot
created: 2026-10-27
---

# Pulire i riferimenti residui al modulo Gdpr rimosso

## Fase BMAD

Residui di un modulo rimosso dal tracking.

## Problema

Il modulo Gdpr e stato rimosso in 54e7e4b937. Restano riferimenti in config (modules_statuses.json, database.php connection gdpr), script (check_all_modules.sh, phpstan-analyze-modules.sh), commenti in User (RegisterWidget, LogRegistrationAction) e in un file di test. User e bloccato da un altro swarm (User.lock).

## Domande aperte

1. Il modulo User e libero per la modifica?
2. La connessione gdpr in database.php serve a qualcosa?

## Prossimi passi

Verificare il lock di User. Rimuovere i riferimenti classificati come morti, con test di regressione.

## Stato

Aperta. Da chiudere con una verifica reale (test, lint o prova nel browser), non con una dichiarazione.
