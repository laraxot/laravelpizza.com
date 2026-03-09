# belongsToManyX Governance Memory

## Decisione da ricordare

In LaravelPizza non si usa `belongsToMany()` come default applicativo.

La relazione many-to-many canonica del progetto e' `belongsToManyX()`.

## Perche'

- il progetto si appoggia alle convenzioni Laraxot `RelationX`;
- i moduli si aspettano pivot e chiavi risolti secondo questa convenzione;
- introdurre `belongsToMany()` crea deriva locale, esempi sbagliati e debugging fuorviante.

## Implicazione pratica

Quando leggo o scrivo:

- modelli `Meetup`;
- docs di architettura;
- esempi per test o risorse Filament;

devo presumere `belongsToManyX()` fino a prova contraria.

Se trovo docs che dicono il contrario, vanno corrette prima di fidarsi del contenuto.
