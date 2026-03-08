# Bashscripts Shell Location Rule

## Regola

I file shell (`*.sh`) del progetto non devono stare in `laravel/` o in cartelle applicative dei moduli.

Posizione obbligatoria:
- `bashscripts/` (preferibilmente in sottocartelle funzionali come `bashscripts/scripts/*`).

## Documentazione obbligatoria

Ogni nuovo script shell deve essere censito e descritto in `bashscripts/docs/` con:
1. scopo;
2. input/output;
3. esempi d'uso;
4. prerequisiti;
5. impatti/rischi.

## Enforcement

Se uno script shell viene trovato in posizione errata:
- spostarlo in `bashscripts/`;
- aggiornare i riferimenti;
- aggiornare issue/discussion con il delta.
