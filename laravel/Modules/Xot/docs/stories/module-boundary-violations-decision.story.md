---
title: Decidere le violazioni di confine tra moduli
status: open
owner: Xot
created: 2026-10-27
---

# Decidere le violazioni di confine tra moduli

## Fase BMAD

Architettura: confini dichiarati non rispettati.

## Problema

Misurate a livello di codice (non di use o docblock): Xot importa User in 10 file (XotAction.php usa Modules\User\Models\Tenant). Sigma importa Ptv in 2 file. Ptv importa Progressioni in 5 file nel codice (BaseValutatore.php:147). Indennita Responsabilita e Ptv si importano a vicenda. Ptv importa Indennita Condizioni Lavoro (CreateStabiDirigente.php:13). Lo strumento e bashscripts/tools/audit/module-coupling.py.

## Domande aperte

1. Per ciascuna coppia: correggere, accettare come eccezione documentata, o spostare il codice?
2. Xot deve restare senza dipendenze di dominio? Il rimedio e il contratto UserContract gia presente.

## Prossimi passi

Una storia per ogni coppia accettata come da correggere. Test di architettura che fallisca alla violazione.

## Stato

Aperta. Da chiudere con una verifica reale (test, lint o prova nel browser), non con una dichiarazione.
