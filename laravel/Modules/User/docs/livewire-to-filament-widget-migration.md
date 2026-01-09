# ERRORE ARCHITETTURALE CRITICO: Uso Diretto di Componenti Livewire nei Login-Card

## Problema Identificato
Durante l'audit del codice è stato identificato un **errore architetturale gravissimo**: l'uso diretto di componenti Livewire (`@livewire(\Modules\User\Http\Livewire\Auth\Login)`) nei blocchi di form come `login-card.blade.php`.
## Gravità del Problema
### Perché è Critico
1. **Architettura Obsoleta**: I componenti Livewire diretti sono stati sostituiti dai widget Filament
2. **Manutenibilità**: Difficoltà nell'aggiornamento e manutenzione del codice
3. **Standardizzazione**: Mancanza di coerenza con l'architettura Filament/AGID
4. **Compatibilità**: Problemi di integrazione con i pannelli Filament
5. **Troubleshooting**: Difficoltà nella risoluzione di errori e debug
### Impatto sul Progetto
- **Inconsistenza Architetturale**: Mix di approcci Livewire e Filament
- **Problemi di Integrazione**: Difficoltà nell'integrazione con i temi AGID
- **Manutenzione Complessa**: Doppia gestione di componenti simili
- **Performance**: Caricamento non ottimizzato dei componenti
## Regola Assoluta
### ❌ VIETATO ASSOLUTO
```blade
{{-- MAI usare componenti Livewire diretti nei login-card --}}
@props([
    'livewireComponent' => '\Modules\User\Http\Livewire\Auth\Login'
])
<div class="login-card">
    @livewire($livewireComponent)
</div>
```
### ✅ OBBLIGATORIO
{{-- SEMPRE usare widget Filament --}}
    'widgetClass' => '\Modules\User\Filament\Widgets\Auth\LoginWidget'
    @livewire($widgetClass)
## Motivazioni Tecniche
### Vantaggi dei Widget Filament
1. **Standardizzazione**: Coerenza con l'architettura Filament
2. **Integrazione AGID**: Compatibilità nativa con i temi istituzionali
3. **Manutenibilità**: Codice più pulito e manutenibile
4. **Estendibilità**: Facilità nell'aggiunta di funzionalità (2FA, SPID, CIE)
5. **Performance**: Ottimizzazioni native di Filament
6. **Troubleshooting**: Debugging semplificato
### Problemi dei Componenti Livewire Diretti
1. **Obsolescenza**: Approccio legacy non più supportato
2. **Incompatibilità**: Problemi con i temi AGID/istituzionali
3. **Duplicazione**: Codice duplicato tra Livewire e Filament
4. **Complessità**: Gestione manuale di stati e validazioni
5. **Sicurezza**: Mancanza di protezioni native di Filament
## Widget Filament Disponibili
### LoginWidget (Raccomandato)
```php
// Modules/User/app/Filament/Widgets/Auth/LoginWidget.php
namespace Modules\User\Filament\Widgets\Auth;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
class LoginWidget extends XotBaseWidget
{
    protected static string $view = 'pub_theme::filament.widgets.auth.login';

    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('email')
                ->email()
                ->required(),
            Forms\Components\TextInput::make('password')
                ->password()
            Forms\Components\Checkbox::make('remember'),
        ];
    }
    public function login(): void
        // Logica di autenticazione
}
### Caratteristiche del Widget
- **Estende XotBaseWidget**: Coerenza architetturale
- **Form Schema**: Validazione integrata
- **Sicurezza**: Protezioni CSRF automatiche
- **Temi**: Compatibilità con temi AGID
- **Estendibilità**: Facile aggiunta di funzionalità
## Piano di Migrazione
### Fase 1: Audit Completo
- [ ] Identificare tutti i file che usano `@livewire(\Modules\User\Http\Livewire\Auth\Login)`
- [ ] Mappare tutti i login-card e componenti simili
- [ ] Documentare le personalizzazioni esistenti
### Fase 2: Refactoring
- [ ] Sostituire tutti i riferimenti Livewire con widget Filament
- [ ] Aggiornare le props dei componenti
- [ ] Testare la compatibilità con i temi
### Fase 3: Testing
- [ ] Test funzionali di autenticazione
- [ ] Test di integrazione con temi AGID
- [ ] Test di performance e caricamento
### Fase 4: Cleanup
- [ ] Rimuovere componenti Livewire obsoleti
- [ ] Aggiornare documentazione
- [ ] Validare con PHPStan
## Implementazione Corretta
### Login-Card Aggiornato
    'title' => 'Accedi ai servizi',
    'subtitle' => 'Utilizza le tue credenziali per accedere all\'area riservata',
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
        <!-- Header Card con Colori AGID -->
        <div class="bg-blue-600 text-white px-6 py-4">
            <h1 class="text-2xl font-bold mb-2">{{ $title }}</h1>
            <p class="text-blue-100 text-sm">{{ $subtitle }}</p>
        </div>

        <!-- Body Card -->
        <div class="px-6 py-8">
            <!-- Widget Filament (STANDARD ARCHITETTURALE) -->
            @livewire($widgetClass)
        <!-- Footer Card con Info Assistenza -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <!-- Info assistenza -->
    </div>
### Utilizzo nei Layout
{{-- Uso corretto nei layout --}}
<x-pub_theme::blocks.forms.login-card
    title="Accedi al portale"
    subtitle="Area riservata cittadini"
    widgetClass="\Modules\User\Filament\Widgets\Auth\LoginWidget"
/>
## Validazione e Testing
### PHPStan
- Eseguire PHPStan livello 9+ dopo ogni refactoring
- Verificare tipizzazione corretta dei widget
### Test Funzionali
- Test di autenticazione con widget Filament
- Test di integrazione con temi AGID
- Test di compatibilità cross-browser
### Performance
- Benchmark di caricamento pagine
- Ottimizzazione asset e bundle
## Backlink e Riferimenti
- [best-practices/filament-widgets.md](best-practices/filament-widgets.md)
- [login_filament_widget_error.md](login_filament_widget_error.md)
- [../../Themes/Sixteen/docs/login-agid-correct-implementation.md](../../Themes/Sixteen/docs/login-agid-correct-implementation.md)
- [../../Themes/Sixteen/project_docs/login-agid-correct-implementation.md](../../Themes/Sixteen/project_docs/login-agid-correct-implementation.md)
---
**QUESTA È UNA REGOLA ASSOLUTA E INVIOLABILE**
*Ultimo aggiornamento: agosto 2025*
