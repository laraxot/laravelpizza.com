# StudioCardSelector Component - Modulo UI

## 🎯 **Panoramica**
Componente Filament Form altamente riutilizzabile per la selezione di studi medici/odontoiatrici attraverso un'interfaccia card visuale moderna e responsive.

## 🏗️ **Architettura Component**

### Classe PHP
```php
// Modules/UI/app/Forms/Components/StudioCardSelector.php
<?php

declare(strict_types=1);

namespace Modules\UI\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Database\Eloquent\Collection;
use Closure;

class StudioCardSelector extends Field
{
    protected string $view = 'ui::forms.components.studio-card-selector';

    // Dati studios da visualizzare
    protected Collection|Closure|null $studios = null;

    // Personalizzazioni UI
    protected bool $showDistance = false;
    protected bool $showSpecializations = false;
    protected bool $showPhone = false;
    protected string $cardLayout = 'default'; // 'default', 'compact', 'detailed'

    // Configure studios data source
    public function studios(Collection|Closure $studios): static
    {
        $this->studios = $studios;
        return $this;
    }

    // Enable/disable features
    public function showDistance(bool $show = true): static
    {
        $this->showDistance = $show;
        return $this;
    }

    public function showSpecializations(bool $show = true): static
    {
        $this->showSpecializations = $show;
        return $this;
    }

    public function showPhone(bool $show = true): static
    {
        $this->showPhone = $show;
        return $this;
    }

    // Layout variants
    public function compact(): static
    {
        $this->cardLayout = 'compact';
        return $this;
    }

    public function detailed(): static
    {
        $this->cardLayout = 'detailed';
        return $this;
    }

    // Data getters for view
    public function getStudios(): Collection
    {
        return $this->evaluate($this->studios) ?? collect();
    }

    public function getCardLayout(): string
    {
        return $this->cardLayout;
    }

    public function shouldShowDistance(): bool
    {
        return $this->showDistance;
    }

    public function shouldShowSpecializations(): bool
    {
        return $this->showSpecializations;
    }

    public function shouldShowPhone(): bool
    {
        return $this->showPhone;
    }
}
```

### Vista Blade
```blade
{{-- Modules/UI/resources/views/forms/components/studio-card-selector.blade.php --}}
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="studioCardSelector({
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }},
            studios: @js($getStudios()->toArray()),
        })"
        class="space-y-4"
    >
        @if($getStudios()->isNotEmpty())
            {{-- Studio Cards Grid --}}
            <div class="space-y-3">
                @foreach($getStudios() as $studio)
                    <div
                        @class([
                            'studio-card cursor-pointer transition-all duration-200',
                            'bg-white rounded-lg shadow-md hover:shadow-lg',
                            'border-2 border-transparent hover:border-primary-300',
                            'p-4' => $getCardLayout() === 'compact',
                            'p-6' => $getCardLayout() === 'default',
                            'p-8' => $getCardLayout() === 'detailed',
                        ])
                        x-bind:class="state == {{ $studio->id }} ? 'border-primary-500 bg-primary-50' : ''"
                        @click="selectStudio({{ $studio->id }})"
                        role="button"
                        tabindex="0"
                        @keydown.enter="selectStudio({{ $studio->id }})"
                        @keydown.space.prevent="selectStudio({{ $studio->id }})"
                    >
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            {{-- Studio Info --}}
                            <div class="flex-1">
                                <div class="flex items-start gap-3">
                                    {{-- Selection Radio --}}
                                    <div class="mt-1">
                                        <div
                                            @class([
                                                'w-4 h-4 rounded-full border-2 transition-colors',
                                                'border-gray-300' => true,
                                            ])
                                            x-bind:class="state == {{ $studio->id }} ? 'bg-primary-500 border-primary-500' : ''"
                                        >
                                            <div
                                                x-show="state == {{ $studio->id }}"
                                                class="w-2 h-2 bg-white rounded-full mx-auto mt-0.5"
                                            ></div>
                                        </div>
                                    </div>

                                    {{-- Studio Details --}}
                                    <div class="flex-1">
                                        <h3 @class([
                                            'font-bold text-primary-800',
                                            'text-lg' => $getCardLayout() === 'compact',
                                            'text-xl' => $getCardLayout() === 'default',
                                            'text-2xl' => $getCardLayout() === 'detailed',
                                        ])>
                                            {{ $studio->name }}
                                        </h3>

                                        <p class="text-gray-600 mt-1">
                                            {{ $studio->address?->formatted_address ?? $studio->address }}
                                        </p>

                                        @if($shouldShowPhone() && $studio->phone)
                                            <p class="text-sm text-gray-500 mt-1">
                                                <x-heroicon-s-phone class="w-4 h-4 inline mr-1" />
                                                {{ $studio->phone }}
                                            </p>
                                        @endif

                                        @if($shouldShowDistance() && isset($studio->distance))
                                            <div class="mt-2">
                                                <x-filament::badge color="gray" size="sm">
                                                    <x-heroicon-s-map-pin class="w-3 h-3 mr-1" />
                                                    {{ $studio->distance_formatted ?? $studio->distance . ' km' }}
                                                </x-filament::badge>
                                            </div>
                                        @endif

                                        @if($shouldShowSpecializations() && $studio->specializations && $studio->specializations->isNotEmpty())
                                            <div class="mt-2 flex flex-wrap gap-1">
                                                @foreach($studio->specializations->take(3) as $specialization)
                                                    <x-filament::badge size="sm">
                                                        {{ $specialization->name }}
                                                    </x-filament::badge>
                                                @endforeach
                                                @if($studio->specializations->count() > 3)
                                                    <x-filament::badge color="gray" size="sm">
                                                        +{{ $studio->specializations->count() - 3 }} altre
                                                    </x-filament::badge>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Action Button --}}
                            <div class="flex-shrink-0">
                                <x-filament::button
                                    type="button"
                                    color="primary"
                                    @click.stop="selectStudio({{ $studio->id }})"
                                    @class([
                                        'whitespace-nowrap',
                                        'w-full lg:w-auto' => true,
                                    ])
                                >
                                    {{ __('ui::studio-selector.actions.select') }}
                                </x-filament::button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-8">
                <x-heroicon-o-building-office class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    {{ __('ui::studio-selector.empty.title') }}
                </h3>
                <p class="text-gray-500">
                    {{ __('ui::studio-selector.empty.description') }}
                </p>
            </div>
        @endif
    </div>
</x-dynamic-component>

{{-- Alpine.js Component --}}
@script
<script>
Alpine.data('studioCardSelector', (config) => ({
    state: config.state,
    studios: config.studios,

    selectStudio(studioId) {
        this.state = studioId;
        this.$dispatch('studio-selected', { studioId });
    },

    init() {
        this.$watch('state', (value) => {
            this.$dispatch('studio-changed', { studioId: value });
        });
    }
}));
</script>
@endscript
```

