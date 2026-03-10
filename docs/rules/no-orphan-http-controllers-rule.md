# Regola: no orphan HTTP controllers

## Regola

Non vanno lasciati nel codice controller HTTP orfani:

- senza route effettive;
- senza boundary web dichiarato;
- usati come deposito di logica di dominio non integrata.

## Motivazione

- aumentano rumore e ambiguita' architetturale;
- fanno credere che esista un endpoint che in realta' non e' attivo;
- spostano logica di dominio in layer HTTP non necessario.

## Approccio corretto

- prima documentare il boundary;
- poi implementare controller, route o action solo se davvero usati;
- se il file e' morto o non collegato, va rimosso.
