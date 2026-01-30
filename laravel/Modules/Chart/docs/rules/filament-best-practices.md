# Best Practices Filament

## Principi di Design
1. **Modularità**:
   - Componenti indipendenti
   - Interfacce chiare
   - Basso accoppiamento

2. **Riutilizzabilità**:
   - Componenti generici
   - Pattern riconoscibili
   - Documentazione chiara

## Architettura
1. **Struttura**:
   - Organizzazione logica
   - Separazione responsabilità
   - Scalabilità

2. **Integrazione**:
   - Comunicazione standardizzata
   - Eventi ben definiti
   - Gestione errori robusta

## Sviluppo
1. **Metodologia**:
   - Test-driven development
   - Code review sistematiche
   - Documentazione continua

2. **Qualità**:
   - Codice pulito
   - Standard consistenti
   - Manutenibilità

## UI/UX
1. **Design**:
   - Coerenza visiva
   - Usabilità
   - Accessibilità

2. **Interazione**:
   - Feedback immediato
   - Stati chiari
   - Errori gestiti

## Performance
1. **Ottimizzazione**:
   - Caricamento efficiente
   - Caching strategico
   - Query ottimizzate

2. **Monitoraggio**:
   - Metriche chiave
   - Analisi proattiva
   - Miglioramento continuo

## Sicurezza
1. **Protezione**:
   - Autorizzazioni granulari
   - Validazione robusta
   - Audit trail

2. **Conformità**:
   - Standard di sicurezza
   - Best practices
   - Documentazione

## Manutenzione
1. **Gestione**:
   - Versionamento
   - Changelog
   - Documentazione

2. **Supporto**:
   - Troubleshooting
   - Debugging
   - Performance tuning

## Gestione dei Temi

### Struttura del Tema
- Percorso: `/laravel/Themes/One/`
- Componenti principali in `components/sections/`
- Layout base in `components/layouts/`
- Blocchi in `components/blocks/`
- Stili in `resources/css/`

### Stili e Colori
- Utilizzare le variabili CSS di Filament
- Definire colori primari e secondari
- Gestire stati hover e focus
- Supportare tema dark/light

### Componenti UI
- Utilizzare classi Tailwind
- Definire stili base per bottoni
- Gestire stati interattivi
- Supportare accessibilità

### Best Practices
- Non sovrascrivere stili di Filament
- Utilizzare variabili CSS
- Mantenere coerenza visiva
- Testare su tutti i temi

## Struttura delle Risorse

### Pagine di Visualizzazione
- Utilizzare `ViewEntry` per preview personalizzate
- Implementare `translateLabel()` per le traduzioni
- Gestire correttamente i dati della vista
- Supportare multilingua

### Componenti Personalizzati
- Creare viste in `resources/views/`
- Utilizzare namespace corretto
- Passare dati necessari
- Gestire errori

## Gestione delle Traduzioni

### Struttura File
```php
return [
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta',
            'tooltip' => 'Descrizione',
        ],
    ],
    'actions' => [
        'action_name' => [
            'label' => 'Etichetta',
            'tooltip' => 'Descrizione',
            'icon' => 'heroicon-o-icon',
            'color' => 'primary',
        ],
    ],
];
```

### Best Practices
- Mantenere coerenza tra lingue
- Utilizzare chiavi descrittive
- Aggiungere tooltip
- Supportare icone e colori

## Preview dei Contenuti

### Sezioni
```php
ViewEntry::make('preview')
    ->translateLabel()
    ->view('cms::sections.preview', [
        'blocks' => $this->record->content_blocks,
        'section' => $this->record,
    ])
```

### Blocchi
- Componenti riutilizzabili
- Stili personalizzati
- Gestione errori
- Supporto multilingua

## Performance

### Ottimizzazione
- Eager loading relazioni
- Cache dei contenuti
- Query ottimizzate
- Asset minification

### Monitoraggio
- Log performance
- Alert threshold
- Report periodici
- Analisi utilizzo

## Sicurezza

### Controlli
- Validazione input
- Sanitizzazione output
- Permessi utente
- Audit log

### Backup
- Backup automatici
- Versionamento
- Ripristino dati
- Verifica integrità 

## Clean Code in Filament

### Principi Fondamentali

