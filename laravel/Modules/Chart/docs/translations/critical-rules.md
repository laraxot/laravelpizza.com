# Regole Critiche per le Traduzioni - MAI VIOLARE

## ⚠️ REGOLA ASSOLUTA: MAI RIMUOVERE CONTENUTO ESISTENTE

**VIETATO**: Rimuovere qualsiasi contenuto esistente dai file di traduzione
**OBBLIGATORIO**: Aggiungere o migliorare solo il contenuto esistente

## Esempi di Errori Critici

### ❌ ERRORE CRITICO - Rimuovere contenuto
```php
// PRIMA (corretto)
return [
    'label' => 'Programmato',
    'description' => 'Elemento programmato nel calendario',
    'color' => 'info',
    'bg_color' => '#3b82f6',  // ✅ ESISTENTE
    'icon' => 'heroicon-o-calendar',
    'modal_heading' => 'Elemento Programmato',  // ✅ ESISTENTE
    'modal_description' => 'Descrizione...',  // ✅ ESISTENTE
];

// DOPO (ERRORE CRITICO)
return [
    'label' => 'Programmato',
    'description' => 'Elemento programmato per una data specifica',
    'color' => 'info',
    // ❌ RIMOSSO bg_color
    'icon' => 'heroicon-o-calendar',
    // ❌ RIMOSSO modal_heading
    // ❌ RIMOSSO modal_description
];
```

### ✅ CORRETTO - Aggiungere/Migliorare
```php
return [
    'label' => 'Programmato',
    'description' => 'Elemento programmato per una data specifica', // ✅ MIGLIORATO
    'tooltip' => 'L\'elemento è stato programmato e è in attesa di esecuzione', // ✅ NUOVO
    'color' => 'info',
    'bg_color' => '#3b82f6', // ✅ MANTENUTO
    'icon' => 'heroicon-o-calendar',
    'modal_heading' => 'Elemento Programmato', // ✅ MANTENUTO
    'modal_description' => 'Questo elemento è stato programmato nel calendario e sarà disponibile alla data indicata.', // ✅ MANTENUTO
    
    // ✅ AGGIUNTO solo nuove traduzioni
    'actions' => [
        'reschedule' => [
            'label' => 'Riprogramma',
            // ...
        ],
    ],
];
```

## Checklist OBBLIGATORIA

Prima di modificare qualsiasi file di traduzione:

- [ ] **LEGGERE** tutto il contenuto esistente del file
- [ ] **IDENTIFICARE** tutti i campi esistenti (`bg_color`, `modal_heading`, etc.)
- [ ] **MANTENERE** tutti i contenuti esistenti
- [ ] **AGGIUNGERE** solo nuove traduzioni
- [ ] **MIGLIORARE** contenuti esistenti se necessario
- [ ] **VERIFICARE** che nessun contenuto sia stato rimosso

## Regole Specifiche

### 1. Campi Sempre Presenti
Questi campi DEVONO essere sempre mantenuti:
- `bg_color` - Colore di sfondo
- `modal_heading` - Titolo del modal
- `modal_description` - Descrizione del modal
- `color` - Colore del tema
- `icon` - Icona Heroicons

### 2. Struttura Standard
Ogni file di stato deve mantenere:
```php
return [
    'label' => '...',
    'description' => '...',
    'tooltip' => '...',
    'color' => '...',
    'bg_color' => '...',
    'icon' => '...',
    'modal_heading' => '...',
    'modal_description' => '...',
    
    // NUOVO: aggiungere solo se necessario
    'actions' => [...],
    'fields' => [...],
    'messages' => [...],
];
```

### 3. Operazioni Consentite
- ✅ Aggiungere nuovi campi (`actions`, `fields`, `messages`)
- ✅ Migliorare testi esistenti
- ✅ Aggiungere traduzioni mancanti
- ✅ Correggere errori di sintassi

### 4. Operazioni VIETATE
- ❌ Rimuovere qualsiasi campo esistente
- ❌ Sostituire completamente il contenuto
- ❌ Rimuovere `bg_color`, `modal_heading`, `modal_description`
- ❌ Cambiare la struttura base

## Sanzioni per Violazioni

1. **Prima violazione**: Correzione immediata + documentazione dell'errore
2. **Seconda violazione**: Blocco temporaneo delle modifiche alle traduzioni
3. **Terza violazione**: Revisione completa di tutte le traduzioni

## Documentazione degli Errori

Ogni errore deve essere documentato in:
- `docs/phpstan/translation_files_corrections_summary_2025_01_06.md`
- Memorie dell'assistente
- Regole aggiornate

---

**ULTIMO AGGIORNAMENTO**: 6 Gennaio 2025 - Dopo errore critico nella rimozione di `bg_color` 