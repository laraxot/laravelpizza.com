# Proposta: Implementazione Campo Slug nei Template Email

## Collegamenti correlati

- [README del modulo Notify](./README.md)
- [Guida all'utilizzo di SpatieEmail](./SPATIE_EMAIL_USAGE_GUIDE.md)
- [Documentazione Template Email](./EMAIL_TEMPLATES.md)
- [Documentazione Root](../../../../docs/collegamenti-documentazione.md)

## Panoramica

Questa proposta riguarda l'implementazione completa del campo `slug` nei template email del modulo Notify. L'obiettivo è migliorare la flessibilità e la manutenibilità del sistema di template email.

## Stato attuale

Attualmente, il sistema di template email identifica i template utilizzando la classe Mailable specificata nel campo `mailable`. Questo approccio presenta alcune limitazioni:

1. Le modifiche al namespace delle classi Mailable possono invalidare i riferimenti ai template
2. Non è possibile avere template multipli per la stessa classe Mailable
3. Il campo `mailable` è una stringa che rappresenta un nome di classe, che è difficile da gestire per gli amministratori

Il campo `slug` è già presente nei campi `$fillable` del modello `MailTemplate`, ma:
- Non è definito nella migrazione del database
- Non è utilizzato attivamente nel sistema
- Non è implementato nella classe `SpatieEmail`

## Implementazione proposta

### 1. Migrazione per aggiungere il campo slug

Creare una nuova migrazione per aggiungere il campo `slug` alla tabella `mail_templates`:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class () extends XotBaseMigration {
    public function up(): void
    {
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (!$this->hasColumn('slug')) {
                    $table->string('slug')->nullable()->after('mailable');
                    $table->index('slug');
                }
            }
        );
    }
};
```

### 2. Aggiornamento del modello MailTemplate

Il modello `MailTemplate` già include `slug` nei campi `$fillable`, ma dovremmo aggiungere funzionalità per:

1. Garantire l'unicità dello slug
2. Generare automaticamente uno slug se non fornito
3. Fornire metodi per recuperare template tramite slug

```php
/**
 * Trova un template per slug.
 *
 * @param string $slug Lo slug del template
 * @return self|null Il template trovato o null
 */
public static function findBySlug(string $slug): ?self
{
    return static::where('slug', $slug)->first();
}

/**
 * Imposta lo slug quando non esiste.
 *
 * @return void
 */
protected static function bootHasSlug(): void
{
    static::creating(function ($model): void {
        if (empty($model->slug) && !empty($model->mailable)) {
            // Genera uno slug dal nome della classe Mailable
            $mailableClass = class_basename($model->mailable);
            $model->slug = Str::slug($mailableClass);
        }
    });
}
```

### 3. Aggiornamento della classe SpatieEmail

Modificare la classe `SpatieEmail` per supportare l'identificazione dei template tramite slug:

```php
class SpatieEmail extends TemplateMailable
{
    protected static $templateModelClass = MailTemplate::class;
    protected static ?string $templateSlug = null;

    public function __construct(Model $record, ?string $templateSlug = null)
    {
        $data = $record->toArray();
        $this->setAdditionalData($data);
        
        if ($templateSlug !== null) {
            static::$templateSlug = $templateSlug;
        }
    }
    
    // Override del metodo per recuperare il template dal database
    public function getHtmlTemplate(): string
    {
        if (static::$templateSlug !== null) {
            $mailTemplate = MailTemplate::findBySlug(static::$templateSlug);
            
            if ($mailTemplate) {
                return $mailTemplate->html_template;
            }
        }
        
        return parent::getHtmlTemplate();
    }
    
    // Altri metodi da override per supportare lo slug...
}
```

## Vantaggi

1. **Maggiore flessibilità**: Possibilità di avere template multipli per la stessa classe Mailable
2. **Identificazione più semplice**: Gli slug sono più leggibili e gestibili rispetto ai nomi di classe completi
3. **Resilienza ai cambiamenti**: Modifiche al namespace delle classi non invalidano i riferimenti ai template
4. **Miglior gestione multilingua**: Possibilità di avere template specifici per una particolare lingua
5. **Maggiore sicurezza**: Meno dipendenza da nomi di classe hardcoded
6. **Migliore UX amministrativa**: Gli slug sono più facili da gestire per gli amministratori
7. **Test facilitati**: Possibilità di creare template di test con slug specifici

## Svantaggi

1. **Complessità aggiuntiva**: L'implementazione richiede nuovi concetti e codice
2. **Compatibilità con versioni precedenti**: Da gestire attentamente per non rompere le funzionalità esistenti
3. **Rischi di collisione**: Gli slug potrebbero collidere se non gestiti correttamente
4. **Overhead di gestione**: Richiede un livello aggiuntivo di gestione dei template

## Esempi di utilizzo

### Utilizzo basato su slug

```php
// Creazione di un template con slug
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'doctor-registration',
    'subject' => [
        'it' => 'Completa la tua registrazione, Dottor {{ last_name }}',
        'en' => 'Complete your registration, Dr. {{ last_name }}'
    ],
    'html_template' => [
        'it' => '<p>Gentile Dottor {{ last_name }},</p><p>La invitiamo a completare la sua registrazione...</p>',
        'en' => '<p>Dear Dr. {{ last_name }},</p><p>We invite you to complete your registration...</p>'
    ]
]);

// Invio email utilizzando lo slug
$doctor = Doctor::find(1);
Mail::to($doctor->email)
    ->locale(LaravelLocalization::getCurrentLocale())
    ->send(new SpatieEmail($doctor, 'doctor-registration'));
```

### Utilizzo di template multipli per la stessa Mailable

```php
// Template per notifica di appuntamento confermato
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'appointment-confirmed',
    'subject' => ['it' => 'Appuntamento confermato']
    // ...
]);

// Template per notifica di appuntamento cancellato
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'slug' => 'appointment-cancelled',
    'subject' => ['it' => 'Appuntamento cancellato']
    // ...
]);

// Utilizzo dei diversi template con la stessa classe Mailable
Mail::to($user->email)->send(new SpatieEmail($appointment, 'appointment-confirmed'));
Mail::to($user->email)->send(new SpatieEmail($appointment, 'appointment-cancelled'));
```

## Implementazione raccomandata

Si raccomanda un approccio graduale:

1. Aggiungere il campo `slug` mantenendo la compatibilità con l'identificazione via `mailable`
2. Generare automaticamente uno slug per i template esistenti
3. Aggiornare la documentazione e gli esempi
4. Incoraggiare l'uso degli slug nei nuovi template

## Conclusione

L'implementazione del campo `slug` nei template email rappresenta un miglioramento significativo in termini di flessibilità e manutenibilità. Nonostante l'aumento di complessità, i vantaggi in termini di resilienza ai cambiamenti e usabilità giustificano ampiamente questa evoluzione.
