# Componenti di Visualizzazione Dati

## Introduzione

I componenti di visualizzazione dati sono essenziali per presentare informazioni in modo chiaro e organizzato. Questa sezione documenta i componenti disponibili per la visualizzazione dei dati nel modulo CMS.

## Accordion

### Utilizzo Base
```php
<x-cms::accordion>
    <x-cms::accordion.item title="Sezione 1">
        Contenuto della sezione 1
    </x-cms::accordion.item>
    <x-cms::accordion.item title="Sezione 2">
        Contenuto della sezione 2
    </x-cms::accordion.item>
</x-cms::accordion>
```

### Proprietà
- `multiple`: boolean - Permette l'apertura di più sezioni
- `defaultOpen`: array - Indici delle sezioni aperte di default
- `bordered`: boolean - Aggiunge bordi alle sezioni

## Alert

### Utilizzo Base
```php
<x-cms::alert
    type="success"
    dismissible
>
    Operazione completata con successo!
</x-cms::alert>
```

### Tipi di Alert
- Success
- Error
- Warning
- Info

### Proprietà
- `type`: string - Tipo di alert
- `dismissible`: boolean - Permette la chiusura
- `icon`: string - Icona personalizzata
- `timeout`: int - Chiusura automatica dopo X millisecondi

## Avatar

### Utilizzo Base
```php
<x-cms::avatar
    src="/path/to/image.jpg"
    alt="Nome Utente"
/>
```

### Varianti
- Immagine
- Iniziali
- Icona

### Proprietà
- `src`: string - URL dell'immagine
- `alt`: string - Testo alternativo
- `size`: string - Dimensione (sm, md, lg)
- `shape`: string - Forma (circle, square)

## Badge

### Utilizzo Base
```php
<x-cms::badge
    label="Nuovo"
    color="red"
/>
```

### Proprietà
- `label`: string - Testo del badge
- `color`: string - Colore del badge
- `size`: string - Dimensione
- `dot`: boolean - Mostra solo un punto

## Card

### Utilizzo Base
```php
<x-cms::card>
    <x-slot name="header">
        Titolo Card
    </x-slot>
    
    Contenuto della card
    
    <x-slot name="footer">
        Footer della card
    </x-slot>
</x-cms::card>
```

### Proprietà
- `padded`: boolean - Aggiunge padding interno
- `bordered`: boolean - Aggiunge bordo
- `hoverable`: boolean - Effetto hover
- `shadow`: string - Tipo di ombra

## List

### Utilizzo Base
```php
<x-cms::list>
    <x-cms::list.item>
        Elemento 1
    </x-cms::list.item>
    <x-cms::list.item>
        Elemento 2
    </x-cms::list.item>
</x-cms::list>
```

### Proprietà
- `type`: string - Tipo di lista (ordered, unordered)
- `divided`: boolean - Aggiunge divisori tra gli elementi
- `hoverable`: boolean - Effetto hover sugli elementi

## Progress Bar

### Utilizzo Base
```php
<x-cms::progress-bar
    :value="75"
    :max="100"
/>
```

### Proprietà
- `value`: int - Valore corrente
- `max`: int - Valore massimo
- `color`: string - Colore della barra
- `striped`: boolean - Pattern a strisce
- `animated`: boolean - Animazione della barra

## Table

### Utilizzo Base
```php
<x-cms::table
    :headers="['Nome', 'Email', 'Ruolo']"
    :rows="$users"
/>
```

### Proprietà
- `headers`: array - Intestazioni della tabella
- `rows`: array - Dati delle righe
- `striped`: boolean - Righe alternate
- `hoverable`: boolean - Effetto hover sulle righe
- `bordered`: boolean - Bordi della tabella

## Timeline

### Utilizzo Base
```php
<x-cms::timeline>
    <x-cms::timeline.item
        title="Evento 1"
        date="2024-01-01"
    >
        Descrizione dell'evento
    </x-cms::timeline.item>
</x-cms::timeline>
```

### Proprietà
- `align`: string - Allineamento (left, center, right)
- `reverse`: boolean - Ordine inverso
- `alternate`: boolean - Elementi alternati

## Best Practices

### Accessibilità
1. Utilizzare markup semantico
2. Fornire alternative testuali
3. Supportare la navigazione da tastiera
4. Mantenere un contrasto adeguato

### Performance
1. Lazy loading per liste lunghe
2. Paginazione per grandi set di dati
3. Ottimizzazione delle immagini
4. Caching appropriato

### Responsive Design
1. Layout fluidi
2. Breakpoint coerenti
3. Gestione overflow
4. Priorità contenuto mobile

## Integrazione con Filament

### Resource Tables
```php
use Filament\Tables\Columns\TextColumn;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name'),
            TextColumn::make('email'),
        ]);
}
```

### Form Layout
```php
use Filament\Forms\Components\Card;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Card::make()
                ->schema([
                    // campi del form
                ]),
        ]);
}
```

## Troubleshooting

### Problemi Comuni
1. Layout non responsivo
   - Verificare i breakpoint
   - Controllare il contenuto overflow
   
2. Performance lenta
   - Implementare paginazione
   - Ottimizzare query database
   
3. Problemi di stile
   - Verificare conflitti CSS
   - Controllare specificity 
