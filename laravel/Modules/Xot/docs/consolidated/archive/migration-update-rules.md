# Regole generali per aggiornamento colonne e gestione errori schema

## Collegamento bidirezionale
- Questo file è collegato a casi specifici documentati nei moduli, ad esempio:
  [Modules/Performance/project_docs/organizzativa-migration-errors.md](../../Performance/project_docs/organizzativa-migration-errors.md)

## Caso pratico: Performance
- Per l’errore su `valutatore_id` in `performance_organizzativa`, vedere la documentazione dettagliata nel modulo Performance.

## Ribadire la regola
- Per aggiunta colonne: copiare la migrazione originale, aggiornare timestamp, aggiungere colonna solo se non esiste. Mai nuove migrazioni di update.
- Motivazione: una sola fonte di verità, coerenza tra ambienti, facilità manutenzione DB.

## Regola
- Quando si aggiunge una colonna a una tabella esistente:
  - NON creare una nuova migrazione di creazione.
  - Copiare la migrazione originale, aggiornare il timestamp, aggiungere la colonna nella sezione di update solo se non esiste.
  - Non implementare mai il metodo down se si estende XotBaseMigration.
  - Documentare sempre la modifica nella cartella docs del modulo e nella root (tramite link).
- Aggiornare la documentazione di ogni intervento strutturale.

## Note
- Per casi specifici e casistiche di errore consultare la documentazione dei singoli moduli (es. Performance).