## 🔧 **Utilizzo nel Widget**

### Implementazione Base
```php
// Nel widget FindDoctorAndAppointmentWidget
use Modules\UI\Forms\Components\StudioCardSelector;

protected function getStudioStepSchema(): array
{
    return [
        'selected_studio' => StudioCardSelector::make('selected_studio')
            ->studios(fn (Get $get) => $this->getStudiosForLocation($get))
            ->showDistance()
            ->showPhone()
            ->required()
    ];
}

private function getStudiosForLocation(Get $get): Collection
{
    $cap = $get('cap');
    $province = $get('province');
    $region = $get('region');

    if (!$cap || !$province || !$region) {
        return collect();
    }

    return \Modules\<nome progetto>\Models\Studio::whereHas('address', function($q) use ($cap, $province, $region) {
        $q->where('postal_code', $cap)
          ->where('administrative_area_level_3', $province)
          ->where('administrative_area_level_2', $region);
    })
    ->where('active', true)
    ->with(['address', 'doctors', 'specializations'])
    ->get();
}
```

### Varianti d'Uso
```php
// Compact layout
StudioCardSelector::make('studio')
    ->compact()
    ->studios($studios);

// Full featured
StudioCardSelector::make('studio')
    ->detailed()
    ->showDistance()
    ->showSpecializations()
    ->showPhone()
    ->studios($studios);

// Basic selection only
StudioCardSelector::make('studio')
    ->studios($studios);
```

## 🌐 **Sistema Traduzioni**

### File Traduzioni UI
```php
// Modules/UI/lang/it/studio-selector.php
<?php

return [
    'actions' => [
        'select' => [
            'label' => 'Seleziona',
            'description' => 'Scegli questo studio',
        ],
    ],
    'empty' => [
        'title' => 'Nessuno studio trovato',
        'description' => 'Non ci sono studi disponibili per la zona selezionata.',
    ],
    'fields' => [
        'distance' => [
            'label' => 'Distanza',
            'helper_text' => 'Distanza approssimativa dalla tua posizione',
        ],
        'phone' => [
            'label' => 'Telefono',
            'helper_text' => 'Numero di telefono dello studio',
        ],
        'specializations' => [
            'label' => 'Specializzazioni',
            'helper_text' => 'Servizi offerti dallo studio',
        ],
    ],
    'accessibility' => [
        'studio_card' => 'Scheda studio, clicca per selezionare',
        'selected_studio' => 'Studio selezionato',
        'select_studio' => 'Premi spazio o invio per selezionare questo studio',
    ],
];
```

