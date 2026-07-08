# File Duplicati Case-Sensitive - Rapporto di Pulizia

**Data**: 2026-02-24  
**Autore**: AI Agent  
**Tipo**: Manutenzione archivio

## Problema

Su filesystem case-sensitive (Linux) non possono esistere file con nomi che differiscono solo per il case (es. `File.php` e `file.php`). Su macOS/Windows (case-insensitive) questi file possono coesistere causando problemi quando il codice viene spostato su server Linux.

## Regola

**Tutti i file di test devono usare PascalCase seguendo lo standard PSR-4:**

- ✅ `GenerateDbDocumentationCommandTest.pest.php`
- ❌ `generatedbdocumentationcommandtest.pest.php` (vietato - lowercase)

## File Duplicati Trovati e Rinominati (.old)

| File Rinominato (lowercase/duplicato) | File Mantenuto (PascalCase) | Percorso |
|----------------------------------------|------------------------------|----------|
| `metatagdatatest.php.old` | `MetatagDataTest.php` | `laravel/Modules/Xot/tests/Unit/` |
| `hasxottabletest.test.old` | `HasXotTableTest.php` | `laravel/Modules/Xot/tests/Unit/` |
| `HasXotTableTest.test.old` | `HasXotTableTest.php` | `laravel/Modules/Xot/tests/Unit/` |

## Comando di Verifica

Per trovare file duplicati case-sensitive in futuro:

```bash
# Cerca file duplicati (case-insensitive) nei test
find ./laravel -type f -name "*.php" | grep -v vendor | awk '{print tolower($0) " " $0}' | sort | uniq -d -f1

# Lista tutti i file di test
find ./laravel -type f -name "*test*.php" -o -name "*Test*.php" | grep -v vendor | sort
```

## Riferimenti

- [AGENTS.md](../AGENTS.md) - Naming Conventions
- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)

---

**Stato**: Completato ✅  
**File rinominati con `.old`**: 3

## Nota sulla Procedura

Invece di cancellare i file duplicati, è preferibile **rinominarli aggiungendo `.old`** per:
1. **Backup di sicurezza** - Possibilità di ripristino se necessario
2. **Audit trail** - Tracciamento delle modifiche
3. **Verifica** - Controllo che il file PascalCase funzioni correttamente prima della rimozione definitiva

Per rimuovere definitivamente i file `.old` dopo il periodo di verifica:

```bash
# Trova e rimuovi tutti i file .old
find ./laravel -type f -name "*.old" -exec rm {} \;
```
