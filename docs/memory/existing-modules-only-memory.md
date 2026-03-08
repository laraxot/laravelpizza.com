# Existing Modules Only Memory

## Contesto

In piu' sessioni sono comparsi scaffold non richiesti di moduli `Event*`, inclusi `EventAttendee` e `EventOrganizer`.

## Lezione appresa

- Il dominio eventi/meetup deve vivere nei moduli gia' esistenti (es. `Meetup`, `User`, `Cms`, `Notify`).
- La creazione di nuovi moduli senza decisione architetturale condivisa genera frammentazione e backlog rumoroso.

## Promemoria permanente

Prima di qualsiasi implementazione:

1. controllare i moduli esistenti;
2. preferire estensione di model/action/test/docs nei moduli attivi;
3. aprire discussione+issue prima di proporre nuovi moduli;
4. se compare un modulo non autorizzato, rimuoverlo subito e registrare il fix su issue/discussion.
