# Testing Environment

## Regola

Il file `.env.testing` deve sempre esistere nel progetto Laravel.

## Principio

- È identico a `.env`
- Cambiano solo le variabili `DB_DATABASE*`
- Ogni valore DB viene concatenato con `_test`

## Perché

- Isola i test dal database di sviluppo
- Evita contaminazione dei dati
- Permette test ripetibili e sicuri

## Esempio

- `DB_DATABASE=fixcity_data` → `DB_DATABASE=fixcity_data_test`
- `DB_DATABASE_USER=fixcity_user` → `DB_DATABASE_USER=fixcity_user_test`
- `DB_PASSWORD_USER=marco` → `DB_PASSWORD_USER=marco_test`

## Filosofia

La separazione degli ambienti è una forma di disciplina: il test deve essere utile senza essere invasivo.