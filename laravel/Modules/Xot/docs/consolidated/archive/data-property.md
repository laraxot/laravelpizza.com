# Proprietà `$data` in XotBaseWidget: COMPONENTE CRITICO DEL SISTEMA

## ⚠️ AVVISO CRITICO

**La rimozione della proprietà `public ?array $data = [];` da `XotBaseWidget` causa il FALLIMENTO COMPLETO del sistema Livewire in tutti i widget Filament del progetto.**

## Architettura Fondamentale

La proprietà `$data` è una componente centrale e non negoziabile dell'architettura Filament-Livewire. Ecco perché è fondamentale:

1. **Binding Dati Livewire**:
   - Tutti i form Filament utilizzano `wire:model="data.campo"` per collegare i campi di input
   - Livewire richiede OBBLIGATORIAMENTE che ogni proprietà collegata con `wire:model` sia dichiarata nella classe del componente
   - Senza questa proprietà, ogni tentativo di binding fallisce con l'errore `[wire:model="data.field"] property does not exist on component`

2. **Accesso ai Dati**:
   - I metodi nei widget come `register()`, `save()`, `submit()` accedono ai valori dei form tramite `$this->data['campo']`
   - Senza questa proprietà, i dati inviati dal form non sono accessibili e le operazioni falliscono

3. **Inizializzazione Form**:
   - `$this->form->fill()` in `mount()` inizializza i campi utilizzando la proprietà `$data`
   - Senza questa proprietà, i form non possono essere correttamente inizializzati

## Esempi di Utilizzo

### File Blade:
```blade
<form wire:submit.prevent="register">
    <x-filament::input.text wire:model="data.first_name" />
    <x-filament::checkbox wire:model="data.newsletter" />
</form>
```

### Classe Widget:
```php
public function register()
{
    // Accesso ai dati inseriti nel form
    $firstName = $this->data['first_name'] ?? null;
    $newsletter = $this->data['newsletter'] ?? false;
    
    // Operazioni con i dati
    if ($firstName) {
        // Logica di registrazione...
    }
}
```

## Errori Derivanti dalla Rimozione

Se la proprietà `$data` viene rimossa da `XotBaseWidget`, si verificano i seguenti errori:

1. **Errore di Proprietà Mancante**:
   ```
   Livewire: [wire:model="data.first_name"] property does not exist on component: [modules.user.filament.widgets.registration-widget]
   ```

2. **Errori di Accesso ai Dati**:
   ```
   Undefined array key "data" o Trying to access array offset on null
   ```

3. **Malfunzionamento Totale dei Widget**:
   - Nessun widget con form può funzionare
   - Impossibilità di inviare dati
   - Comportamento imprevedibile dell'UI

## 🚫 REGOLE ASSOLUTE

1. **MAI rimuovere la proprietà `$data` da `XotBaseWidget`**
2. **MAI ridichiarare la proprietà `$data` nelle classi derivate**
3. **MAI modificare il tipo della proprietà da `?array`**
4. **MAI modificare la visibilità da `public`**

## Procedura di Verifica

Prima di ogni commit che coinvolge `XotBaseWidget`, eseguire questo controllo:

```bash
grep -n "public ?array \$data" /var/www/html/base_<nome progetto>/laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php
```

Se il comando non restituisce risultati, LA PROPRIETÀ È STATA RIMOSSA e deve essere ripristinata immediatamente.

## Origine dell'Architettura

Questa struttura deriva dall'architettura Livewire+Filament in cui:

1. I componenti Livewire utilizzano proprietà pubbliche per il data binding
2. Filament standardizza il pattern utilizzando un array `$data` per organizzare tutti i valori dei form
3. `XotBaseWidget` implementa questo pattern per tutti i widget del progetto

## Collegamenti Correlati

- [Livewire Properties Documentation](https://livewire.laravel.com/project_docs/properties)
- [Filament Forms Documentation](https://filamentphp.com/project_docs/3.x/forms/installation)
- [RegistrationWidget Example](../../User/project_docs/filament/widgets/registration-widget.md)
