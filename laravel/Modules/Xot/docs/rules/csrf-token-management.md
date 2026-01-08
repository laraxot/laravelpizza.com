# Gestione Token CSRF nei Widget XotBase

## Descrizione
I widget che estendono `XotBaseWidget` devono gestire correttamente il token CSRF per le richieste AJAX di Livewire.

## Contesto
Livewire utilizza richieste AJAX per le interazioni dinamiche. Ogni richiesta deve includere un token CSRF valido per la sicurezza.

## Regole
1. Ogni widget deve estendere `XotBaseWidget`
2. Il token CSRF deve essere gestito nel metodo `mount()`
3. La vista deve includere il token CSRF nel form
4. Il meta tag CSRF deve essere presente nel layout principale

## Implementazione
```php
class MyWidget extends XotBaseWidget
{
    public string $_token;

    public function mount(): void
    {
        $this->_token = csrf_token();
    }
}
```

```blade
<div>
    @csrf
    <form wire:submit.prevent="submit">
        {{ $this->form }}
    </form>
</div>
```

## Best Practices
1. Non utilizzare direttamente `@csrf` nella vista, ma passare il token tramite il widget
2. Verificare sempre la presenza del token prima di ogni richiesta AJAX
3. Utilizzare il trait `HasCsrfToken` per la gestione centralizzata
4. Mantenere aggiornate le dipendenze Livewire

## Collegamenti Correlati
- [Documentazione Livewire](https://livewire.laravel.com/docs/security)
- [Documentazione Laravel CSRF](https://laravel.com/docs/csrf)
- [XotBaseWidget Implementation](../xot_base_classes.md)

## Esempio di Correzione
```php
// Widget
class FindDoctorAndAppointmentWidget extends XotBaseWidget
{
    public string $_token;

    public function mount(): void
    {
        $this->_token = csrf_token();
    }
}

// View
<div>
    @csrf
    <form wire:submit.prevent="submit">
        {{ $this->form }}
    </form>
</div>
```

## Checklist di Verifica
- [ ] Widget estende XotBaseWidget
- [ ] Token CSRF gestito nel mount()
- [ ] Token presente nella vista
- [ ] Meta tag CSRF nel layout
- [ ] Dipendenze Livewire aggiornate 