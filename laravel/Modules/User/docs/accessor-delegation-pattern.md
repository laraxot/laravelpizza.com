---
title: "Accessor Delegation Pattern (SACRO)"
type: pattern
tags: [accessor, delegation, pattern]
created: 2026-07-14
updated: 2026-07-14
qmd: "accessor-delegation-pattern accessor delegation pattern (sacro)"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-structure.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
  - "./actions-structure.md"
status: draft
---

# Accessor Delegation Pattern (SACRO)

Questo documento descrive il pattern di delegazione per gli accessor Eloquent con auto-persistenza, utilizzato per garantire performance e pulizia nei modelli del modulo User (es. BaseUser).

## Descrizione

Il pattern separa l'orchestrazione dell'accessor dalla logica di calcolo pura. Questo garantisce testabilità, performance e pulizia del codice.

### Struttura

1.  **Accessor (`getSomeValueAttribute`)**: Gestisce il controllo della cache (DB), l'orchestrazione e la persistenza silenziosa.
2.  **Metodo Puro (`getSomeValue`)**: Contiene la logica di calcolo complessa, senza dipendenze dal DB o effetti collaterali. Deve essere posizionato **vicino** all'accessor per facilità di lettura.

## Esempio

```php
protected function getSomeValueAttribute(?float $value): ?float
{
    if (is_float($value)) {
        return $value;
    }

    $result = $this->getSomeValue();

    if ($this->exists) {
        static::withoutEvents(function () use ($result): void {
            $this->update(['some_value' => $result]);
        });
    }

    return $result;
}

protected function getSomeValue(): float
{
    // Logica complessa...
    return 42.0;
}
```

---
**Riferimenti**:
- [Documento Canonico AI Agents](../../../../.agents/docs/accessor-auto-persistence.md)
- [INDEX.md](index.md)
