# Elenco metodi relazione duplicate

> Modulo: Sigma + consumer
> Generato: 2026-06-15

## Metodi HasMany con pattern ente+matr+ann

| Modulo | Model | Metodo | File | Linea | Pattern |
|--------|-------|--------|------|-------|---------|
| Incentivi | Employee | qua00f() | Employee.php | 144 | hardcoded ente/matr |
| Incentivi | Employee | rep00f() | Employee.php | 188 | hardcoded ente/matr |
| IndennitaResponsabilita | LettF | qua00fRetribuzioneDateRange() | LettF.php | 371 | ofRangeDate (✅ corretto) |
| IndennitaResponsabilita | LettF | rep00fByAnno() | LettF.php | 340 | ofYear (✅ corretto) |
| Progressioni | Assenza | asz00fs() | Assenza.php | 67 | ente+ann="" |
| Sigma | Asz00k1 | qua00fsimple() | Asz00k1.php | 219 | ente+ann="" |
| Sigma | Asz00k1 | qua00f() | Asz00k1.php | 231 | ente+ann="" |
| Sigma | Qua00f | dipt00f() | Qua00f.php | 240 | ente+matr+ann="" |
| Sigma | Qua00f | rep00f() | Qua00f.php | 308 | ente+matr+ann="" |
| Sigma | Rep00f | qua00f() | Rep00f.php | 255 | ente+matr+ann="" (❌ typo metodo) |
| Sigma | Wstr02f | wmen00f() | Wstr02f.php | 251 | **usa enteField/matrField** (✅) |

## Analisi

- **Pattern duplicato:** 11 modelli ripetono `->where('ente', $this->ente)`
- **Pattern duplicato:** 11 modelli usano `->whereRaw('xxxann=""')`
- **Soluzione esistente:** Wstr02f usa `$this->enteField()` e `$this->matrField()`

## Refatoring richiesto

Sostituire:
```php
->where('ente', $this->ente)
->where('matr', $this->matr)
```

Con:
```php
->where($this->enteField(), $this->{$this->enteField()})
->where($this->matrField(), $this->{$this->matrField()})
```