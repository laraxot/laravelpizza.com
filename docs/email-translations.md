# Integrazione Traduzioni Email - il progetto

## Panoramica

Sistema di traduzione multilingua per i template email in il progetto.

## Struttura Traduzioni

### 1. File di Traduzione

```php
// resources/lang/it/notify.php
return [
    'mail' => [
        'templates' => [
            'welcome' => [
                'subject' => 'Benvenuto in il progetto',
                'greeting' => 'Ciao {{ $name }}',
                'content' => 'Grazie per esserti registrato...',
                'button' => [
                    'text' => 'Inizia Ora',
                    'tooltip' => 'Clicca per iniziare',
                ],
            ],
            'appointment' => [
                'subject' => 'Appuntamento Confermato',
                'greeting' => 'Gentile {{ $name }}',
                'content' => 'Il tuo appuntamento è stato confermato...',
                'button' => [
                    'text' => 'Vedi Dettagli',
                    'tooltip' => 'Visualizza i dettagli dell\'appuntamento',
                ],
            ],
        ],
        'components' => [
            'button' => [
                'text' => 'Clicca Qui',
                'tooltip' => 'Clicca per procedere',
            ],
            'footer' => [
                'text' => '© {{ $year }} il progetto',
                'privacy' => 'Privacy Policy',
                'terms' => 'Termini e Condizioni',
            ],
        ],
    ],
];
```

### 2. Gestione Traduzioni

```php
namespace Modules\Notify\Services;

class MailTranslationService
{
    public function translate(string $key, array $replace = [], string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        $translation = trans("notify::mail.{$key}", $replace, $locale);
        
        if ($translation === "notify::mail.{$key}") {
            return $this->fallbackTranslation($key, $replace);
        }
        
        return $translation;
    }

    protected function fallbackTranslation(string $key, array $replace): string
    {
        return trans("notify::mail.{$key}", $replace, 'en');
    }
}
```

### 3. Integrazione con Editor

```php
namespace Modules\Notify\Filament\Forms\Components;

class TranslatableEmailEditor extends EmailEditor
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (TranslatableEmailEditor $component, $state) {
            $component->state($this->translateState($state));
        });

        $this->dehydrateStateUsing(function ($state) {
            return $this->untranslateState($state);
        });
    }

    protected function translateState($state): string
    {
        return preg_replace_callback(
            '/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/',
            function ($matches) {
                return $this->translationService->translate($matches[1]);
            },
            $state
        );
    }

    protected function untranslateState($state): string
    {
        return preg_replace_callback(
            '/\{\{\s*\$([a-zA-Z0-9_]+)\s*\}\}/',
            function ($matches) {
                return $this->translationService->untranslate($matches[1]);
            },
            $state
        );
    }
}
```

## Componenti Traducibili

### 1. Button Component

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class TranslatableButtonBlock extends ButtonBlock
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label(trans('notify::mail.components.button.text'))
                    ->tooltip(trans('notify::mail.components.button.tooltip')),
                TextInput::make('url')
                    ->required()
                    ->url()
                    ->label(trans('notify::mail.components.button.url')),
                ColorPicker::make('color')
                    ->default('#000000')
                    ->label(trans('notify::mail.components.button.color')),
            ]);
    }
}
```

### 2. Footer Component

```php
namespace Modules\Notify\Filament\Forms\Components\Blocks;

