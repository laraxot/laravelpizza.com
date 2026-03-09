# PHP Quality Gate Memory

## Snapshot

- Regola utente consolidata: ogni file PHP modificato richiede verifica post-edit con `phpstan`, `phpmd`, `phpinsights`.
- Se il file e' testabile, va cercato il test Pest associato; se manca, va creato o aggiornato.
- La verifica minima non e' mentale e non e' solo sintattica: `php -l` da solo non basta.
- Hotfix veloci o fix a view/page PHP non fanno eccezione.
- Il report finale deve sempre distinguere tra tool eseguito con successo e tool non disponibile nel repo.

## Ordine operativo

1. Docs-first su modulo e tema coinvolti.
2. Edit del file PHP.
3. Quality gate post-edit sul file/perimetro stretto.

Aggiornamento operativo (2026-03-09):

- Regola utente esplicita: dopo ogni modifica a file PHP eseguire sempre `phpstan`, `phpmd`, `phpinsights`.
- Se il file e testabile, il test Pest associato e obbligatorio: va eseguito e, se manca, va creato/aggiornato prima di dichiarare done.
4. Test Pest associato se il comportamento e' testabile.
5. Report finale con evidenza reale dei controlli eseguiti.

## Nota pratica

- Per file singoli, partire da comandi focalizzati riduce rumore e tempo di verifica.
- Se un tool non e' installato o produce un blocco infrastrutturale, il fatto va documentato e non nascosto.
