# Regola: NON Creare Nuovi Moduli - Usa Quelli Esistenti

**Data**: 08-03-2026
**Regola**: CRITICA

## Principio

**MAI creare nuovi moduli quando la funzionalita' esiste gia' nel codebase!**

## Motivazione

1. **Coesione**: Ogni modulo ha gia' la sua logica di dominio
2. **Relazioni**: I modelli hanno gia' relazioni configurate
3. **Testing**: Coverage gia' esistente nel modulo
4. **Zero dipendenze circolari**

## Moduli Esistenti

Tutta la logica relativa agli eventi esiste in `Modules/Meetup/`:

```
Modules/Meetup/
├── app/
│   ├── Models/
│   │   ├── Event.php              # Evento principale
│   │   ├── EventUser.php          # Pivot registrazione
│   │   ├── EventSpeaker.php       # Speaker
│   │   ├── EventSponsor.php       # Sponsor
│   │   ├── Venue.php              # Luogo
│   │   └── ...
│   └── Actions/
│       └── Event/
│           ├── RegisterAttendeeToEventAction.php
│           ├── UnregisterAttendeeFromEventAction.php
│           └── ...
```

## Esempi

### SBAGLIATO
```
❌ Creare Modules/EventRegistration/
❌ Creare Modules/EventFeedback/
❌ Creare Modules/EventTicket/
```

### CORRETTO
```
✅ Usare Modules/Meetup/Models/Event
✅ Usare Modules/Meetup/Models/EventUser (pivot)
✅ Usare Modules/Meetup/Actions/Event/RegisterAttendeeToEventAction
```

## Workflow

Prima di creare qualcosa di nuovo:

1. **Cercare** nei moduli esistenti (`Modules/*/`)
2. **Verificare** se il modello/azione esiste gia'
3. **Estendere** invece di creare
4. **Solo se non esiste**, creare nel modulo appropriato

## Violazioni

- Creazione di moduli duplicati
- Re-invenzione di funzionalita' esistenti
- Breaking di relazioni esistenti

## Riferimenti

- Memory: `docs/memory/no-new-modules-use-existing-memory.md`
- AGENTS.md: Sezione "REGOLA CRITICA: NON Creare Nuovi Moduli"
