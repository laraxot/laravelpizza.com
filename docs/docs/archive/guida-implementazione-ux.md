# Guida all'Implementazione UX in il progetto

Questa guida fornisce indicazioni pratiche su come implementare i principi UX documentati in [Leggi di UX](/project_docs/07-frontend/leggi-ux.md) nel progetto il progetto. È rivolta agli sviluppatori e ai designer che lavorano sul progetto.

## Indice
1. [Principi Generali](#principi-generali)
2. [Implementazione nei Form](#implementazione-nei-form)
3. [Implementazione nelle Dashboard](#implementazione-nelle-dashboard)
4. [Implementazione nelle Pagine Dettaglio](#implementazione-nelle-pagine-dettaglio)
5. [Checklist UX](#checklist-ux)
6. [Librerie e Componenti](#librerie-e-componenti)

## Principi Generali

### Coerenza Visiva

**Tipografia**:
- Font principale: Inter
- Dimensioni font:
  - Titoli principali: 24px (1.5rem)
  - Sottotitoli: 18px (1.125rem)
  - Testo corpo: 16px (1rem)
  - Testo secondario: 14px (0.875rem)
  - Etichette piccole: 12px (0.75rem)

**Colori**:
```css
:root {
  /* Colori primari */
  --primary: hsl(220, 70%, 50%);
  --primary-focus: hsl(220, 70%, 40%);
  --primary-content: hsl(220, 70%, 98%);
  
  /* Colori secondari */
  --secondary: hsl(250, 60%, 50%);
  --secondary-focus: hsl(250, 60%, 40%);
  --secondary-content: hsl(250, 60%, 98%);
  
  /* Colori neutrali */
  --neutral: hsl(220, 10%, 40%);
  --neutral-focus: hsl(220, 10%, 30%);
  --neutral-content: hsl(220, 10%, 98%);
  
  /* Colori di stato */
  --success: hsl(150, 80%, 40%);
  --warning: hsl(40, 90%, 50%);
  --error: hsl(0, 90%, 60%);
  --info: hsl(200, 90%, 60%);
  
  /* Background e testo */
  --base-100: hsl(220, 20%, 98%);
  --base-200: hsl(220, 20%, 95%);
  --base-300: hsl(220, 20%, 90%);
  --base-content: hsl(220, 20%, 20%);
}
```

**Spaziatura**:
- Unità base: 4px
- Padding contenuto: 16px (1rem)
- Margin tra componenti: 16px (1rem)
- Padding interno card: 16px (1rem)
- Gap grid: 16px (1rem)

**Bordi e Ombre**:
- Border radius: 8px (0.5rem)
- Border width: 1px
- Ombra card: `0 2px 4px rgba(0, 0, 0, 0.1)`
- Ombra dialog: `0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08)`

### Feedback Utente

**Tempistiche**:
- Transizioni hover: 150ms
- Animazioni feedback: 200-300ms
- Tempo massimo senza feedback: 400ms (soglia di Doherty)

**Tipi di Feedback**:
- Stato hover: Cambio colore e cursor
- Click: Feedback visivo (ripple effect)
- Loading: Spinner o progress bar
- Successo: Animazione + messaggio
- Errore: Highlight + messaggio
- Form validation: Inline + messaggio

## Implementazione nei Form

### Struttura Base Form

```php
// Campo di testo base
TextInput::make('name')
    ->label('Nome')
    ->required()
    ->maxLength(255)
    ->placeholder('Inserisci il nome')
    ->helperText('Nome del paziente')

// Gruppo di campi correlati
Grid::make(2)
    ->schema([
        TextInput::make('nome')
            ->required(),
        TextInput::make('cognome')
            ->required(),
    ])

// Sezione logica
Section::make('Informazioni Personali')
    ->description('Dati anagrafici del paziente')
    ->schema([
        // campi sezione
    ])
```

### Wizard Form

```php
Wizard::make([
    Step::make('Dati Personali')
        ->icon('heroicon-o-user')
        ->description('Inserisci i dati personali')
        ->schema([
            // campi step
        ]),
    // altri step
])
->nextAction(
    fn (Action $action) => $action->label('Avanti')
)
->previousAction(
    fn (Action $action) => $action->label('Indietro')
)
```

### Validazione Form

```php
TextInput::make('codice_fiscale')
    ->required()
    ->unique(Patient::class, 'fiscal_code')
    ->length(16)
    ->regex('/^[A-Z0-9]+$/')
    ->validationMessages([
        'required' => 'Il codice fiscale è obbligatorio',
        'unique' => 'Questo codice fiscale è già registrato',
        'length' => 'Il codice fiscale deve essere di 16 caratteri',
        'regex' => 'Il codice fiscale può contenere solo lettere maiuscole e numeri',
    ])
```

### Accessibilità Form

```php
TextInput::make('name')
    ->label('Nome')
    ->required()
    ->placeholder('Inserisci il nome')
    ->helperText('Nome del paziente')
    ->aria('describedby', 'name-helper-text')
    ->id('patient-name')
```

## Implementazione nelle Dashboard

### Grid Layout

```php
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <x-dashboard.card title="Pazienti">
        <!-- contenuto card -->
    </x-dashboard.card>
    
    <x-dashboard.card title="Appuntamenti">
        <!-- contenuto card -->
    </x-dashboard.card>
    
    <x-dashboard.card title="Dati ISEE">
        <!-- contenuto card -->
    </x-dashboard.card>
</div>
```

### Card Component

```blade
<!-- resources/views/components/dashboard/card.blade.php -->
<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow p-4']) }}>
    <div class="mb-4 flex justify-between items-center">
        <h3 class="text-lg font-semibold">{{ $title }}</h3>
        @if(isset($action))
            <div>{{ $action }}</div>
        @endif
    </div>
    
    <div>
        {{ $slot }}
    </div>
</div>
```

### Priorità Visiva

Organizzare gli elementi dashboard in ordine di importanza:
1. Avvisi critici (in alto a sinistra)
2. Azioni principali (in alto a destra)
3. KPI e statistiche (prima riga)
4. Attività recenti (seconda riga)
5. Funzionalità secondarie (in basso)

## Implementazione nelle Pagine Dettaglio

### Struttura Base

```blade
<div class="container mx-auto py-6 px-4">
    <!-- Intestazione -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">{{ $patient->full_name }}</h1>
            <p class="text-neutral">Codice Fiscale: {{ $patient->fiscal_code }}</p>
        </div>
        <div class="flex space-x-2">
            <button class="btn btn-primary">Modifica</button>
            <button class="btn btn-outline">Documenti</button>
        </div>
    </div>
    
    <!-- Contenuto principale -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonna sinistra -->
        <div class="lg:col-span-2">
            <!-- Sezioni principali -->
            <div class="card bg-white shadow rounded-lg mb-6">
                <!-- Contenuto card -->
            </div>
            
            <!-- Altre sezioni -->
        </div>
        
        <!-- Colonna destra (sidebar) -->
        <div>
            <!-- Informazioni riassuntive e azioni -->
            <div class="card bg-white shadow rounded-lg sticky top-4">
                <!-- Contenuto sidebar -->
            </div>
        </div>
    </div>
</div>
```

### Tabs Navigation

```blade
<div x-data="{ activeTab: 'info' }">
    <div class="border-b mb-4">
        <nav class="flex -mb-px">
            <button 
                @click="activeTab = 'info'" 
                :class="{'border-primary text-primary': activeTab === 'info', 'border-transparent': activeTab !== 'info'}"
                class="px-4 py-2 border-b-2 font-medium text-sm">
                Informazioni
            </button>
            <button 
                @click="activeTab = 'documents'" 
                :class="{'border-primary text-primary': activeTab === 'documents', 'border-transparent': activeTab !== 'documents'}"
                class="px-4 py-2 border-b-2 font-medium text-sm">
                Documenti
            </button>
            <button 
                @click="activeTab = 'appointments'" 
                :class="{'border-primary text-primary': activeTab === 'appointments', 'border-transparent': activeTab !== 'appointments'}"
                class="px-4 py-2 border-b-2 font-medium text-sm">
                Appuntamenti
            </button>
        </nav>
    </div>
    
    <div x-show="activeTab === 'info'">
        <!-- Contenuto tab info -->
    </div>
    <div x-show="activeTab === 'documents'" x-cloak>
        <!-- Contenuto tab documenti -->
    </div>
    <div x-show="activeTab === 'appointments'" x-cloak>
        <!-- Contenuto tab appuntamenti -->
    </div>
</div>
```

### Visualizzazione Dati

```blade
<!-- Lista con raggruppamento visivo -->
<ul class="divide-y">
    <li class="py-3">
        <div class="text-sm text-neutral">Email</div>
        <div>{{ $patient->email }}</div>
    </li>
    <li class="py-3">
        <div class="text-sm text-neutral">Telefono</div>
        <div>{{ $patient->phone }}</div>
    </li>
    <li class="py-3">
        <div class="text-sm text-neutral">Indirizzo</div>
        <div>{{ $patient->address }}</div>
    </li>
</ul>
```

## Checklist UX

Utilizzare questa checklist per verificare che ogni interfaccia rispetti i principi UX:

- [ ] **Carico Cognitivo**
  - [ ] Ogni schermata ha uno scopo chiaro
  - [ ] Le informazioni sono raggruppate logicamente
  - [ ] Gli elementi non essenziali sono nascosti/collassati

- [ ] **Feedback Utente**
  - [ ] Ogni azione ha un feedback visivo
  - [ ] Le operazioni lunghe mostrano progress/loading
  - [ ] Gli errori sono chiaramente evidenziati

- [ ] **Usabilità**
  - [ ] Gli elementi interattivi sono facilmente distinguibili
  - [ ] I punti di tatto (touch targets) sono sufficientemente grandi
  - [ ] L'interfaccia ha una gerarchia visiva chiara

- [ ] **Accessibilità**
  - [ ] Contrasto sufficiente testo/sfondo
  - [ ] Elementi non solo identificati dal colore
  - [ ] Focus indicators sono visibili
  - [ ] Markup semantico appropriato

- [ ] **Efficienza**
  - [ ] Azioni comuni facilmente accessibili
  - [ ] Percorsi di navigazione chiari
  - [ ] Scorciatoie per utenti esperti

- [ ] **Coerenza**
  - [ ] Pattern di design consistenti
  - [ ] Terminologia consistente
  - [ ] Layout consistente tra schermate simili

## Librerie e Componenti

### DaisyUI

il progetto utilizza DaisyUI per la maggior parte dei componenti UI. Questi sono alcuni componenti comuni e come usarli secondo i principi UX:

**Buttons**:
```html
<!-- Azione primaria (Legge di Fitts + Effetto Von Restorff) -->
<button class="btn btn-primary">Azione principale</button>

<!-- Azione secondaria -->
<button class="btn btn-outline">Azione secondaria</button>

<!-- Azione distruttiva -->
<button class="btn btn-error">Elimina</button>

<!-- Button with icon (Suggerimento visivo) -->
<button class="btn btn-primary">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
    </svg>
    Aggiungi
</button>
```

**Forms**:
```html
<!-- Input con label, hint e validazione (Riduce carico cognitivo + feedback) -->
<div class="form-control w-full mb-4">
    <label class="label">
        <span class="label-text">Email</span>
    </label>
    <input type="email" class="input input-bordered w-full" placeholder="email@esempio.com" />
    <label class="label">
        <span class="label-text-alt text-error">Email non valida</span>
        <span class="label-text-alt">Esempio: nome@dominio.it</span>
    </label>
</div>
```

**Alert/Notification**:
```html
<!-- Alert per feedback importante (Effetto Von Restorff) -->
<div class="alert alert-success mb-4">
    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    <span>Paziente registrato con successo!</span>
</div>
```

**Tabs**:
```html
<!-- Tabs per raggruppare contenuti correlati (Chunking) -->
<div class="tabs mb-4">
    <a class="tab tab-bordered tab-active">Informazioni</a>
    <a class="tab tab-bordered">Documenti</a>
    <a class="tab tab-bordered">Appuntamenti</a>
</div>
```

**Card**:
```html
<!-- Card per raggruppare informazioni correlate (Legge della Regione Comune) -->
<div class="card bg-base-100 shadow-lg">
    <div class="card-body">
        <h2 class="card-title">Informazioni paziente</h2>
        <p>Contenuto della card</p>
        <div class="card-actions justify-end">
            <button class="btn btn-primary">Azione</button>
        </div>
    </div>
</div>
```

### Filament Components

Filament fornisce componenti avanzati per form e tabelle. Ecco come usarli secondo i principi UX:

**Select con ricerca**:
```php
// Riduce il carico cognitivo (Legge di Hick)
Select::make('provincia')
    ->label('Provincia')
    ->options(Province::all()->pluck('name', 'id'))
    ->searchable()
    ->preload()
```

**DatePicker**:
```php
// Format consistente (Legge di Postel)
DatePicker::make('birth_date')
    ->label('Data di nascita')
    ->required()
    ->displayFormat('d/m/Y')
    ->maxDate(now())
```

**Repeater**:
```php
// Chunking per item complessi
Repeater::make('documents')
    ->label('Documenti')
    ->schema([
        // campi documento
    ])
    ->itemLabel(fn (array $state): ?string => 
        $state['title'] ?? null
    )
    ->collapsible()
    ->maxItems(5)
```

## Conclusione

Applicando sistematicamente queste linee guida, il progetto il progetto manterrà una UX coerente, intuitiva ed efficiente. Ricordate che l'obiettivo finale è rendere l'interfaccia il più possibile trasparente, permettendo agli utenti di concentrarsi sul loro lavoro piuttosto che sull'interazione con il sistema.

Per approfondimenti, consultare:
- [Leggi di UX applicate a il progetto](/project_docs/07-frontend/leggi-ux.md)
- [UX del Wizard di Registrazione](/project_docs/07-frontend/ux-wizard-registrazione-paziente.md)
- [DaisyUI Documentation](https://daisyui.com/components/)
- [Filament Documentation](https://filamentphp.com/project_docs/forms) 