1. **Single Responsibility Principle (SRP)**
   - Ogni metodo deve avere una sola responsabilità
   - Separare la logica in metodi più piccoli e focalizzati
   - Esempio:
   ```php
   // ❌ NON FARE
   protected static function getPrivacyStep(): Forms\Components\Wizard\Step
   {
       return Forms\Components\Wizard\Step::make('privacy_step')
           ->schema([
               Forms\Components\View::make('patient::privacy-policy')
                   ->columnSpanFull(),
               Forms\Components\Checkbox::make('privacy_acceptance')
                   ->required()
                   ->columnSpanFull(),
               Forms\Components\Checkbox::make('newsletter')
                   ->columnSpanFull(),
           ]);
   }

   // ✅ FARE COSÌ
   protected static function getPrivacyStep(): Forms\Components\Wizard\Step
   {
       return Forms\Components\Wizard\Step::make('privacy_step')
           ->schema(self::getPrivacyStepSchema());
   }

   protected static function getPrivacyStepSchema(): array
   {
       return [
           Forms\Components\View::make('patient::privacy-policy')
               ->columnSpanFull(),
           Forms\Components\Checkbox::make('privacy_acceptance')
               ->required()
               ->columnSpanFull(),
           Forms\Components\Checkbox::make('newsletter')
               ->columnSpanFull(),
       ];
   }
   ```

2. **Naming Conventions**
   - Nomi descrittivi e autoesplicativi
   - Utilizzare il prefisso `get` per i metodi che restituiscono dati
   - Utilizzare il suffisso `Schema` per i metodi che definiscono schemi
   - Esempio:
   ```php
   protected static function getFormSchema(): array
   protected static function getPrivacyStepSchema(): array
   protected static function getPersonalDataStepSchema(): array
   ```

3. **Method Extraction**
   - Estrarre la logica complessa in metodi separati
   - Mantenere i metodi brevi e focalizzati
   - Riutilizzare il codice attraverso metodi dedicati
   - Esempio:
   ```php
   // ❌ NON FARE
   public function form(Form $form): Form
   {
       return $form->schema([
           // Logica complessa qui
       ]);
   }

   // ✅ FARE COSÌ
   public function form(Form $form): Form
   {
       return $form->schema($this->getFormSchema());
   }

   protected function getFormSchema(): array
   {
       return [
           $this->getPersonalDataSection(),
           $this->getDocumentsSection(),
           $this->getPrivacySection(),
       ];
   }
   ```

4. **Documentation**
   - Documentare ogni metodo pubblico
   - Spiegare il purpose di ogni metodo
   - Includere esempi di utilizzo
   - Esempio:
   ```php
   /**
    * Get the privacy step schema for the wizard
    * 
    * This method defines the form fields for the privacy step,
    * including the privacy policy view and consent checkboxes.
    * 
    * @return array<\Filament\Forms\Components\Component>
    */
   protected static function getPrivacyStepSchema(): array
   ```

5. **Code Organization**
   - Raggruppare metodi correlati
   - Mantenere un ordine logico
   - Separare interfaccia e implementazione
   - Esempio:
   ```php
   class PatientResource extends XotBaseResource
   {
       // 1. Properties
       protected static ?string $model = Patient::class;

       // 2. Public Methods
       public static function getFormSchema(): array
       public static function getFormSchemaWidget(): array

       // 3. Protected Methods - Step Definitions
       protected static function getPersonalDataStep(): Step
       protected static function getDocumentsStep(): Step
       protected static function getPrivacyStep(): Step

       // 4. Protected Methods - Schema Definitions
       protected static function getPersonalDataStepSchema(): array
       protected static function getDocumentsStepSchema(): array
       protected static function getPrivacyStepSchema(): array
   }
   ```

### Best Practices per i Wizard

### Struttura e Organizzazione

1. **Separazione delle Responsabilità**
   - Ogni step deve avere un metodo dedicato per la definizione dello step
   - Ogni step deve avere un metodo dedicato per lo schema
   - Esempio:
   ```php
   protected static function getPrivacyStep(): Forms\Components\Wizard\Step
   {
       return Forms\Components\Wizard\Step::make('privacy_step')
           ->schema(self::getPrivacyStepSchema());
   }

   protected static function getPrivacyStepSchema(): array
   {
       return [
           Forms\Components\View::make('patient::privacy-policy')
               ->columnSpanFull(),
           Forms\Components\Checkbox::make('privacy_acceptance')
               ->required()
               ->columnSpanFull(),
           Forms\Components\Checkbox::make('newsletter')
               ->columnSpanFull(),
       ];
   }
   ```

2. **Naming Conventions**
   - I metodi degli step devono seguire il pattern `get{StepName}Step`
   - I metodi degli schema devono seguire il pattern `get{StepName}StepSchema`
   - I nomi degli step devono essere in snake_case
   - Esempio:
   ```php
   getPersonalInfoStep()
   getPersonalInfoStepSchema()
   getPrivacyStep()
   getPrivacyStepSchema()
   ```

3. **Visibilità e Validazione**
   - La visibilità dello step deve essere definita nel metodo dello step
   - La validazione deve essere definita nel metodo dello step
   - Esempio:
   ```php
   protected static function getPrivacyStep(): Forms\Components\Wizard\Step
   {
       return Forms\Components\Wizard\Step::make('privacy_step')
           ->schema(self::getPrivacyStepSchema())
           ->visible(fn () => request()->has('token'))
           ->afterValidation(function (Forms\Set $set) {
               // Logica di validazione
           });
   }
   ```

