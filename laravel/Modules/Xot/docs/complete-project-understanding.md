<<<<<<< .merge_file_Rd1E67
# healthcare_app Fila4 Mono - Filosofia Completa del Progetto
=======
# ModuloEsempio Fila4 Mono - Filosofia Completa del Progetto
>>>>>>> .merge_file_pvn0TA

## Logica (Logic)

### Architettura del Sistema
<<<<<<< .merge_file_Rd1E67
healthcare_app è un sistema completo di gestione survey basato su Laravel 12 + Filament 4 con il framework Laraxot. L'architettura è modulare e segue il pattern:

```
Xot (Motore) → Moduli Specifici (User, healthcare_app, etc.) → Funzionalità
=======
ModuloEsempio è un sistema completo di gestione survey basato su Laravel 12 + Filament 4 con il framework Laraxot. L'architettura è modulare e segue il pattern:

```
Xot (Motore) → Moduli Specifici (User, ModuloEsempio, etc.) → Funzionalità
>>>>>>> .merge_file_pvn0TA
```

### Domain Model Principale
1. **Customer** - Entità principale, estende BaseTenant per multi-tenancy
2. **SurveyPdf** - Collega Customer a LimeSurvey e contiene le domande
3. **Contact** - Contatto che riceve inviti survey
4. **QuestionChart** - Grafico per visualizzare risposte alle domande

### Workflow Principale
1. Creazione Customer
2. Creazione SurveyPdf collegata al Customer
3. Creazione Contacts tramite CreateContactFromArrayAction
4. Aggiornamento token tramite UpdateContactTokenAction (queueable)
5. Invio inviti tramite SendInviteAction
6. Visualizzazione dati tramite QuestionChart e widget Filament
7. Generazione PDF tramite MakePdf2Action

## Religione (Religion)

### Comandamenti Sacri
1. **Mai estendere classi Filament direttamente** - Usare sempre XotBase* classes
2. **Mai usare property_exists() su modelli Eloquent** - Usare isset() o hasAttribute()
3. **Customer è il centro dell'universo** - Tutto deve essere collegato a Customer
4. **Token è sacro** - Non modificare manualmente i token dei Contact
5. **NO CONTROLLER, NO ROUTES per export** - Usare solo Filament Actions
6. **Usare Actions invece di Services** - Pattern Spatie Queueable Actions
7. **Una tabella = una migrazione** - Ogni tabella deve avere una sola migrazione responsabile
8. **Mai modificare phpstan.neon** - File sacro, non deve essere modificato

### Best Practices
- Usare XotBaseResource per tutte le Filament Resource
- Usare XotBaseServiceProvider per tutti i Service Provider
- Usare XotBaseModel come classe base per i modelli
- Usare Actions per tutta la business logic
- Usare Data Objects per i filtri complessi

## Politica (Politics)

### Decisioni Architetturali
1. **Multi-tenant First** - Tutto è multi-tenant aware
2. **LimeSurvey Integration** - Integrazione profonda con sistema esterno
3. **Queueable Actions** - Tutte le operazioni asincrone sono queueable
4. **Widget-Based Visualization** - Visualizzazione dati tramite widget Filament
5. **Translation-First Approach** - Nessun hardcoded labels
6. **Theme as "Vestito"** - Themes forniscono solo presentazione

### Governance
- PHPStan Level 10 richiesto per tutti i moduli
- Laravel Pint per formattazione
- PHPMD e PHPInsights per quality gates
- Multi-language support richiesto (it, en, de)

## Zen (Zen)

### Principi Zen
1. **Semplicità** - Il codice più semplice è il migliore
2. **Flusso** - Il codice deve fluire naturalmente
3. **Vuoto** - Rimuovere il non necessario
4. **Armonia** - Tutto deve essere in equilibrio
5. **Presenza** - Essere presenti nel codice, non distratti

### Pratiche Zen
- Actions single-purpose
- Widget focused
- Data Objects minimali
- No over-engineering
- Workflow lineari: Customer → SurveyPdf → Contact → Invite

## Business Logic

<<<<<<< .merge_file_Rd1E67
### Modulo healthcare_app
=======
### Modulo ModuloEsempio
>>>>>>> .merge_file_pvn0TA
- **Customer Management**: Gestione clienti e organizzazioni
- **Survey Management**: Creazione e gestione survey tramite LimeSurvey
- **Contact Management**: Gestione contatti e inviti
- **Question Chart Management**: Visualizzazione dati e grafici
- **Export System**: PDF e XLS generation tramite Filament Actions

### Pattern Architetturali
1. **Action Pattern**: Tutte le operazioni di business sono Actions
2. **Data Object Pattern**: Dati complessi in Data Objects (Spatie Laravel Data)
3. **Widget Pattern**: Visualizzazione dati tramite Widget Filament
4. **Export Pattern**: Esportazioni solo tramite Filament Actions

## Organizzazione Files

### Directory bashscripts
Gli script sono organizzati in sottocartelle tematiche:
- `analysis/` - Script per analisi del codice
- `refactor/` - Script per refactoring
- `php/` - Script specifici per PHP
- `git/` - Script per gestione Git
- `maintenance/` - Script per manutenzione
- `testing/` - Script per testing
- `docs/` - Script per documentazione
- e molte altre...

### Convenzioni Documentazione
- File .md solo dentro cartelle docs esistenti
- Nessun file .md con maiuscole tranne README.md e CHANGELOG.md
- Nessun file .md con date nel nome
- Prima di creare un nuovo file, verificare che non esista già un documento sullo stesso argomento

## MCP Configuration

Il sistema è configurato con Model Context Protocol (MCP) per potenziare IDE AI. Gli MCP servers sono configurati per:
- Filesystem access ai percorsi Laravel, Modules, Themes
- GitHub integration per PR, issues, code reviews
- Memory per ricordare context e decisioni architetturali
- Sequential thinking per problem-solving strutturato
- Web content fetching
- Laravel command boosting

## Conclusione

<<<<<<< .merge_file_Rd1E67
healthcare_app rappresenta un sistema che riflette principi profondi di semplicità, chiarezza e armonia. Ogni riga di codice è una manifestazione dei principi DRY, KISS, SOLID e robustezza. Il sistema è progettato per essere mantenibile, scalabile e affidabile, seguendo un'architettura rigorosamente modulare dove ogni componente ha un ruolo preciso e prevedibile.
=======
ModuloEsempio rappresenta un sistema che riflette principi profondi di semplicità, chiarezza e armonia. Ogni riga di codice è una manifestazione dei principi DRY, KISS, SOLID e robustezza. Il sistema è progettato per essere mantenibile, scalabile e affidabile, seguendo un'architettura rigorosamente modulare dove ogni componente ha un ruolo preciso e prevedibile.
>>>>>>> .merge_file_pvn0TA

La "Super Mucca" approccio richiede di analizzare a fondo il codice e le cartelle docs per capire la logica, la filosofia, la religione, la politica e lo zen del progetto prima di implementare qualsiasi cambiamento. La cartella docs è la memoria del sistema e deve essere costantemente aggiornata, studiata e migliorata.
