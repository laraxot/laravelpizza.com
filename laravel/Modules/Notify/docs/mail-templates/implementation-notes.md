# Note di Implementazione Email

## Errori Comuni e Soluzioni

### 1. Errore Destinatario Mancante
L'errore `Symfony\Component\Mime\Exception\LogicException: An email must have a "To", "Cc", or "Bcc" header` si verifica quando:

1. **Causa Principale**
   - Il destinatario non è specificato correttamente
   - Il valore del campo 'to' è null o vuoto
   - Il formato dell'email non è valido

2. **Verifica dei Dati**
   - Controllare che `$data['to']` sia presente
   - Verificare che non sia null
   - Assicurarsi che sia un indirizzo email valido

3. **Soluzione**
   - Validare l'input prima dell'invio
   - Verificare il formato dell'email
   - Assicurarsi che il destinatario sia specificato

## Implementazione Allegati Corretta

### Struttura Corretta
L'implementazione corretta degli allegati richiede una struttura specifica. Ecco le caratteristiche chiave:

1. **Formato Array di Array**
   ```php
   $attachments = [
       [
           'path' => 'public_html/images/avatars/default-3.svg',
           'path' => 'public_html/images/avatars/default-3.svg',
           'path' => 'public_html/images/avatars/default-3.svg',
           'as' => 'logo.png',
           'mime' => 'image/png'
       ],
       [
           'path' => 'public_html/images/avatars/default-3.svg',
           'path' => 'public_html/images/avatars/default-3.svg',
           'path' => 'public_html/images/avatars/default-3.svg',
           'as' => 'logo.png',
           'mime' => 'image/png'
       ]
   ];
   ```

2. **Percorsi**
   - Supporto per percorsi assoluti e relativi
   - Verifica dell'accessibilità dei file
   - Gestione dei permessi

### Differenze con la Documentazione Precedente

1. **Struttura Array**
   - La documentazione precedente suggeriva un singolo array
   - L'implementazione corretta richiede un array di array
   - Ogni allegato deve essere un array separato

2. **Gestione dei Percorsi**
   - Supporto per percorsi assoluti
   - Verifica dell'accessibilità
   - Gestione dei permessi

3. **Integrazione con SpatieEmail**
   ```php
   // Creare l'istanza dell'email
   $email = new SpatieEmail($user, 'due');

   // Aggiungere gli allegati
   $email->addAttachments($attachments);

   // Inviare l'email
   Mail::to($data['to'])
       ->locale('it')
       ->send($email);
   ```

### Best Practices Verificate

1. **Organizzazione File**
   - Verificare l'accessibilità dei file
   - Gestire i permessi correttamente
   - Utilizzare percorsi coerenti

2. **Gestione MIME Types**
   - Specificare sempre il MIME type corretto
   - Verificare la compatibilità
   - Documentare i tipi supportati

3. **Performance**
   - Ottimizzare le dimensioni dei file
   - Considerare l'impatto sulla velocità
   - Monitorare l'uso della memoria

### Note di Miglioramento

1. **Documentazione**
   - Aggiornare la documentazione esistente
   - Rimuovere le informazioni non corrette
   - Aggiungere esempi funzionanti

2. **Testing**
   - Verificare con diversi tipi di file
   - Testare in vari client email
   - Validare la compatibilità

3. **Manutenzione**
   - Monitorare le performance
   - Aggiornare i MIME types
   - Verificare la compatibilità

## Conclusioni

L'implementazione corretta dimostra che:
1. La struttura array di array è necessaria
2. I percorsi devono essere verificati
3. L'integrazione con SpatieEmail richiede passaggi specifici
4. La documentazione deve essere precisa
5. La validazione del destinatario è fondamentale

## Prossimi Passi

1. **Documentazione**
   - Aggiornare `ATTACHMENTS.md`
   - Revisionare `TROUBLESHOOTING.md`
   - Aggiungere esempi reali

2. **Testing**
   - Espandere i test
   - Verificare edge cases
   - Documentare i risultati

3. **Miglioramenti**
   - Considerare la validazione
   - Implementare logging
   - Aggiungere monitoraggio

## Visualizzazione Parametri come Badge

### Implementazione
È stata aggiunta una funzionalità per visualizzare i parametri del template email come badge colorati nell'interfaccia Filament.

#### Caratteristiche
1. **Campo Params**: Campo di input testuale che accetta parametri separati da virgola
2. **Visualizzazione Badge**: I parametri vengono mostrati come badge blu sotto il campo HTML template
3. **Visibilità Condizionale**: I badge appaiono solo quando ci sono parametri definiti
4. **Design Responsive**: I badge si adattano al layout e supportano la modalità dark

#### Struttura Implementata

