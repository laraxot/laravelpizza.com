# DaisyUI: Componenti e Implementazione in il progetto

Questo documento descrive l'utilizzo di [DaisyUI](https://daisyui.com/) nel progetto il progetto, fornendo linee guida per sfruttare al meglio questa libreria di componenti per Tailwind CSS.

## Indice
1. [Introduzione a DaisyUI](#introduzione-a-daisyui)
2. [Vantaggi per il progetto](#vantaggi-per-<nome progetto>)
3. [Installazione e Configurazione](#installazione-e-configurazione)
4. [Sistema di Temi](#sistema-di-temi)
5. [Componenti Principali](#componenti-principali)
6. [Personalizzazione](#personalizzazione)
7. [Best Practices](#best-practices)
8. [Esempi di Implementazione](#esempi-di-implementazione)
9. [Risorse Utili](#risorse-utili)

## Introduzione a DaisyUI

DaisyUI è un plugin per Tailwind CSS che aggiunge classi semantiche per componenti UI, permettendo di scrivere HTML più pulito e manutenibile. È un'estensione che non sostituisce Tailwind, ma lo arricchisce con componenti predefiniti mantenendo la flessibilità delle utility classes.

**Caratteristiche principali**:
- 100% CSS puro (nessuna dipendenza JavaScript)
- 61+ componenti pronti all'uso
- Sistema di temi completo
- Compatibile con tutti i framework (React, Vue, Angular, ecc.)
- Riduce significativamente la quantità di classi da scrivere
- Mantiene la flessibilità di Tailwind CSS

## Vantaggi per il progetto

L'utilizzo di DaisyUI nel progetto il progetto comporta numerosi benefici:

1. **Sviluppo più rapido**: Riduzione del tempo necessario per implementare interfacce complesse grazie ai componenti predefiniti.

2. **HTML più pulito**: Riduzione fino all'88% del numero di classi necessarie, con una diminuzione del 79% della dimensione del DOM.

3. **Coerenza nell'interfaccia**: Garantisce uniformità visiva in tutta l'applicazione.

4. **Accessibilità**: I componenti sono progettati tenendo in considerazione le best practices di accessibilità.

5. **Facile manutenzione**: Il codice è più leggibile e facile da mantenere grazie alle classi semantiche.

6. **Rispetto dei principi UX**: I componenti DaisyUI supportano naturalmente molte delle [Leggi di UX](/docs/07-frontend/leggi-ux.md) documentate.

## Installazione e Configurazione

### Installazione

```bash
npm i -D daisyui@latest
```

### Configurazione in tailwind.config.js

```js
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('daisyui')
  ],
  daisyui: {
    themes: [
      {
        <nome progetto>: {
          "primary": "#1e40af",
          "secondary": "#6b21a8",
          "accent": "#0ea5e9",
          "neutral": "#374151",
          "base-100": "#f8fafc",
          "info": "#3abff8",
          "success": "#15803d",
          "warning": "#f59e0b",
          "error": "#dc2626",
        },
      },
      "light",
    ],
  },
}
```

## Sistema di Temi

DaisyUI offre un potente sistema di temi che consente di personalizzare l'aspetto dell'applicazione in modo coerente. Per il progetto, abbiamo definito un tema personalizzato che riflette l'identità visiva del progetto.

### Tema il progetto

```js
<nome progetto>: {
  "primary": "#1e40af",     // Blu principale
  "secondary": "#6b21a8",   // Viola secondario
  "accent": "#0ea5e9",      // Azzurro per accenti
  "neutral": "#374151",     // Grigio neutro
  "base-100": "#f8fafc",    // Sfondo chiaro
  "info": "#3abff8",        // Blu informativo
  "success": "#15803d",     // Verde successo
  "warning": "#f59e0b",     // Arancione avviso
  "error": "#dc2626",       // Rosso errore
}
```

### Cambio Tema

Per supportare modalità chiara/scura o temi alternativi, utilizzare l'attributo `data-theme`:

```html
<div data-theme="<nome progetto>">
  <!-- Contenuto con tema il progetto -->
</div>

<div data-theme="light">
  <!-- Contenuto con tema chiaro standard -->
</div>
```

## Componenti Principali

### Azioni

#### Pulsanti

I pulsanti sono uno degli elementi più importanti dell'interfaccia e DaisyUI offre numerose varianti.

```html
<!-- Pulsante base -->
<button class="btn">Pulsante</button>

<!-- Varianti di colore -->
<button class="btn btn-primary">Primario</button>
<button class="btn btn-secondary">Secondario</button>
<button class="btn btn-accent">Accento</button>
<button class="btn btn-info">Info</button>
<button class="btn btn-success">Successo</button>
<button class="btn btn-warning">Avviso</button>
<button class="btn btn-error">Errore</button>

<!-- Varianti di stile -->
<button class="btn btn-outline">Outline</button>
<button class="btn btn-ghost">Ghost</button>
<button class="btn btn-link">Link</button>

<!-- Dimensioni -->
<button class="btn btn-lg">Grande</button>
<button class="btn">Normale</button>
<button class="btn btn-sm">Piccolo</button>
<button class="btn btn-xs">Extra piccolo</button>

<!-- Con icona -->
<button class="btn gap-2">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
  </svg>
  Preferito
</button>
```

#### Modal

Le modal sono utili per mostrare contenuto aggiuntivo senza cambiare pagina.

```html
<!-- Trigger del modal -->
<label for="my-modal" class="btn">Apri Modal</label>

<!-- Modal -->
<input type="checkbox" id="my-modal" class="modal-toggle" />
<div class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Titolo Modal</h3>
    <p class="py-4">Contenuto del modal</p>
    <div class="modal-action">
      <label for="my-modal" class="btn">Chiudi</label>
    </div>
  </div>
</div>
```

### Visualizzazione Dati

#### Card

Le card sono contenitori versatili per mostrare informazioni in modo organizzato.

```html
<div class="card bg-base-100 shadow-xl">
  <figure><img src="example.jpg" alt="Immagine" /></figure>
  <div class="card-body">
    <h2 class="card-title">Titolo Card</h2>
    <p>Contenuto della card.</p>
    <div class="card-actions justify-end">
      <button class="btn btn-primary">Azione</button>
    </div>
  </div>
</div>
```

#### Table

Tabelle per visualizzare dati strutturati.

```html
<div class="overflow-x-auto">
  <table class="table">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Codice Fiscale</th>
        <th>Età</th>
        <th>Azioni</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Mario Rossi</td>
        <td>RSSMRA80A01H501U</td>
        <td>43</td>
        <td>
          <button class="btn btn-sm">Visualizza</button>
        </td>
      </tr>
      <!-- Altre righe -->
    </tbody>
  </table>
</div>
```

### Navigazione

#### Navbar

Barre di navigazione responsive.

```html
<div class="navbar bg-base-100">
  <div class="navbar-start">
    <div class="dropdown">
      <label tabindex="0" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
        </svg>
      </label>
      <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
        <li><a>Home</a></li>
        <li><a>Pazienti</a></li>
        <li><a>Appuntamenti</a></li>
      </ul>
    </div>
    <a class="btn btn-ghost normal-case text-xl">il progetto</a>
  </div>
  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal p-0">
      <li><a>Home</a></li>
      <li><a>Pazienti</a></li>
      <li><a>Appuntamenti</a></li>
    </ul>
  </div>
  <div class="navbar-end">
    <a class="btn">Login</a>
  </div>
</div>
```

#### Tabs

Tab per organizzare contenuti in una singola vista.

```html
<div class="tabs">
  <a class="tab tab-lifted">Informazioni</a>
  <a class="tab tab-lifted tab-active">Documenti</a>
  <a class="tab tab-lifted">Appuntamenti</a>
</div>

<div class="tab-content">
  <!-- Contenuto del tab attivo -->
</div>
```

### Input Dati

#### Form Control

Controlli form con label e messaggi di errore.

```html
<div class="form-control w-full max-w-xs">
  <label class="label">
    <span class="label-text">Nome</span>
  </label>
  <input type="text" placeholder="Inserisci nome" class="input input-bordered w-full max-w-xs" />
  <label class="label">
    <span class="label-text-alt text-error">Nome non valido</span>
  </label>
</div>
```

#### Select

Menu a discesa per selezione.

```html
<div class="form-control w-full max-w-xs">
  <label class="label">
    <span class="label-text">Provincia</span>
  </label>
  <select class="select select-bordered">
    <option disabled selected>Seleziona una provincia</option>
    <option>Roma</option>
    <option>Milano</option>
    <option>Napoli</option>
    <!-- Altre opzioni -->
  </select>
</div>
```

### Feedback

#### Alert

Notifiche per comunicare stati o messaggi importanti.

```html
<div class="alert alert-info">
  <div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span>Informazione: I tuoi dati sono stati aggiornati.</span>
  </div>
</div>

<div class="alert alert-success">
  <div>
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span>Successo! Il paziente è stato registrato.</span>
  </div>
</div>

<div class="alert alert-error">
  <div>
    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span>Errore! Si è verificato un problema durante il salvataggio.</span>
  </div>
</div>
```

#### Progress e Loading

Indicatori di caricamento e avanzamento.

```html
<!-- Spinner di caricamento -->
<span class="loading loading-spinner loading-md"></span>

<!-- Barra di progresso -->
<progress class="progress progress-primary w-56" value="70" max="100"></progress>

<!-- Progress indeterminato -->
<progress class="progress w-56"></progress>
```

## Personalizzazione

### Estendere componenti con Tailwind

DaisyUI si integra perfettamente con le utility di Tailwind, permettendo di personalizzare i componenti:

```html
<!-- Bottone con personalizzazioni Tailwind -->
<button class="btn btn-primary rounded-full shadow-lg hover:shadow-xl transition-shadow">
  Bottone personalizzato
</button>

<!-- Card con personalizzazioni -->
<div class="card bg-base-100 hover:bg-base-200 transition-colors shadow-md hover:shadow-lg">
  <div class="card-body">
    <h2 class="card-title text-primary">Titolo personalizzato</h2>
    <p class="text-neutral-600">Contenuto con colore personalizzato.</p>
  </div>
</div>
```

### Creare varianti personalizzate

Per stili ricorrenti, è consigliabile estendere Tailwind con varianti personalizzate:

```js
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      // Estensioni del tema
    },
  },
  plugins: [
    require('daisyui'),
    // Plugin personalizzato per componenti specifici di il progetto
    function({ addComponents }) {
      const components = {
        '.<nome progetto>-card': {
          '@apply card bg-base-100 shadow-md hover:shadow-lg border border-base-300': {},
        },
        '.<nome progetto>-form-field': {
          '@apply form-control w-full mb-4': {},
        },
      }
      addComponents(components)
    },
  ],
}
```

Utilizzo:

```html
<div class="<nome progetto>-card">
  <!-- Contenuto card -->
</div>

<div class="<nome progetto>-form-field">
  <!-- Campo form -->
</div>
```

## Best Practices

### 1. Organizzazione del codice

- Utilizzare componenti Blade per incapsulare componenti UI riutilizzabili
- Mantenere una struttura coerente per i componenti ripetuti
- Applicare principi DRY (Don't Repeat Yourself)

### 2. Performance

- Utilizzare purgeCSS per rimuovere classi CSS non utilizzate
- Minimizzare l'annidamento di componenti quando possibile
- Preferire gli utility di Tailwind per piccole personalizzazioni

### 3. Accessibilità

- Aggiungere attributi ARIA quando necessario
- Assicurarsi che tutti gli input abbiano label associate
- Verificare il contrasto dei colori per garantire leggibilità
- Testare la navigazione da tastiera

### 4. Responsive Design

- Utilizzare le classi di breakpoint di Tailwind (`sm:`, `md:`, `lg:`, ecc.)
- Testare sempre su vari dispositivi e dimensioni dello schermo
- Dare priorità all'approccio mobile-first

### 5. Integrazione con le Leggi UX

- **Effetto Estetica-Usabilità**: Mantenere un design pulito utilizzando i componenti DaisyUI
- **Chunking**: Utilizzare card, tabs e sezioni per raggruppare informazioni correlate
- **Legge di Fitts**: Dimensionare adeguatamente i bottoni utilizzando le varianti di dimensione
- **Legge della Regione Comune**: Utilizzare card e container per raggruppare visivamente elementi correlati
- **Effetto Von Restorff**: Usare varianti di colore per evidenziare elementi importanti

## Esempi di Implementazione

### Dashboard Paziente

```blade
<div class="container mx-auto p-4">
  <h1 class="text-2xl font-bold mb-6">Dashboard Paziente</h1>
  
  <!-- Informazioni Paziente -->
  <div class="card bg-base-100 shadow-xl mb-6">
    <div class="card-body">
      <h2 class="card-title">{{ $patient->full_name }}</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <p><strong>Codice Fiscale:</strong> {{ $patient->fiscal_code }}</p>
          <p><strong>Data di Nascita:</strong> {{ $patient->birth_date->format('d/m/Y') }}</p>
          <p><strong>Età:</strong> {{ $patient->age }} anni</p>
        </div>
        <div>
          <p><strong>Email:</strong> {{ $patient->email }}</p>
          <p><strong>Telefono:</strong> {{ $patient->phone }}</p>
          <p><strong>Indirizzo:</strong> {{ $patient->address }}</p>
        </div>
      </div>
      <div class="card-actions justify-end mt-4">
        <button class="btn btn-primary">Modifica</button>
        <button class="btn btn-ghost">Documenti</button>
      </div>
    </div>
  </div>
  
  <!-- Tabs -->
  <div class="tabs mb-4">
    <a class="tab tab-bordered tab-active">Appuntamenti</a>
    <a class="tab tab-bordered">Documenti</a>
    <a class="tab tab-bordered">ISEE</a>
  </div>
  
  <!-- Contenuto Tab -->
  <div class="overflow-x-auto">
    <table class="table w-full">
      <thead>
        <tr>
          <th>Data</th>
          <th>Orario</th>
          <th>Tipologia</th>
          <th>Stato</th>
          <th>Azioni</th>
        </tr>
      </thead>
      <tbody>
        @foreach($appointments as $appointment)
        <tr>
          <td>{{ $appointment->date->format('d/m/Y') }}</td>
          <td>{{ $appointment->time }}</td>
          <td>{{ $appointment->type }}</td>
          <td>
            <div class="badge badge-{{ $appointment->status_color }}">
              {{ $appointment->status }}
            </div>
          </td>
          <td>
            <div class="btn-group">
              <button class="btn btn-sm">Dettagli</button>
              <button class="btn btn-sm btn-outline">Modifica</button>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
```

### Form di Registrazione Semplificato

```blade
<div class="container mx-auto p-4 max-w-md">
  <h1 class="text-2xl font-bold mb-6">Registrazione Paziente</h1>
  
  <form action="{{ route('patients.store') }}" method="POST">
    @csrf
    
    <div class="form-control w-full mb-4">
      <label class="label">
        <span class="label-text">Nome</span>
      </label>
      <input type="text" name="name" class="input input-bordered w-full" value="{{ old('name') }}" required />
      @error('name')
        <label class="label">
          <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
      @enderror
    </div>
    
    <div class="form-control w-full mb-4">
      <label class="label">
        <span class="label-text">Cognome</span>
      </label>
      <input type="text" name="surname" class="input input-bordered w-full" value="{{ old('surname') }}" required />
      @error('surname')
        <label class="label">
          <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
      @enderror
    </div>
    
    <div class="form-control w-full mb-4">
      <label class="label">
        <span class="label-text">Codice Fiscale</span>
      </label>
      <input type="text" name="fiscal_code" class="input input-bordered w-full" value="{{ old('fiscal_code') }}" required />
      @error('fiscal_code')
        <label class="label">
          <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
      @enderror
    </div>
    
    <div class="form-control w-full mb-4">
      <label class="label">
        <span class="label-text">Email</span>
      </label>
      <input type="email" name="email" class="input input-bordered w-full" value="{{ old('email') }}" />
      @error('email')
        <label class="label">
          <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
      @enderror
    </div>
    
    <div class="form-control w-full mb-6">
      <label class="label cursor-pointer">
        <span class="label-text">In gravidanza</span> 
        <input type="checkbox" name="is_pregnant" class="toggle toggle-primary" {{ old('is_pregnant') ? 'checked' : '' }} />
      </label>
    </div>
    
    <div class="form-control">
      <button type="submit" class="btn btn-primary">Registra Paziente</button>
    </div>
  </form>
</div>
```

## Risorse Utili

- [Documentazione ufficiale DaisyUI](https://daisyui.com/)
- [Repository GitHub](https://github.com/saadeghi/daisyui)
- [Documentazione Tailwind CSS](https://tailwindcss.com/docs)
- [Theme Generator DaisyUI](https://daisyui.com/theme-generator/)
- [Filament + DaisyUI Integration](https://filamentphp.com/docs/panels/themes)

---

Per ulteriori informazioni sull'implementazione di DaisyUI in il progetto o per segnalare problemi, contattare il team di sviluppo. 