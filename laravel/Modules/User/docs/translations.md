# Traduzioni del Modulo User

## Collegamenti

- [Modulo Lang](../../Lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../Xot/docs/translations.md)

## Struttura

```
Modules/User/
└── lang/
    ├── it/
    │   └── user.php
    └── en/
        └── user.php
```

## Contenuto

Il file `user.php` contiene le traduzioni per:
- Gestione utenti
- Profili
- Permessi
- Ruoli
- Autenticazione
- Registrazione

## Esempi

```php
return [
    'profile' => [
        'label' => 'Profilo Utente',
        'tooltip' => 'Gestisci le informazioni del tuo profilo'
    ],
    'permissions' => [
        'label' => 'Permessi',
        'tooltip' => 'Gestisci i permessi degli utenti'
    ],
    'roles' => [
        'label' => 'Ruoli',
        'tooltip' => 'Gestisci i ruoli degli utenti'
    ]
];
```

## Struttura delle Traduzioni

### File di Traduzione
Le traduzioni sono organizzate per lingua nella directory `lang/`:
```
lang/
├── it/
│   └── user.php
├── en/
│   └── user.php
└── ...
```

### Struttura del File
Ogni file di traduzione segue questa struttura:
```php
return [
    'navigation' => [
        'name' => 'Utenti',
        'plural' => 'Utenti',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione degli utenti e dei loro permessi',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID utente',
        ],
        // ...
    ],
];
```

## Best Practices

### 1. Nomenclatura
- Usare chiavi descrittive e consistenti
- Seguire la convenzione `modulo.entità.campo`
- Mantenere la coerenza tra le lingue

### 2. Gestione Campi
- Ogni campo deve avere `label` e `placeholder`
- Usare descrizioni chiare e concise
- Mantenere la coerenza terminologica

### 3. Validazione
- Verificare la presenza di tutte le traduzioni necessarie
- Controllare la coerenza tra le lingue
- Testare le traduzioni in produzione

## Checklist di Verifica

1. [ ] Tutti i campi hanno traduzioni
2. [ ] Le traduzioni sono coerenti tra le lingue
3. [ ] I placeholder sono descrittivi
4. [ ] Le etichette sono chiare e concise
5. [ ] Le traduzioni sono testate

## Esempi Comuni

### Campi Base
```php
'id' => [
    'label' => 'ID',
    'placeholder' => 'ID utente',
],
'email_verified_at' => [
    'label' => 'Email Verificata il',
    'placeholder' => 'Data di verifica email',
],
```

### Campi Relazionali
```php
'roles' => [
    'label' => 'Ruoli',
    'placeholder' => 'Seleziona i ruoli',
],
'permissions' => [
    'label' => 'Permessi',
    'placeholder' => 'Seleziona i permessi',
],
```

## Risorse Utili
- [Documentazione Laravel Localization](https://laravel.com/docs/localization)
- [Guida Filament Translations](https://filamentphp.com/docs/3.x/panels/translations)
- [Strumenti di Traduzione](https://laravel-lang.com/) 

## Collegamenti tra versioni di translations.md
* [translations.md](../../../Chart/docs/translations.md)
* [translations.md](../../../Reporting/docs/translations.md)
* [translations.md](../../../Gdpr/docs/translations.md)
* [translations.md](../../../Notify/docs/translations.md)
* [translations.md](../../../Xot/docs/roadmap/lang/translations.md)
* [translations.md](../../../Xot/docs/translations.md)
* [translations.md](../../../Dental/docs/translations.md)
* [translations.md](../../../User/docs/translations.md)
* [translations.md](../../../UI/docs/translations.md)
* [translations.md](../../../Lang/docs/packages/translations.md)
* [translations.md](../../../Lang/docs/translations.md)
* [translations.md](../../../Job/docs/translations.md)
* [translations.md](../../../Media/docs/translations.md)
* [translations.md](../../../Tenant/docs/translations.md)
* [translations.md](../../../Activity/docs/translations.md)
* [translations.md](../../../Patient/docs/translations.md)
* [translations.md](../../../Cms/docs/translations.md)

