# Gestione Sezioni

## Introduzione
Il modello `Section` permette di gestire sezioni riutilizzabili del sito come header, footer, sidebar e altri blocchi di contenuto. Ogni sezione può contenere diversi tipi di blocchi ed è completamente personalizzabile.

## Struttura

### Modello Section
```php
class Section extends BaseModel
{
    use HasTranslations;
    use SushiToJsons;

    public $translatable = [
        'name',
        'blocks'
    ];

    protected $fillable = [
        'name',
        'slug',
        'blocks'
    ];
}
```

### Schema JSON
```json
{
    "name": {
        "it": "Header Principale",
        "en": "Main Header"
    },
    "slug": "main-header",
    "blocks": {
        "it": [
            {
                "type": "navigation",
                "data": {
                    "items": []
                }
            }
        ],
        "en": []
    }
}
```

## Utilizzo

### Creazione Sezione
```php
use Modules\Cms\Models\Section;

$header = Section::create([
    'name' => [
        'it' => 'Header Principale',
        'en' => 'Main Header'
    ],
    'slug' => 'main-header',
    'blocks' => [
        'it' => [
            [
                'type' => 'navigation',
                'data' => [
                    'items' => [
                        [
                            'label' => 'Home',
                            'url' => '/'
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
```

### Recupero Sezione
```php
$header = Section::where('slug', 'main-header')->first();
$blocks = $header->getTranslation('blocks', app()->getLocale());
```

## Gestione tramite Filament

### Resource
La risorsa `SectionResource` fornisce un'interfaccia amministrativa completa per:
- Creazione sezioni
- Modifica sezioni
- Gestione traduzioni
- Anteprima sezioni

### Builder Blocchi
Ogni sezione può contenere diversi tipi di blocchi:
- Navigation
- Logo
- Content
- Social
- Custom HTML

## Best Practices

### 1. Organizzazione
- Usare slug significativi
- Mantenere la coerenza tra le traduzioni
- Strutturare i blocchi logicamente

### 2. Performance
- Utilizzare la cache
- Ottimizzare le query
- Minimizzare i blocchi

### 3. Manutenzione
- Backup regolari
- Validazione contenuti
- Monitoraggio utilizzo

## Collegamenti
- [Documentazione Blocchi](blocks/README.md)
- [Documentazione UI](../../UI/project_docs/README.md)
- [Documentazione Root](../../../../project_docs/README.md)
- [Documentazione Root – Sezioni](../../../../project_docs/sections.md)
- [Panoramica Gestione Pagine (Root)](../../../../project_docs/page-content-management.md)
