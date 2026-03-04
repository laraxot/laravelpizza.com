# Debug Autenticazione - Login Widget

## Introduzione
Questo documento serve come guida per il troubleshooting dei problemi di login, specialmente quando si usano i widget Filament invece delle pagine standard.

## Discrepanza tra Login Page e Login Widget

Nel sistema Laraxot, esistono due modi per gestire l'autenticazione:
1.  **Standard Page**: `Modules\User\Http\Livewire\Auth\Login.php`
2.  **Themed Widget**: `Modules\User\Filament\Widgets\Auth\LoginWidget.php`

Mentre la pagina standard è usata nelle rotte amministrative o in layout semplici, il **Widget** è la scelta preferita per i temi (come Sixteen) dove il login è integrato in una pagina Folio.

## Problemi Comuni

### 1. Form non popolato / Validazione fallita
**Sintomo**: L'utente inserisce email e password, ma il sistema restituisce "L'indirizzo email è obbligatorio".
**Causa**: Mancanza del metodo `mount()` con chiamata a `$this->form->fill()`.
**Soluzione**: Assicurarsi che `XotBaseWidget` (o il widget specifico) chiami `fill()` nel `mount()`.

### 2. State Path Mismatch
**Sintomo**: I dati non vengono salvati o catturati.
**Causa**: Confusione tra `$this->data` e proprietà dirette.
**Regola**: Usare sempre `$schema->statePath('data')` e definire `public array $data = []`.

### 3. Namespace components
**Sintomo**: Errori di rendering.
**Causa**: Uso di componenti `Filament\Forms` dentro uno `Schema` che si aspetta componenti compatibili o viceversa.
**Soluzione**: In Filament 4, verificare sempre le importazioni (`use Filament\Forms\Components\...`).

## Checklist di Troubleshooting
- [ ] Il componente estende `XotBaseWidget`?
- [ ] Il metodo `mount()` è presente e chiama `fill()`?
- [ ] Il metodo `schema()` (o `form()`) definisce lo `statePath('data')`?
- [ ] La view usa `{{ $this->form }}`?
- [ ] Il bottone di submit chiama il metodo corretto (`wire:submit="login"`)?

---
*Documentazione conforme agli standard Laraxot*
