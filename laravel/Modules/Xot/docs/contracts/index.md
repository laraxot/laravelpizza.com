# Contratti del Modulo Xot

Questa sezione contiene la documentazione dei contratti (interfaces) disponibili nel modulo Xot.

## Contratti per i Modelli

### ModelWithPosContract

Il [ModelWithPosContract](model-with-pos-contract.md) definisce l'interfaccia per i modelli che supportano il posizionamento ordinato degli elementi. Fornisce metodi per:

- Gestione della posizione degli elementi
- Riordinamento della collezione
- Supporto per drag-and-drop
- Gestione delle relazioni gerarchiche tramite parent_id

[Vai alla documentazione completa](model-with-pos-contract.md)

### ModelWithAuthorContract

Il [ModelWithAuthorContract](model-with-author-contract.md) definisce l'interfaccia per i modelli che necessitano di tracciare gli autori delle modifiche. Fornisce metodi per:

- Gestione degli autori dei record
- Tracciamento delle modifiche
- Audit trail e logging
- Relazioni con gli utenti autori

[Vai alla documentazione completa](model-with-author-contract.md)

### ModelWithUserContract

Il [ModelWithUserContract](model-with-user-contract.md) definisce l'interfaccia per i modelli che necessitano di una relazione con un utente proprietario. Fornisce metodi per:

- Gestione della proprietà degli elementi
- Verifica dell'appartenenza
- Autorizzazioni basate su utente
- Relazioni utente-elemento

[Vai alla documentazione completa](model-with-user-contract.md)

### ModelWithStatusContract

Il [ModelWithStatusContract](model-with-status-contract.md) definisce l'interfaccia per i modelli che necessitano di gestire stati multipli. Fornisce metodi per:

- Gestione degli stati dei modelli
- Storico delle transizioni di stato
- Motivi dei cambi di stato
- Integrazione con Spatie Laravel Model Status

[Vai alla documentazione completa](model-with-status-contract.md) 
## Collegamenti tra versioni di index.md
* [index.md](../../../Xot/docs/contracts/index.md)
* [index.md](../../../Cms/docs/frontend-architecture/index.md)
* [index.md](../../../../Themes/One/docs/roadmap/philosophy/index.md)
* [index.md](../../../../Themes/One/docs/roadmap/inspiration/index.md)

