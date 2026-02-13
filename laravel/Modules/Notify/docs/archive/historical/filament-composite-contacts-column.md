# Colonna Contatti Composite per Filament - Modulo Notify

## Panoramica
Documentazione del pattern per implementare colonne contatti composite in Filament Tables, specificamente per il modulo Notify. Questo pattern è stato sviluppato inizialmente nel modulo TechPlanner e ora viene generalizzato per riutilizzo.

## Pattern Architetturale

### Approccio Raccomandato: TextColumn con formatStateUsing
Il pattern ottimale utilizza `TextColumn` con `formatStateUsing` e rendering HTML inline per massima flessibilità e performance.

```php
TextColumn::make('contacts')
    ->label('Contatti')
    ->formatStateUsing(function ($record) {
        return $this->formatContacts($record);
    })
    ->html()
    ->wrap()
    ->searchable(['phone', 'email', 'pec', 'whatsapp', 'mobile', 'fax'])
    ->sortable(false),
```

### Metodo Helper per Rendering
Il metodo helper nel controller/resource gestisce la logica di rendering:

```php
/**
 * Formatta i contatti con icone appropriate.
 *
 * @param mixed $record
 * @return string
 */
private function formatContacts($record): string
{
    $contacts = [];
    
    // Telefono
    if ($record->phone) {
        $contacts[] = '<a href="tel:' . $record->phone . '" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200">
            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
            </svg>
            <span class="text-xs font-medium hidden sm:inline-block">' . htmlspecialchars($record->phone) . '</span>
        </a>';
    }
    
    // Email
    if ($record->email) {
        $contacts[] = '<a href="mailto:' . $record->email . '" class="inline-flex items-center text-green-600 hover:text-green-800 transition-colors duration-200">
            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
            </svg>
            <span class="text-xs font-medium hidden sm:inline-block">' . htmlspecialchars(Str::limit($record->email, 20)) . '</span>
        </a>';
    }
    
    // PEC (Posta Elettronica Certificata)
    if ($record->pec) {
        $contacts[] = '<a href="mailto:' . $record->pec . '" class="inline-flex items-center text-purple-600 hover:text-purple-800 transition-colors duration-200">
            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
            </svg>
            <span class="text-xs font-medium hidden sm:inline-block">PEC</span>
        </a>';
    }
    
    // WhatsApp
    if ($record->whatsapp) {
        $whatsappNumber = preg_replace('/[^0-9]/', '', $record->whatsapp);
        $contacts[] = '<a href="https://wa.me/' . $whatsappNumber . '" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-green-500 hover:text-green-700 transition-colors duration-200">
            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 10a8 8 0 113.07 6.24l-.9 2.7 2.7-.9A8 8 0 012 10z" />
                <path fill-rule="evenodd" d="M6.78 5.39a6 6 0 016.44 6.44l-1.6 1.6a4 4 0 01-4.84-4.84l1.6-1.6z" clip-rule="evenodd" />
            </svg>
            <span class="text-xs font-medium hidden sm:inline-block">WA</span>
        </a>';
    }
    
    return empty($contacts) 
        ? '<span class="text-gray-400 text-sm italic">Nessun contatto</span>' 
        : '<div class="flex flex-wrap gap-2 items-center">' . implode('', $contacts) . '</div>';
}
```

## Schema Colori e Icone Standard

### Palette Colori Semantici
- **Telefono**: `text-blue-600` - Blu per comunicazione vocale
- **Email**: `text-green-600` - Verde per comunicazione elettronica
- **PEC**: `text-purple-600` - Viola per distinguere dalla email normale
- **WhatsApp**: `text-green-500` - Verde brand WhatsApp
- **Mobile**: `text-blue-500` - Blu più chiaro per distinguere dal fisso
- **Fax**: `text-gray-600` - Grigio per tecnologia legacy

### Icone Heroicons Raccomandate
- **Phone**: Icona telefono classica
- **Email**: Icona busta
- **PEC**: Icona lucchetto (sicurezza)
- **WhatsApp**: Icona chat o custom brand
- **Mobile**: Icona telefono mobile
- **Fax**: Icona stampante

## Caratteristiche UX/UI

### Responsive Design
- **Mobile**: Solo icone visibili con tooltip
- **Desktop**: Icone + testo abbreviato
- **Breakpoint**: `sm:` per mostrare testo

