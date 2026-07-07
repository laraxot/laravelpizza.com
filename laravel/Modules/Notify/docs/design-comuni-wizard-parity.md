# Design Comuni Wizard Parity

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Frontend / Filament / Design Comuni  
**Module**: Fixcity  
**Theme**: Sixteen

---

## Obiettivo

Wizard step 2 deve avere **alto HTML parity** e **altissimo visual parity** con:
https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html

---

## Struttura Reference (Design Comuni)

```
┌─────────────────────────────────────────────────┐
│  Breadcrumb                                     │
│  H1: Segnalazione disservizio                   │
├─────────────────────────────────────────────────┤
│  Stepper (2/3)                                  │
├──────────────────┬──────────────────────────────┤
│  NavScroll       │  Sezione LUOGO               │
│  (sidebar sx)    │  - cmp-card                  │
│  - Luogo         │    - card-header             │
│  - Disservizio   │      - H2 title-xxlarge      │
│  - Autore        │      - p subtitle-small      │
│                  │    - card-body               │
│                  │      - form-group            │
│                  │      - AddressInput          │
│                  │      - Geolocate link        │
│                  ├──────────────────────────────┤
│                  │  Sezione DISSERVIZIO         │
│                  │  - cmp-card                  │
│                  │    - card-header             │
│                  │      - H2 title-xxlarge      │
│                  │    - card-body               │
│                  │      - Select (tipo)         │
│                  │      - TextInput (titolo)    │
│                  │      - Textarea (dettagli)   │
│                  │      - FileUpload (immagini) │
│                  ├──────────────────────────────┤
│                  │  Sezione AUTORE              │
│                  │  - cmp-card                  │
│                  │    - cmp-info-button-card    │
│                  │      - H3 (nome utente)      │
│                  │      - Codice Fiscale        │
│                  │      - Accordion "Mostra"    │
│                  │        - Contatti            │
├──────────────────┴──────────────────────────────┤
│  Nav Steps (Indietro | Salva | Avanti)          │
└─────────────────────────────────────────────────┘
```

---

## Implementazione Filament Widget

### PHP Widget
**File**: `Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`

```php
public function getDataSchema(): array
{
    return [
        // Sezione LUOGO
        Section::make(__('fixcity::segnalazione.sections.place.label'))
            ->description(__('fixcity::segnalazione.sections.place.description'))
            ->aside()       // Sidebar heading style
            ->compact()     // Compact card style
            ->schema([...]),

        // Sezione DISSERVIZIO
        Section::make(__('fixcity::segnalazione.sections.inefficiency.label'))
            ->compact()
            ->schema([...]),

        // Sezione AUTORE
        Section::make(__('fixcity::segnalazione.sections.author.label'))
            ->description(__('fixcity::segnalazione.sections.author.description'))
            ->aside()
            ->compact()
            ->schema([...]),
    ];
}
```

### Blade View
**File**: `Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`

```blade
<div class="segnalazione-wizard-root">
    <div class="container" id="main-container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="cmp-heading pb-3 pb-lg-4">
                    <h1 class="title-xxxlarge">{{ $pageTitle }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 pb-40 pb-lg-80">
                <x-filament-widgets::widget class="cmp-wizard-widget">
                    <form wire:submit="submit">
                        {{ $this->form }}
                    </form>
                </x-filament-widgets::widget>
            </div>
        </div>
    </div>
</div>
```

---

## CSS Parity
**File**: `Themes/Sixteen/resources/css/components/wizard-parity.css`

Stili custom per match Design Comuni:
- `.cmp-wizard-widget` - Root wrapper
- `.fi-fo-section` → `cmp-card` styling
- `.fi-fo-section-header-title` → `title-xxlarge`
- `.fi-fo-field-wrapper` → `form-group` styling
- Submit button → `btn btn-primary mobile-full`

---

## Traduzioni
**File**: `Modules/Fixcity/lang/it/segnalazione.php`

```php
'sections' => [
    'place' => [
        'label' => 'LUOGO',
        'description' => 'Indica il luogo del disservizio',
    ],
    'inefficiency' => [
        'label' => 'DISSERVIZIO',
    ],
    'author' => [
        'label' => 'AUTORE DELLA SEGNALAZIONE',
        'description' => 'Informazione su di te',
    ],
],
```

---

## Build

```bash
cd Themes/Sixteen
npm run build
```

---

## Checklist Parity

- [x] 3 sezioni: Luogo, Disservizio, Autore
- [x] Section heading con title-xxlarge
- [x] Section description con subtitle-small
- [x] Card wrapper styling (cmp-card parity)
- [x] Form groups con form-control styling
- [x] Submit button btn-primary mobile-full
- [x] Container col-12 col-lg-10 layout
- [x] cmp-heading wrapper
- [ ] Section navigation sidebar (TODO)
- [ ] Stepper component (TODO)
- [ ] Nav steps footer (TODO)

---

*Ultimo aggiornamento: 2026-04-14*
