# Troubleshooting

## Common Issues

Per i problemi generali fare riferimento alla [Xot Troubleshooting Guide](../../Xot/docs/troubleshooting.md).

### Activity Log + Accessor/Mutator che salvano valori

Sigma utilizza accessor/mutator per calcolare e **cachare** valori derivati (es. tramite `EnteMatrMutator`).  
Questi metodi possono salvare in DB usando `update()` ma, in presenza del trait `LogsActivity`, è fondamentale evitare loop e errori tipo:

- `Attempt to read property "attributeRawValues" on null` (Spatie Activity Log)

Pattern adottato:

- guard su PK: salvare solo se `$this->getKey() != null`
- wrapping delle scritture in `static::withoutEvents(...)` per non triggherare nuovamente gli eventi Eloquent durante la lettura degli attributi da parte di Activity Log.

Per i dettagli vedere:

- [Errore attributeRawValues null – Activity](../../Activity/docs/errori/attributerawvalues-null-firstorcreate.md)
- [BaseScheda - Configurazione Activity Log](../../Ptv/docs/models/base-scheda-activity-log.md)
