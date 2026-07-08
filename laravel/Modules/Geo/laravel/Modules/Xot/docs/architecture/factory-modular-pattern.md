# Pattern Factory Modulare - Laraxot PTVX

Questa guida definisce come gestire le Factory in un'architettura modulare, specialmente quando i modelli estendono classi del vendor (es. Laravel Passport).

## 1. Il Problema con i Vendor
Quando un modello di modulo estende un modello del vendor (es. `OauthClient` estende `PassportClient`), eredita anche la Factory del vendor.
- **Rischio**: I test potrebbero usare la factory originale che punta alla connessione DB sbagliata o manca di personalizzazioni locali.
- **Connessione**: Le factory vendor ignorano spesso il pattern multi-database `_test`.

## 2. Pattern Obbligatorio
Per garantire che `Model::factory()` restituisca la factory del modulo:

### A. Tag PHPDoc (per IDE Support)
Rimuovere il riferimento alla factory del vendor e puntare a quella del modulo.
```php
/**
 * @method static \Modules\Module\Database\Factories\ModelFactory factory($count = null, $state = [])
 */
```

### B. Implementazione Runtime
Usare il trait `HasXotFactory` o sovrascrivere `newFactory()`.
```php
use Modules\Xot\Models\Traits\HasXotFactory;

class MyModel extends VendorModel {
    use HasXotFactory; // Gestisce automaticamente la risoluzione nel modulo
}
```

## 3. Cosa NON fare (Anti-patterns)
- ❌ Importare `Laravel\Passport\Database\Factories\ClientFactory` nei modelli di modulo.
- ❌ Lasciare che l'IDE suggerisca la factory del vendor.
- ❌ Usare `HasFactory` standard senza `newFactory()` in modelli con namespace profondi.

## 4. Perché rimuovere ClientFactory (Passport)?
Nel file `Modules/User/app/Models/OauthClient.php`, togliere `ClientFactory` di Passport ha senso perché:
1. **Isolamento**: Vogliamo usare la nostra `OauthClientFactory` definita nel modulo.
2. **DX**: Evita suggerimenti ambigui nell'IDE.
3. **Coerenza**: Il progetto usa `user` come connessione per questi modelli, la factory vendor userebbe `default`.
