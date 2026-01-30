# Best Practices per Widget Filament

## Struttura Corretta dei File e Namespace
### Posizionamento dei File
I widget Filament **DEVONO** essere posizionati nella seguente directory:
```
Modules/User/app/Filament/Widgets/  # Widget Filament
### Namespace Corretti
Il namespace corretto è `Modules\User\Filament\Widgets` (senza il segmento `app`):
```php
// ✅ CORRETTO
namespace Modules\User\Filament\Widgets;
// ❌ ERRATO
namespace Modules\User\App\Filament\Widgets;
### Estensione di XotBaseWidget
Tutti i widget Filament devono estendere `XotBaseWidget`:
use Modules\Xot\Filament\Widgets\XotBaseWidget;
class UserStatsWidget extends XotBaseWidget
{
    // Implementazione
}
## Gestione Dati
### 1. Validazione dei Dati
{{ $record-> }} // Sintassi incompleta
{{ $record?->property ?? 'Valore di default' }}
### 2. Gestione dello Stato Null
{{ $record->name }} // Può causare errori se $record è null
{{ optional($record)->name ?? 'Non specificato' }}
## Struttura Widget
### 1. Template Base
<x-filament::widget>
    <x-filament::card>
        @if($record)
            {{-- Contenuto widget --}}
        @else
            <x-filament::empty-state
                icon="heroicon-o-user"
                heading="Nessun utente selezionato"
                description="Seleziona un utente per visualizzare i dettagli"
            />
        @endif
    </x-filament::card>
</x-filament::widget>
### 2. Gestione Errori
@php
    try {
        $value = $record->property;
    } catch (\Exception $e) {
        \Log::error('Errore widget: ' . $e->getMessage());
        $value = null;
    }
@endphp
## Best Practices
### 1. Validazione Input
- Verificare sempre l'esistenza dei dati
- Utilizzare il null coalescing operator
- Implementare valori di default
- Utilizzare try-catch per operazioni rischiose
- Loggare gli errori appropriatamente
- Fornire feedback all'utente
### 3. Performance
- Evitare query n+1
- Utilizzare eager loading
- Implementare caching dove appropriato
### 4. Testing
public function testWidgetRendering()
    $user = User::factory()->create();

    $this->get(route('filament.resources.users.view', $user))
        ->assertSuccessful()
        ->assertSee($user->name);
### 5. Integrazione con Filtri Dashboard
- Utilizzare accesso sicuro ai filtri della pagina
- Implementare fallback appropriati quando i filtri non sono disponibili
- Verificare sempre l'esistenza di `$this->filters` prima dell'accesso
- Vedere: [Dashboard Filters Integration](../filament/widgets/dashboard-filters-integration.md)
## Checklist di Verifica
1. [ ] I dati sono validati prima dell'uso
2. [ ] Gli stati null sono gestiti appropriatamente
3. [ ] Gli errori sono catturati e loggati
4. [ ] Il widget è testato
5. [ ] Le performance sono ottimizzate
## Implementazione del Polling
Per implementare il polling automatico nei widget Filament, utilizzare il trait `CanPoll`:
use Filament\Widgets\Concerns\CanPoll;
    use CanPoll;
    // Personalizzare l'intervallo di polling (default: 5s)
    protected static ?string $pollingInterval = '30s';
    protected function getPollingInterval(): ?string
    {
        return static::$pollingInterval;
    // Il contenuto del widget verrà aggiornato automaticamente
    public function getFormSchema(): array
        // Schema del form che verrà aggiornato automaticamente
        return [
            'active_users' => TextInput::make('active_users')
                ->default($this->getActiveUsers())
                ->disabled()
                ->hint('Aggiornato automaticamente ogni 30 secondi'),
        ];
    private function getActiveUsers(): int
        // Logica per ottenere il numero di utenti attivi
        return User::where('last_active_at', '>', now()->subMinutes(5))->count();
## Collegamenti Bidirezionali
### Modulo Xot (Core)
- [README.md](../../../Xot/docs/README.md) - Indice principale della documentazione
- [Widget Filament](../../../Xot/docs/filament/widgets/xot-base-widget.md) - Documentazione su XotBaseWidget
- [Polling nei Widget](../../../Xot/docs/filament/widgets/FILAMENT_WIDGETS_POLLING.md) - Implementazione del polling
### Moduli Correlati
- [Cms - Convenzioni Namespace Filament](../../../Cms/docs/convenzioni-namespace-filament.md) - Convenzioni per i namespace Filament
- [Lang - Filament Translations](../../../Lang/docs/filament-translations.md) - Traduzioni in Filament
- [UI - Form Filament Widgets](../../../UI/docs/form_filament_widgets.md) - Widget per form Filament
- [README.md](../../../Xot/project_docs/README.md) - Indice principale della documentazione
- [Widget Filament](../../../Xot/project_docs/filament/widgets/xot-base-widget.md) - Documentazione su XotBaseWidget
- [Polling nei Widget](../../../Xot/project_docs/filament/widgets/FILAMENT_WIDGETS_POLLING.md) - Implementazione del polling
- [Cms - Convenzioni Namespace Filament](../../../Cms/project_docs/convenzioni-namespace-filament.md) - Convenzioni per i namespace Filament
- [Lang - Filament Translations](../../../Lang/project_docs/filament-translations.md) - Traduzioni in Filament
- [UI - Form Filament Widgets](../../../UI/project_docs/form_filament_widgets.md) - Widget per form Filament
### Documentazione Interna
- [README del modulo User](../README.md) - Indice principale del modulo User
- [Filament Best Practices](../FILAMENT_BEST_PRACTICES.md) - Best practices generali per Filament
## Risorse Utili
- [Documentazione Filament](https://filamentphp.com/docs)
- [Laravel Blade](https://laravel.com/docs/blade)
- [Laravel Blade](https://laravel.com/project_docs/blade)
- [Livewire](https://livewire.laravel.com/docs)
