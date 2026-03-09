# Volt And Livewire Component Boundaries

## Fonte

Studio basato su:

- repository ufficiale `livewire/volt`
- documentazione ufficiale Livewire 4.x sui components

## Regole operative

### 1. Volt non sostituisce Folio

Folio definisce il path e il file page.

Volt vive bene:

- dentro una page Folio;
- come componente interattivo riusabile;
- come full-page component quando il caso lo richiede.

### 2. Volt non sostituisce Blade statico

Se un blocco non ha stato, lifecycle o interazioni utente, non deve diventare Volt per inerzia.

### 3. Stato e lifecycle nel componente

Le inizializzazioni e il comportamento del componente devono stare nel layer Volt/Livewire, non sparsi tra host page e include Blade.

### 4. Props e route params

I dati che arrivano dalla route o dal parent devono essere espliciti e testabili. Evitare estrazioni manuali da request quando il framework puo' iniettare i dati in modo dichiarativo.

### 5. Full-page components

Quando la pagina e' interattiva sul serio, usare il contratto Livewire full-page component con layout e rendering coerenti, invece di mescolare troppa logica dentro un file Blade generico.
