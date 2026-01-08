# Riutilizzabilità dei Temi

## Tema One (`laraxot/theme_one_fila3`)

Il tema One è un pacchetto npm riutilizzabile che può essere installato in qualsiasi progetto Laravel + Filament 3.

### Documentazione Dettagliata

- [Tema One - Riutilizzabilità](../../../Themes/One/docs/theme-reusability.md)
- [Tema One - Gestione Assets](../../../Themes/One/docs/theme-assets.md)

## Linee Guida per la Riutilizzabilità

1. **Indipendenza**
   - I temi devono essere indipendenti dal progetto specifico
   - Non devono contenere logica di business
   - Devono essere configurabili e personalizzabili

2. **Gestione Assets**
   - Gli script di build devono essere adattabili
   - I percorsi degli assets devono essere configurabili
   - La struttura delle directory deve essere flessibile

3. **Configurazione**
   - Utilizzare file di configurazione separati
   - Supportare variabili d'ambiente
   - Permettere override delle impostazioni

## Best Practices

1. **Installazione**
   - Utilizzare package manager (npm)
   - Documentare le dipendenze
   - Fornire script di setup

2. **Personalizzazione**
   - Utilizzare temi child per modifiche specifiche
   - Mantenere la compatibilità con gli aggiornamenti
   - Documentare i punti di estensione

3. **Manutenzione**
   - Versionare correttamente i temi
   - Mantenere un changelog
   - Testare la compatibilità

## Struttura Consigliata

```
project/
├── public/
│   └── themes/
│       └── {theme-name}/
└── resources/
    └── themes/
        └── {theme-name}/
```

## Integrazione

1. **Installazione**
```bash
npm install laraxot/theme_one_fila3
```

2. **Configurazione**
```json
{
    "scripts": {
        "copy": "cp -r ./public* PATH_TO_YOUR_PUBLIC_THEME_DIRECTORY"
    }
}
```

3. **Personalizzazione**
   - Creare un tema child se necessario
   - Configurare i percorsi degli assets
   - Adattare le variabili di stile

## Integrazione con il CMS

### Tema One (`laraxot/theme_one_fila3`)

1. **Installazione**
   - Il tema è un pacchetto npm indipendente
   - Può essere utilizzato in qualsiasi progetto Laravel + Filament 3
   - Non dipende da il progetto o altri progetti specifici

2. **Configurazione nel CMS**
   - Registrare il tema nel service provider del CMS
   - Configurare i percorsi degli assets
   - Impostare le variabili di personalizzazione

3. **Gestione Assets**
   - Adattare lo script `copy` al proprio progetto
   - Configurare i percorsi corretti nel CMS
   - Gestire la cache degli assets

## Best Practices per il CMS

1. **Registrazione Temi**
```php
// config/themes.php
return [
    'available' => [
        'one' => [
            'name' => 'laraxot/theme_one_fila3',
            'path' => 'themes/one',
            'assets' => 'themes/one'
        ]
    ]
];
```

2. **Gestione Assets**
```php
// Modules/Cms/Providers/ThemeServiceProvider.php
public function boot()
{
    $this->publishes([
        'themes/one/public' => public_path('themes/one'),
    ], 'theme-one-assets');
}
```

3. **Personalizzazione**
```php
// config/theme-one.php
return [
    'assets' => [
        'path' => 'themes/one',
        'compile' => [
            'copy_path' => public_path('themes/one')
        ]
    ]
];
```

## Integrazione con Altri Temi

1. **Struttura Standard**
   - Seguire la stessa struttura di directory
   - Utilizzare lo stesso sistema di build
   - Mantenere la compatibilità con il CMS

2. **Gestione Dipendenze**
   - Dichiarare tutte le dipendenze nel package.json
   - Gestire i conflitti di versione
   - Documentare i requisiti

3. **Testing**
   - Verificare la compatibilità con il CMS
   - Testare l'integrazione degli assets
   - Controllare le performance

## Troubleshooting

1. **Problemi di Assets**
   - Verificare i percorsi nel CMS
   - Controllare lo script `copy`
   - Verificare i permessi delle directory

2. **Conflitti di Stile**
   - Utilizzare namespace CSS
   - Isolare i componenti
   - Gestire le dipendenze correttamente

3. **Problemi di Cache**
   - Pulire la cache del CMS
   - Rigenerare gli assets
   - Verificare le versioni 
