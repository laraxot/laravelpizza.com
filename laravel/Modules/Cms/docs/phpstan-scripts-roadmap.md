# PHPStan Legacy Scripts Status

**Modulo**: Cms  
**Scope**: `../../../bashscripts/cms/generate_test_data.php`, `../populate_database_comprehensive.php`  
**Verifica aggiornata**: 2026-03-12  
**Status**: ✅ `No errors` su entrambi i file

## Stato verificato

La verifica mirata eseguita con:

```bash
cd ./laravel
./vendor/bin/phpstan analyse --no-progress ../bashscripts/cms/generate_test_data.php Modules/Cms/populate_database_comprehensive.php
```

restituisce oggi:

```text
[OK] No errors
```

Questo documento sostituisce la vecchia roadmap che fotografava un backlog storico di errori `mixed` non piu' riprodotto nello stato attuale del repository.

## Pattern di fix da mantenere

Quando questi script legacy tornano a generare errori PHPStan, il pattern corretto nel modulo Cms resta questo:

1. fare type narrowing subito dopo bootstrap o `require` che ritornano `mixed`;
2. introdurre array shape esplicite per strutture come `$results`;
3. usare helper privati tipizzati per normalizzare record count, payload di esito e iterable;
4. preferire controlli runtime piccoli e locali invece di `@phpstan-ignore-*`;
5. evitare cast generici non necessari e modellare invece i dati con tipi piu' stretti.

## Pattern consigliati

### Bootstrap Laravel

Annotare il container applicativo con un tipo concreto prima di usare `make()` o `bootstrap()`.

### Results payload
**

Per i riepiloghi finali usare shape esplicite, per esempio:

```php
/** @phpstan-type ScriptResult array{
 *     status: 'success'|'failed'|'error',
 *     count?: int,
 *     reason?: string,
 *     error?: string,
 *     factory?: class-string
 * }
 */
```

### Factory e callback

Se un callback puo' restituire collezioni, array o singoli record, conviene passare da un helper che produca sempre un `int` count tipizzato. Questo evita accessi offset o `count()` su `mixed`.

## Nota operativa

Su questi due file non e' stata applicata una patch di codice in questa sessione, perche' il gate PHPStan corrente e' gia' verde e una modifica cosmetica ai legacy script avrebbe aumentato il rischio senza chiudere un errore reale.
### ⏳ In Lavoro

**`populate_database_comprehensive.php`** - **0/10 errori risolti**
- ⏳ Type narrowing per `$app` (riga 35)
- ⏳ Type narrowing per factory calls (righe 81, 117, 119, 194)
- ⏳ Type assertions per array access (righe 233, 240, 241)

---

## 📈 Statistiche

- **Errori iniziali**: 32
- **Errori risolti**: 21
- **Errori rimanenti**: 11
- **Progresso**: 65.6% ✅

---

## 🔧 Note Tecniche

### Problema Rimanente in `generate_test_data.php`

**Riga 122**: `Cannot call method create() on mixed`

**Causa**: Il metodo `count(100)->create()` viene chiamato su un oggetto `mixed` perché PHPStan non può inferire il tipo del risultato di `count()`.

**Soluzioni tentate**:
1. Type assertion `object&callable` - Non risolve
2. `call_user_func` - Non risolve
3. Type narrowing con `method_exists` - Non sufficiente

**Prossimi passi**: Usare un approccio diverso, possibilmente con un'interfaccia o trait che definisca il tipo del factory.

---

**