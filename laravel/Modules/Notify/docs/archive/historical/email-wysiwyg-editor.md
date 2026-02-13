# Editor WYSIWYG per Email - il progetto

## Panoramica

Implementazione di un editor WYSIWYG avanzato per la creazione e modifica dei template email in il progetto.

## Caratteristiche

### 1. Editor Base

```php
namespace Modules\Notify\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Livewire\Component;

class EmailEditor extends Field
{
    protected string $view = 'notify::forms.components.email-editor';

    public function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (EmailEditor $component, $state) {
            $component->state($state);
        });

        $this->dehydrateStateUsing(function ($state) {
            return $this->sanitizeHtml($state);
        });
    }

    protected function sanitizeHtml(string $html): string
    {
        return clean($html, [
            'HTML.Allowed' => 'h1,h2,h3,h4,h5,h6,b,strong,i,em,u,a[href],p,br,ul,ol,li,img[src|alt|width|height],table,thead,tbody,tr,td,th',
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]);
    }
}
```

### 2. Componenti Personalizzati

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class ButtonBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label('Testo'),
                TextInput::make('url')
                    ->required()
                    ->url()
                    ->label('URL'),
                ColorPicker::make('color')
                    ->default('#000000')
                    ->label('Colore'),
            ])
            ->view('notify::forms.components.blocks.button');
    }
}

class ImageBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                FileUpload::make('image')
                    ->required()
                    ->image()
                    ->label('Immagine'),
                TextInput::make('alt')
                    ->required()
                    ->label('Testo alternativo'),
            ])
            ->view('notify::forms.components.blocks.image');
    }
}
```

### 3. Preview Live

```php
namespace Modules\Notify\Filament\Forms\Components;

class EmailPreview extends Field
{
    protected string $view = 'notify::forms.components.email-preview';

    public function setUp(): void
    {
        parent::setUp();

        $this->afterStateUpdated(function ($state) {
            $this->dispatch('preview-updated', [
                'html' => $this->renderPreview($state)
            ]);
        });
    }

    protected function renderPreview($state): string
    {
        return view('notify::mail.preview', [
            'content' => $state,
            'layout' => $this->getLayout(),
        ])->render();
    }
}
```

### 4. Validazione

```php
namespace Modules\Notify\Rules;

class EmailTemplateRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        // Verifica struttura HTML
        if (!$this->isValidHtml($value)) {
            return false;
        }

        // Verifica placeholder
        if (!$this->hasValidPlaceholders($value)) {
            return false;
        }

        // Verifica responsive
        if (!$this->isResponsive($value)) {
            return false;
        }

        return true;
    }

    protected function isValidHtml(string $html): bool
    {
        $dom = new \DOMDocument();
        return @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    }

    protected function hasValidPlaceholders(string $html): bool
    {
        preg_match_all('/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/', $html, $matches);
        
        foreach ($matches[1] as $placeholder) {
            if (!in_array($placeholder, $this->allowedPlaceholders)) {
                return false;
            }
        }

        return true;
    }

    protected function isResponsive(string $html): bool
    {
        return str_contains($html, '<meta name="viewport"') &&
               str_contains($html, '@media');
    }
}
```

### 5. Gestione Assets

```php
namespace Modules\Notify\Services;

class EmailAssetManager
{
    public function uploadImage($file): string
    {
        $path = $file->store('email-assets', 'public');
        
        // Ottimizza immagine
        $this->optimizeImage($path);
        
        // Genera URL pubblico
        return Storage::url($path);
    }

    public function optimizeImage(string $path): void
    {
        $image = Image::make(storage_path("app/public/{$path}"));
        
        $image->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $image->save(null, 80);
    }
}
```

## Integrazione con Filament

### 1. Resource

```php
class MailTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                // Editor principale
                EmailEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview
                EmailPreview::make('preview')
                    ->columnSpanFull(),

                // Componenti disponibili
                Select::make('components')
                    ->multiple()
                    ->options([
                        'button' => 'Pulsante',
                        'image' => 'Immagine',
                        'divider' => 'Divisore',
                        'spacer' => 'Spaziatore',
                    ]),

                // Layout
                Select::make('layout')
                    ->options([
                        'default' => 'Default',
                        'sidebar' => 'Sidebar',
                        'centered' => 'Centrato',
                    ]),
            ])
        ]);
    }
}
```

### 2. Actions

```php
class MailTemplateActions
{
    public static function make(): array
    {
        return [
            // Test invio
            Action::make('test')
                ->label('Test Email')
                ->icon('heroicon-o-paper-airplane')
                ->form([
                    TextInput::make('email')
                        ->email()
                        ->required(),
                ])
                ->action(function (array $data, MailTemplate $record) {
                    Mail::to($data['email'])
                        ->send(new TestMail($record));
                }),

            // Duplica template
            Action::make('duplicate')
                ->label('Duplica')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (MailTemplate $record) {
                    $record->replicate()->save();
                }),

            // Esporta
            Action::make('export')
                ->label('Esporta')
                ->icon('heroicon-o-download')
                ->action(function (MailTemplate $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo $record->html_template;
                    }, "template-{$record->id}.html");
                }),
        ];
    }
}
```

## Best Practices

### 1. Struttura HTML

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Stili base */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        {{ $content }}
    </div>
</body>
</html>
```

### 2. Componenti Riutilizzabili

```php
// Button component
class ButtonComponent
{
    public static function render(string $text, string $url, string $color = '#000000'): string
    {
        return view('notify::mail.components.button', [
            'text' => $text,
            'url' => $url,
            'color' => $color,
        ])->render();
    }
}

// Image component
class ImageComponent
{
    public static function render(string $src, string $alt, int $width = 600): string
    {
        return view('notify::mail.components.image', [
            'src' => $src,
            'alt' => $alt,
            'width' => $width,
        ])->render();
    }
}
```

### 3. Validazione Template

```php
class TemplateValidator
{
    public function validate(MailTemplate $template): array
    {
        $errors = [];

        // Verifica struttura
        if (!$this->validateStructure($template->html_template)) {
            $errors[] = 'Struttura HTML non valida';
        }

        // Verifica placeholder
        if (!$this->validatePlaceholders($template)) {
            $errors[] = 'Placeholder non validi';
        }

        // Verifica responsive
        if (!$this->validateResponsive($template->html_template)) {
            $errors[] = 'Template non responsive';
        }

        return $errors;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Editor non carica**
   - Verifica dipendenze JS
   - Controlla console errori
   - Verifica permessi file

2. **Preview non funziona**
   - Verifica stato live
   - Controlla renderizzazione
   - Debug template

3. **Validazione fallisce**
   - Controlla struttura HTML
   - Verifica placeholder
   - Debug regole

### 2. Performance

1. **Editor lento**
   - Ottimizza JS
   - Riduci dipendenze
   - Usa lazy loading

2. **Preview lenta**
   - Cache preview
   - Ottimizza template
   - Riduci complessità

3. **Upload lento**
   - Compressi immagini
   - Usa CDN
   - Ottimizza storage

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)
- [Mail Queue](database-mail-queue.md)

## Vedi Anche
- [TinyMCE Documentation](https://www.tiny.cloud/docs)
- [CKEditor Documentation](https://ckeditor.com/docs)
- [Quill Documentation](https://quilljs.com/docs) 