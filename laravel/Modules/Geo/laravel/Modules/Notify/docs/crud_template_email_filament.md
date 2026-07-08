# Proposta Architetturale: CRUD Template Email in Notify (Filament)

## Obiettivo
Consentire la gestione runtime (CRUD) dei template email direttamente dal backend Filament, con fallback su file statici. Garantire robustezza, versioning, localizzazione e coerenza con le regole <nome progetto>.

---

## 1. Struttura Database (Esempio Migration)
```php
Schema::create('email_templates', function (Blueprint $table) {
    $table->id();
    $table->string('mailable_class'); // Es: Modules\\Notify\\Mail\\WelcomeMail
    $table->string('locale')->default('it');
    $table->string('theme')->nullable();
    $table->string('subject');
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->json('variables')->nullable();
    $table->integer('version')->default(1);
    $table->timestamps();
});
```

---

## 2. Model Eloquent
```php
namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'mailable_class', 'locale', 'theme', 'subject', 'html_template', 'text_template', 'variables', 'version'
    ];
}
```

---

## 3. Risorsa Filament (semplificata)
```php
namespace Modules\Notify\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms;
use Filament\Tables;
use Modules\Notify\Models\EmailTemplate;

class EmailTemplateResource extends Resource
{
    protected static string $model = EmailTemplate::class;

    public static function getFormSchema(): array
    {
        return [
            'mailable_class' => Forms\Components\TextInput::make('mailable_class')->required(),
            'locale' => Forms\Components\Select::make('locale')->options(['it'=>'it','en'=>'en']),
            'theme' => Forms\Components\TextInput::make('theme'),
            'subject' => Forms\Components\TextInput::make('subject')->required(),
            'html_template' => Forms\Components\Textarea::make('html_template')->rows(12)->required(),
            'text_template' => Forms\Components\Textarea::make('text_template')->rows(6),
            'variables' => Forms\Components\TextInput::make('variables'),
            'version' => Forms\Components\TextInput::make('version')->numeric()->default(1),
        ];
    }

    public static function getListTableColumns(): array
    {
        return [
            'mailable_class' => Tables\Columns\TextColumn::make('mailable_class'),
            'locale' => Tables\Columns\TextColumn::make('locale'),
            'theme' => Tables\Columns\TextColumn::make('theme'),
            'subject' => Tables\Columns\TextColumn::make('subject'),
            'version' => Tables\Columns\TextColumn::make('version'),
        ];
    }
}
```

---

## 4. Pattern di fallback (runtime)
```php
function resolveEmailTemplate(string $mailableClass, string $locale, ?string $theme): EmailTemplate|array {
    $template = EmailTemplate::where('mailable_class', $mailableClass)
        ->where('locale', $locale)
        ->when($theme, fn($q) => $q->where('theme', $theme))
        ->latest('version')->first();
    if ($template) {
        return $template;
    }
    // Fallback su file statico (resources/views/vendor/mail/...)
    return [
        'subject' => __('mail.subjects.'.$mailableClass),
        'html_template' => view('mail.'.$mailableClass)->render(),
        'text_template' => null,
        'variables' => [],
        'version' => 0,
    ];
}
```

---

## 5. Preview e Test automatici
- Implementare route protette in dev/admin per preview rendering
- Automatizzare test snapshot rendering per i principali template

---

## 6. Diagramma di flusso (testuale)
```
[Filament UI] -> [DB EmailTemplate] -> [Fallback file statico] -> [Render Email]
```

---

## 7. Best Practice
- Versionare ogni modifica ai template
- Validare e sanitizzare variabili dinamiche
- Documentare override e fallback
- Mantenere template minimi in file statici come backup

---

## 8. Collegamenti
- [email-templates-spatie.md](email-templates-spatie.md)
- [email-templates-laravel-mailables-notifications.md](email-templates-laravel-mailables-notifications.md)
- [email-templates-editor-visuali.md](email-templates-editor-visuali.md)
