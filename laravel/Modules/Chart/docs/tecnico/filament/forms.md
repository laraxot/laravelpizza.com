# Forms Filament

## XotBaseForm

La classe base per tutti i form Filament:

```php
abstract class XotBaseForm extends Form
{
    use TransTrait;

    protected static ?string $model = null;
    protected static ?string $recordTitleAttribute = null;

    // Metodi utili
    public static function getModuleName(): string
    public static function trans(string $key): string
    public static function getModel(): string
    public static function getRecordTitleAttribute(): string
}
```

## Implementazione

### 1. Creazione Form
```php
class ArticleForm extends XotBaseForm
{
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
}
```

### 2. Struttura Directory
```
Module/
└── app/
    └── Filament/
        └── Forms/
            ├── ArticleForm.php
            └── CommentForm.php
```

### 3. Funzionalità Base
- Traduzioni integrate
- Model binding
- Validazione automatica
- Layout standard
- Relazioni automatiche

### 4. Best Practices
- Naming: `ModelNameForm`
- Namespace: `Modules\ModuleName\Filament\Forms`
- Implementare sempre `getFormSchema()`
- Utilizzare type hints
- Documentare PHPDoc

### 5. Esempio Completo
```php
declare(strict_types=1);

namespace Modules\Blog\Filament\Forms;

use Modules\Xot\Filament\Forms\XotBaseForm;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;

class ArticleForm extends XotBaseForm
{
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label(static::trans('title'))
                ->required()
                ->maxLength(255),

            RichEditor::make('content')
                ->label(static::trans('content'))
                ->required(),

            Select::make('status')
                ->label(static::trans('status'))
                ->options([
                    'draft' => static::trans('status.draft'),
                    'published' => static::trans('status.published'),
                ])
                ->required(),
        ];
    }
}
```

## Componenti Form

### 1. Input Base
```php
TextInput::make('title')
    ->label(static::trans('title'))
    ->required()
    ->maxLength(255)
    ->unique(Article::class, 'title')
    ->helperText(static::trans('title.help'))
```

### 2. Editor Rich Text
```php
RichEditor::make('content')
    ->label(static::trans('content'))
    ->required()
    ->toolbarButtons([
        'bold',
        'italic',
        'link',
        'orderedList',
        'unorderedList',
    ])
```

### 3. Select
```php
Select::make('category_id')
    ->label(static::trans('category'))
    ->relationship('category', 'name')
    ->required()
    ->searchable()
    ->preload()
```

### 4. Date/Time
```php
DateTimePicker::make('published_at')
    ->label(static::trans('published_at'))
    ->required()
    ->default(now())
    ->timezone('Europe/Rome')
```

### 5. File Upload
```php
FileUpload::make('image')
    ->label(static::trans('image'))
    ->image()
    ->directory('articles')
    ->maxSize(5120)
    ->imageResizeMode('cover')
    ->imageCropAspectRatio('16:9')
```

### 6. Toggle
```php
Toggle::make('is_featured')
    ->label(static::trans('is_featured'))
    ->default(false)
    ->helperText(static::trans('is_featured.help'))
```

## Validazione

### 1. Regole Base
```php
TextInput::make('title')
    ->required()
    ->maxLength(255)
    ->unique(Article::class, 'title')
```

### 2. Regole Personalizzate
```php
TextInput::make('slug')
    ->required()
    ->maxLength(255)
    ->unique(Article::class, 'slug')
    ->rules([
        'regex:/^[a-z0-9-]+$/',
        function (string $attribute, mixed $value, Closure $fail) {
            if (str_contains($value, '--')) {
                $fail('Lo slug non può contenere trattini consecutivi.');
            }
        },
    ])
```

### 3. Messaggi di Errore
```php
TextInput::make('title')
    ->required()
    ->maxLength(255)
    ->unique(Article::class, 'title')
    ->validationMessages([
        'required' => static::trans('validation.required'),
        'max' => static::trans('validation.max'),
        'unique' => static::trans('validation.unique'),
    ])
```

## Relazioni

### 1. Belongs To
```php
Select::make('category_id')
    ->relationship('category', 'name')
    ->required()
    ->searchable()
    ->preload()
```

### 2. Has Many
```php
Repeater::make('comments')
    ->relationship()
    ->schema([
        TextInput::make('content'),
        DateTimePicker::make('created_at'),
    ])
```

### 3. Many To Many
```php
Select::make('tags')
    ->relationship('tags', 'name')
    ->multiple()
    ->searchable()
    ->preload()
```

## Testing

### 1. Form Test
```php
class ArticleFormTest extends TestCase
{
    public function test_can_validate_form()
    {
        $form = new ArticleForm();
        $data = [
            'title' => '',
            'content' => '',
        ];

        $this->assertFalse($form->validate($data));
    }
}
```

## Workflow di Sviluppo

1. **Setup Iniziale**
   - Creare directory Forms
   - Creare classe base
   - Configurare namespace

2. **Implementazione**
   - Definire schema
   - Configurare validazione
   - Gestire relazioni

3. **Testing**
   - Test validazione
   - Test relazioni
   - Test submit