### Interattività
- **Click-to-call**: `tel:` per numeri di telefono
- **Click-to-email**: `mailto:` per indirizzi email
- **WhatsApp**: Link diretto a WhatsApp Web
- **Hover States**: Transizioni fluide sui colori

### Accessibilità
- **Title attributes**: Tooltip informativi
- **ARIA labels**: Per screen reader
- **Focus management**: Navigazione da tastiera
- **Color contrast**: Rispetto WCAG 2.1 AA

## Vantaggi del Pattern

### 1. Compattezza
- **Spazio ottimizzato**: 1 colonna invece di 6 separate
- **Informazioni dense**: Massima informazione in minimo spazio
- **Scalabilità**: Facile aggiungere nuovi tipi di contatto

### 2. Usabilità
- **Identificazione rapida**: Icone semantiche immediate
- **Azioni dirette**: Click-to-call, click-to-email
- **Feedback visivo**: Hover states e transizioni

### 3. Manutenibilità
- **Codice centralizzato**: Un metodo per tutto il rendering
- **Riutilizzabilità**: Pattern applicabile a qualsiasi risorsa
- **Estendibilità**: Facile aggiungere nuovi canali

## Implementazione nel Modulo Notify

### File Coinvolti
- **ContactColumn.php**: Classe helper per il pattern
- **Risorse Filament**: Implementazione nelle tabelle
- **File di traduzione**: Label e messaggi localizzati

### Campi Supportati
Il modulo Notify supporta questi campi di contatto standard:
- `phone` - Telefono fisso
- `mobile` - Telefono cellulare  
- `email` - Email principale
- `pec` - Posta Elettronica Certificata
- `whatsapp` - Numero WhatsApp
- `fax` - Numero fax (legacy)

### Configurazione Searchable
La colonna supporta ricerca su tutti i campi:
```php
->searchable(['phone', 'mobile', 'email', 'pec', 'whatsapp', 'fax'])
```

## Best Practices

### Sicurezza
- **Sanitizzazione**: Sempre usare `htmlspecialchars()`
- **Validazione**: Verificare formato numeri/email
- **XSS Prevention**: Nessun HTML non controllato

### Performance
- **Lazy Loading**: Non caricare dati non necessari
- **Caching**: Cache dei risultati quando possibile
- **Limit**: Limitare lunghezza testi mostrati

### Consistenza
- **Schema colori**: Mantenere colori coerenti tra moduli
- **Icone**: Usare stesso set di icone
- **Comportamento**: Stessa UX in tutto il progetto

## Pattern Alternativi

### ViewColumn (Non Raccomandato per Questo Caso)
```php
// Meno flessibile, più overhead
ViewColumn::make('contacts')
    ->view('notify::filament.tables.columns.contacts')
```

### Colonne Separate (Deprecato)
```php
// Spreco di spazio, UX frammentata
TextColumn::make('phone'),
TextColumn::make('email'),
TextColumn::make('pec'),
// ...
```

## Riutilizzo in Altri Moduli

Questo pattern può essere applicato a:
- **TechPlanner**: Clienti, fornitori, partner
- **User**: Profili utente, contatti
- **Cms**: Contatti pagine, form
- **Qualsiasi modulo**: Con dati di contatto

## Documentazione Correlata

### Modulo Notify
- [Filament Resources](filament_resources.md)
- [Translation Standards](translation_standards.md)
- [Best Practices](best_practices.md)

### Root Documentation
- [Filament Table Columns Best Practices](../../../docs/filament-table-columns-best-practices.md)
- [Composite Columns Pattern](../../../docs/composite-columns-pattern.md)
- [UI/UX Standards](../../../docs/ui-ux-standards.md)

### Altri Moduli
- [TechPlanner Contacts Column](../../TechPlanner/docs/contacts-column-implementation-complete.md)
- [UI Components](../../UI/docs/components.md)

## Changelog

### 2025-08-01
- **Creazione**: Documentazione iniziale del pattern
- **Standardizzazione**: Pattern derivato da TechPlanner
- **Best Practices**: Definite regole architetturali

---

*Ultimo aggiornamento: 2025-08-01*  
*Autore: Sistema Laraxot*  
*Versione: 1.0*
