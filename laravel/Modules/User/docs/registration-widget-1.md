# Registration Widget Documentation

## Overview

Il file `RegistrationWidget.php` si trova in `Modules/User/app/Filament/Widgets/RegistrationWidget.php`. Questo widget è utilizzato per la registrazione di diversi tipi di utenti in applicazioni basate su Laravel con Filament. Il modulo `User` è progettato per essere riutilizzabile in vari progetti, quindi la logica del widget deve essere flessibile e adattabile a contesti diversi.

## Current Issues

Dopo aver esaminato il codice, ho notato che manca la parte relativa al salvataggio vero e proprio dei dati dell'utente e all'impostazione dello stato dell'utente dopo la registrazione. Questo è essenziale per completare il flusso di registrazione. Inoltre, il widget deve gestire diversi tipi di utenti, quindi la logica di salvataggio deve essere configurabile in base al tipo di utente specificato tramite la proprietà `$type`.

## Recent Updates

Recentemente, il codice è stato aggiornato per introdurre una strategia più dinamica e modulare:
- **Importazione di `Illuminate\Support\Str`**: Per manipolare stringhe e creare dinamicamente il nome della classe di azione.
- **Nuove proprietà `$model` e `$action`**: Definite nel metodo `mount()` per determinare il modello associato al tipo di utente e l'azione di registrazione corrispondente (ad esempio, `Modules\Patient\Actions\Doctor\RegisterAction`).
- **Metodo `register()` aggiornato**: Ora utilizza un'azione personalizzata (`app($this->action)->execute($data)`) invece di implementare direttamente la logica di salvataggio, permettendo una maggiore flessibilità e riutilizzabilità.

## Recommended Modifications

Di seguito sono riportati i consigli per modificare `RegistrationWidget.php` al fine di includere il salvataggio dei dati e l'impostazione dello stato, mantenendo la flessibilità per l'uso in diversi progetti:

1. **Utilizzo di Azioni Dinamiche**:
   - Continuare a utilizzare la strategia basata su `$action` per delegare la logica di registrazione a classi specifiche come `Modules\Patient\Actions\Doctor\RegisterAction` o `Modules\Patient\Actions\Patient\RegisterAction`.

2. **Impostazione dello Stato dell'Utente**:
   - Assicurarsi che ogni azione personalizzata gestisca lo stato dell'utente in base al tipo e al contesto del progetto.

3. **Gestione del Workflow (se applicabile)**:
   - Nelle azioni personalizzate, implementare la logica per i workflow di moderazione o altri passaggi specifici del progetto.

4. **Notifica o Reindirizzamento**:
   - Configurare le azioni per gestire notifiche o reindirizzamenti in modo personalizzato per ogni tipo di utente.

### Example Code

```php
public function register()
{
    $data = $this->form->getState();
    app($this->action)->execute($data);
    session()->flash('message', 'Registrazione completata con successo.');
    return redirect()->route($this->getConfirmationRoute());
}

public function mount(string $type): void
{
    $this->type = $type;
    $this->resource = XotData::make()->getUserResourceClassByType($type);
    $this->model = $this->resource::getModel();
    $this->action = Str::of($this->model)->replace('\\Models\\', '\\Actions\\')->append('\\RegisterAction')->toString();
    $this->form->fill();
}

protected function getConfirmationRoute(): string
{
    // Route configurabile in base al progetto
    $mapping = app()->make('user_route_mapping') ?? [];
    return $mapping[$this->type] ?? 'user.registration.confirmation';
}
```

## References

- [Namespace Issues](../../../docs/references/namespace-issues.md)
- [Filament Resource Guidelines](../../../Modules/Xot/docs/rules/filament-resource-guidelines.md)
