# Gestione delle Traduzioni dei Messaggi di Validazione

## Obiettivo
Fornire una guida completa per:
- Tradurre i messaggi di validazione standard e personalizzati
- Gestire la corrispondenza tra label e nome campo nei messaggi di errore
- Gestire array di campi e placeholder dinamici
- Scrivere messaggi di validazione user-friendly e localizzati

---

## 1. Messaggi di Validazione Standard

Laravel fornisce messaggi di default in `resources/lang/{lang}/validation.php`.  
**Consiglio:**  
- Usa il pacchetto [Laravel-Lang/lang](https://github.com/Laravel-Lang/lang) per avere traduzioni aggiornate e complete.
- Aggiorna i file con `composer require laravel-lang/common --dev` e `php artisan lang:add it`.

---

## 2. Personalizzazione dei Nomi dei Campi (attributes)

Quando il nome del campo non corrisponde alla label visualizzata, usa il metodo `attributes()` nella Form Request:

```php
public function attributes(): array
{
    return [
        'ordered_at' => __('order date'),
    ];
}
```
**Best practice:**  
- Usa sempre la funzione `__()` per permettere la localizzazione.
- Per array di campi:  
  ```php
  public function attributes(): array
  {
      return [
          'products.*.name' => __('product :position name'),
          'products.*.quantity' => __('product :position quantity'),
      ];
  }
  ```
  Usa `:index` o `:position` per mostrare l'indice umano (1-based).

---

## 3. Messaggi di Validazione Personalizzati

Per messaggi specifici, usa il metodo `messages()` nella Form Request:

```php
public function messages(): array
{
    return [
        'products.*.name.required' => __('Product :position is required'),
        'products.*.quantity.required' => __('Quantity is required'),
        'products.*.quantity.integer' => __('Quantity has to be a number'),
    ];
}
```
**Nota:**  
- La chiave è `campo.regola` (es. `products.*.name.required`)
- Il valore è il messaggio localizzato, puoi usare placeholder come `:attribute`, `:position`, `:index`, ecc.

---

## 4. Gestione degli Array di Campi

Per validare array di oggetti (es. prodotti in un ordine):

- Usa la notazione `products.*.name` nelle regole e negli attributi.
- Personalizza i messaggi per ogni campo/indice.
- Usa `:position` per mostrare l'indice umano (1, 2, 3...).

---

## 5. Esempio Completo

```php
class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer'],
            'ordered_at' => ['required', 'date'],
            'products' => ['required', 'array'],
            'products.*.name' => ['required', 'string'],
            'products.*.quantity' => ['required', 'integer'],
        ];
    }

    public function attributes(): array
    {
        return [
            'ordered_at' => __('order date'),
            'products.*.name' => __('product :position name'),
            'products.*.quantity' => __('product :position quantity'),
        ];
    }

    public function messages(): array
    {
        return [
            'products.*.name.required' => __('Product :position is required'),
            'products.*.quantity.required' => __('Quantity is required'),
            'products.*.quantity.integer' => __('Quantity has to be a number'),
        ];
    }
}
```

---

## 6. Best Practice e Checklist

- [ ] Usa sempre la funzione `__()` per i valori in `attributes()` e `messages()`
- [ ] Personalizza i nomi dei campi per una UX migliore
- [ ] Gestisci array di campi con `*` e placeholder `:position`
- [ ] Centralizza i messaggi comuni in `validation.php` e usa override solo se necessario
- [ ] Documenta le regole e le eccezioni in `/Modules/Lang/docs/validation-messages.md`
- [ ] Aggiorna la documentazione ogni volta che cambi la strategia di validazione

---

## 7. Modifiche consigliate ai file del progetto

- **resources/lang/it/validation.php** e **resources/lang/en/validation.php**  
  - Aggiorna/integra i messaggi standard con quelli del pacchetto Laravel-Lang.
  - Aggiungi eventuali override per messaggi custom usati spesso.
- **Form Request**  
  - Usa sempre `attributes()` e `messages()` per ogni form complesso.
  - Documenta la logica custom direttamente nella classe e nella doc del modulo.

---

## 8. FAQ e Problemi Comuni

- **Come tradurre i messaggi di validazione?**  
  Usa i file `validation.php` e i metodi `attributes()`/`messages()` nelle Form Request.
- **Come gestire array di campi?**  
  Usa la notazione `campo.*.sotto_campo` e placeholder `:position`.
- **Come evitare messaggi poco user-friendly?**  
  Personalizza sempre i nomi dei campi e i messaggi per i casi complessi.

---

## 9. Collegamenti correlati

- [translations-faq.md](./translations-faq.md)
- [TRANSLATION_KEYS_BEST_PRACTICES.md](./TRANSLATION_KEYS_BEST_PRACTICES.md)
- [translations-storage.md](./translations-storage.md)
- [translation-process.md](./translation-process.md)
- [README.md](./README.md) 
