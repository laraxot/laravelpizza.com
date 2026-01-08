# Componenti

Questa cartella contiene la documentazione relativa ai componenti del frontend.

## File Contenuti

- `index.md` - Panoramica dei componenti
- `forms.md` - Componenti per i form
- `navigation.md` - Componenti di navigazione
- `layout.md` - Componenti di layout

## Note

Questa documentazione descrive come utilizzare e personalizzare i componenti del frontend.

# Componenti UI il progetto

## Panoramica

Il sistema di componenti UI di il progetto è costruito su una base solida di best practices e standard moderni. Integra le funzionalità di David UI con il framework Laravel e Filament, offrendo un'esperienza di sviluppo coerente e professionale.

## Convenzioni di Laravel

### Struttura delle Directory
- `resources` (minuscolo) è la directory standard per le risorse
- `views` contiene i template Blade
- `components` contiene i componenti Blade
- `lang` contiene le traduzioni
- `css` contiene gli stili
- `js` contiene gli script

### Best Practices
1. **Naming delle Directory**:
   - Usare sempre lettere minuscole
   - Usare underscore per gli spazi
   - Seguire le convenzioni di Laravel

2. **Struttura dei Componenti**:
   ```
   resources/
   ├── views/
   │   ├── components/
   │   │   ├── section.blade.php
   │   │   └── ...
   │   └── ...
   ```

3. **Documentazione**:
   - Mantenere la documentazione aggiornata
   - Includere esempi di utilizzo
   - Documentare le convenzioni

## Categorie di Componenti

### Elementi Core
- **[Button](core-elements/button.md)** - Pulsanti interattivi per azioni primarie e secondarie
- **[Button Group](core-elements/button-group.md)** - Raggruppamenti logici di pulsanti correlati
- **[Icon Button](core-elements/icon-button.md)** - Pulsanti compatti con icone per azioni specifiche
- **[Rating Bar](core-elements/rating-bar.md)** - Sistema di valutazione visuale
- **[Switch](core-elements/switch.md)** - Toggle per stati binari

### Display Dati
- **[Accordion](data-display/accordion.md)** - Contenuti collassabili per ottimizzare lo spazio
- **[Alert](data-display/alert.md)** - Sistema di notifiche e feedback
- **[Avatar](data-display/avatar.md)** - Rappresentazione visuale degli utenti
- **[Badge](data-display/badge.md)** - Indicatori di stato e notifiche
- **[Card](data-display/card.md)** - Contenitori modulari per informazioni correlate
- **[Chip](data-display/chip.md)** - Elementi compatti per tag e selezioni
- **[List](data-display/list.md)** - Visualizzazione strutturata di dati sequenziali
- **[Progress Bar](data-display/progress-bar.md)** - Indicatori di avanzamento
- **[Table](data-display/table.md)** - Visualizzazione tabellare dei dati
- **[Timeline](data-display/timeline.md)** - Rappresentazione cronologica degli eventi

### Navigazione
- **[Breadcrumb](navigation/breadcrumb.md)** - Navigazione gerarchica
- **[Pagination](navigation/pagination.md)** - Gestione di grandi set di dati
- **[Stepper](navigation/stepper.md)** - Guide passo-passo
- **[Tabs](navigation/tabs.md)** - Organizzazione di contenuti correlati

### Layout
- **[Footer](layout/footer.md)** - Struttura del piè di pagina
- **[Gallery](layout/gallery.md)** - Visualizzazione di contenuti multimediali
- **[Navbar](layout/navbar.md)** - Navigazione principale
- **[Sidebar](layout/sidebar.md)** - Menu laterale e navigazione secondaria

## Linee Guida per l'Implementazione

### Standard di Codice
1. **Type Safety**
   ```php
   public function render(): View
   {
       return view('components.button', [
           'variant' => $this->variant,
           'size' => $this->size,
       ]);
   }
   ```

