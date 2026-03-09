# HasBlocks Parse Error Memory

Data: 2026-03-09

## Evento
Fatal error homepage: token inatteso `if` in `Modules/Cms/app/Models/Traits/HasBlocks.php`.

## Root cause
Riga corrotta da placeholder purge in assegnazione (`$blocks = // ...`) che rende il file PHP non parsabile.

## Mitigazione
- ripristinare assegnazione valida
- lint file con `php -l`
- tracciare fix su issue/discussion blocker parse errors
