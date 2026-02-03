# Task: Implementare Schema.org per Eventi - Seo

**Modulo**: Seo
**Priorita'**: Media
**Completamento**: 0%
**Data**: 2026-01-30

---

## Scopo e responsabilita'

- **Seo**: assemblare e rendere disponibile JSON-LD nelle pagine (Cms/Theme), evitando duplicazione di logica di dominio.
- **Meetup**: source-of-truth per i dati Event/EventSeries/Join/Leave/Reservation.
- **Geo**: source-of-truth per Place/PostalAddress/GeoCircle.

## Funzionalita'

- [ ] Schema.org Event markup (JSON-LD)
- [ ] Schema.org EventSchedule (Schedule via `eventSchedule`) per eventi ricorrenti
- [ ] Schema.org EventSeries per eventi ricorrenti (serie) e collegamento con Event (`superEvent`/`subEvent`)
- [ ] Schema.org JoinAction / LeaveAction per flussi registrazione/disiscrizione (come `potentialAction` o come dati di audit/export)
- [ ] Schema.org EventReservation per pagine/conferme prenotazione (se esistono nel flusso)
- [ ] Schema.org EducationEvent per eventi formativi (workshop/corsi)
- [ ] Schema.org attendee (non `attendees`, che è superseded) e distinzione con `participant` (Action)
- [ ] Schema.org Organization per LaravelPizza
- [ ] Schema.org Person per speaker
- [ ] Schema.org Place per venue
- [ ] Schema.org FoodEstablishment + Offer + DeliveryChargeSpecification (per delivery) quando applicabile
- [ ] Schema.org GeoCircle per area servita (delivery radius / eventi vicino a me)
- [ ] Breadcrumb schema
- [ ] FAQ schema per pagine informative

---

## Note di modellazione (vincoli)

- Se un Event usa `eventSchedule` (Schedule) in JSON-LD, evitare di emettere anche `startDate`/`endDate` sullo stesso Event (ambiguita').
- `attendees` e' superseded: usare `attendee`.

## Criteri di Completamento

- [ ] JSON-LD generato per pagine evento
- [ ] Validato con Google Rich Results Test
- [ ] Integrazione con modulo Meetup
- [ ] Validato anche con https://validator.schema.org/
- [ ] Documentazione aggiornata nei moduli coinvolti (Meetup/Geo/Cms)

---

## Step operativi

- [ ] Definire l’entrypoint di generazione JSON-LD per pagina evento (Cms/Theme): dove viene iniettato lo script e in quale view/layout.
- [ ] Definire un contratto/DTO per il payload schema.org dell’evento (es. array serializzato) che venga dal modulo Meetup e non dal Seo.
- [ ] Comporre il grafo JSON-LD includendo:
  - `Event`/`EducationEvent`
  - `EventSeries` (se applicabile)
  - `Schedule` via `eventSchedule` (se applicabile)
  - `Place`/`PostalAddress` (da Geo)
  - `Offer` / `DeliveryChargeSpecification` / `PriceSpecification` (se applicabile)
  - `potentialAction` (Join/Leave) se si decide di pubblicarlo in pagina
- [ ] Rendere la composizione idempotente (no duplicati, no campi null non necessari).

---

## Checklist validazione

- [ ] Validare con https://validator.schema.org/ (struttura, tipi, campi).
- [ ] Validare con Google Rich Results Test (quando applicabile).
- [ ] Verificare che non ci siano ambiguita' start/end vs schedule.
- [ ] Verificare coerenza URL canoniche e `@id` tra Event, Place, Offer.

---

## Nota: ricerca Schema.org e robots.txt

Alcune pagine di ricerca Schema.org (es. `https://schema.org/docs/search_results.html?...`) possono essere bloccate da robots.txt e non sempre sono fetchabili automaticamente.

- [ ] Se serve utilizzare quelle pagine come fonte: aprire manualmente in browser e copiare/incollare i risultati rilevanti (o screenshot) dentro una nota/issue interna.
- [ ] Aggiornare questo task con i link effettivamente usati come fonte (o con un estratto testuale) per rendere riproducibile la ricerca.

---

## Collegamenti

- [Meetup: tasks-schema-org-event-series-actions](../../Meetup/docs/tasks-schema-org-event-series-actions.md)
- [Geo: tasks-schema-org-place-geocircle](../../Geo/docs/tasks-schema-org-place-geocircle.md)
