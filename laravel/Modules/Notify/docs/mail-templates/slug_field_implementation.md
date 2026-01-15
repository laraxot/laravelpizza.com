# Implementazione del Campo `slug` in MailTemplate

## Introduzione

Il campo `slug` nella tabella `mail_templates` è un elemento fondamentale per l'identificazione e il recupero efficiente dei template email. Questo documento spiega l'implementazione tecnica del campo, i suoi vantaggi e le best practice per utilizzarlo.

## Definizione nella Migrazione

Il campo `slug` è implementato nella migrazione principale `2018_10_10_000002_create_mail_templates_table.php` secondo il pattern di `XotBaseMigration`:

```php
// Nella sezione tableCreate
$table->string('slug')->unique();

// Nella sezione tableUpdate
if (!$this->hasColumn('slug')) {
    $table->string('slug')->unique()->after('mailable');
}
```

Questa implementazione assicura che:
1. Le nuove installazioni abbiano il campo `slug` fin dall'inizio
2. Le installazioni esistenti ottengano il campo durante l'aggiornamento
3. Il campo sia sempre un indice univoco per garantire identificatori unici

## Vantaggi del Campo `slug`

1. **Identificatori Leggibili dall'Uomo**
   - Gli slug sono più facili da leggere e ricordare rispetto agli ID numerici
   - Esempio: `welcome-email` vs `42`

2. **URL e Routing Amichevoli**
   - Permette URL descrittivi come `/admin/mail-templates/welcome-email`
   - Migliora l'esperienza utente e la SEO

3. **Stabilità nei Riferimenti**
   - I riferimenti basati su slug sono più stabili nel tempo
   - I template possono essere trasferiti tra installazioni mantenendo lo stesso identificatore

4. **Recupero Semplificato in Codice**
   - Permette pattern di codice più leggibili e intuitivi
   - Esempio: `MailTemplate::findBySlug('welcome-email')` vs `MailTemplate::find(42)`

## Implementazione nel Modello MailTemplate

Il modello `MailTemplate` deve includere il campo `slug` tra i campi compilabili:

```php
protected $fillable = [
    'name',
    'slug',
    'mailable',
    'subject',
    'html_template',
    'text_template',
    'version',
];
```

### Metodi Utility Raccomandati

Per facilitare l'uso degli slug, si raccomanda di implementare questi metodi nel modello:

```php
/**
 * Trova un template per slug.
 *
 * @param string $slug
 * @return static|null
 */
public static function findBySlug(string $slug): ?static
{
    return static::where('slug', $slug)->first();
}

/**
 * Trova un template per slug o lancia un'eccezione se non trovato.
 *
 * @param string $slug
 * @return static
 * @throws ModelNotFoundException
 */
public static function findBySlugOrFail(string $slug): static
{
    return static::where('slug', $slug)->firstOrFail();
}
```

## Utilizzo nella Filament UI

Nel Resource Filament, il campo `slug` dovrebbe essere implementato con:

```php
public static function getFormSchema(): array
{
    return [
        'name' => Forms\Components\TextInput::make('name')
            ->required(),
            
        'slug' => Forms\Components\TextInput::make('slug')
            ->required()
            ->unique(ignoreRecord: true)
            ->afterStateUpdated(fn (string $context, $state, callable $set) => 
                $context === 'create' ? $set('slug', Str::slug($state)) : null),
            
        // Altri campi...
    ];
}
```

## Esempi di Utilizzo nel Codice

### Invio di Email Specifiche

```php
// Utilizzo mediante slug (raccomandato)
$template = MailTemplate::findBySlug('welcome-email');

// Oppure con controllo più esplicito
if ($template = MailTemplate::where('slug', 'welcome-email')->first()) {
    Mail::to($user)->send(new SpatieEmail($template, [
        'userName' => $user->name,
        // altri dati
    ]));
}
```

### Implementazione di Notifiche Predefinite

```php
// In un seeder o provider di servizi
public function registerDefaultTemplates()
{
    MailTemplate::updateOrCreate(
        ['slug' => 'welcome-email'],
        [
            'name' => 'Email di Benvenuto',
            'mailable' => 'WelcomeEmail',
            'subject' => json_encode(['it' => 'Benvenuto!', 'en' => 'Welcome!']),
            'html_template' => json_encode(['it' => '<p>Benvenuto nel sistema</p>', 'en' => '<p>Welcome to the system</p>']),
        ]
    );
    
    // Altri template predefiniti...
}
```

## Best Practices

1. **Sempre utilizzare slug leggibili**
   - Utilizzare parole separate da trattini (`welcome-email`, `password-reset`)
   - Evitare caratteri speciali o spazi
   - Mantenere gli slug brevi ma descrittivi

2. **Generazione automatica di slug**
   - In fase di creazione, generare automaticamente lo slug dal nome
   - Permettere la modifica manuale per casi speciali

3. **Utilizzo nei test automatizzati**
   - Gli slug facilitano l'identificazione dei template nei test
   - Contribuiscono a rendere i test più leggibili e manutenibili

## Conclusione

L'implementazione del campo `slug` nella tabella `mail_templates` segue le migliori pratiche del progetto e offre numerosi vantaggi in termini di usabilità, manutenibilità e flessibilità. La sua inclusione nella migrazione originale seguendo il pattern `XotBaseMigration` assicura coerenza con le convenzioni del progetto.

## Riferimenti

- [Migration Structure](./MIGRATION_STRUCTURE.md)
- [Email Templates](../EMAIL_TEMPLATES.md)
- [Spatie Email Usage Guide](../SPATIE_EMAIL_USAGE_GUIDE.md)
