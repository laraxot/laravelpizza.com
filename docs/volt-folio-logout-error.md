# Errore Volt/Folio: `VoltDirectiveMissingException` su logout

## Descrizione dell'errore
Quando si crea una pagina con azioni Volt/Livewire (es. logout) all'interno di una pagina Folio (file-based routing), può comparire il seguente errore:

```
Livewire\Volt\Exceptions\VoltDirectiveMissingException
The [@volt] directive is required when using Volt anonymous components in Folio pages. The directive is missing in [.../logout.blade.php].
```

## Causa
Folio richiede che tutte le pagine che usano Volt (azioni, state, ecc.) includano la direttiva `@volt` all'inizio del file Blade. Senza questa direttiva, Volt non può "montare" correttamente la logica Livewire associata alla pagina.

## Come risolvere
1. **Aggiungi la direttiva `@volt` come prima riga del file Blade** che utilizza Volt/Livewire:
   
   ```blade
   @volt
   ...
   ```
2. **Verifica che tutte le pagine Folio che usano state, mount, azioni Livewire, ecc. abbiano `@volt` come prima riga.**
3. **Non serve altro:** la direttiva `@volt` è sufficiente per abilitare Volt nella pagina.

## Esempio di fix
Prima (sbagliato):
```blade
<?php
use function Livewire\Volt\{state, mount};
// ...
```

Dopo (corretto):
```blade
@volt
<?php
use function Livewire\Volt\{state, mount};
// ...
```

## Best practice
- Ricordati sempre di aggiungere `@volt` in tutte le Folio pages che usano logica Volt/Livewire.
- Documenta questa regola nelle guide interne del team.

---

**Errore risolto: aggiungi `@volt` come prima riga!**
=======