class TranslatableFooterBlock extends Block
{
    public static function make(): static
    {
        return parent::make()
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->label(trans('notify::mail.components.footer.text')),
                TextInput::make('privacy')
                    ->required()
                    ->label(trans('notify::mail.components.footer.privacy')),
                TextInput::make('terms')
                    ->required()
                    ->label(trans('notify::mail.components.footer.terms')),
            ]);
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
                // Editor traducibile
                TranslatableEmailEditor::make('html_template')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('preview', $this->renderPreview($state));
                    }),

                // Preview
                EmailPreview::make('preview')
                    ->columnSpanFull(),

                // Lingua
                Select::make('locale')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'de' => 'Deutsch',
                    ])
                    ->default('it')
                    ->required(),

                // Componenti disponibili
                Select::make('components')
                    ->multiple()
                    ->options([
                        'button' => trans('notify::mail.components.button.label'),
                        'footer' => trans('notify::mail.components.footer.label'),
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
            // Traduci
            Action::make('translate')
                ->label(trans('notify::mail.actions.translate'))
                ->icon('heroicon-o-translate')
                ->form([
                    Select::make('target_locale')
                        ->options([
                            'en' => 'English',
                            'de' => 'Deutsch',
                        ])
                        ->required(),
                ])
                ->action(function (array $data, MailTemplate $record) {
                    $record->translate($data['target_locale']);
                }),

            // Esporta traduzioni
            Action::make('export_translations')
                ->label(trans('notify::mail.actions.export_translations'))
                ->icon('heroicon-o-download')
                ->action(function (MailTemplate $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo json_encode($record->getTranslations(), JSON_PRETTY_PRINT);
                    }, "translations-{$record->id}.json");
                }),
        ];
    }
}
```

## Best Practices

### 1. Struttura Chiavi

```php
// Struttura consigliata
[
    'module' => [
        'feature' => [
            'element' => [
                'property' => 'value',
                'tooltip' => 'tooltip value',
                'placeholder' => 'placeholder value',
            ],
        ],
    ],
]

// Esempio
[
    'notify' => [
        'mail' => [
            'button' => [
                'text' => 'Clicca Qui',
                'tooltip' => 'Clicca per procedere',
                'placeholder' => 'Inserisci testo...',
            ],
        ],
    ],
]
```

### 2. Gestione Placeholder

```php
class TranslationPlaceholder
{
    public static function make(string $key, array $attributes = []): array
    {
        return [
            'key' => $key,
            'label' => trans("notify::mail.placeholders.{$key}.label"),
            'tooltip' => trans("notify::mail.placeholders.{$key}.tooltip"),
            'attributes' => $attributes,
        ];
    }
}

// Uso
$placeholders = [
    TranslationPlaceholder::make('name', ['required' => true]),
    TranslationPlaceholder::make('date', ['format' => 'd/m/Y']),
];
```

### 3. Validazione Traduzioni

```php
class TranslationValidator
{
    public function validate(array $translations): array
    {
        $errors = [];

        foreach ($translations as $locale => $data) {
            // Verifica chiavi mancanti
            if (!$this->hasRequiredKeys($data)) {
                $errors[$locale][] = 'Chiavi richieste mancanti';
            }

            // Verifica placeholder
            if (!$this->hasValidPlaceholders($data)) {
                $errors[$locale][] = 'Placeholder non validi';
            }

            // Verifica lunghezza
            if (!$this->hasValidLength($data)) {
                $errors[$locale][] = 'Lunghezza non valida';
            }
        }

        return $errors;
    }
}
```

## Troubleshooting

### 1. Problemi Comuni

1. **Traduzioni mancanti**
   - Verifica file di traduzione
   - Controlla namespace
   - Debug fallback

2. **Placeholder non funzionano**
   - Verifica sintassi
   - Controlla escape
   - Debug replace

3. **Cache traduzioni**
   - Pulisci cache
   - Ricarica traduzioni
   - Verifica locale

### 2. Performance

1. **Caricamento lento**
   - Cache traduzioni
   - Lazy loading
   - Ottimizza query

2. **Memoria alta**
   - Limita traduzioni
   - Pulisci cache
   - Monitora uso

## Collegamenti
- [Editor WYSIWYG](email-wysiwyg-editor.md)
- [Database Mail System](database-mail-system.md)
- [Email Plugins Analysis](email-plugins-analysis.md)

## Vedi Anche
- [Laravel Localization](https://laravel.com/project_docs/localization)
- [Laravel Localization](https://laravel.com/docs/localization)
- [Laravel Lang](https://github.com/Laravel-Lang/lang)
- [Laravel Translation Manager](https://github.com/barryvdh/laravel-translation-manager) 