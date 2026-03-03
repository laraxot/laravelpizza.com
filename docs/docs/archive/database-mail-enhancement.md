# Database Mail Enhancement (Open Source)

Questo documento descrive un approccio in-house per la gestione e l'invio di email da database, ispirato al plugin a pagamento `martin-petricko-database-mail` per Filament e alle soluzioni open source di Spatie.

## Analisi del plugin commerciale

- **martin-petricko-database-mail** fornisce UI Filament per definire template email nel DB
- Supporto per variabili dinamiche, anteprima, versioning
- Integrazione con invio mail, ma è un pacchetto a pagamento

## Obiettivi della nostra versione

1. Gestire template email nel DB con interfaccia Filament
2. Utilizzare soluzioni gratuite e open source
3. Supportare variabili dinamiche, anteprima, versioning
4. Invio tramite queue e log delle attività
5. Facile estensione e manutenzione

## Pacchetti Open Source

- **spatie/laravel-database-mail-templates**: gestione template in DB, parsing markdown
- **spatie/laravel-mailcoach-mailer**: invio massivo e transazionale con Mailcoach
- **spatie/laravel-queueable-action**: action queueable per logica di invio
- **spatie/laravel-model-states**: gestione stato dei messaggi (draft, sent, failed)

## Architettura proposta

1. **Database**: tabella `email_templates` (id, name, subject, body, variables)
2. **Modello**: `EmailTemplate` casted con ModelStates per `status`
3. **Filament Resource**: gestione CRUD di template con anteprima live (MarkdownEditor)
4. **Action**: `SendEmailTemplateAction` queueable che:
   - carica il template
   - sostituisce variabili dinamiche
   - invia con Mailable o MailcoachMailer
   - aggiorna stato e log
5. **Job / Queue**: invio asincrono, retry, fallback su failure
6. **Log**: tabella `email_logs` con destinatario, stato, template_id, errori

## Implementazione in sintesi

```php
// 1. Migrazione template
table->create('email_templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('subject');
    $table->text('body');
    $table->json('variables')->nullable();
    $table->timestamps();
});

// 2. Model con ModelStates
class EmailTemplate extends Model {
    use HasStates;
    protected $casts = ['status' => EmailStatus::class];
}

// 3. Filament Resource
class EmailTemplateResource extends XotBaseResource {
    public static function form(Form $form): Form {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('subject')->required(),
            MarkdownEditor::make('body')->required(),
            KeyValue::make('variables'),
        ]);
    }
}

// 4. Action queueable
testable class SendEmailTemplateAction {
    use QueueableAction;
    public function execute(EmailTemplate $template, string $to, array $data = []): void {
        $content = $this->render($template->body, $data);
        Mail::to($to)->send(new GenericHtmlMail($template->subject, $content));
        $template->status->transitionTo(Sent::class);
    }
}
```

## Vantaggi

- Nessun costo licence
- Elevata personalizzazione e integrazione con Spatie
- Testabilità e scalabilità
- Allineato alle convenzioni di progetto

---

**Collegamenti**:

- [martin-petricko Database Mail](https://filamentphp.com/plugins/martin-petricko-database-mail)
- [spatie/laravel-database-mail-templates](https://github.com/spatie/laravel-database-mail-templates)
- [spatie/laravel-mailcoach-mailer](https://github.com/spatie/laravel-mailcoach-mailer)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
