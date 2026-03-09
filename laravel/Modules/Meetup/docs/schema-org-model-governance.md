# Meetup Schema.org Model Governance

## Obiettivo

Il modulo `Meetup` deve essere `rich snippets ready`.

Questo obiettivo va interpretato correttamente:
- ogni model di dominio rilevante deve poter produrre structured data completo e accurato;
- il model non deve trasformarsi in una copia meccanica della pagina `schema.org`;
- il mapping puo' usare attributi persistiti, relazioni, enum, oggetti derivati e `meta_data`.

## Perche' mettere in dubbio "tutti gli elementi di schema.org nel model"

Su `schema.org`, tipi come `Event`, `Person`, `Organization` e `Place` ereditano un numero molto alto di proprieta'.

Applicare la regola in modo letterale porterebbe a:
- model gonfiati con campi mai usati;
- duplicazione tra database, accessor e structured data;
- perdita di DRY e di chiarezza;
- documentazione che dichiara compliance senza implementazione reale.

La regola corretta e' quindi:

> ogni model `Meetup` deve avere un contratto di serializzazione `schema.org` completo per i dati che il dominio possiede o puo' derivare in modo affidabile.

## Canonical type map

| Model | Canonical type | Note |
|------|------|------|
| `Event` | `Event` | modello principale rich result |
| `Venue` | `Place` | eventualmente sottotipo piu' specifico se il dominio lo giustifica |
| `Performer` | `Person` / `PerformingGroup` | dipende dal soggetto reale |
| `Sponsor` | `Organization` | puo' contribuire come nested `sponsor` |
| `Profile` | `Person` | profilo speaker/organizer/attendee |
| `Feedback` | `Review` | review dell'evento |
| `EventUser` | `EventReservation` / `JoinAction` | rappresentazione derivata, non root entity obbligatoria |
| `EventPerformer` | `Role` o nodo nested | collega performer e evento |
| `EventSponsor` | nodo nested | collega sponsor e evento |

## Minimum governance per model

Ogni model rilevante deve avere:
- type canonico esplicito;
- metodo `toSchemaOrg()` o equivalente;
- nested entities collegate quando il dominio le conosce;
- test Pest del mapping;
- documentazione che distingua chiaramente `implemented`, `derived`, `gap`.

## Stato attuale sintetico

- `Event` ha una base `toSchemaOrg()`, ma non basta per dichiarare copertura completa di `schema.org/Event`.
- Gli altri model `Meetup` non hanno ancora un contratto `schema.org` esplicito equivalente.
- La priorita' corretta e' passare da copertura opportunistica a coverage matrix per model.

## Fonti primarie

- https://schema.org/Event
- https://schema.org/Place
- https://schema.org/Person
- https://schema.org/Organization
- https://schema.org/Review
- https://schema.org/EventReservation
- https://schema.org/Role
