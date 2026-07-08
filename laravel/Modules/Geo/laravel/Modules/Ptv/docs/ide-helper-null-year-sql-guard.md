# ide-helper Null Year SQL Guard

## Problem
Durante analisi/reflection (`ide-helper:models`) alcuni modelli possono essere idratati parzialmente (`anno` nullo). In questo stato, la costruzione SQL dinamica può generare frammenti invalidi.

## Change
In `Modules/Ptv/app/Models/StabiDirigente.php` è stata aggiunta una guard clause in `getNomeDiriAttribute()`:
- se `anno` non è un intero positivo, ritorna il valore corrente senza costruire SQL.

## Why
Questo evita SQL malformata con pattern tipo:
- `( between year(qua2kd) and year(qua2ka) )`
- `( >= year(qua2kd) and qua2ka=0 )`

## Tracking
- Issue collegata: https://github.com/provtv/base_ptv_fila5_mono/issues/49
- Discussion centrale: https://github.com/provtv/base_ptv_fila5_mono/discussions/18
