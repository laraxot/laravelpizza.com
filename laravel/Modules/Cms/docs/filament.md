# Filament nel Modulo CMS

## Risorse (Resources)

Tutte le risorse Filament nel modulo CMS devono seguire queste convenzioni:

### Requisiti

1. **Estendere XotBaseResource**
   - Tutte le risorse devono estendere `Modules\Xot\Filament\Resources\XotBaseResource`

2. **Struttura Directory**
   - Le risorse devono essere collocate in `app/Filament/Resources`
   - Le pagine delle risorse devono essere in `app/Filament/Resources/{ResourceName}/Pages`

3. **Metodo getFormSchema**
   - Deve restituire un array associativo con chiavi stringa
   - Le chiavi devono corrispondere ai nomi dei campi
   - Non utilizzare `columns()` o Grid a livello radice

4. **Non includere**
   - Non includere proprietà di navigazione (`$navigationIcon`, `$navigationGroup`, etc.)
   - Non includere il metodo `getRelations()` se restituisce un array vuoto
   - Non implementare `form(Form $form): Form` (è final nella classe base)

### Esempio di Risorsa

```php
class PageResource extends XotBaseResource
{
    use Translatable;

    protected static ?string $model = Page::class;

    public static function getTranslatableLocales(): array
    {
        return ['it', 'en'];
    }

    public static function getFormSchema(): array
    {
        return [
            'title' => Forms\Components\TextInput::make('title')
                ->required(),
            'slug' => Forms\Components\TextInput::make('slug')
                ->required(),
            'content' => Forms\Components\Section::make('Content')
                ->schema([
                    PageContent::make('content')
                        ->columnSpanFull(),
                ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
```

## Campi personalizzati

I campi personalizzati devono essere collocati in `app/Filament/Fields` e devono seguire queste convenzioni:

1. **Namespace**
   - Devono utilizzare `Modules\Cms\Filament\Fields`

2. **Convenzioni di Naming**
   - Devono avere nomi descrittivi che indicano il loro scopo
   - Devono terminare con il tipo di campo (es. `PageContent`, `IconPicker`)

3. **Documentazione**
   - Ogni campo deve avere un commento PHPDoc che ne descrive l'uso
   - Includere esempi di come utilizzare il campo

## Cluster

I cluster devono essere collocati in `app/Filament/Clusters` e raggruppano risorse correlate:

1. **Struttura**
   - Ogni cluster deve avere un nome descrittivo
   - Deve implementare l'interfaccia `Filament\Clusters\Cluster`

2. **Configurazione**
   - Deve specificare `$navigationGroup` e `$navigationIcon`
   - Deve elencare le risorse contenute nel cluster

## Pagine

Le pagine custom devono essere collocate in `app/Filament/Pages`:

1. **Convenzioni**
   - Devono estendere `Filament\Pages\Page`
   - Devono avere un template Blade corrispondente
   - Devono avere un titolo e un slug descrittivi 
## Collegamenti tra versioni di filament.md
* [filament.md](docs/tecnico/filament/filament.md)
* [filament.md](laravel/Modules/Chart/docs/filament.md)
* [filament.md](laravel/Modules/Gdpr/docs/filament.md)
* [filament.md](laravel/Modules/Xot/docs/technical/filament.md)
* [filament.md](laravel/Modules/Xot/docs/roadmap/integration/filament.md)
* [filament.md](laravel/Modules/Lang/docs/filament.md)
* [filament.md](laravel/Modules/Job/docs/filament.md)
* [filament.md](laravel/Modules/Activity/docs/filament.md)
* [filament.md](laravel/Modules/Cms/docs/filament.md)

