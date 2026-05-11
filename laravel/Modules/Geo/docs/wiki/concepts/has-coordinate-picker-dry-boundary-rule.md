# HasCoordinatePicker DRY Boundary Rule

## Regola

La trait `HasCoordinatePicker` deve contenere solo stato condiviso, configurazione condivisa e helper riusabili dell'intera famiglia picker. Le classi concrete (`CoordinatePicker`, `GeopointPicker`, `MapPicker`, ecc.) devono tenere solo cio' che e' davvero specifico del componente.

## Perche'

Nel refactor recente erano finite duplicate in piu' classi:

- proprieta `latitude` / `longitude`
- getter equivalenti
- logica di supporto non specifica del singolo field

Questo ha aumentato il rischio di drift, fatal e differenze arbitrarie fra picker fratelli.

## Best Practices

- mettere nella trait le proprieta condivise del contratto coordinate
- mettere nella trait i getter/setter condivisi quando non dipendono dalla view concreta
- lasciare nella classe concreta solo schema, naming, rendering e comportamento realmente specifico
- mantenere il contratto dei sibling components coerente
- usare la trait come sorgente unica per helper di famiglia

## Bad Practices

- duplicare `latitude` e `longitude` in piu' field
- copiare gli stessi getter tra `CoordinatePicker` e `GeopointPicker`
- mischiare logica runtime JS-specifica dentro la trait PHP
- far divergere i sibling component senza motivo architetturale

## False Friends

- "sono solo due proprieta" non giustifica duplicazione
- una trait non deve diventare un contenitore di tutto: solo codice davvero condiviso
- condividere stato non significa condividere per forza la view
- DRY non vuol dire ereditare markup o JS che hanno confini diversi

## Confine corretto

- trait: stato coordinate, config comune, helper riusabili
- field concreto: nome componente, view calcolata dall'owner corretto, varianti specifiche
- JS Lit: lifecycle mappa, resize, tile refresh, interazione utente
