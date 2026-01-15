# GrapesJS Editor Integration

## Panoramica

Integrazione dell'editor GrapesJS per la gestione avanzata dei template di notifica. Questo permette di:
- Creare template HTML visualmente
- Gestire stili e layout in modo intuitivo
- Supportare componenti riutilizzabili
- Mantenere la compatibilità con i template esistenti

## Configurazione

```php
// config/notify.php
return [
    'grapesjs' => [
        'enabled' => true,
        'storage' => [
            'type' => 'remote', // remote, local
            'endpoint' => '/api/notify/templates',
        ],
        'assets' => [
            'css' => [
                'https://unpkg.com/grapesjs/dist/css/grapes.min.css',
            ],
            'js' => [
                'https://unpkg.com/grapesjs',
            ],
        ],
        'plugins' => [
            'gjs-preset-webpage',
            'gjs-blocks-basic',
        ],
        'blocks' => [
            'basic' => true,
            'forms' => true,
            'components' => true,
        ],
    ],
];
```

## Utilizzo

### Nel Resource Filament

```php
use Filament\Forms\Components\GrapesJS;

GrapesJS::make('body_html')
    ->label('Template HTML')
    ->tooltip('Editor visuale per il template')
    ->storage([
        'type' => 'remote',
        'endpoint' => '/api/notify/templates',
    ])
    ->plugins([
        'gjs-preset-webpage',
        'gjs-blocks-basic',
    ])
    ->blocks([
        'basic' => true,
        'forms' => true,
        'components' => true,
    ])
    ->variables([
        'user_name' => 'Nome Utente',
        'appointment_date' => 'Data Appuntamento',
    ])
```

### Nel Template

```php
class NotificationTemplate extends Model
{
    protected $casts = [
        'body_html' => 'string',
        'grapesjs_data' => 'array',
    ];

    public function getGrapesJSData(): array
    {
        return $this->grapesjs_data ?? [];
    }

    public function setGrapesJSData(array $data): self
    {
        $this->grapesjs_data = $data;
        return $this;
    }
}
```

## Funzionalità

1. **Editor Visuale**
   - Drag & drop di componenti
   - Gestione stili inline
   - Preview in tempo reale

2. **Componenti**
   - Blocchi predefiniti
   - Componenti personalizzati
   - Template riutilizzabili

3. **Variabili**
   - Supporto per variabili di template
   - Preview con dati di esempio
   - Validazione sintassi

4. **Storage**
   - Salvataggio automatico
   - Versioning dei template
   - Backup e ripristino

## Best Practices

1. **Template**
   - Usa componenti riutilizzabili
   - Mantieni la struttura pulita
   - Testa la responsività

2. **Variabili**
   - Usa nomi descrittivi
   - Documenta le variabili
   - Fornisci valori di esempio

3. **Stili**
   - Usa classi CSS
   - Evita stili inline
   - Mantieni la coerenza

4. **Performance**
   - Ottimizza le immagini
   - Minimizza il CSS
   - Usa lazy loading

## Vedi Anche

- [GrapesJS Documentation](https://grapesjs.com/docs/)
- [Filament GrapesJS Plugin](https://filamentphp.com/plugins/dotswan-grapesjs)
- [Laravel Notifications](https://laravel.com/docs/notifications) 