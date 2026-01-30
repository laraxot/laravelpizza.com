# Missing Mail Template - Pattern e Prevenzione Globale

## Panoramica

L'errore "MissingMailTemplate" si verifica nel sistema Spatie Mail Templates quando viene richiesto un template email che non esiste nel database. Questo documento raccoglie pattern comuni e strategie di prevenzione globali per tutti i moduli.

## 🚨 Caso Critico Identificato: <nome progetto> Patient Registration

**Data**: 26 Giugno 2025  
**Impatto**: Sistema registrazione pazienti completamente bloccato  

➡️ **Documentazione completa**: [<nome progetto>: Missing Mail Template Error](../laravel/Modules/<nome progetto>/docs/errori/missing-mail-template-spatiemail.md)

### Problema Specifico
Conflitto nel sistema di template dinamici:
- Template generati dinamicamente tramite slug
- `firstOrCreate` in constructor SpatieEmail fallisce
- Package Spatie cerca template con slug vuoto
- Notifiche di sistema bloccate

## Pattern Comuni dell'Errore

### 1. **Template Dinamici Non Esistenti**
```php
// ❌ PROBLEMA: Slug generato dinamicamente senza validazione
$mail_slug = Str::slug($data['type'].'-'.$data['state']);
Notification::route('mail', $email)->notify(new RecordNotification($record, $mail_slug));
```

**Cause**:
- Slug vuoti o null non gestiti
- Template non pre-creati per tutti i casi possibili
- Race condition nel `firstOrCreate`

### 2. **Mancata Configurazione del TemplateModel**
```php
// ❌ PROBLEMA: Model class non configurato correttamente
class CustomEmail extends TemplateMailable
{
    // Missing: protected static $templateModelClass = MailTemplate::class;
}
```

### 3. **Errori di Database Connection**
```php
// ❌ PROBLEMA: Connection cross-database non gestita
class MailTemplate extends SpatieMailTemplate
{
    protected $connection = 'notify'; // Può causare problemi
}
```

### 4. **Slug Lookup Fallito**
```php
// ❌ PROBLEMA: Lookup per slug restituisce null
$template = MailTemplate::findForMailable($mailable);
// Template non trovato, eccezione lanciata
```

## Strategie di Prevenzione Globali

### 1. **Pre-creazione Template Critici**

Utilizzare seeder per garantire template essenziali:

```php
// Database/Seeders/CriticalMailTemplatesSeeder.php
class CriticalMailTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        $criticalTemplates = [
            'user-registration-pending',
            'user-registration-approved', 
            'user-registration-rejected',
            'password-reset-request',
            'account-activation',
            'system-notification'
        ];

        foreach ($criticalTemplates as $slug) {
            MailTemplate::updateOrCreate([
                'mailable' => 'Modules\Notify\Emails\SpatieEmail',
                'slug' => $slug,
            ], [
                'subject' => json_encode(['it' => 'Notifica da Sistema']),
                'html_template' => json_encode(['it' => '<p>Notifica dal sistema.</p>']),
                'text_template' => json_encode(['it' => 'Notifica dal sistema.'])
            ]);
        }
    }
}
```

### 2. **Validazione Slug Robusta**

```php
trait HasMailTemplateValidation
{
    protected function ensureTemplateExists(string $slug): void
    {
        if (empty($slug)) {
            throw new InvalidArgumentException('Template slug cannot be empty');
        }

        $exists = MailTemplate::where('mailable', static::class)
            ->where('slug', $slug)
            ->exists();
            
        if (!$exists) {
            $this->createFallbackTemplate($slug);
        }
    }
    
    protected function createFallbackTemplate(string $slug): void
    {
        MailTemplate::create([
            'mailable' => static::class,
            'slug' => $slug,
            'subject' => json_encode(['it' => 'Notifica da Sistema']),
            'html_template' => json_encode(['it' => '<p>Notifica automatica.</p>']),
            'text_template' => json_encode(['it' => 'Notifica automatica.'])
        ]);
        
        Log::warning("Created fallback mail template for slug: {$slug}");
    }
}
```

### 3. **Mailable Base Robusta**

```php
abstract class BaseTemplateMailable extends TemplateMailable
{
    use HasMailTemplateValidation;
    
    protected static $templateModelClass = MailTemplate::class;
    protected string $templateSlug;
    
    public function __construct(Model $record, string $slug)
    {
        $this->templateSlug = $this->sanitizeSlug($slug);
        $this->ensureTemplateExists($this->templateSlug);
        
        $data = $record->toArray();
        $this->setAdditionalData($data);
    }
    
    protected function sanitizeSlug(string $slug): string
    {
        $sanitized = Str::slug($slug);
        
        if (empty($sanitized)) {
            return 'default-notification';
        }
        
        return $sanitized;
    }
    
    public function getTemplateSlug(): string
    {
        return $this->templateSlug;
    }
}
```

### 4. **Monitoring e Alerting**

```php
// Console/Commands/CheckMailTemplates.php
class CheckMailTemplates extends Command
{
    protected $signature = 'mail:check-templates {--fix : Create missing templates}';
    
    public function handle()
    {
        $requiredTemplates = config('mail.required_templates', []);
        $missing = [];
        
        foreach ($requiredTemplates as $slug) {
            if (!MailTemplate::where('slug', $slug)->exists()) {
                $missing[] = $slug;
            }
        }
        
        if (!empty($missing)) {
            $this->error('Missing mail templates: ' . implode(', ', $missing));
            
            if ($this->option('fix')) {
                $this->createMissingTemplates($missing);
                $this->info('Created missing templates');
            }
            
            return 1;
        }
        
        $this->info('All required mail templates exist');
        return 0;
    }
}
```

