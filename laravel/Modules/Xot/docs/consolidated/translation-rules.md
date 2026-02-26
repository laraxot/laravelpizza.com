# Regole per i file di traduzione in Laraxot PTVX

## Struttura dei file di traduzione

Ogni modulo deve avere i propri file di traduzione nella directory `Modules/<NomeModulo>/lang/<lingua>/`. La struttura standard di questi file deve seguire il seguente schema:

```php
<?php

return [
    'navigation' => [
        'group' => [
            'label' => 'Nome Gruppo',
        ],
        'resource' => [
            'label' => 'Nome Risorsa',
            'plural' => 'Nome Risorse',
        ],
    ],
    'page' => [
        'title' => 'Titolo Pagina',
        'description' => 'Descrizione Pagina',
    ],
    'fields' => [
        'nome_campo' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'tooltip' => 'Tooltip Campo',
            'help' => 'Testo di aiuto',
        ],
    ],
    'actions' => [
        'nome_azione' => [
            'label' => 'Etichetta Azione',
            'tooltip' => 'Tooltip Azione',
            'success' => 'Messaggio di successo',
            'error' => 'Messaggio di errore',
        ],
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'email' => 'Il campo :attribute deve essere un indirizzo email valido',
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
    ],
];
```

## Sintassi

1. **Utilizzare sintassi array breve**:
   ```php
   // CORRETTO
   return [
       'key' => 'value',
   ];
   
   // ERRATO
   return array(
       'key' => 'value',
   );
   ```

2. **Dichiarazione strict types**:
   ```php
   <?php
   
   declare(strict_types=1);
   
   return [
       'key' => 'value',
   ];
   ```

3. **Indentazione e formattazione coerente**:
   - Utilizzare 4 spazi per l'indentazione
   - Mantenere coerenza tra virgole e parentesi
   - Chiudere sempre correttamente gli array annidati

## Regole di naming

1. **Chiavi in snake_case**:
   ```php
   'nome_campo' => [
       'label' => 'Etichetta Campo',
   ],
   ```

2. **Prefissi per icone**:
   - Utilizzare il prefisso del modulo per le icone personalizzate
   - Esempio: `'icl-upload-animated'` per un'icona del modulo IndennitaCondizioniLavoro

3. **Evitare chiavi generiche**:
   - Usare nomi specifici e descrittivi
   - Evitare nomi come `button1`, `action2`, ecc.

## Pattern comuni

1. **Riferimento alle traduzioni nel codice**:
   ```php
   // CORRETTO
   ->label(__('modulo::risorsa.fields.nome_campo.label'))
   
   // ERRATO
   ->label('Etichetta hardcoded')
   ```

2. **Registrazione di icone SVG**:
   ```php
   // Nel ServiceProvider
   Blade::component('modulo::components.icons.nome-icona', 'modulo-nome-icona');
   
   // Nel file di traduzione
   'icona' => 'modulo-nome-icona',
   ```

## Errori comuni da evitare

1. **Parentesi mancanti in array annidati**
2. **Virgole mancanti tra elementi dell'array**
3. **Etichette non tradotte (stesse chiavi come valori)**
4. **Mescolanza di stili array (`array()` e `[]`)**
5. **Riferimenti a traduzioni inesistenti**
6. **Mancanza di `declare(strict_types=1);`**
7. **Campi `helper_text` vuoti o duplicati**
8. **Conflitti di merge non risolti**

## Manutenzione dei file di traduzione

1. **Controllo sintassi prima del commit**:
   ```bash
   php -l Modules/<NomeModulo>/lang/<lingua>/<file>.php
   ```

2. **Aggiornare le traduzioni quando si aggiungono funzionalità**
3. **Mantenere coerenza tra le diverse lingue**
4. **Rimuovere traduzioni obsolete**

## Link alla documentazione correlata

- [Errori comuni nei file di traduzione](/laravel/Modules/Lang/project_docs/errori_comuni_traduzione.md)
- [Convenzioni di documentazione](/laravel/Modules/Xot/project_docs/documentation_conventions.md)
- [Documentazione principale sulle traduzioni](/project_docs/translation_rules.md)

*Ultimo aggiornamento: 3 Giugno 2025*