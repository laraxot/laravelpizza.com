


=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> 36321fcb (.)
=======
>>>>>>> 712617d3 (.)
=======
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)

=======
>>>>>>> 4f3927d7 (.)
=======
>>>>>>> c8b1c8bf (.)

=======
>>>>>>> 75179b855 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> 36321fcb (.)
=======
>>>>>>> 712617d3 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 2a97406c (.)
>>>>>>> 998e6866b (.)
=======
>>>>>>> 36136dcfa (.)
=======
=======
>>>>>>> 36321fcb (.)
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 731b801a8 (.)
=======
=======
>>>>>>> fdb24863 (rebase 210)
>>>>>>> b85076e48 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
=======
>>>>>>> 9c45d9bd (rebase 210)
>>>>>>> ce1853afd (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> c31e900eb (.)
=======
=======
>>>>>>> 36ac4fc1 (.)
>>>>>>> fea359347 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
=======
>>>>>>> 4f3927d7 (.)
>>>>>>> 602b8a0a9 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
=======
>>>>>>> 9cf0dc90 (.)
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
# Sistema di Gestione Email Basato su Database - il progetto

## Panoramica

Implementazione personalizzata di un sistema di gestione email basato su database per il progetto, ispirato a Spatie/laravel-database-mail-templates ma con funzionalità aggiuntive e integrazione completa con il nostro ecosistema.

## Caratteristiche Principali

- Template email memorizzati nel database
- Supporto multilingua
- Editor WYSIWYG integrato con Filament
- Sistema di placeholder avanzato
- Versionamento dei template
- Preview in tempo reale
- Test di invio
- Statistiche di apertura/click
- Integrazione con il sistema di code
- Supporto per allegati dinamici
- Gestione layout personalizzati
- Backup automatico dei template

## Struttura Database

```php
// Template Email
Schema::create('notify_mail_templates', function (Blueprint $table) {
    $table->id();
    $table->string('mailable'); // Classe Mailable associata
    $table->string('name');     // Nome template
    $table->string('locale');   // Lingua (it, en, etc.)
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->json('variables')->nullable(); // Variabili disponibili
    $table->json('layout')->nullable();    // Layout personalizzato
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->softDeletes();
});

// Versioni Template
Schema::create('notify_mail_template_versions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained('notify_mail_templates');
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->string('created_by');
    $table->text('change_notes')->nullable();
    $table->timestamps();
});

// Statistiche Invio
Schema::create('notify_mail_stats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained('notify_mail_templates');
    $table->string('email');
    $table->timestamp('sent_at');
    $table->timestamp('opened_at')->nullable();
    $table->json('clicked_links')->nullable();
    $table->string('status'); // sent, delivered, opened, clicked, bounced
    $table->json('metadata')->nullable();
});
```

## Componenti del Sistema

### 1. Template Manager

```php
namespace Modules\Notify\Services;

class MailTemplateManager
{
    public function getTemplate(string $mailable, string $locale = null): ?MailTemplate
    {
        $locale = $locale ?? app()->getLocale();
        return MailTemplate::where('mailable', $mailable)
            ->where('locale', $locale)
            ->where('is_active', true)
            ->first();
    }

    public function renderTemplate(MailTemplate $template, array $data): string
    {
        // Rendering con Blade + gestione placeholder
        return view()
            ->make('notify::mail.template', [
                'content' => $template->html_template,
                'layout' => $template->layout,
                'data' => $data
            ])
            ->render();
    }
}
```

### 2. Trait per Mailables

```php
namespace Modules\Notify\Traits;

trait UseDatabaseTemplate
{
    public function build()
    {
        $template = app(MailTemplateManager::class)
            ->getTemplate(static::class);

        if (!$template) {
            return parent::build();
        }

        return $this->view('notify::mail.template')
            ->with([
                'content' => $template->html_template,
                'layout' => $template->layout,
                'data' => $this->data
            ]);
    }
}
```

### 3. Filament Resource

```php
namespace Modules\Notify\Filament\Resources;

class MailTemplateResource extends XotBaseResource
{
    protected static ?string $model = MailTemplate::class;


=======
    public static function form(Form $form): Form
>>>>>>> 75179b85 (.)


=======
    public static function form(Form $form): Form
>>>>>>> 4f042b88 (.)
=======
    public static function form(Form $form): Form
>>>>>>> 36321fcb (.)
=======
    public static function form(Form $form): Form
>>>>>>> 712617d3 (.)
=======
    public static function form(Form $form): Form
>>>>>>> fdb24863 (rebase 210)
=======
    public static function form(Form $form): Form
>>>>>>> 4fc21b78 (rebase 210)

=======
    public static function form(Form $form): Form
>>>>>>> 4f3927d7 (.)
=======
    public static function form(Form $form): Form
>>>>>>> c8b1c8bf (.)
=======
    public static function form(Form $form): Form
>>>>>>> 9cf0dc90 (.)
=======
    public static function form(Form $form): Form
>>>>>>> 75179b85 (.)
=======
    public static function form(Form $form): Form
>>>>>>> f963d2c0 (.)
=======
    public static function form(Form $form): Form
>>>>>>> ee18dd92 (.)
=======
    public static function form(Form $form): Form
>>>>>>> 66453ace (.)
=======
    public static function form(Form $form): Form
>>>>>>> 2a97406c (.)

=======
    public static function form(Form $form): Form
>>>>>>> 712617d3 (.)
=======
    public static function form(Form $form): Form
>>>>>>> fdb24863 (rebase 210)
=======
    public static function form(Form $form): Form
>>>>>>> 4fc21b78 (rebase 210)
=======
    public static function form(Form $form): Form
>>>>>>> 9c45d9bd (rebase 210)
=======
    public static function form(Form $form): Form
>>>>>>> eb62d6cf (rebase 210)
=======
    public static function form(Form $form): Form
>>>>>>> 8c8937e7 (rebase 210)
=======
    public static function form(Form $form): Form
>>>>>>> 36ac4fc1 (.)


=======
    public static function form(Form $form): Form
>>>>>>> 75179b85 (.)
=======
    public static function form(Form $form): Form
>>>>>>> 75179b855 (.)
=======
    public static function form(Form $form): Form
>>>>>>> f963d2c0 (.)
=======
    public static function form(Form $form): Form
>>>>>>> ee18dd92 (.)
=======
    public static function form(Form $form): Form
>>>>>>> 66453ace (.)
=======
    public static function form(Form $form): Form
>>>>>>> 2a97406c (.)
=======
    public static function form(Form $form): Form
>>>>>>> 4f042b88 (.)
=======
    public static function form(Form $form): Form
>>>>>>> 36321fcb (.)

=======
>>>>>>> 4bec160e6 (.)
=======
=======
    public static function form(Form $form): Form
>>>>>>> 66453ace (.)
>>>>>>> 138485550 (.)
=======
>>>>>>> 998e6866b (.)
=======
=======
    public static function form(Form $form): Form
>>>>>>> 4f042b88 (.)
>>>>>>> 36136dcfa (.)
=======
>>>>>>> 70175d0c4 (.)
=======
=======
    public static function form(Form $form): Form
>>>>>>> 712617d3 (.)
>>>>>>> 731b801a8 (.)
=======
=======
    public static function form(Form $form): Form
>>>>>>> fdb24863 (rebase 210)
>>>>>>> b85076e48 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
=======
    public static function form(Form $form): Form
>>>>>>> 9c45d9bd (rebase 210)
>>>>>>> ce1853afd (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
=======
    public static function form(Form $form): Form
>>>>>>> 8c8937e7 (rebase 210)
>>>>>>> c31e900eb (.)
=======
>>>>>>> fea359347 (.)
=======
=======
    public static function form(Form $form): Form
>>>>>>> fd1fcc4c (.)
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 602b8a0a9 (.)
=======
=======
    public static function form(Form $form): Form
>>>>>>> c8b1c8bf (.)
>>>>>>> 7ceb00286 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
    public static function form(Form $form): Form
>>>>>>> a55aa5e96 (.)
    {
        return $form->schema([
            Card::make()->schema([
                TextInput::make('name')
                    ->required(),
                Select::make('mailable')
                    ->options(static::getMailableClasses())
                    ->required(),
                Select::make('locale')
                    ->options(static::getAvailableLocales())
                    ->required(),
                RichEditor::make('html_template')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'orderedList',
                        'unorderedList',
                        'h2',
                        'h3',
                    ]),
                Toggle::make('is_active')
                    ->default(true),
            ])
        ]);
    }
}
```

## Utilizzo

### 1. Creazione Template

```php
use Modules\Notify\Models\MailTemplate;

MailTemplate::create([
    'mailable' => WelcomeEmail::class,
    'name' => 'Welcome Email',
    'locale' => 'it',
    'html_template' => '<h1>Benvenuto {{ $user->name }}!</h1>',
    'variables' => ['user' => 'App\Models\User'],
]);
```

### 2. Utilizzo in Mailable

```php
use Modules\Notify\Traits\UseDatabaseTemplate;

class WelcomeEmail extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public User $user)
    {
        //
    }
}
```

### 3. Invio Email

```php
Mail::to($user)->send(new WelcomeEmail($user));
```

## Best Practices

1. **Versionamento Template**
   - Mantenere storico modifiche
   - Possibilità di rollback
   - Note di cambiamento

2. **Testing**
   - Test automatici per rendering
   - Validazione variabili
   - Preview multi-device

3. **Performance**
   - Cache dei template
   - Ottimizzazione query
   - Code per invio massivo

4. **Sicurezza**
   - Sanitizzazione input
   - Escape variabili
   - Protezione XSS

## Integrazione con Altri Moduli

### 1. Module Patient
```php
// Esempio notifica appuntamento
class AppointmentReminder extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public Appointment $appointment)
    {
        //
    }
}
```

### 2. Module Dental
```php
// Esempio notifica trattamento
class TreatmentComplete extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public Treatment $treatment)
    {
        //
    }
}
```

## Comandi Artisan

```bash

=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======

=======

=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======

=======
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 8a8a8e2f (rebase 210)
=======

=======
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======

=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> e0d9c9be (.)
=======
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> e0836b102 (.)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 47a873f13 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> cbb586cb0 (.)

>>>>>>> b19cd40 (.)
=======

=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> e0836b102 (.)
=======
>>>>>>> 47a873f13 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> cbb586cb0 (.)
>>>>>>> 75179b85 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b85 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b85 (.)


=======
>>>>>>> f963d2c0 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 66453ace (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> c6c33175 (.)
=======
>>>>>>> 4f042b88 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> 36321fcb (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 8e5817bc (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 7a2f131f (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
=======
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 1c0eb9c7 (rebase 210)
=======
>>>>>>> fdb24863 (rebase 210)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> 229a065a (rebase 210)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> a9bf0423 (rebase 210)

>>>>>>> 9fe1b60e (rebase 210)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 8a8a8e2f (rebase 210)
>>>>>>> 9f8e680a (rebase 210)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> b4f93b3a (rebase 210)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 52cd5f85 (rebase 210)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> bb00ab64 (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
=======
>>>>>>> 36ac4fc1 (.)


=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> f81a620f (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 06e3078e (.)
=======
>>>>>>> 70e8274e (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> 3ee54c5d (.)
=======
>>>>>>> c8b1c8bf (.)
>>>>>>> 2fc60436 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
>>>>>>> 82ae73be (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)

=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> ee18dd92 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> e7a9a2bf (.)

=======
>>>>>>> 66453ace (.)
=======
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
>>>>>>> 2a97406c (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)

=======
>>>>>>> 4f042b88 (.)

=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> 36321fcb (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 8e5817bc (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 51182e3c (rebase 210)

>>>>>>> 229a065a (rebase 210)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 4d253d2c (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 9fe1b60e (rebase 210)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 8a8a8e2f (rebase 210)
=======
>>>>>>> efb0f8d9 (rebase 210)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> 9f8e680a (rebase 210)

>>>>>>> 1375c94d (rebase 210)
>>>>>>> 5aedc39c (rebase 210)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> c5c038f2 (rebase 210)

>>>>>>> 22baa66d (rebase 210)
=======
>>>>>>> 36ac4fc1 (.)
>>>>>>> 2effe245 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 77edd94a (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 59916c8f (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)

=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 06e3078e (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> 3ee54c5d (.)
=======
>>>>>>> c8b1c8bf (.)


=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b855 (.)
>>>>>>> 82ae73be (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
=======
>>>>>>> b207a9b1a (.)
=======

>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 66453ace (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)


=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> c6c33175 (.)
=======
>>>>>>> 4f042b88 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
=======

>>>>>>> b19cd40 (.)
>>>>>>> 3b4c9907 (.)

=======
>>>>>>> 36321fcb (.)

=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 7a2f131f (.)
=======
>>>>>>> 712617d3 (.)
=======
=======

>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 10292b60a (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
>>>>>>> bf5d31b0f (.)
=======
>>>>>>> 12a7e2462 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> b207a9b1a (.)
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> 4bec160e6 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> d3a8af4d5 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> 138485550 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> c22b35d1e (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
>>>>>>> 8f2456941 (.)
=======
>>>>>>> f87b41c3b (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 998e6866b (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 138fcd4b0 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 36136dcfa (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> db0bc148f (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
>>>>>>> 49639b815 (.)
=======
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 9cb55171f (.)
=======
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> 731b801a8 (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 13655a7ed (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> cb85c538 (rebase 210)
>>>>>>> e0836b102 (.)
=======
>>>>>>> b85076e48 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 903e3e2cd (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 460b8f5b (rebase 210)
>>>>>>> 47a873f13 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> a0788fa28 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> ce1853afd (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 5d49e093a (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 17f6b8617 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
>>>>>>> db6bec044 (.)
=======
>>>>>>> c31e900eb (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> fea359347 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> 2e1ac1f20 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> e95dfc210 (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> 602b8a0a9 (.)
=======
>>>>>>> 763771402 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
>>>>>>> be698cf2c (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
>>>>>>> cbb586cb0 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
# Gestione template
php artisan notify:mail-template:list
php artisan notify:mail-template:create
php artisan notify:mail-template:update
php artisan notify:mail-template:delete

# Utilità
php artisan notify:mail-template:export
php artisan notify:mail-template:import
php artisan notify:mail-template:test
```

## Roadmap

1. **Fase 1 - Base**
   - [x] Template database
   - [x] Editor WYSIWYG
   - [x] Supporto multilingua

2. **Fase 2 - Avanzato**
   - [ ] A/B Testing
   - [ ] Analytics avanzate
   - [ ] Template condizionali

3. **Fase 3 - Enterprise**
   - [ ] API REST
   - [ ] Webhook
   - [ ] Integrazioni esterne

## Troubleshooting

### Problemi Comuni

1. **Template non trovato**
   - Verificare mailable class
   - Controllare locale
   - Verificare is_active

2. **Variabili non renderizzate**
   - Controllare sintassi
   - Verificare escape
   - Debug dati passati

3. **Performance**
   - Ottimizzare query
   - Implementare cache
   - Monitorare tempi

## Collegamenti
- [Notify Module](../README.md)
- [Email Templates](email-templates.md)
- [Mail Queue](mail-queue.md)

## Vedi Anche

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
>>>>>>> 207ac35e (.)

=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 8a8a8e2f (rebase 210)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
=======
>>>>>>> 030c9674 (rebase 210)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
>>>>>>> 4d2eb53e (.)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 8a8a8e2f (rebase 210)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
=======
>>>>>>> 030c9674 (rebase 210)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
=======
>>>>>>> eea68ec9 (.)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
>>>>>>> 4d2eb53e (.)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

>>>>>>> 1619767d8 (.)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> de02998b (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> e7a9a2bf (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 9cdf6146 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 3f39ac8b (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 6d08c01b (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 3b4c9907 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 8e5817bc (.)
=======

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
=======
>>>>>>> a115e2aad (.)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 82ae73be (.)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 8a8a8e2f (rebase 210)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
=======
>>>>>>> 030c9674 (rebase 210)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> f81a620f (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 2fc60436 (.)
=======
- [Laravel Mail](https://laravel.com/project_docs/mail)
- [Filament Forms](https://filamentphp.com/project_docs/forms)
>>>>>>> b19cd40 (.)

=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> d3a8af4d5 (.)
=======
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 138fcd4b0 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> db0bc148f (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> 13655a7ed (.)
=======
>>>>>>> e0836b102 (.)
=======
>>>>>>> 903e3e2cd (.)
=======
>>>>>>> 47a873f13 (.)
=======
>>>>>>> a0788fa28 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> 5d49e093a (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 17f6b8617 (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> 2e1ac1f20 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> e95dfc210 (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 207ac35e (.)
=======

=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> e0d9c9be (.)
=======
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 8a8a8e2f (rebase 210)
=======

=======
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======

=======
>>>>>>> e0d9c9be (.)
=======
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 8a8a8e2f (rebase 210)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> eea68ec9 (.)
=======

=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======

=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> e0836b102 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> cbb586cb0 (.)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 4e2ebfb (.)

=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> e0836b102 (.)
=======
>>>>>>> 47a873f13 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> cbb586cb0 (.)
>>>>>>> 207ac35e (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 9777d1b3 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)


=======

=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> ba564870 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
- [Laravel Mail](https://laravel.com/project_docs/mail)
- [Filament Forms](https://filamentphp.com/project_docs/forms)
>>>>>>> b19cd40 (.)
>>>>>>> 9cdf6146 (.)

=======
- [Laravel Mail](https://laravel.com/project_docs/mail)
- [Filament Forms](https://filamentphp.com/project_docs/forms)
>>>>>>> b19cd40 (.)
>>>>>>> 3f39ac8b (.)


=======
>>>>>>> 6b6b9e41 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> c6c33175 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)

=======
=======
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
=======
>>>>>>> 8e5817bc (.)
=======
>>>>>>> e0d9c9be (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 7a2f131f (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 712617d3 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
=======
>>>>>>> 51182e3c (rebase 210)

>>>>>>> 229a065a (rebase 210)
=======
>>>>>>> a9bf0423 (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 9f8e680a (rebase 210)
=======
>>>>>>> b4f93b3a (rebase 210)
>>>>>>> 5aedc39c (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)

>>>>>>> 22baa66d (rebase 210)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 36ac4fc1 (.)
>>>>>>> 2effe245 (.)
=======
>>>>>>> 77edd94a (.)
=======
>>>>>>> eea68ec9 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 59916c8f (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> fd1fcc4c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)

=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 3ee54c5d (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> c8b1c8bf (.)

=======
=======
>>>>>>> 1487fe812 (.)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 161887a2 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> ee18dd92 (.)


=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 66453ace (.)

=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 5fd545e4 (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 888799d0 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 2a97406c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
>>>>>>> 6d08c01b (.)

=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 503981fd (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 36321fcb (.)


=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 712617d3 (.)

=======
>>>>>>> 51182e3c (rebase 210)
>>>>>>> 229a065a (rebase 210)
=======
>>>>>>> a9bf0423 (rebase 210)

>>>>>>> 5aedc39c (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
>>>>>>> 22baa66d (rebase 210)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 36ac4fc1 (.)


=======
=======
>>>>>>> f81a620f (.)
=======
>>>>>>> 06e3078e (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 70e8274e (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 4f3927d7 (.)

=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> c8b1c8bf (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 58816034 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 9cf0dc90 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 75179b85 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 9777d1b3 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 75179b855 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 9777d1b3 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 161887a2 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> ba564870 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 5fd545e4 (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 888799d0 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 2a97406c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> c6c33175 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 503981fd (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 36321fcb (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
=======
>>>>>>> 8e5817bc (.)
=======
>>>>>>> e0d9c9be (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> 7a2f131f (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 301ad8b44 (.)
=======
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 10292b60a (.)
=======
=======
>>>>>>> 207ac35e (.)
>>>>>>> bf5d31b0f (.)
=======
>>>>>>> 12a7e2462 (.)
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> de02998b (.)
>>>>>>> b207a9b1a (.)
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> 4bec160e6 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
=======
>>>>>>> e7a9a2bf (.)
>>>>>>> d3a8af4d5 (.)
=======
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> 138485550 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> c22b35d1e (.)
=======
=======
>>>>>>> 80f054e0 (.)
>>>>>>> 8f2456941 (.)
=======
>>>>>>> f87b41c3b (.)
=======
=======
>>>>>>> 4d2eb53e (.)
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 998e6866b (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
>>>>>>> 23f115647 (.)
=======
>>>>>>> 138fcd4b0 (.)
=======
=======
>>>>>>> 6b6b9e41 (.)
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 36136dcfa (.)
=======
>>>>>>> a115e2aad (.)
=======
=======
>>>>>>> 3b4c9907 (.)
>>>>>>> db0bc148f (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 9cb55171f (.)
=======
=======
>>>>>>> 8e5817bc (.)
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> 731b801a8 (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 13655a7ed (.)
=======
=======
>>>>>>> cb85c538 (rebase 210)
>>>>>>> e0836b102 (.)
=======
>>>>>>> b85076e48 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 903e3e2cd (.)
=======
=======
>>>>>>> 460b8f5b (rebase 210)
>>>>>>> 47a873f13 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
=======
>>>>>>> 9fe1b60e (rebase 210)
>>>>>>> a0788fa28 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> ce1853afd (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 5d49e093a (.)
=======
=======
>>>>>>> 1375c94d (rebase 210)
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 17f6b8617 (.)
=======
=======
>>>>>>> 030c9674 (rebase 210)
>>>>>>> db6bec044 (.)
=======
>>>>>>> c31e900eb (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> fea359347 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
=======
>>>>>>> 77edd94a (.)
>>>>>>> 2e1ac1f20 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 2dab69c8a (.)
=======
=======
>>>>>>> f81a620f (.)
>>>>>>> e95dfc210 (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> 602b8a0a9 (.)
=======
>>>>>>> 763771402 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
=======
>>>>>>> 2fc60436 (.)
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
>>>>>>> a55aa5e96 (.)
