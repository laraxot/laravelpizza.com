# Template Email

## Panoramica
Questo documento descrive il sistema di template email utilizzato nel modulo Notify.

## Struttura dei Template

### Template Base
```php
// resources/views/vendor/notifications/email/base.blade.php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
```

### Template Markdown
```php
// resources/views/vendor/notifications/email/welcome.blade.php
@component('mail::message')

# Benvenuto in {{ config('app.name') }}

Grazie per esserti registrato.

@component('mail::button', ['url' => $url])
Accedi
@endcomponent

Grazie,<br>
{{ config('app.name') }}
@endcomponent
```

## Editor Visuale

### Integrazione GrapesJS
```php
// app/Filament/Resources/EmailTemplateResource.php
use Filament\Forms\Components\Builder;

public static function form(Form $form): Form
{
    return $form->schema([
        Builder::make('content')
            ->blocks([
                Builder\Block::make('text')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->required()
                    ]),
                Builder\Block::make('image')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->required()
                    ]),
            ])
    ]);
}
```

## Personalizzazione

### Variabili Template
```php
// app/Notifications/WelcomeNotification.php
public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Benvenuto {name}')
        ->greeting('Ciao {name}')
        ->line('Benvenuto in {app_name}')
        ->action('Accedi', $this->loginUrl)
        ->line('Grazie per esserti registrato!')
        ->with([
            'name' => $notifiable->name,
            'app_name' => config('app.name'),
        ]);
}
```

### Stili Personalizzati
```css
/* resources/css/email.css */
.email-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.email-header {
    text-align: center;
    padding: 20px 0;
}

.email-footer {
    text-align: center;
    padding: 20px 0;
    font-size: 12px;
    color: #666;
}
```

## Best Practices

### 1. Struttura Template
- Utilizzare layout responsive
- Mantenere stili inline
- Testare su diversi client
- Supportare modalità testo

### 2. Performance
- Ottimizzare immagini
- Minimizzare CSS
- Utilizzare CDN
- Implementare cache

### 3. Accessibilità
- Contrasto adeguato
- Test screen reader
- Tag semantici
- Alt text immagini

## Note
- Tutti i collegamenti sono relativi
- La documentazione è mantenuta in italiano
- I collegamenti sono bidirezionali quando appropriato
- Ogni sezione ha il suo README.md specifico

## Contribuire
Per contribuire alla documentazione, seguire le [Linee Guida](../../../../docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../../docs/regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../../docs/README_links.md). 
