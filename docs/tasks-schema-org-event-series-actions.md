# Task: Schema.org Event, EventSeries, azioni e partecipanti

**Obiettivo:** utilizzare i tipi Schema.org studiati (Event, EventSchedule, EventSeries, JoinAction, LeaveAction, EventReservation, EducationEvent, attendee/attendees, participant) per arricchire dati strutturati e modelli del modulo Meetup.

**Riferimento:** [schema-org-enhancement-recommendations](schema-org-enhancement-recommendations.md) (sezione "Reference: Schema.org types studiati") · [event-schema-org-implementation](event-schema-org-implementation.md)

---

## Task 1: Event – completare toSchemaOrg() e campi

- [ ] Verificare che `Event::toSchemaOrg()` esponga almeno: `name`, `startDate`, `endDate`, `eventStatus`, `eventAttendanceMode`, `location`, `organizer`, `offers`, `maximumAttendeeCapacity`, `isAccessibleForFree`, `inLanguage`.
- [ ] Allineare enum/campo `event_status` ai valori Schema.org (`EventScheduled`, `EventCancelled`, `EventPostponed`, `EventRescheduled`).
- [ ] Allineare `event_attendance_mode` a `OfflineEventAttendanceMode` / `OnlineEventAttendanceMode` / `MixedEventAttendanceMode`.
- [ ] Includere `location` come Place (con `address` e `geo`) quando è disponibile `place_id`; altrimenti VirtualLocation se solo URL.
- [ ] Aggiungere in JSON-LD `performer` (speaker/relatori) e, se consentito da privacy, `attendee` (non `attendees`, che è superseded) come Person/Organization o lista.

---

## Task 2: EventSchedule e ricorrenza

- [ ] Definire dove memorizzare la ricorrenza (es. campo `recurrence` o relazione a `EventSeries`).
- [ ] Se l’evento usa `eventSchedule` (Schedule) in JSON-LD, non emettere anche `startDate`/`endDate` sullo stesso Event: devono stare nella Schedule per evitare ambiguità.
- [ ] Se l’evento fa parte di una serie ricorrente, emettere in JSON-LD un `eventSchedule` (Schedule) con `repeatFrequency`, `byDay`, `startTime`, `endTime`, `duration`, `scheduleTimezone` (dove applicabile).
- [ ] Documentare in docs Meetup la convenzione: evento singolo vs evento in serie (EventSeries + subEvent).

---

## Task 3: EventSeries per meetup ricorrenti

- [ ] Valutare modello/tabella `event_series` (nome, descrizione, pattern ricorrente, team/organizer).
- [ ] Collegare `events` a `event_series` (es. `event_series_id`) dove applicabile.
- [ ] In JSON-LD: per eventi in serie, emettere tipo `EventSeries` come contenitore con `subEvent` che punta ai singoli Event; oppure ogni Event con `superEvent` che punta alla serie.
- [ ] Aggiornare [schema-org-enhancement-recommendations](schema-org-enhancement-recommendations.md) con la scelta adottata (nuovo modello vs solo JSON-LD).

---

## Task 4: JoinAction e LeaveAction (registrazione / disiscrizione)

- [ ] Modellare la registrazione a un evento (RSVP) in modo che possa essere rappresentata come **JoinAction**: `event` = Event e/o `object` = Event; `agent` = Person; usare `participant` per co-agenti solo se necessario.
- [ ] Modellare la disiscrizione come **LeaveAction** (stesso pattern).
- [ ] Decidere se emettere JoinAction/LeaveAction in JSON-LD nelle pagine evento (es. "Registrati" come azione disponibile) o solo in Activity/audit; documentare in docs.
- [ ] Se si usa Activity log: mappare azioni "registered" → JoinAction, "unregistered" → LeaveAction per export/API strutturati.

---

## Task 5: EventReservation (prenotazione / biglietto)

- [ ] Se è prevista prenotazione con identificativo: modellare come **EventReservation** (`reservationFor` = Event, `underName` = Person, `reservationStatus`, `reservationId`).
- [ ] Collegare eventuale modello Ticket/Offer al reservation per prezzo e validità.
- [ ] In pagina evento/dettaglio prenotazione: emettere JSON-LD EventReservation dove utile per SEO/assistenti.

---

## Task 6: EducationEvent (eventi formativi)

- [ ] Aggiungere flag o tipo "formativo" (es. `is_education_event` o tipo `education_event`) dove il meetup è esplicitamente workshop/corso.
- [ ] Per tali eventi emettere `@type: EducationEvent` invece di solo `Event` in JSON-LD.
- [ ] Compilare proprietà specifiche EducationEvent (es. `teaches`, `educationalLevel`) se i dati sono disponibili; altrimenti lasciare solo il tipo.

---

## Task 7: attendee / attendees / participant

- [ ] In `Event::toSchemaOrg()`: se la policy privacy lo consente, includere `attendee` (singolo o ripetuto) come Person/Organization; non usare `attendees` (superseded).
- [ ] Nei componenti di registrazione: esporre l’azione "Registrati" in modo che possa essere interpretata come JoinAction (link o form con `itemType`/structured data).
- [ ] Per speaker/relatori: usare `performer` (Person) in Event; per "chi ha compiuto l’azione" in Join/Leave usare `participant`.

---

## Verifica finale

- [ ] Validare output JSON-LD con [validator.schema.org](https://validator.schema.org/) e con Google Rich Results Test.
- [ ] Verificare che non ci siano ambiguità startDate/endDate: o Event singolo con start/end, oppure Event con eventSchedule.
- [ ] Aggiornare [event-schema-org-implementation](event-schema-org-implementation.md) con eventuali nuovi campi e convenzioni.
- [ ] Collegare questo file da [rules-index](rules-index.md) o [00-index](00-index.md) nella sezione Schema.org / task.

---

## Nota: ricerca Schema.org e robots.txt

Alcune pagine Schema.org (in particolare `https://schema.org/docs/search_results.html?...`) possono essere bloccate da robots.txt.

- [ ] Se servono come fonte: aprire manualmente in browser e riportare nel repo un estratto (testo o screenshot) con i punti chiave.
- [ ] Preferire come fonte primaria le pagine “tipo” (Event, EventSeries, eventSchedule, JoinAction, LeaveAction, EventReservation, EducationEvent) che sono fetchabili.

---

## Collegamenti

- [schema-org-enhancement-recommendations](schema-org-enhancement-recommendations.md)
- [event-schema-org-implementation](event-schema-org-implementation.md)
- [task-registrazione-rsvp](task-registrazione-rsvp.md)
- [business-logic](business-logic.md)
