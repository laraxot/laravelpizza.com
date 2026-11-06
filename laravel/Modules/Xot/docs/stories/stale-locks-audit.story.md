---
title: Audit dei file lock stantii nei moduli
status: open
owner: Xot
created: 2026-10-27
---

# Audit dei file lock stantii nei moduli

## Fase BMAD

Coordinamento tra agenti: lock vecchi.

## Problema

Ci sono 194 file .lock sotto Modules/. Alcuni sono vecchi di settimane (Ptv/docs.lock del 5 ottobre, Pdnd.lock del 6 ottobre). Il protocollo richiede prova prima di rubare un lock. Ho scritto purpose.md di Pdnd senza verificare Pdnd.lock.

## Domande aperte

1. Quali lock sono ancora attivi? Verificare PID, file mtime e task.
2. Chi autorizza la rimozione?

## Prossimi passi

Elenco per modulo con esito. Rimuovere solo lock provati orfani. Registrare la prova in ogni storia.

## Stato

Aperta. Da chiudere con una verifica reale (test, lint o prova nel browser), non con una dichiarazione.
