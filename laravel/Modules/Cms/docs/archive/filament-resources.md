# Filament Resources nel CMS

## Struttura Directory
```
laravel/
└── Modules/
    └── Cms/
        └── app/
            └── Filament/
                └── Resources/
                    └── {Model}Resource.php
```

## Namespace Requirements
```php
namespace Modules\Cms\Filament\Resources; // CORRETTO
// namespace Modules\Cms\App\Filament\Resources; // ERRATO
```

## Convenzioni di Nomenclatura
- File: `{Model}Resource.php`
- Classe: `{Model}Resource`
- Pagine: `{Model}Resource/Pages/{Action}{Model}.php`

## Classi Base di Xot
Le classi base di Xot devono essere importate dal namespace corretto:
```php
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
```

## Traduzioni
Le traduzioni devono essere gestite attraverso i file di traduzione del modulo:
```php
// lang/it/filament.php
return [
    'resources' => [
        'section' => [
            'label' => 'Sezione',
            'plural' => 'Sezioni',
            'navigation' => [
                'label' => 'Sezioni',
                'icon' => 'heroicon-o-rectangle-stack',
            ],
        ],
    ],
];
```

## Problemi Comuni e Soluzioni
1. **File non trovato**
   - Verifica il percorso del file
   - Controlla il namespace
   - Assicurati che il file sia nel modulo corretto

2. **Namespace Issues**
   - Usa sempre il namespace completo
   - Verifica la sensibilità alle maiuscole/minuscole
   - Controlla gli `use` statements
   - **Il namespace per le risorse Filament deve essere `Modules\<NomeModulo>\Filament\Resources`, non `Modules\<NomeModulo>\App\Filament\Resources` anche se il file si trova in `laravel/Modules/<NomeModulo>/app/Filament/Resources`**

3. **Classi Base**
   - Usa sempre le classi base con il prefisso "Base"
   - Importa dal namespace corretto `Modules\Xot\Filament\Resources\Pages\`
   - Non usare le classi senza il prefisso "Base"

## Best Practices
1. **Struttura Directory**
   - Organizza le risorse per dominio
   - Mantieni la coerenza tra i moduli
   - Segui le convenzioni di Laravel

2. **Nomenclatura**
   - Usa nomi descrittivi
   - Segui le convenzioni PSR-4
   - Mantieni la coerenza

3. **Organizzazione**
   - Documenta le dipendenze
   - Mantieni aggiornata la documentazione
   - Usa i namespace corretti

## Link Correlati
- [Documentazione Filament](https://filamentphp.com/docs)
- [Best Practices Filament](https://filamentphp.com/project_docs/best-practices)
- [Struttura Resources](https://filamentphp.com/project_docs/resources)
- [Convenzioni Namespace](../Xot/project_docs/namespace_conventions.md)
- [Best Practices Traduzioni](../Xot/project_docs/TRANSLATIONS-BEST-PRACTICES.md)

## Note Importanti
- Le classi base di Xot sono sempre nel namespace `Modules\Xot\Filament\Resources\Pages\`
- Usa sempre il prefisso "Base" per le classi base
- Mantieni la documentazione aggiornata con i namespace corretti
- Usa sempre i file di traduzione invece dei label hardcoded

## Collegamenti Bidirezionali
- [README](README.md) - Documentazione principale del modulo
- [Integrazione Filament](filament-integration.md) - Integrazione con Filament
- [Componenti](filament-components.md) - Componenti Filament
- [Form](filament-forms.md) - Sistema di form
- [Widget](filament-widgets-in-blade.md) - Widget in Blade
- [Personalizzazioni](filament-personalizzazioni-avanzate.md) - Personalizzazioni avanzate
- [Namespace](convenzioni-namespace-filament.md) - Convenzioni namespace

## Vedi Anche
- [Modulo UI](../UI/project_docs/README.md) - Componenti di interfaccia
- [Modulo Xot](../Xot/project_docs/README.md) - Classi base e utilities
- [Modulo Theme](../Theme/project_docs/README.md) - Gestione temi
- [Documentazione Filament](https://filamentphp.com/docs) - Documentazione ufficiale
- [Resources](https://filamentphp.com/project_docs/3.x/resources) - Gestione risorse
- [Best Practices](https://filamentphp.com/project_docs/3.x/resources/best-practices) - Best practices
## Collegamenti tra versioni di filament-resources.md
* [filament-resources.md](docs/tecnico/filament/filament-resources.md)
* [filament-resources.md](docs/regole/filament-resources.md)
* [filament-resources.md](laravel/Modules/Gdpr/project_docs/filament-resources.md)
* [filament-resources.md](laravel/Modules/Xot/project_docs/filament-resources.md)
* [filament-resources.md](laravel/Modules/Cms/project_docs/filament-resources.md)