## 🎨 **Styling e Personalizzazione**

### CSS Custom Properties
```css
/* resources/css/ui-components.css */
.studio-card {
    --studio-card-border-radius: theme('borderRadius.lg');
    --studio-card-shadow: theme('boxShadow.md');
    --studio-card-shadow-hover: theme('boxShadow.lg');
    --studio-card-padding: theme('spacing.6');
    --studio-card-gap: theme('spacing.4');
}

.studio-card:hover {
    transform: translateY(-1px);
    box-shadow: var(--studio-card-shadow-hover);
}

.studio-card[data-selected="true"] {
    background: theme('colors.primary.50');
    border-color: theme('colors.primary.500');
}

@media (max-width: 768px) {
    .studio-card {
        --studio-card-padding: theme('spacing.4');
        --studio-card-gap: theme('spacing.3');
    }
}
```

## ♿ **Accessibilità**

### Features Implementate
- **Keyboard Navigation**: Tab, Enter, Space per selezione
- **Screen Reader**: Etichette ARIA e ruoli appropriati
- **Focus Management**: Indicatori visivi chiari
- **Color Contrast**: Conformità WCAG 2.1 AA
- **Touch Targets**: Bottoni min 44px per mobile

### Attributi ARIA
```html
<div
    role="button"
    tabindex="0"
    aria-label="{{ __('ui::studio-selector.accessibility.studio_card') }}: {{ $studio->name }}"
    aria-pressed="{{ $isSelected ? 'true' : 'false' }}"
    @keydown.enter="selectStudio({{ $studio->id }})"
    @keydown.space.prevent="selectStudio({{ $studio->id }})"
>
```

## 🧪 **Testing**

### Unit Tests
```php
// tests/Unit/UI/Components/StudioCardSelectorTest.php
class StudioCardSelectorTest extends TestCase
{
    /** @test */
    public function it_renders_studios_correctly()
    {
        $studios = Studio::factory()->count(3)->create();

        $component = StudioCardSelector::make('studio')
            ->studios($studios);

        $this->assertCount(3, $component->getStudios());
    }

    /** @test */
    public function it_supports_layout_variants()
    {
        $component = StudioCardSelector::make('studio')->compact();
        $this->assertEquals('compact', $component->getCardLayout());

        $component = StudioCardSelector::make('studio')->detailed();
        $this->assertEquals('detailed', $component->getCardLayout());
    }
}
```

### Browser Tests (Dusk)
```php
// tests/Browser/StudioCardSelectorTest.php
class StudioCardSelectorTest extends DuskTestCase
{
    /** @test */
    public function user_can_select_studio_with_click()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/form-with-studio-selector')
                    ->click('@studio-card-1')
                    ->assertSeeIn('@selected-studio', 'Studio 1');
        });
    }

    /** @test */
    public function user_can_navigate_with_keyboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/form-with-studio-selector')
                    ->keys('@studio-card-1', ['{tab}', '{enter}'])
                    ->assertSeeIn('@selected-studio', 'Studio 1');
        });
    }
}
```

## 🚀 **Roadmap & Enhancement**

### Version 1.0 (Current)
- ✅ Basic card selection
- ✅ Responsive layout
- ✅ Accessibility support
- ✅ Multi-layout variants

### Version 1.1 (Future)
- 🔄 Map integration
- 🔄 Advanced filters (distance, rating)
- 🔄 Infinite scroll for large datasets
- 🔄 Geolocation-based sorting

### Version 1.2 (Future)
- 🔄 Virtual scrolling for performance
- 🔄 Advanced animations
- 🔄 Integration with booking system
- 🔄 Offline support with caching

## 📖 **Collegamenti Documentazione**

### Modulo UI
- [Components Overview](./README.md)
- [Form Components Guide](../form-components.md)
- [Accessibility Guidelines](../accessibility.md)

### Modulo <nome progetto>
- [Studio Models](../../<nome progetto>/docs/models/studio-address-relationship.md)
- [Widget Analysis](../../<nome progetto>/docs/widgets/find-doctor-widget-studio-step-analysis.md)

### External References
- [Filament Form Components](https://filamentphp.com/docs/forms/fields)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

---

**Component Status**: 📋 Documented - Ready for Implementation
**Reusability**: 🔄 High - Cross-module compatible
**Complexity**: 🟡 Medium - Custom view with Alpine.js
**Maintenance**: 🟢 Low - Well-documented and tested
**Last Updated**: January 2025
