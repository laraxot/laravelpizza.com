# Correzioni Errori di Sintassi - Modulo UI

## Problema Risolto: UiBasePolicy.php

### Errore Originale
```php
// ERRORE: Metodi orfani fuori dalla classe
abstract class UiBasePolicy
{
    use HandlesAuthorization;

            return true;  // ❌ Fuori da qualsiasi metodo
        }

        return null;     // ❌ Fuori da qualsiasi metodo
    }
```

### Causa
Il file aveva istruzioni `return` che non appartenevano a nessun metodo, causando errori di sintassi PHP:
- `Syntax error, unexpected T_RETURN on line 14`
- `Syntax error, unexpected '}', expecting EOF on line 18`

### Soluzione Implementata
```php
// ✅ CORRETTO: Metodo before() completo
abstract class UiBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $_ability): null|bool
    {
        $xotData = XotData::make();
        if ($user->hasRole('super-admin')) {
            return true;
        }

        return null;
    }
}
```

### Pattern Seguito
La correzione segue il pattern standard delle policy base del progetto:
- Estende `HandlesAuthorization` trait
- Implementa metodo `before()` per controlli di autorizzazione globali
- Usa `UserContract` per type safety
- Restituisce `true` per super-admin, `null` per altri utenti

### File Correlati
- `Modules/User/app/Models/Policies/UserBasePolicy.php` - Pattern di riferimento
- `Modules/Xot/Contracts/UserContract.php` - Interface utilizzata
- `Modules/Xot/Datas/XotData.php` - Data class per configurazione

### Best Practices Applicate
1. **Type Safety**: Return type `null|bool` esplicito
2. **Strict Types**: `declare(strict_types=1);` presente
3. **Namespace Corretto**: `Modules\UI\Models\Policies`
4. **Import Necessari**: Solo quelli utilizzati
5. **Documentazione**: PHPDoc per metodi pubblici

### Test di Verifica
- ✅ PHPStan livello 10: Nessun errore
- ✅ Sintassi PHP: Valida
- ✅ Pattern Consistency: Allineato con altre policy base

## Prevenzione Errori Futuri

### Controlli Automatici
- Utilizzare sempre editor con linting attivo
- Verificare sintassi prima di ogni commit
- Controllare che tutti i metodi siano dentro le classi

### Pattern da Seguire
- Ogni metodo deve essere dichiarato **all'interno** della classe
- La chiusura della classe (`}`) deve essere l'ultima istruzione del file
- Dopo ogni refactor, controllare che non restino metodi orfani

### Filosofia
La coerenza strutturale del codice è fondamentale per la manutenibilità e la prevenzione di bug sistemici. Ogni correzione va documentata per prevenire regressioni future.
