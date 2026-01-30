# Prenotazione Paziente da URL /it/patient/book

## Introduzione
Questo documento dettaglia la funzionalità di prenotazione diretta tramite la URL `/it/patient/book`, pensata per offrire un'esperienza semplificata e mobile-first per la prenotazione di visite odontoiatriche.

## Obiettivi
- Ridurre i passaggi necessari per la prenotazione
- Migliorare l'esperienza utente, soprattutto da mobile
- Integrare selezione servizio, data, orario e conferma in un unico flusso
- Validare documenti e requisiti prima della conferma
- Collegare notifiche e gestione backoffice

## User Story
Come paziente voglio poter prenotare una visita accedendo direttamente a /it/patient/book, scegliendo servizio, data e orario, caricando eventuali documenti richiesti e ricevendo conferma immediata, così da velocizzare il processo senza passaggi intermedi.

## Acceptance Criteria
- Accesso diretto a /it/patient/book senza login obbligatorio (se già autenticato)
- Form unico con selezione servizio, data, orario, upload documenti
- Validazione dati e documenti in tempo reale
- Conferma e notifica immediata (email/SMS/push)
- Visualizzazione stato prenotazione nell'area personale

## Flusso utente dettagliato
1. Accesso diretto alla pagina `/it/patient/book`
2. Visualizzazione form unico:
   - Selezione servizio (dropdown, ricerca, preferiti)
   - Selezione data e orario disponibili (calendar picker, slot)
   - Upload/validazione documenti richiesti (ISEE, gravidanza, tessera sanitaria)
   - Conferma prenotazione
3. Ricezione conferma e notifica (email/SMS/push)
4. Visualizzazione stato prenotazione nell'area personale
5. Possibilità di annullare/modificare la prenotazione

## Dettagli tecnici previsti
- Componente Livewire dedicato per la gestione del flusso
- Utilizzo di Spatie Laravel Data per la validazione dei dati
- Integrazione con sistema notifiche (email, SMS, push)
- Logging e tracciamento azioni per audit
- Ottimizzazione UI/UX per mobile (Tailwind, Filament, Volt)
- Test di validazione e copertura edge case
- Gestione errori con ValidationException::withMessages
- Collegamento con backoffice per verifica e approvazione

## Test previsti
- Test unitari su validazione dati e documenti
- Test end-to-end del flusso di prenotazione
- Test di notifica e feedback utente
- Test responsive e accessibilità
- Test di integrazione con backoffice e notifiche

## Impatti su altri moduli
- Modulo Notifiche: invio conferme e reminder
- Modulo Backoffice: gestione richieste e approvazioni
- Modulo Patient: aggiornamento storico e stato prenotazioni
- Modulo UI/UX: nuovi componenti e ottimizzazione mobile

## Rischi e criticità
- Complessità validazione documenti in tempo reale
- Dipendenza da fornitori terzi per SMS/push
- Performance su dispositivi mobili
- Edge case su doppie prenotazioni o slot occupati

## Tabella dipendenze
| Dipendenza           | Stato     | Note                                  |
|---------------------|-----------|---------------------------------------|
| Sistema Notifiche   | In sviluppo | Integrazione email/SMS/push           |
| Modulo Backoffice   | Pronto     | Flusso approvazione                   |
| Modulo Patient      | Pronto     | Aggiornamento storico                 |
| UI/UX Mobile        | In sviluppo | Ottimizzazione e test                 |

## Esempi di UI/UX
- Form unico step-by-step (wizard semplificato)
- Calendar picker mobile-friendly
- Feedback visivo immediato su validazione
- Pulsante conferma grande e ben visibile
- Messaggio di conferma con icona e riepilogo

## Collegamenti e backlink
- [Torna alla Roadmap Frontoffice](../roadmap_frontoffice.md)
- [Prenotazione Visite](./07-prenotazione-visite.md)
- [UI/UX Base](./03-ui-ux-base.md)
- [Sistema Notifiche](./28-sistema-notifiche.md)
- [Backoffice](./09-backoffice.md)

> La pagina /it/patient/book è orchestrata dalla blade tematica Themes/One/resources/views/pages/patient/book.blade.php che include solo widget modulari. Ogni widget incluso DEVE restituire un solo root element HTML. File legacy come app/Livewire/Patient/Book.php o resources/views/livewire/patient/book.blade.php NON devono esistere in architettura modulare.

> [2025-05-28] La pagina ora include direttamente il widget Filament FindDoctorAndAppointmentWidget, come da policy architetturale. Nessun form custom, solo widget modulari. Aggiornamento documentato anche in docs/rules/filament_best_practices.md.

---

*Ultimo aggiornamento: 28 Maggio 2025* 