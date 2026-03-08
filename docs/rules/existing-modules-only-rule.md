# Existing Modules Only Rule

## Regola critica

Non creare nuovi moduli in `laravel/Modules/*` senza approvazione esplicita del maintainer.

## Obbligo operativo

1. Prima di ogni sviluppo, verificare i moduli esistenti in `laravel/config/modules_statuses.json` e `laravel/modules_statuses.json`.
2. Implementare feature e fix estendendo i moduli esistenti.
3. Se emerge un bisogno architetturale nuovo, aprire prima una GitHub Discussion e una GitHub Issue di proposta.
4. Solo dopo approvazione documentata creare eventuale nuovo modulo.

## Enforcement

- Ogni PR/task che introduce un modulo non approvato e' da considerarsi non conforme.
- In caso di errore, rimuovere subito il modulo e aggiornare issue/discussion con RCA e azioni preventive.
