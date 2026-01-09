# Struttura Pagine Filament - Modulo UI

## Panoramica
Il modulo UI gestisce pagine Filament per test e funzionalità di sistema. Ogni pagina deve seguire le convenzioni di naming e struttura.

## Struttura Directory

```
Modules/UI/
├── app/Filament/
│   ├── Clusters/
│   │   └── Test/
│   │       └── Pages/
│   │           └── S3Test.php
│   └── Widgets/
├── resources/views/
│   └── filament/
│       ├── clusters/
│       │   └── test/
│       │       └── pages/
│       │           └── s3test.blade.php
│       ├── pages/
│       └── widgets/
```

## Convenzioni Naming

### File PHP
- **Clusters**: PascalCase (es. `Test.php`)
- **Pages**: PascalCase (es. `S3Test.php`)
- **Namespace**: `Modules\UI\Filament\Clusters\{Cluster}\Pages`

### File Blade
- **Directory**: lowercase con separatori (es. `clusters/test/pages/`)
- **File**: lowercase con separatori (es. `s3test.blade.php`)
- **View Path**: `ui::filament.clusters.test.pages.s3test`

## Struttura View Blade

### Template Base per Pagine Filament
```blade
<x-filament::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('ui::pages.s3test.heading') }}
        </x-slot>

        <x-slot name="description">
            {{ __('ui::pages.s3test.description') }}
        </x-slot>

        {{-- Contenuto della pagina --}}
        <div class="space-y-6">
            {{ $this->form }}
        </div>
    </x-filament::section>
</x-filament::page>
```

### Template per Pagine con Form
```blade
<x-filament::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('ui::pages.s3test.heading') }}
        </x-slot>

        <x-slot name="description">
            {{ __('ui::pages.s3test.description') }}
        </x-slot>

        {{-- Form principale --}}
        <form wire:submit="sendEmail">
            {{ $this->emailForm }}

            {{-- Azioni del form --}}
            <div class="flex justify-end gap-4 mt-6">
                {{ $this->getEmailFormActions() }}
            </div>
        </form>
    </x-filament::section>
</x-filament::page>
```

## Traduzioni

### Struttura File Traduzione
```php
// Modules/UI/lang/it/pages.php
return [
    's3test' => [
        'heading' => 'Test Invio Email S3',
        'description' => 'Pagina di test per l\'invio di email tramite S3',
        'fields' => [
            'to' => [
                'label' => 'Destinatario',
                'placeholder' => 'Inserisci l\'indirizzo email',
            ],
            'subject' => [
                'label' => 'Oggetto',
                'placeholder' => 'Inserisci l\'oggetto dell\'email',
            ],
            'body_html' => [
                'label' => 'Contenuto',
                'placeholder' => 'Inserisci il contenuto dell\'email',
            ],
        ],
        'actions' => [
            'send_email' => [
                'label' => 'Invia Email',
                'success' => 'Email inviata con successo',
                'error' => 'Errore durante l\'invio dell\'email',
            ],
        ],
    ],
];
```

## Best Practices

### 1. **Estensione Classi Base**
- ✅ Estendere sempre `XotBasePage` invece di `Page`
- ✅ Non ridichiarare trait già presenti nella classe base
- ✅ Utilizzare metodi della classe base quando possibile

### 2. **Struttura View**
- ✅ Utilizzare `<x-filament::page>` come wrapper principale
- ✅ Organizzare contenuto in sezioni con heading e description
- ✅ Utilizzare traduzioni per tutti i testi

### 3. **Form Handling**
- ✅ Utilizzare `wire:submit` per azioni del form
- ✅ Gestire stati di loading e errori
- ✅ Fornire feedback all'utente tramite notifiche

### 4. **Responsive Design**
- ✅ Utilizzare classi Tailwind per layout responsive
- ✅ Testare su diversi dispositivi
- ✅ Mantenere accessibilità

## Esempi di Implementazione

### Pagina S3Test
```php
// S3Test.php
class S3Test extends XotBasePage
{
    protected static string $view = 'ui::filament.clusters.test.pages.s3test';

    public function emailForm(Form $form): Form
    {
        return $form->schema([
            // Schema del form
        ]);
    }
}
```

```blade
{{-- s3test.blade.php --}}
<x-filament::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('ui::pages.s3test.heading') }}
        </x-slot>

        <form wire:submit="sendEmail">
            {{ $this->emailForm }}

            <div class="flex justify-end gap-4 mt-6">
                {{ $this->getEmailFormActions() }}
            </div>
        </form>
    </x-filament::section>
</x-filament::page>
```

## Collegamenti
- [Filament Extension Rules](../../../.cursor/rules/filament-extension-rules.mdc)
- [UI Module README](./README.md)
- [Blade Components](./blade-components.md)

*Ultimo aggiornamento: 2025-01-06*