4. **Documentazione**
   - PHPDoc
   - README
   - CHANGELOG

## Form Wizard

### 1. Struttura Base
```php
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;

class PatientRegistrationWizard extends Component
{
    use InteractsWithForms;

    public ?array $data = [];

    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Step::make('Dati Personali')
                    ->icon('heroicon-o-user')
                    ->description('Inserisci i tuoi dati personali')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required(),
                        TextInput::make('surname')
                            ->label('Cognome')
                            ->required(),
                    ]),
                Step::make('Indirizzo')
                    ->icon('heroicon-o-home')
                    ->description('Inserisci il tuo indirizzo')
                    ->schema([
                        TextInput::make('address')
                            ->label('Indirizzo')
                            ->required(),
                    ]),
            ])
        ];
    }
}
```

### 2. Best Practices
- Utilizzare icone appropriate per ogni step
- Fornire descrizioni chiare
- Raggruppare i campi correlati nello stesso step
- Validare i dati per step
- Gestire la navigazione tra gli step
- Salvare i dati progressivamente
- Gestire gli errori appropriatamente

### 3. Validazione per Step
```php
Step::make('Dati Personali')
    ->schema([
        TextInput::make('name')
            ->required()
            ->maxLength(255)
            ->unique(Patient::class),
    ])
    ->afterStateUpdated(function ($state) {
        // Validazione aggiuntiva
    })
```

### 4. Salvataggio Progressivo
```php
Step::make('Dati Personali')
    ->afterStateUpdated(function ($state) {
        // Salva i dati dello step
        $this->saveStepData('personal', $state);
    })
```

### 5. Navigazione
```php
Wizard::make([
    // ... steps
])
->nextAction(
    fn (Action $action) => $action->label('Avanti')
)
->previousAction(
    fn (Action $action) => $action->label('Indietro')
)
->submitAction(
    fn (Action $action) => $action->label('Completa')
)
```

### 6. Testing
```php
class PatientRegistrationWizardTest extends TestCase
{
    public function test_can_navigate_steps()
    {
        $wizard = new PatientRegistrationWizard();
        $wizard->nextStep();
        $this->assertEquals(1, $wizard->currentStep);
    }

    public function test_can_validate_step()
    {
        $wizard = new PatientRegistrationWizard();
        $wizard->data = [
            'name' => '',
            'surname' => '',
        ];
        $this->assertFalse($wizard->validateStep(0));
    }
}
``` 
## Collegamenti tra versioni di forms.md
* [forms.md](docs/tecnico/filament/forms.md)
* [forms.md](laravel/Modules/Xot/docs/features/forms.md)

## Gestione Traduzioni
- Le traduzioni sono gestite tramite LangServiceProvider
- NON usare ->label(), ->placeholder(), ->helperText()
- Definire le traduzioni nei file di lingua del modulo

## Struttura Traduzioni
```php
// resources/lang/it/forms.php
return [
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo',
            'helper_text' => 'Il titolo del contenuto',
        ],
        'content' => [
            'label' => 'Contenuto',
            'placeholder' => 'Inserisci il contenuto',
            'helper_text' => 'Il contenuto principale',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'helper_text' => 'Lo stato corrente',
        ],
        'category' => [
            'label' => 'Categoria',
            'placeholder' => 'Seleziona la categoria',
            'helper_text' => 'La categoria del contenuto',
        ],
        'published_at' => [
            'label' => 'Data pubblicazione',
            'placeholder' => 'Seleziona la data',
            'helper_text' => 'Quando il contenuto sarà pubblicato',
        ],
        'image' => [
            'label' => 'Immagine',
            'placeholder' => 'Carica un\'immagine',
            'helper_text' => 'L\'immagine principale',
        ],
        'is_featured' => [
            'label' => 'In evidenza',
            'helper_text' => 'Mostra questo contenuto in evidenza',
        ],
    ],
];
```

## Implementazione
```php
// ❌ NON FARE:
->label(static::trans('title'))
->placeholder(static::trans('title.placeholder'))
->helperText(static::trans('title.help'))

// ✅ FARE:
// Le traduzioni sono gestite automaticamente tramite LangServiceProvider
// Definire nei file di lingua come mostrato sopra
```

## Componenti
1. **TextInput**
   - Input testuale
   - Validazione
   - Placeholder

2. **RichEditor**
   - Editor WYSIWYG
   - Formattazione
   - Immagini

3. **Select**
   - Selezione opzioni
   - Ricerca
   - Multi-select

4. **DateTimePicker**
   - Selezione data/ora
   - Formato personalizzato
   - Timezone

5. **FileUpload**
   - Upload file
   - Preview
   - Validazione

## Best Practices
1. **Validazione**
   - Regole chiare
   - Messaggi di errore
   - Feedback utente

2. **UI/UX**
   - Layout responsive
   - Feedback visivo
   - Accessibilità

3. **Performance**
   - Lazy loading
   - Caching
   - Ottimizzazione

## Note Tecniche
- Tutte le traduzioni sono gestite tramite LangServiceProvider
- Definire le traduzioni nei file di lingua del modulo
- NON usare metodi di traduzione diretti nei componenti

