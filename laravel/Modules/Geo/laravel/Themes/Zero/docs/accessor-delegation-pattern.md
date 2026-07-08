# 🧘 Accessor Delegation Pattern - Zero Theme

> **Pattern per accessor nel Zero Theme**
> **Aggiornato**: 2026-04-01
> **Versione**: 1.0

---

## 🎯 Panoramica

Questo documento applica il **pattern di delega accessor** al Zero Theme, basato sul lavoro completato nel modulo Sigma (22/22 accessor refactorizzati).

**Regola SACRA**: 
> Il metodo puro `get<Nome>()` deve vivere **VICINO** all'accessor `get<Nome>Attribute()`, idealmente nelle stesse 50 righe di codice.

---

## 📊 Riferimenti

La documentazione completa si trova nel modulo Sigma:

- **Guida Completa**: `laravel/Modules/Sigma/docs/accessor-delegation-complete-guide.md`
- **Pattern**: `laravel/Modules/Sigma/docs/accessor-delegation-pattern.md`
- **Audit**: `laravel/Modules/Sigma/docs/accessor-delegation-audit.md`

---

## 📋 Template per Zero Theme

```php
/**
 * Helper method: [Descrizione calcolo] (calcolo puro).
 *
 * Business Rule: [Spiegazione regola business specifica per il theme]
 *
 * @return [Tipo]|[null] [Descrizione risultato], null se [condizione]
 */
protected function get<Nome>(): [Tipo]|null
{
    // ✅ SOLO calcolo puro (max 50 righe)
}

/**
 * Accessor per <snake_case_nome> ([descrizione]).
 * Delega calcolo a get<Nome>().
 *
 * @param [Tipo]|null $value Valore cached dal DB
 *
 * @return [Tipo]|[null] [Descrizione risultato] calcolato
 */
protected function get<Nome>Attribute([Tipo]|null $value): [Tipo]|null
{
    // ✅ Cache hit
    if ([controllo tipo]) {
        return $value;
    }

    // ✅ Guard: modello deve avere PK
    if (null == $this->getKey()) {
        return null;
    }

    // ✅ Delega al metodo puro (VICINO!)
    $value = $this->get<Nome>();

    if (null === $value) {
        return null;
    }

    // ✅ Persist con update chirurgico
    $this->update(['<snake_case_nome>' => $value]);

    return $value;
}
```

---

## 🔗 Indici Documentazione

Per prevenire duplicati, consulta sempre:

1. **Indice Principale**: `docs/README.md` (questo file)
2. **Indice Moduli**: `laravel/Modules/Sigma/docs/README.md`
3. **Indice Progetto**: `docs/project/README.md`

---

*Documento creato: 2026-04-01*
*Ultimo aggiornamento: 2026-04-01*
*Stato: ✅ Allineato con Sigma Module (22/22 accessor)*