```php
// Nel MailTemplateResource.php
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

#### View Component
- **File**: `resources/views/filament/components/params-badges.blade.php`
- **Logica**: Divide la stringa params per virgola e crea badge per ogni parametro
- **Stile**: Utilizza classi Tailwind coerenti con il design Filament

#### Benefici
1. **Visualizzazione Chiara**: I parametri sono immediatamente visibili come badge colorati
2. **Usabilità**: Gli utenti possono vedere rapidamente quali variabili sono disponibili
3. **Consistenza**: Design coerente con l'interfaccia Filament
4. **Accessibilità**: Supporto per modalità dark e screen reader

#### Utilizzo
1. Modificare un template email esistente
2. Inserire parametri nel campo "Parametri" separati da virgola
3. I badge appaiono automaticamente sotto il template HTML
4. I parametri possono essere utilizzati nel template con la sintassi `{{parameter_name}}`

#### Esempi
```
Input: "name, email, company, date"
Output: [name] [email] [company] [date] (come badge blu)
```
# Note di Implementazione Email

## Errori Comuni e Soluzioni

### 1. Errore Destinatario Mancante
L'errore `Symfony\Component\Mime\Exception\LogicException: An email must have a "To", "Cc", or "Bcc" header` si verifica quando:

1. **Causa Principale**
   - Il destinatario non è specificato correttamente
   - Il valore del campo 'to' è null o vuoto
   - Il formato dell'email non è valido

2. **Verifica dei Dati**
   - Controllare che `$data['to']` sia presente
   - Verificare che non sia null
   - Assicurarsi che sia un indirizzo email valido

3. **Soluzione**
   - Validare l'input prima dell'invio
   - Verificare il formato dell'email
   - Assicurarsi che il destinatario sia specificato

## Implementazione Allegati Corretta

### Struttura Corretta
L'implementazione corretta degli allegati richiede una struttura specifica. Ecco le caratteristiche chiave:

1. **Formato Array di Array**
   ```php
   $attachments = [
       [
           'path' => 'public_html/images/avatars/default-3.svg',
           'as' => 'logo.png',
           'mime' => 'image/png'
       ],
       [
           'path' => 'public_html/images/avatars/default-3.svg',
           'as' => 'logo.png',
           'mime' => 'image/png'
       ]
   ];
   ```

2. **Percorsi**
   - Supporto per percorsi assoluti e relativi
   - Verifica dell'accessibilità dei file
   - Gestione dei permessi

### Differenze con la Documentazione Precedente

1. **Struttura Array**
   - La documentazione precedente suggeriva un singolo array
   - L'implementazione corretta richiede un array di array
   - Ogni allegato deve essere un array separato

2. **Gestione dei Percorsi**
   - Supporto per percorsi assoluti
   - Verifica dell'accessibilità
   - Gestione dei permessi

3. **Integrazione con SpatieEmail**
   ```php
   // Creare l'istanza dell'email
   $email = new SpatieEmail($user, 'due');

   // Aggiungere gli allegati
   $email->addAttachments($attachments);

   // Inviare l'email
   Mail::to($data['to'])
       ->locale('it')
       ->send($email);
   ```

### Best Practices Verificate

1. **Organizzazione File**
   - Verificare l'accessibilità dei file
   - Gestire i permessi correttamente
   - Utilizzare percorsi coerenti

2. **Gestione MIME Types**
   - Specificare sempre il MIME type corretto
   - Verificare la compatibilità
   - Documentare i tipi supportati

3. **Performance**
   - Ottimizzare le dimensioni dei file
   - Considerare l'impatto sulla velocità
   - Monitorare l'uso della memoria

### Note di Miglioramento

1. **Documentazione**
   - Aggiornare la documentazione esistente
   - Rimuovere le informazioni non corrette
   - Aggiungere esempi funzionanti

2. **Testing**
   - Verificare con diversi tipi di file
   - Testare in vari client email
   - Validare la compatibilità

3. **Manutenzione**
   - Monitorare le performance
   - Aggiornare i MIME types
   - Verificare la compatibilità

## Conclusioni

L'implementazione corretta dimostra che:
1. La struttura array di array è necessaria
2. I percorsi devono essere verificati
3. L'integrazione con SpatieEmail richiede passaggi specifici
4. La documentazione deve essere precisa
5. La validazione del destinatario è fondamentale

## Prossimi Passi

1. **Documentazione**
   - Aggiornare `ATTACHMENTS.md`
   - Revisionare `TROUBLESHOOTING.md`
   - Aggiungere esempi reali

2. **Testing**
   - Espandere i test
   - Verificare edge cases
   - Documentare i risultati

3. **Miglioramenti**
   - Considerare la validazione
   - Implementare logging
   - Aggiungere monitoraggio

## Visualizzazione Parametri come Badge

### Implementazione
È stata aggiunta una funzionalità per visualizzare i parametri del template email come badge colorati nell'interfaccia Filament.

#### Caratteristiche
1. **Campo Params**: Campo di input testuale che accetta parametri separati da virgola
2. **Visualizzazione Badge**: I parametri vengono mostrati come badge blu sotto il campo HTML template
3. **Visibilità Condizionale**: I badge appaiono solo quando ci sono parametri definiti
4. **Design Responsive**: I badge si adattano al layout e supportano la modalità dark

#### Struttura Implementata

```php
// Nel MailTemplateResource.php
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

#### View Component
- **File**: `resources/views/filament/components/params-badges.blade.php`
- **Logica**: Divide la stringa params per virgola e crea badge per ogni parametro
- **Stile**: Utilizza classi Tailwind coerenti con il design Filament

#### Benefici
1. **Visualizzazione Chiara**: I parametri sono immediatamente visibili come badge colorati
2. **Usabilità**: Gli utenti possono vedere rapidamente quali variabili sono disponibili
3. **Consistenza**: Design coerente con l'interfaccia Filament
4. **Accessibilità**: Supporto per modalità dark e screen reader

#### Utilizzo
1. Modificare un template email esistente
2. Inserire parametri nel campo "Parametri" separati da virgola
3. I badge appaiono automaticamente sotto il template HTML
4. I parametri possono essere utilizzati nel template con la sintassi `{{parameter_name}}`

#### Esempi
```
Input: "name, email, company, date"
Output: [name] [email] [company] [date] (come badge blu)
```
