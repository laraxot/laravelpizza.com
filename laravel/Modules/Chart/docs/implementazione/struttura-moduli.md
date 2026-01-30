# Struttura Modulare di il progetto

## Principi Fondamentali

### Organizzazione Moduli
- Ogni modulo è un'unità indipendente con:
  - `composer.json` per namespace e autoload
  - Namespace `Modules\<Nome>\` (non `Modules\<Nome>\app`)
  - Struttura directory PSR-4:
    - `app/` - Classi PHP
    - `resources/` - Assets e viste
    - `config/` - Configurazioni
    - `database/` - Migrazioni e seeders
- Convenzioni di naming:
  - Directory sempre minuscole
  - `Resources` maiuscolo solo per classi PHP Resource
  - Blade sempre in `resources/views/`

### Documentazione
- Documentazione tecnica in `docs/` di ogni modulo
- `docs/` root solo per indice con link bidirezionali
- Focus su "perché" e "cosa", non su "come"

## Distribuzione Moduli

### Xot - Modulo Base
- Funzionalità generiche e condivise
- Classi base per estensioni
- Componenti riutilizzabili
- Convenzioni standard

### Root - Logica Progetto
- Configurazioni specifiche
- Integrazioni custom
- Business logic unica

### Cms - Frontend
- Gestione contenuti
- UI/UX
- Template e layout
- Integrazione Folio+Volt+Livewire

### Moduli Specializzati
- Lang: Traduzioni e localizzazione
- User: Gestione utenti
- Tenant: Multi-tenancy
- Media: Gestione file
- Notification: Sistema notifiche
- Report: Generazione report
- GDPR: Privacy e dati
- Job: Processi background
- Chart: Visualizzazione dati

## Best Practices

### Form e Azioni
```php
// ✅ Corretto
protected function getTableActions(): array
{
    return [
        'edit' => Tables\Actions\EditAction::make(),
        'delete' => Tables\Actions\DeleteAction::make(),
    ];
}

// ✅ Con estensione
protected function getTableActions(): array
{
    return [
        ...parent::getTableActions(),
        'custom' => Tables\Actions\Action::make(),
    ];
}

// ❌ Non fare
protected function getTableActions(): array
{
    return [
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
    ];
}
```

### Traduzioni
```php
// ✅ Corretto
->label(__('user.fields.first_name'))

// ❌ Non fare
->label('First Name')
```

### Frontoffice
- Stack: Folio + Volt + Livewire + Widget
- No rotte in `web.php`
- Blade in `Themes/{ThemeName}/resources/views/pages/`
- Form complessi:
```blade
@livewire(\Modules\{Module}\Filament\Widgets\CustomWidget)
```

### Widget
```php
class CustomWidget extends XotBaseWidget
{
    use HasForms;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('first_name'),
            Forms\Components\TextInput::make('last_name'),
        ];
    }
}
```

### Estensioni
- Non estendere direttamente classi Filament
- Usare `XotBase` in Xot
- Azioni form in array associativi

### Script e Prompt
- Script solo in cartelle `bashscripts` esistenti
- Prompt condivisi in singola stringa senza formattazione/acapo

## Riferimenti
- [Documentazione Xot](../../laravel/Modules/Xot/docs/README.md)
- [Documentazione Cms](../../laravel/Modules/Cms/docs/README.md)
- [Documentazione Lang](../../laravel/Modules/Lang/docs/README.md)
- [Documentazione Filament](https://filamentphp.com/docs/3.x/support/blade-components/overview)
