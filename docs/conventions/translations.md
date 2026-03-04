# Convenzioni di Traduzione

## Struttura Base
```php
return [
    'navigation' => [
        'name' => 'Nome Singolare',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Gruppo di Appartenenza',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'identificativo', // senza .navigation
        'sort' => 99, // ordine di visualizzazione
        'icon' => 'prefisso-identificativo', // prefisso specifico per modulo
    ],
    'fields' => [...],
    'actions' => [...],
    'messages' => [...],
];
```

## Prefissi Icone
- Performance: `performance-`
- Xot: `xot-`
- Altri moduli: `[nome-modulo]-`

## Struttura Campi
```php
'fields' => [
    'nome_campo' => [
        'label' => 'Etichetta',
        'placeholder' => 'Testo placeholder',
        'help' => 'Testo di aiuto',
        'options' => [ // se necessario
            'key' => 'Valore',
        ],
    ],
],
```

## Struttura Azioni
```php
'actions' => [
    'nome_azione' => [
        'label' => 'Etichetta Azione',
        'success' => 'Messaggio di successo',
        'error' => 'Messaggio di errore',
    ],
],
```

## Struttura Messaggi
```php
'messages' => [
    'validation' => [...],
    'errors' => [...],
    'warnings' => [...],
    'info' => [...],
],
```

## Regole Generali
1. Non usare suffissi `.navigation` nei label
2. Usare nomi descrittivi e coerenti
3. Raggruppare i campi logicamente
4. Fornire help text informativi
5. Mantenere coerenza nelle traduzioni
6. Usare prefissi standard per le icone

## SVG Animati
- Creare nella directory `Resources/svg/`
- Nominare con l'identificativo dell'icona
- Includere animazioni hover
- Mantenere dimensioni 24x24
- Usare currentColor per il riempimento
