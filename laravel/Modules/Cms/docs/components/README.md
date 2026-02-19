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
* [README.md](bashscripts/docs/readme.md)
* [README.md](bashscripts/docs/it/readme.md)
* [README.md](docs/laravel-app/phpstan/readme.md)
* [README.md](docs/laravel-app/readme.md)
* [README.md](docs/moduli/struttura/readme.md)
* [README.md](docs/moduli/readme.md)
* [README.md](docs/moduli/manutenzione/readme.md)
* [README.md](docs/moduli/core/readme.md)
* [README.md](docs/moduli/installati/readme.md)
* [README.md](docs/moduli/comandi/readme.md)
* [README.md](docs/phpstan/readme.md)
* [README.md](docs/readme.md)
* [README.md](docs/module-links/readme.md)
* [README.md](docs/troubleshooting/git-conflicts/readme.md)
* [README.md](docs/tecnico/laraxot/readme.md)
* [README.md](docs/modules/readme.md)
* [README.md](docs/conventions/readme.md)
* [README.md](docs/amministrazione/backup/readme.md)
* [README.md](docs/amministrazione/monitoraggio/readme.md)
* [README.md](docs/amministrazione/deployment/readme.md)
* [README.md](docs/translations/readme.md)
* [README.md](docs/roadmap/readme.md)
* [README.md](docs/ide/cursor/readme.md)
* [README.md](docs/implementazione/api/readme.md)
* [README.md](docs/implementazione/testing/readme.md)
* [README.md](docs/implementazione/pazienti/readme.md)
* [README.md](docs/implementazione/ui/readme.md)
* [README.md](docs/implementazione/dental/readme.md)
* [README.md](docs/implementazione/core/readme.md)
* [README.md](docs/implementazione/reporting/readme.md)
* [README.md](docs/implementazione/isee/readme.md)
* [README.md](docs/it/readme.md)
* [README.md](laravel/vendor/mockery/mockery/docs/readme.md)
* [README.md](laravel/modules/chart/docs/readme.md)
* [README.md](laravel/modules/reporting/docs/readme.md)
* [README.md](laravel/modules/gdpr/docs/phpstan/readme.md)
* [README.md](laravel/modules/gdpr/docs/readme.md)
* [README.md](laravel/modules/notify/docs/phpstan/readme.md)
* [README.md](laravel/modules/notify/docs/readme.md)
* [README.md](laravel/modules/xot/docs/filament/readme.md)
* [README.md](laravel/modules/xot/docs/phpstan/readme.md)
* [README.md](laravel/modules/xot/docs/exceptions/readme.md)
* [README.md](laravel/modules/xot/docs/readme.md)
* [README.md](laravel/modules/xot/docs/standards/readme.md)
* [README.md](laravel/modules/xot/docs/conventions/readme.md)
* [README.md](laravel/modules/xot/docs/development/readme.md)
* [README.md](laravel/modules/dental/docs/readme.md)
* [README.md](laravel/modules/user/docs/phpstan/readme.md)
* [README.md](laravel/modules/user/docs/readme.md)
* [README.md](laravel/modules/user/resources/views/docs/readme.md)
* [README.md](laravel/modules/ui/docs/phpstan/readme.md)
* [README.md](laravel/modules/ui/docs/readme.md)
* [README.md](laravel/modules/ui/docs/standards/readme.md)
* [README.md](laravel/modules/ui/docs/themes/readme.md)
* [README.md](laravel/modules/ui/docs/components/readme.md)
* [README.md](laravel/modules/lang/docs/phpstan/readme.md)
* [README.md](laravel/modules/lang/docs/readme.md)
* [README.md](laravel/modules/job/docs/phpstan/readme.md)
* [README.md](laravel/modules/job/docs/readme.md)
* [README.md](laravel/modules/media/docs/phpstan/readme.md)
* [README.md](laravel/modules/media/docs/readme.md)
* [README.md](laravel/modules/tenant/docs/phpstan/readme.md)
* [README.md](laravel/modules/tenant/docs/readme.md)
* [README.md](laravel/modules/activity/docs/phpstan/readme.md)
* [README.md](laravel/modules/activity/docs/readme.md)
* [README.md](laravel/modules/patient/docs/readme.md)
* [README.md](laravel/modules/patient/docs/standards/readme.md)
* [README.md](laravel/modules/patient/docs/value-objects/readme.md)
* [README.md](laravel/modules/cms/docs/blocks/readme.md)
* [README.md](laravel/modules/cms/docs/readme.md)
* [README.md](laravel/modules/cms/docs/standards/readme.md)
* [README.md](laravel/modules/cms/docs/content/readme.md)
* [README.md](laravel/modules/cms/docs/frontoffice/readme.md)
* [README.md](laravel/modules/cms/docs/components/readme.md)
* [README.md](laravel/themes/two/docs/readme.md)
* [README.md](laravel/themes/one/docs/readme.md)
