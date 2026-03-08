# MEMORIA: NON Creare Nuovi Moduli - Usa Quelli Esistenti

**Data**: 08-03-2026
**Contesto**: Sviluppo RSVP per Meetup

## Regola Fondamentale

**MAI creare nuovi moduli quando la funzionalita' esiste gia' nel modulo Meetup!**

### Moduli Esistenti in Meetup

Tutta la logica relativa agli eventi esiste gia' in `Modules/Meetup/`:

```
Modules/Meetup/
├── app/
│   ├── Models/
│   │   ├── Event.php              # Evento principale
│   │   ├── EventUser.php          # Pivot registrazione (attendees)
│   │   ├── EventSpeaker.php       # Relazione speaker
│   │   ├── EventSponsor.php       # Relazione sponsor
│   │   ├── Venue.php              # Luogo evento
│   │   ├── Performer.php          # Performers/Speakers
│   │   └── Sponsor.php            # Sponsor
│   └── Actions/
│       └── Event/
│           ├── RegisterAttendeeToEventAction.php   # ✅ Esisteva
│           ├── UnregisterAttendeeFromEventAction.php # ✅ Creata oggi
│           ├── CreateEventAction.php
│           ├── UpdateEventAction.php
│           ├── DeleteEventAction.php
│           └── ImportEventsFromJsonAction.php
```

### ERRORI DA NON FARE

❌ **SBAGLIATO**: Creare `Modules/Event/`, `Modules/EventRegistration/`, etc.

✅ **CORRETTO**: Usare `Modules/Meetup/Models/Event`, `Modules/Meetup/Models/EventUser`

### Perche'

1. **Coesione**: Tutta la logica meetup e' nel modulo Meetup
2. **Dependency**: I modelli gia' hanno relazioni configured
3. **Testing**: Test coverage gia' esistente nel modulo
4. **Namespace**: Nessuna dipendenza circolare

## Caso d'Uso: RSVP

Per implementare registrazione eventi:

1. **NON creare nuovo modulo EventRegistration**
2. **Usare** `Modules\Meetup\Models\EventUser` (pivot table)
3. **Usare** `Modules\Meetup\Actions\Event\RegisterAttendeeToEventAction`
4. **Estendere** `Event` model con metodi come `isUserRegistered()`, `isFull()`

## Riferimenti

- Issue: #485 - RSVP Backend Action
- Track A: #438