2. **Validazione Props**
   ```php
   protected function validateProps(): void
   {
       if (!in_array($this->variant, ['primary', 'secondary', 'outline'])) {
           throw new InvalidArgumentException('Invalid variant');
       }
   }
   ```

3. **Gestione Eventi**
   ```php
   public function dispatchClick(): void
   {
       $this->dispatch('button::clicked', [
           'id' => $this->getId(),
           'value' => $this->value,
       ]);
   }
   ```

### Accessibilità (WCAG 2.1)
1. **Attributi ARIA**
   ```php
   <button
       aria-label="{{ $ariaLabel }}"
       aria-expanded="{{ $isExpanded }}"
       role="button"
   >
   ```

2. **Supporto Tastiera**
   ```js
   button.addEventListener('keydown', (e) => {
       if (e.key === 'Enter' || e.key === ' ') {
           e.preventDefault();
           button.click();
       }
   });
   ```

3. **Focus Management**
   ```php
   <div
       tabindex="0"
       x-trap.noscroll="isOpen"
       class="focus:ring-2 focus:ring-primary-500"
   >
   ```

### Performance
1. **Lazy Loading**
   ```php
   use Illuminate\Database\Eloquent\Builder;
   
   public function users(): Builder
   {
       return User::query()
           ->select(['id', 'name', 'email'])
           ->withCount('orders')
           ->latest();
   }
   ```

2. **Caching**
   ```php
   public function getData(): array
   {
       return cache()->remember('component-data', 3600, function () {
           return $this->computeData();
       });
   }
   ```

3. **Asset Optimization**
   ```php
   // webpack.mix.js
   mix.js('resources/js/components.js', 'public/js')
      .postCss('resources/css/components.css', 'public/css', [
          require('tailwindcss'),
      ])
      .version();
   ```

## Integrazione con Filament

### Resource Components
```php
use Filament\Resources\Resource;
use Filament\Resources\Pages\ListRecords;

class UserResource extends Resource
{
    public static function getNavigationGroup(): ?string
    {
        return __('admin.users.group');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
```

### Form Components
```php
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Card::make()
                ->schema([
                    Grid::make(['default' => 2])
                        ->schema([
                            // componenti del form
                        ]),
                ])
                ->columnSpan(['lg' => 2]),
        ]);
}
```

## Testing

### Unit Tests
```php
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ButtonTest extends TestCase
{
    /** @test */
    public function it_renders_with_correct_variant(): void
    {
        $view = $this->blade(
            '<x-cms::button variant="primary">Test</x-cms::button>'
        );

        $view->assertSee('bg-primary-600');
    }
}
```

### Feature Tests
```php
/** @test */
public function it_handles_click_events(): void
{
    Livewire::test(ButtonComponent::class)
        ->call('click')
        ->assertEmitted('button::clicked');
}
```

### Browser Tests
```php
use Laravel\Dusk\Browser;

/** @test */
public function it_shows_loading_state(): void
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/test-page')
                ->click('@submit-button')
                ->waitFor('@loading-indicator')
                ->assertVisible('@loading-indicator');
    });
}
```

## Contribuire

### Processo di Sviluppo
1. Fork del repository
2. Creazione branch feature/fix
3. Sviluppo con TDD
4. Pull Request con descrizione dettagliata

### Standard di Documentazione
1. Documentazione in italiano
2. Esempi di codice testati
3. Screenshot/GIF per componenti visuali
4. Note su accessibilità e performance

## Troubleshooting

### Debug Common Issues
1. **Stili non applicati**
   - Verificare pubblicazione assets
   - Controllare conflitti classi Tailwind
   - Verificare ordine caricamento CSS

2. **Eventi non triggrati**
   - Debug Livewire DevTools
   - Verificare naming eventi
   - Controllare Alpine.js setup

3. **Rendering Issues**
   - Pulire cache view e route
   - Verificare versioni dipendenze
   - Controllare conflitti JavaScript

## Risorse Utili

### Documentation
- [Filament Docs](https://filamentphp.com/docs)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Alpine.js](https://alpinejs.dev/docs)
- [WCAG Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

