# Storage delle Traduzioni: PHP vs JSON

## Introduzione
In Laravel puoi salvare le traduzioni in file PHP strutturati o in file JSON flat. Ogni approccio ha vantaggi, svantaggi e impatti diversi su fallback, gestione team e manutenzione.

## Confronto tra PHP e JSON

| Caratteristica         | PHP Files                        | JSON Files                      |
|-----------------------|----------------------------------|---------------------------------|
| **Struttura**         | Annidata, multi-livello          | Flat, chiave = frase            |
| **Contesto**          | Sì (chiavi strutturate)          | No (tutto in un file)           |
| **Commenti**          | Sì                               | No                              |
| **Fallback**          | Sì (usa fallback_locale)         | No (mostra la chiave)           |
| **Per traduttori**    | Più difficile, serve contesto    | Più facile, chiavi leggibili    |
| **Per dev**           | Più flessibile, DRY              | Più semplice, meno controllo    |
| **Consistenza**       | Più facile con chiavi            | Rischio duplicati/frasi simili  |
| **Uso consigliato**   | UI, errori, messaggi brevi       | Frasi lunghe, onboarding, email |

## Best Practice per 
- **Usa file PHP** per UI, errori, messaggi brevi, validazione, notifiche.
- **Usa JSON** solo per frasi lunghe o onboarding, se serve collaborazione con traduttori non-dev.
- **Non mischiare** chiavi tra PHP e JSON con lo stesso nome.
- **Fallback:** solo i file PHP supportano il fallback_locale. I JSON mostrano la chiave se manca la traduzione.
- **Mantieni la coerenza**: scegli uno stile e seguilo in tutto il progetto.

## Esempi

### PHP
/lang/en/auth.php
```php
return [
    'register' => [
        'name' => 'Name',
        'email' => 'Email',
    ],
    'login' => [
        'login' => 'Login',
    ],
];
```

Uso:
```blade
{{ __('auth.register.name') }}
```

### JSON
/lang/en.json
```json
{
  "Register to Join our Community": "Sign up to join our community"
}
```

Uso:
```blade
{{ __('Register to Join our Community') }}
```

## Raccomandazioni
- Per , **PHP è la scelta principale**. JSON solo per casi particolari.
- Documenta sempre la scelta e spiega ai traduttori/dev come aggiungere nuove stringhe.
- Per fallback, imposta sempre `fallback_locale` in `config/app.php`.
- Per traduzioni lunghe, valuta se usare chiavi dedicate in PHP o, solo se necessario, JSON.

## Fonti
- [Laravel Daily: Store in PHP or JSON?](https://laraveldaily.com/lesson/multi-language-laravel/mcamara-laravel-localization)
- [Laravel Docs](https://laravel.com/project_docs/11.x/localization)
- [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)

## Processo Dev → Traduttore: Checklist e Istruzioni

1. **Preparazione**
   - Esporta i file PHP/JSON di riferimento da `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/en/` o `/lang/en.json`.
   - Elimina tutte le stringhe non usate prima di inviare ai traduttori.
2. **Istruzioni per i Traduttori**
   - Nei file PHP: traduci solo il testo a destra di `=>`, non cambiare chiavi o struttura.
   - Nei file JSON: traduci solo il valore, non la chiave.
   - Non aggiungere, rimuovere o spostare chiavi.
   - Se serve un apostrofo (`'`), anteporre `\`.
3. **Reintegrazione**
   - Sostituisci i file tradotti in `/lang/{locale}/` o `/lang/{locale}.json`.
   - Verifica la sintassi e testa l'applicazione.

### Modifiche Proposte
- Uniformare la struttura delle chiavi in tutti i file PHP.
- Usare sempre chiavi strutturate in inglese.
- Nei Blade, sostituire stringhe hardcoded con chiavi (es. `__('auth.login.submit_button')`).
- Documentare ogni file PHP con commenti per i traduttori. 

## Gestione Plurale/Singolare nelle Traduzioni

### Uso di `trans_choice()` e `@choice`
- Per messaggi che variano in base al conteggio, usa `trans_choice()` o la direttiva Blade `@choice()`.
- Sintassi tipica in PHP:
  ```php
  // lang/en/messages.php
  return [
      'newMessageIndicator' => '{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages',
  ];
  ```
- In Blade:
  ```blade
  @choice('messages.newMessageIndicator', $messagesCount)
  ```

### Sintassi delle Regole Plurali
- `{0}`: caso zero
- `{1}`: caso singolare
- `[2,*]`: da 2 in poi
- Usa `:count` per il numero

### Plurale in JSON
- Supportato ma meno leggibile:
  ```json
  {
    "{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages": "{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages"
  }
  ```
- In Blade:
  ```blade
  {{ trans_choice('{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages', $messagesCount) }}
  ```
- **Raccomandazione**: Preferire i file PHP per le stringhe plurali.

### Modifiche Proposte
- Inserire tutte le stringhe plurali in `/lang/{locale}/messages.php`.
- Nei Blade, sostituire blocchi condizionali con `trans_choice()` o `@choice()`.
- Evitare l'uso del JSON per le stringhe plurali.
