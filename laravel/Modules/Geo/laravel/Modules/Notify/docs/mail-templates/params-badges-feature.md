# Visualizzazione Parametri come Badge - Mail Templates

## Panoramica

Questa funzionalità permette di visualizzare i parametri dei template email come badge colorati nell'interfaccia Filament, migliorando l'usabilità e la comprensione dei parametri disponibili per ogni template.

## Caratteristiche Principali

### 1. Campo Parametri Editabile
- **Tipo**: Input di testo
- **Formato**: Parametri separati da virgola
- **Esempio**: `name, email, company, date, address`

### 2. Visualizzazione Badge
- **Posizione**: Subito dopo il campo HTML Template
- **Stile**: Badge blu con supporto modalità dark
- **Comportamento**: Visibili solo quando ci sono parametri definiti

### 3. Design Responsivo
- **Layout**: Flexbox con wrap automatico
- **Accessibilità**: Supporto screen reader
- **Temi**: Light e dark mode

## Implementazione Tecnica

### File Coinvolti

1. **MailTemplateResource.php**
   ```php
   'params_display' => Forms\Components\View::make('notify::filament.components.params-badges')
       ->viewData(fn ($record) => ['params' => $record?->params])
       ->columnSpanFull()
       ->visible(fn ($record): bool => !empty($record?->params)),

   'params' => Forms\Components\TextInput::make('params')
       ->label('Parametri')
       ->helperText('Inserisci i parametri separati da virgola (es: name, email, date)')
       ->placeholder('name, email, date, company')
       ->columnSpanFull(),
   ```

2. **params-badges.blade.php**
   ```blade
   @if(!empty($params))
       <div class="space-y-2">
           <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
               {{ __('notify::mail_template.sections.variables') }}
           </div>
           
           <div class="flex flex-wrap gap-2">
               @foreach(array_filter(array_map('trim', explode(',', $params))) as $param)
                   <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                              bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 
                              border border-blue-200 dark:border-blue-800">
                       {{ $param }}
                   </span>
               @endforeach
           </div>
           
           <div class="text-xs text-gray-500 dark:text-gray-400">
               {{ __('notify::mail_template.fields.variables.helper_text') }}
           </div>
       </div>
   @endif
   ```

### Database Schema

Il campo `params` è definito nella migrazione come:
```php
$table->string('params')->nullable();
```

## Utilizzo

### Per gli Sviluppatori

1. **Aggiungere Parametri**
   ```php
   $template = MailTemplate::create([
       'name' => 'Welcome Email',
       'mailable' => WelcomeEmail::class,
       'params' => 'user_name, email, registration_date, company_name'
   ]);
   ```

2. **Utilizzare nei Template**
   ```html
   <h1>Benvenuto {{ user_name }}!</h1>
   <p>La tua email {{ email }} è stata registrata il {{ registration_date }}.</p>
   <p>Benvenuto in {{ company_name }}!</p>
   ```

### Per gli Utenti Finali

1. Aprire un template email esistente o crearne uno nuovo
2. Nel campo "Parametri", inserire i nomi delle variabili separati da virgola
3. I badge appariranno automaticamente sotto il template HTML
4. Utilizzare i parametri nel template con la sintassi `{{ parameter_name }}`

## Esempi Pratici

### Template di Benvenuto
```
Parametri: user_name, email, activation_link
Badge: [user_name] [email] [activation_link]
```

### Template di Conferma Ordine
```
Parametri: customer_name, order_number, total_amount, delivery_date
Badge: [customer_name] [order_number] [total_amount] [delivery_date]
```

### Template di Reset Password
```
Parametri: user_name, reset_link, expiry_time
Badge: [user_name] [reset_link] [expiry_time]
```

## Benefici

1. **Visibilità Immediata**: I parametri sono chiaramente visibili
2. **Riduzione Errori**: Meno probabilità di utilizzare parametri sbagliati
3. **Documentazione Visiva**: I badge fungono da documentazione interattiva
4. **Coerenza UI**: Design integrato con Filament
5. **Usabilità**: Facilita la creazione e modifica dei template

## Best Practices

### Naming Conventions
- Utilizzare nomi descrittivi: `user_name` invece di `name`
- Mantenere consistenza: `user_email` e `user_phone`
- Evitare spazi: utilizzare `_` o `camelCase`

### Organizzazione
- Ordinare i parametri per logica: prima dati utente, poi dati ordine
- Limitare il numero di parametri per template (max 10-15)
- Documentare parametri complessi nei commenti

### Validazione
- Verificare che tutti i parametri nel campo siano utilizzati nel template
- Controllare che tutti i parametri nel template siano definiti nel campo
- Testare con dati reali per verificare la correttezza

## Troubleshooting

### Badge Non Visibili
- Verificare che il campo `params` non sia vuoto
- Controllare che la view `params-badges.blade.php` esista
- Verificare i permessi sui file di view

### Styling Problematico
- Assicurarsi che Tailwind CSS sia caricato
- Verificare la compatibilità con la versione di Filament
- Controllare eventuali override CSS custom

### Performance
- Con molti parametri, considerare la paginazione
- Ottimizzare la view per grandi quantità di badge
- Monitorare l'impatto sul caricamento delle pagine

## Collegamenti

- [Implementation Notes](./implementation_notes.md#visualizzazione-parametri-come-badge)
- [Mail Templates Index](./index.md)
- [Filament UI Enhancements](./filament_ui_enhancements.md)
- [Email Templates Guide](./email_templates_guide.md)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0  
**Compatibilità**: Filament 3.x, Laravel 10+ 