# Componenti PDF Riutilizzabili

## Panoramica

I componenti PDF in Laraxot sono progettati per essere riutilizzabili e seguire i principi DRY (Don't Repeat Yourself) e KISS (Keep It Simple, Stupid). Questi componenti forniscono stili e layout standardizzati per tutti i PDF generati nel sistema.

## Motivazione

### Principi DRY
- **Evitare duplicazione**: Gli stili CSS per PDF sono spesso ripetuti tra diversi template
- **Manutenibilità**: Un singolo file CSS è più facile da mantenere e aggiornare
- **Coerenza**: Garantisce un aspetto uniforme in tutti i PDF del sistema

### Principi KISS
- **Semplicità**: Componenti con responsabilità singola e ben definite
- **Chiarezza**: Struttura semplice e comprensibile
- **Riutilizzabilità**: Componenti che possono essere utilizzati in diversi contesti

## Componenti Disponibili

### CSS Base per PDF
**File**: `xot::pdf.css`
**Scopo**: Stili CSS standardizzati per tutti i PDF del sistema

#### Caratteristiche
- Stili per header e footer
- Classi per tabelle e layout
- Stili per stati (success, error, warning)
- Stili per elementi medicali
- Responsive design per PDF
- **Principi DRY + KISS**: Un solo file CSS per tutti i PDF

#### Utilizzo
```blade
@include('xot::pdf.css')
```

#### Implementazione
Il componente è stato estratto dal template `report_pdf.blade.php` del tema One e reso riutilizzabile per tutti i PDF del sistema.

#### Struttura CSS
```css
/* Header e Footer */
.page-header, .page-footer {
    /* Stili standardizzati */
}

/* Tabelle */
.info-table {
    /* Stili per tabelle informative */
}

/* Stati */
.status-scheduled, .status-confirmed {
    /* Stili per stati */
}

/* Elementi medicali */
.medical-item, .medical-question {
    /* Stili per contenuti medici */
}
```

## Best Practices

### 1. Organizzazione dei Componenti
- Tutti i componenti PDF devono essere in `Modules/Xot/resources/views/pdf/`
- Utilizzare namespace `xot::pdf.*` per tutti i componenti
- Mantenere una struttura logica e coerente

### 2. Naming Convention
- File CSS: `css.blade.php`
- Componenti specifici: `{nome_componente}.blade.php`
- Utilizzare kebab-case per i nomi dei file

### 3. Struttura dei Componenti
```blade
{{-- Componente CSS riutilizzabile --}}
<style type="text/css">
    /* Stili standardizzati */
    body {
        font-family: Arial, sans-serif;
        font-size: 10px;
        line-height: 1.3;
    }
    
    /* Altre classi... */
</style>
```

### 4. Utilizzo nei Template
```blade
<page backtop="20mm" backbottom="10mm" backleft="15mm" backright="15mm">
    @include('xot::pdf.css')
    
    {{-- Contenuto del PDF --}}
</page>
```

## Esempi di Implementazione

### Template PDF Standard
```blade
<page backtop="20mm" backbottom="10mm" backleft="15mm" backright="15mm">
    @include('xot::pdf.css')
    
    <page_header>
        {{-- Header standardizzato --}}
    </page_header>
    
    <page_footer>
        {{-- Footer standardizzato --}}
    </page_footer>
    
    {{-- Contenuto specifico del PDF --}}
</page>
```

### Template PDF Medical
```blade
<page backtop="20mm" backbottom="10mm" backleft="15mm" backright="15mm">
    @include('xot::pdf.css')
    @include('xot::pdf.medical-styles')
    
    {{-- Contenuto medical specifico --}}
</page>
```

## Vantaggi dell'Approccio

### 1. Manutenibilità
- Un singolo file CSS da mantenere
- Aggiornamenti centralizzati
- Meno duplicazione di codice

### 2. Coerenza
- Aspetto uniforme in tutti i PDF
- Stili standardizzati
- Branding consistente

### 3. Performance
- CSS condiviso tra PDF
- Riduzione della dimensione dei file
- Caricamento ottimizzato

### 4. Scalabilità
- Facile aggiungere nuovi stili
- Componenti modulari
- Riutilizzabilità tra progetti

## Collegamenti

- [Documentazione Componenti](../componenti_personalizzati.md)
- [Best Practices Filament](../filament-best-practices.mdc)
- [README Principale](../README.md)

## Note di Sviluppo

Quando si aggiungono nuovi stili CSS per PDF:

1. **Valutare la riutilizzabilità**: Il nuovo stile può essere utilizzato in altri PDF?
2. **Seguire le convenzioni**: Utilizzare le classi CSS esistenti quando possibile
3. **Documentare**: Aggiornare questa documentazione per nuovi componenti
4. **Testare**: Verificare che i PDF generati abbiano l'aspetto corretto

**Ultimo aggiornamento**: Dicembre 2024 