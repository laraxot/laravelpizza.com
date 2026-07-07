# Naming Conventions - Database Folders

## Regola Mandatoria
Tutte le cartelle all'interno di `database/` nei moduli devono essere rigorosamente in **minuscolo**:
- `database/factories`
- `database/migrations`
- `database/seeders`

## Razionale
Garantire la compatibilità cross-platform (Linux/Windows) e l'allineamento con gli standard di caricamento automatico di Laravel e Composer.

## Azioni Correttive
In caso di rilevamento di cartelle con iniziali maiuscole (es. `Factories`), rinominarle immediatamente e aggiornare i namespace nei file PHP contenuti.
