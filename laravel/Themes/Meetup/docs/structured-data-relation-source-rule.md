# Structured Data Relation Source Rule

## Regola

Nel tema `Meetup` il JSON-LD e i blocchi pubblici non devono inventare relazioni many-to-many con query ad hoc o assumere `belongsToMany()` plain.

Quando la pagina espone:

- organizer
- performer
- sponsor
- attendees

la sorgente canonica resta il modello backend con relazioni Laraxot `belongsToManyX()`.

## Obiettivo

Mantenere coerenti:

- UI visibile;
- dati del block CMS;
- structured data `schema.org`;
- relazioni del dominio `Meetup`.

## Anti-pattern

- fare query Blade che replicano male i pivot;
- documentare relazioni `belongsToMany()` nel tema;
- emettere JSON-LD con nodi che non corrispondono ai dati reali del backend.
