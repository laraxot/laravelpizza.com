# Pattern DRY+KISS: getSpecificRecord()

## Descrizione

Il pattern `getSpecificRecord()` è un esempio pratico di applicazione dei principi DRY (Don't Repeat Yourself) e KISS (Keep It Simple, Stupid) nella gestione dei record nelle pagine Filament.

## Problema

Nelle pagine Filament che estendono `XotBasePage`, il record è spesso accessibile tramite `$this->record`, ma questo può causare:
1. Errori di tipo quando il record potrebbe essere null
2. Duplicazione di codice di controllo in più metodi
3. Codice meno leggibile e più fragile

## Soluzione DRY+KISS

Creare un metodo protetto che centralizza il controllo di tipo e lancia un'eccezione se il record non è valido:

```php
/**
 * Get the record instance narrow-typed to IndennitaResponsabilita.
 */
protected function getSpecificRecord(): IndennitaResponsabilita
{
    if (! $this->record instanceof IndennitaResponsabilita) {
        throw new \LogicException('Record is missing or invalid.');
    }

    return $this->record;
}
```

## Vantaggi

1. **DRY**: Il controllo di tipo è centralizzato in un unico metodo
2. **KISS**: Codice semplice con early throw per gestire errori
3. **Type Safety**: Il metodo ritorna sempre il tipo corretto, eliminando necessità di cast ripetuti
4. **Manutenibilità**: Se la logica di validazione cambia, si modifica in un solo punto

## Utilizzo

```php
protected function fillFormWithInitialData(): void
{
    $record = $this->getSpecificRecord();
    $this->form->fill([
        'matr' => $record->matr,
        'cognome' => $record->cognome,
        'nome' => $record->nome,
    ]);
}

protected function authorizeAccess(): void
{
    Gate::authorize('update', $this->getSpecificRecord());
}
```

## Implementazione di Riferimento

- File: `Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`
- Metodo: `getSpecificRecord()` (righe 44-53)

## Collegamenti

- [docs/DRY-KISS-PATTERNS.md](./DRY-KISS-PATTERNS.md)
- [docs/PHPSTAN-LEVEL10.md](./PHPSTAN-LEVEL10.md)
