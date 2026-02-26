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
];
```

## 📖 **Collegamenti Documentazione**

### Modulo UI
- [Components Overview](./components.md)
- [Form Components Guide](./form-components.md)

### Modulo <nome progetto>
- [Widget Analysis](../<nome progetto>/docs/widgets/find-doctor-widget-studio-step-analysis.md)

---

**Component Status**: 📋 Documented - Ready for Implementation
**Reusability**: 🔄 High - Cross-module compatible
**Last Updated**: January 2025