4. **Organizzazione del Codice**
   - I metodi degli step devono essere raggruppati insieme
   - I metodi degli schema devono essere raggruppati insieme
   - Esempio:
   ```php
   class PatientResource extends XotBaseResource
   {
       // 1. Step Methods
       protected static function getPersonalInfoStep(): Step
       protected static function getPrivacyStep(): Step

       // 2. Schema Methods
       protected static function getPersonalInfoStepSchema(): array
       protected static function getPrivacyStepSchema(): array
   }
   ```

### Best Practices

1. **Riutilizzo del Codice**
   - Utilizzare metodi dedicati per gli schema
   - Evitare la duplicazione del codice
   - Mantenere la coerenza nella struttura

2. **Gestione delle Traduzioni**
   - Utilizzare il sistema di traduzione di Filament
   - Evitare l'uso diretto della funzione `__()`
   - Mantenere le traduzioni nei file dedicati

3. **Validazione e Sicurezza**
   - Implementare la validazione appropriata
   - Gestire correttamente i permessi
   - Mantenere la sicurezza dei dati

4. **Manutenibilità**
   - Documentare ogni metodo
   - Mantenere il codice pulito e organizzato
   - Seguire le convenzioni di codifica

### Errori da Evitare

1. **Naming degli Step**
   - ❌ `Step::make(__('step_name'))`
   - ❌ `Step::make('Step Name')->label(__('label'))`
   - ❌ `Step::make('Step Name')->description(__('description'))`
   - ✅ `Step::make('step_name')`

2. **Struttura del Codice**
   - ❌ Definire lo schema direttamente nel metodo dello step
   - ❌ Duplicare la logica tra gli step
   - ❌ Mischiare la logica di validazione con la definizione dello schema
   - ✅ Separare la definizione dello step dallo schema
   - ✅ Utilizzare metodi dedicati per ogni responsabilità

3. **Gestione delle Traduzioni**
   - ❌ Utilizzare `__()` direttamente nei form o nei widget
   - ❌ Definire le traduzioni inline
   - ✅ Utilizzare il sistema di traduzione di Filament
   - ✅ Mantenere le traduzioni nei file dedicati

4. **Validazione e Sicurezza**
   - ❌ Implementare la validazione in modo inconsistente
   - ❌ Ignorare i permessi e la sicurezza
   - ✅ Implementare una validazione coerente
   - ✅ Gestire correttamente i permessi
   - ✅ Mantenere la sicurezza dei dati

## Root element unico nei widget Livewire/Filament
Ogni widget Livewire/Filament DEVE restituire un solo root element HTML (es. <div> o <section>). Mai markup "sciolto" o più root. Questo per evitare errori MultipleRootElementsDetectedException. Aggiornare sempre la view e la docstring del widget. Vedi anche docs/xot.md.

## Collegamenti tra versioni di filament_best_practices.md
* [filament_best_practices.md](../../laravel/Modules/Xot/docs/filament/filament_best_practices.md)
* [filament_best_practices.md](../../laravel/Modules/Xot/docs/filament_best_practices.md)
* [filament_best_practices.md](../../laravel/Modules/User/docs/filament_best_practices.md)
* [filament_best_practices.md](../../laravel/Modules/Job/docs/filament_best_practices.md)

> [2025-05-28] Policy aggiornata: tutte le pagine di form devono includere direttamente solo widget Filament modulari, mai form custom. Motivazione: coerenza architetturale, manutenzione, DRY, troubleshooting semplificato.

## Livewire e Filament: inclusione obbligatoria di @livewireStyles e @livewireScripts
Per evitare errori 419 Page Expired nei widget Filament/Livewire, il layout DEVE includere @livewireStyles subito dopo @filamentStyles e @livewireScripts subito dopo @filamentScripts. Vedi anche docs/widget-deleting-method-error.md.

## View widget: solo wrapper per $this->form
Le view dei widget Filament devono essere solo wrapper per $this->form. Niente markup custom, niente logica Livewire/AlpineJS, niente gestione CSRF manuale. Tutta la logica va nel widget PHP o nel tema. Motivazione: coerenza, DRY, KISS, troubleshooting semplificato. Collegamento a docs/xot.md.

## Vietato ->label() e ->placeholder() nei form component
Tutti i form component devono usare solo chiavi campo, senza label o placeholder inline. Le etichette e i placeholder sono gestiti tramite i file di traduzione del modulo e il LangServiceProvider. Motivazione: coerenza, centralizzazione, override semplice, policy di qualità. Collegamento a docs/xot.md.

## Regola: trait solo se riusabili
I trait vanno creati solo se riutilizzati in più classi. Vietato creare trait per una sola classe. Se la logica è specifica di un solo modello, va implementata direttamente nella classe. Motivazione: semplicità, KISS, manutenibilità, evitare complessità inutile. Collegamento a docs/xot.md.

