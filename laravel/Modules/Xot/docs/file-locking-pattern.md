# File Locking Pattern - Prevenzione Race Conditions

## 🔐 Filosofia

> "Un file alla volta, un maestro alla volta.  
> Il lock è la chiave, la chiave è il rispetto.  
> Chi trova il lock, attende o va oltre.  
> Chi finisce la modifica, libera il lock."

## 📖 Regola Fondamentale

**Prima di modificare qualsiasi file, SEMPRE creare un file `.lock` con lo stesso nome e percorso.**

## 🚦 Workflow

### 1. Prima della Modifica
```bash
# File da modificare: MyClass.php
# Crea: MyClass.php.lock

touch /path/to/MyClass.php.lock
```

### 2. Controllo Lock Esistente
```bash
# Se MyClass.php.lock esiste già:
if [ -f /path/to/MyClass.php.lock ]; then
    echo "File in modifica da altro processo - SKIPPO"
    exit 0
fi
```

### 3. Modifica del File
```bash
# Con lock acquisito, modifica sicura
vim /path/to/MyClass.php
# oppure
sed -i 's/old/new/g' /path/to/MyClass.php
```

### 4. Rilascio Lock
```bash
# SEMPRE dopo la modifica
rm /path/to/MyClass.php.lock
```

## 💡 Implementazione AI/Script

### Esempio con AI Claude
```python
# Pseudo-codice pattern AI
def modify_file(filepath):
    lockfile = filepath + '.lock'
    
    # Check se lock esiste
    if exists(lockfile):
        log("File locked, skipping")
        return SKIP
    
    # Acquisisci lock
    create_file(lockfile, metadata)
    
    try:
        # Modifica il file
        content = read_file(filepath)
        new_content = apply_changes(content)
        write_file(filepath, new_content)
    finally:
        # SEMPRE rilascia lock
        delete_file(lockfile)
```

### Esempio Bash Script
```bash
#!/bin/bash

FILE="$1"
LOCK="${FILE}.lock"

# Check lock
if [ -f "$LOCK" ]; then
    echo "⚠️  File locked: $FILE"
    cat "$LOCK"  # Mostra chi ha il lock
    exit 1
fi

# Acquisisci lock
echo "LOCKED by: $(whoami) at $(date)" > "$LOCK"
echo "Reason: $2" >> "$LOCK"

# Trap per garantire rilascio anche se script fallisce
trap "rm -f '$LOCK'" EXIT INT TERM

# Modifica il file
nano "$FILE"  # o qualsiasi altra operazione

# Lock rilasciato automaticamente dal trap
echo "✅ Lock released for: $FILE"
```

## 🎯 Benefici

### Prevenzione Race Conditions
- ✅ Evita modifiche concorrenti che causano merge conflicts
- ✅ Garantisce atomicità delle operazioni
- ✅ Previene corruzione dei file

### Tracciabilità
- 📝 Il file `.lock` può contenere metadata:
  - Chi sta modificando
  - Timestamp inizio modifica
  - Motivo della modifica
  - ID del processo

### Coordinamento Team
- 👥 Team distribuiti possono vedere chi sta lavorando su quale file
- ⏱️ Timeout implicito: lock vecchi possono essere rimossi manualmente
- 🔄 Facilita workflow di review e coordinamento

## 📋 Esempio Completo

```bash
#!/bin/bash
# fix_merge_conflicts.sh

FILES=(
    "Modules/Xot/app/Providers/RouteServiceProvider.php"
    "Modules/Xot/app/Datas/XotData.php"
    "Modules/Xot/app/Datas/MetatagData.php"
)

for FILE in "${FILES[@]}"; do
    LOCK="${FILE}.lock"
    
    # Verifica lock
    if [ -f "$LOCK" ]; then
        echo "⚠️  Skipping locked file: $FILE"
        continue
    fi
    
    # Crea lock con metadata
    cat > "$LOCK" << EOF
Locked by: $(whoami)
Process: $$
Started: $(date)
Reason: Merge conflict resolution
EOF
    
    # Modifica (esempio: rimuove linee duplicate)
    awk '!seen[$0]++' "$FILE" > "${FILE}.tmp"
    mv "${FILE}.tmp" "$FILE"
    
    # Rilascia lock
    rm "$LOCK"
    echo "✅ Fixed and released: $FILE"
done
```

## ⚠️ Casi Limite

### Lock Orfano
Se un processo crashe prima di rilasciare il lock:

```bash
# Verifica età del lock
LOCK_AGE=$(stat -c %Y "$LOCKFILE")
NOW=$(date +%s)
AGE=$((NOW - LOCK_AGE))

if [ $AGE -gt 3600 ]; then  # 1 ora
    echo "⚠️  Lock orfano (>1h), rimozione sicura"
    rm "$LOCKFILE"
fi
```

### Lock Distribuito
Per team distribuiti, usare Redis/Database invece di file:

```php
// Redis-based locking
if (Redis::set("lock:$filepath", $metadata, 'EX', 3600, 'NX')) {
    // Lock acquisito
    try {
        modify_file($filepath);
    } finally {
        Redis::del("lock:$filepath");
    }
} else {
    // Lock già acquisito da altro processo
    return SKIP;
}
```

## 🔗 References

- [Merge Conflict Resolution 2025-11-04](./merge-conflict-resolution-2025-11-04.md)
- [Service Provider Architecture](./service-provider-architecture.md)
- [Code Quality Standards](./code-quality-standards.md)
- [DRY KISS Principles](./dry-kiss-analysis.md)

## 📅 Changelog

- **2025-11-04**: Documento creato dopo risoluzione massiva di merge conflicts in 16 file
- Pattern identificati e documentati
- Script di esempio forniti
