# REGOLA CRITICA: Cartelle docs root VIETATE

## CARTELLE CHE NON DEVONO MAI ESISTERE:
- `/var/www/html/_bases/base_<nome progetto>/docs` ❌ VIETATA ASSOLUTA
- `/var/www/html/_bases/base_<nome progetto>/laravel/docs` ❌ VIETATA ASSOLUTA

## REGOLA FONDAMENTALE:
**TUTTA la documentazione va SOLO nelle cartelle `docs` dei moduli specifici**

## AZIONI VIETATE:
- ❌ NON creare MAI queste cartelle root docs
- ❌ NON spostare documentazione in cartelle root
- ❌ NON fare riferimenti a documentazione in cartelle root

## AZIONI OBBLIGATORIE:
- ✅ Se esistono, spostare IMMEDIATAMENTE il contenuto nei moduli appropriati
- ✅ Eliminare le cartelle vuote
- ✅ Aggiornare tutti i riferimenti

## DOVE SPOSTARE LA DOCUMENTAZIONE:
- **Traduzioni** → `Modules/Xot/project_docs/` (modulo che gestisce le traduzioni)
- **Frontend** → `Modules/Cms/project_docs/` (modulo frontend)  
- **Audit generali** → `Modules/Xot/project_docs/` (modulo base)
- **Modulo specifico** → `Modules/{NomeModulo}/project_docs/`

## PRIORITÀ: MASSIMA
Questa regola ha priorità assoluta su qualsiasi altra considerazione.

## CONTROLLI AUTOMATICI:
```bash
# Comando per verificare che non esistano cartelle docs root
find /var/www/html/_bases/base_<nome progetto> -maxdepth 2 -name "docs" -type d | grep -E "(^/var/www/html/_bases/base_<nome progetto>/docs$|^/var/www/html/_bases/base_<nome progetto>/laravel/docs$)"
# Se il comando restituisce output = ERRORE CRITICO
# Se il comando non restituisce output = OK
```

## DATA IMPLEMENTAZIONE:
2025-08-08 - Regola implementata e verificata

## RESPONSABILITÀ:
Tutti gli sviluppatori e AI devono rispettare questa regola senza eccezioni.
