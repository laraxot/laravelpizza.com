# Architettura del Sistema di Notifiche - Best Practices

## Introduzione

Basandoci sullo studio del pacchetto `filament-spatie-laravel-database-mail-templates`, questo documento illustra come applicare le best practices e i pattern architetturali al modulo Notify per migliorare il sistema di gestione delle notifiche e dei template email.

## Architettura del Plugin

### Pattern Plugin Filament

Come nel pacchetto `filament-spatie-laravel-database-mail-templates`, possiamo implementare un'architettura plugin per gestire le risorse di notifica:

```php
<?php

namespace Modules\Notify\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Modules\Notify\Filament\Resources\MailTemplateResource;

class NotifyPlugin implements Plugin
{
    public function getId(): string
    {
        return 'notify';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            MailTemplateResource::class,
            // Altre risorse di notifica
        ]);
    }

    public function boot(Panel $panel): void
    {
        // Logica di inizializzazione
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
```

## Gestione dei Template Email

### Sistema di Template Avanzato

Basandoci sul pattern del pacchetto Spatie, possiamo migliorare la gestione dei template:

```php
<?php

namespace Modules\Notify\Services;

use Spatie\MailTemplates\Models\MailTemplate;
use Illuminate\Support\Arr;

class EmailTemplateService
{
    public function getTemplateForMailable(string $mailableClass): ?MailTemplate
    {
        return MailTemplate::where('mailable', $mailableClass)->first();
    }

    public function renderTemplate(MailTemplate $template, array $variables): array
    {
        $subject = $this->replaceVariables($template->getSubject(), $variables);
        $html = $this->replaceVariables($template->getHtmlTemplate(), $variables);
        $text = $this->replaceVariables($template->getTextTemplate() ?? '', $variables);

        return [
            'subject' => $subject,
            'html' => $html,
            'text' => $text,
        ];
    }

    private function replaceVariables(string $template, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $template = str_replace('{{'.$key.'}}', $value, $template);
        }

        return $template;
    }

    public function getTemplateVariables(string $mailableClass): array
    {
        if (!class_exists($mailableClass)) {
            return [];
        }

        // Richiama il metodo getVariables della classe mailable se esiste
        if (method_exists($mailableClass, 'getVariables')) {
            return $mailableClass::getVariables();
        }

        return [];
    }
}
```

## Componenti UI Avanzati

### Editor di Template Specializzato

Come nel pacchetto esterno, possiamo creare componenti UI specializzati per la gestione dei template:

```php
<?php

namespace Modules\Notify\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Support\Str;

class TemplateVariableDisplay extends Field
{
    protected string $view = 'notify::filament.components.template-variables';

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false);
    }

    public static function make(string $name = 'template-variables'): static
    {
        return parent::make($name)
            ->view('notify::filament.components.template-variables');
    }
}
```

## Architettura del Modello

### Estensione del Modello MailTemplate

Possiamo estendere le funzionalità del modello MailTemplate per sfruttare appieno il pacchetto Spatie:

```php
<?php

namespace Modules\Notify\Models;

use Spatie\MailTemplates\Models\MailTemplate as SpatieMailTemplate;
use Spatie\MailTemplates\Interfaces\MailTemplateInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Notify\Models\MailTemplateVersion;

class MailTemplate extends SpatieMailTemplate implements MailTemplateInterface
{
    // ... codice esistente ...

    public function versions(): HasMany
    {
        return $this->hasMany(MailTemplateVersion::class, 'template_id')
            ->orderByDesc('version');
    }

    public function createNewVersion(string $createdBy, ?string $notes = null): self
    {
        $this->versions()->create([
            'mailable' => $this->mailable,
            'subject' => $this->subject,
            'html_template' => $this->html_template,
            'text_template' => $this->text_template,
            'version' => $this->version,
            'created_by' => $createdBy,
            'change_notes' => $notes,
        ]);

        $this->increment('version');
        return $this;
    }

    public function getVariables(): array
    {
        $mailableClass = $this->mailable;

        if (! class_exists($mailableClass)) {
            return [];
        }

        if (method_exists($mailableClass, 'getVariables')) {
            return $mailableClass::getVariables();
        }

        return [];
    }
}
```

## Sistema di Versioning

### Gestione Versioni Template

Implementazione del versioning dei template come nel pacchetto Spatie:

```php
<?php

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MailTemplateVersion extends Model
{
    protected $fillable = [
        'template_id',
        'mailable',
        'subject',
        'html_template',
        'text_template',
        'version',
        'created_by',
        'change_notes',
    ];

    protected $table = 'mail_template_versions';

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(MailTemplate::class, 'template_id');
    }
}
```

## Miglioramenti UI per Filament

### Risorse Filament avanzate

Come nel pacchetto esterno, possiamo migliorare l'esperienza utente:

```php
<?php

namespace Modules\Notify\Filament\Resources;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MailTemplateResource extends Resource
{
    protected static ?string $model = MailTemplate::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([
                        TextInput::make('subject')
                            ->label(__('notify::mail_template.field.subject')),
                        MarkdownEditor::make('text_template')
                            ->label(__('notify::mail_template.field.text_template'))
                            ->toolbarButtons([
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'bold',
                                'italic',
                                'undo',
                                'redo',
                            ]),
                        RichEditor::make('html_template')
                            ->label(__('notify::mail_template.field.html_template'))
                            ->toolbarButtons([
                                'blockquote',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'undo',
                                'redo',
                            ]),
                    ])->columnSpan(['md' => 2, 'lg' => 3]),
                    Section::make([
                        TextInput::make('mailable')
                            ->label(__('notify::mail_template.field.mailable'))
                            ->extraAttributes(['class' => 'font-mono'])
                            ->disabled(),
                        View::make('notify::filament.components.template-variables'),
                    ])->columnSpan(1),
                ])->columnSpanFull(),
            ])
            ->columns(['md' => 3, 'lg' => 4]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mailable')
                    ->label(__('notify::mail_template.field.mailable'))
                    ->searchable()
                    ->sortable()
                    ->fontFamily(FontFamily::Mono),
                TextColumn::make('subject')
                    ->label(__('notify::mail_template.field.subject'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('notify::mail_template.field.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('notify::mail_template.field.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
```

## Conclusione

Implementando questi pattern e best practices basati sul pacchetto `filament-spatie-laravel-database-mail-templates`, possiamo ottenere:

1. **Miglior esperienza utente** grazie a componenti UI più specializzati
2. **Sistema di template più robusto** con versioning e gestione avanzata delle variabili
3. **Architettura più modulare** grazie al pattern plugin Filament
4. **Integrazione più stretta** con le funzionalità del pacchetto Spatie
5. **Mantenibilità migliorata** grazie a una separazione chiara delle responsabilità
