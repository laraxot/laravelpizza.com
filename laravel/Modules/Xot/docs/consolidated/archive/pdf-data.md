# PdfData

La classe PdfData è un Data Object che gestisce la configurazione e i dati per la generazione di PDF nel modulo Xot.

## Caratteristiche principali

- Gestione delle opzioni di configurazione PDF
- Supporto per metadati del documento
- Gestione del layout e dello stile
- Configurazione dell'intestazione e del piè di pagina

## Proprietà

| Proprietà | Tipo | Descrizione |
|-----------|------|-------------|
| title | string | Titolo del documento PDF |
| author | string | Autore del documento |
| subject | string | Soggetto/argomento del documento |
| keywords | array | Parole chiave per il documento |
| creator | string | Creatore del documento |
| orientation | string | Orientamento della pagina (portrait/landscape) |
| pageSize | string | Dimensione della pagina (A4, Letter, etc.) |
| margins | array | Margini del documento |

## Metodi

### Costruttore
```php
public function __construct(array $data)
```

### Metodi di accesso
- `getTitle(): string`
- `getAuthor(): string`
- `getSubject(): string`
- `getKeywords(): array`
- `getOrientation(): string`
- `getPageSize(): string`
- `getMargins(): array`

### Factory Methods
```php
public static function fromArray(array $data): self
public static function make(array $data): self
```

## Best Practices

- Utilizzare i metodi factory per creare nuove istanze
- Validare i dati in ingresso con Assert
- Mantenere l'immutabilità dell'oggetto
- Utilizzare tipi di dati stretti

## Esempio di utilizzo

```php
$pdfData = PdfData::make([
    'title' => 'Il mio documento',
    'author' => 'Mario Rossi',
    'orientation' => 'portrait',
    'pageSize' => 'A4',
]);
```

## Validazione

La classe utilizza `Assert` per validare:
- Presenza dei campi obbligatori
- Tipi di dati corretti
- Valori validi per orientamento e dimensioni pagina 