### 5. **Configuration Centralized**

```php
// config/mail_templates.php
return [
    'required_templates' => [
        'user-registration-pending',
        'user-registration-approved',
        'password-reset-request',
        'account-activation',
        'system-notification',
        'error-notification'
    ],
    
    'default_content' => [
        'subject' => [
            'it' => 'Notifica da {{app_name}}',
            'en' => 'Notification from {{app_name}}'
        ],
        'html_template' => [
            'it' => '<p>Gentile {{first_name}},</p><p>Notifica dal sistema.</p>',
            'en' => '<p>Dear {{first_name}},</p><p>System notification.</p>'
        ],
        'text_template' => [
            'it' => 'Notifica dal sistema.',
            'en' => 'System notification.'
        ]
    ],
    
    'fallback_template' => 'system-notification'
];
```

## Best Practice per Moduli

### 1. **Seeder Dedicati**
Ogni modulo dovrebbe avere un seeder per i propri template:

```bash
php artisan make:seeder UserModuleMailTemplatesSeeder
php artisan make:seeder NotifyModuleMailTemplatesSeeder
php artisan make:seeder <nome progetto>ModuleMailTemplatesSeeder
```

### 2. **Test Automatizzati**
```php
class MailTemplateTest extends TestCase
{
    /** @test */
    public function required_mail_templates_exist()
    {
        $required = config('mail_templates.required_templates');
        
        foreach ($required as $slug) {
            $this->assertDatabaseHas('mail_templates', [
                'slug' => $slug,
                'mailable' => 'Modules\Notify\Emails\SpatieEmail'
            ]);
        }
    }
    
    /** @test */
    public function mail_can_be_sent_with_all_templates()
    {
        Mail::fake();
        
        $user = User::factory()->create();
        $required = config('mail_templates.required_templates');
        
        foreach ($required as $slug) {
            Mail::to($user->email)->send(new SpatieEmail($user, $slug));
            Mail::assertSent(SpatieEmail::class);
        }
    }
}
```

### 3. **Healthcheck Endpoints**
```php
Route::get('/health/mail-templates', function () {
    $required = config('mail_templates.required_templates');
    $missing = [];
    
    foreach ($required as $slug) {
        if (!MailTemplate::where('slug', $slug)->exists()) {
            $missing[] = $slug;
        }
    }
    
    return response()->json([
        'status' => empty($missing) ? 'ok' : 'error',
        'missing_templates' => $missing,
        'timestamp' => now()
    ], empty($missing) ? 200 : 500);
});
```

## Checklist di Prevenzione

### Per Sviluppatori
- [ ] Validare slug prima dell'uso
- [ ] Utilizzare try-catch per creazione template
- [ ] Implementare fallback per template mancanti
- [ ] Loggare creazioni di template automatiche
- [ ] Utilizzare mailable base robusti

### Per DevOps
- [ ] Monitorare endpoint /health/mail-templates
- [ ] Eseguire check template in CI/CD
- [ ] Alert su template mancanti in produzione
- [ ] Backup regolari della tabella mail_templates

### Per Testing
- [ ] Test per tutti i template richiesti
- [ ] Test di invio email per ogni template
- [ ] Test di fallback per template mancanti
- [ ] Test di performance per creazione template

## Comandi Utili per Debug

```bash

# Verifica template esistenti
php artisan tinker -c "MailTemplate::where('mailable', 'like', '%SpatieEmail%')->get(['id', 'slug', 'subject'])"

# Check salute template
php artisan mail:check-templates

# Crea template mancanti
php artisan mail:check-templates --fix

# Reseed template critici
php artisan db:seed --class=CriticalMailTemplatesSeeder

# Test invio email
php artisan tinker -c "Mail::to('test@example.com')->send(new \Modules\Notify\Emails\SpatieEmail(User::first(), 'test-slug'))"
```

## Riferimenti e Collegamenti

### **Documentazione Moduli**
- [<nome progetto>: Missing Mail Template](../laravel/Modules/<nome progetto>/docs/errori/missing-mail-template-spatiemail.md) - Caso specifico critico
- [Notify: Email Templates](../laravel/Modules/Notify/docs/email_templates.md) - Documentazione sistema template
- [Notify: Spatie Email Usage](../laravel/Modules/Notify/docs/spatie_email_usage_guide.md) - Guida all'uso

### **Pattern Correlati**
- [Array to String Conversion](./array-to-string-conversion-patterns.md) - Pattern errore correlato
- [Database Connection Issues](./database-connection-patterns.md) - Problemi di connessione

### **Documentazione Esterna**
- [Spatie Mail Templates](https://github.com/spatie/laravel-database-mail-templates) - Package documentation
- [Laravel Notifications](https://laravel.com/docs/notifications) - Documentazione ufficiale Laravel

---

**Ultimo aggiornamento**: 26 Giugno 2025  
**Contributori**: AI Assistant  
**Review Status**: Pending Technical Review  
