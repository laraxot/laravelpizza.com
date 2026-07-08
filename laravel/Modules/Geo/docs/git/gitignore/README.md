# Script GitIgnore - Laraxot PTVX

Questa cartella contiene script per la gestione e standardizzazione dei file `.gitignore` dei moduli Laraxot.

## Script Disponibili

### update_gitignore.sh
**Scopo**: Aggiornamento batch dei file .gitignore per conformarli al prototipo standardizzato.

**Utilizzo**:
```bash
cd /var/www/html/_bases/base_ptvx_fila5_mono
./bashscripts/git/gitignore/update_gitignore.sh
```

**Funzionalità**:
- Aggiorna tutti i moduli con .gitignore incompleti
- Applica il prototipo standardizzato completo
- Verifica automatica della conformità
- Backup automatico dei file originali

### fix_remaining_gitignore.sh
**Scopo**: Correzione finale per i moduli che rimangono non conformi dopo l'aggiornamento batch.

**Utilizzo**:
```bash
cd /var/www/html/_bases/base_ptvx_fila5_mono
./bashscripts/git/gitignore/fix_remaining_gitignore.sh
```

**Funzionalità**:
- Correzione mirata dei moduli problematici
- Sostituzione completa con prototipo standardizzato
- Verifica finale di conformità al 100%
- Report dettagliato dei risultati

## Prototipo Standardizzato

Il prototipo standardizzato è documentato in:
`laravel/Modules/Xot/docs/gitignore-prototype.md`

### Sezioni del Prototipo
1. Dependencies and packages
2. Lock files and cache
3. Log files
4. Build directories
5. Laravel specific
6. Database directories
7. Local configurations
8. IDE specific
9. Git specific
10. Temporary and system files
11. Documentation and cache
12. Development tools

## Pattern Critici

### Obbligatori in Tutti i Moduli
- `*:Zone.Identifier` - Identificatori zone Windows
- `/vendor/` - Dipendenze Composer
- `/node_modules/` - Dipendenze NPM
- `database/Factories_` - Directory factories temporanee
- `database/Factories_old` - Directory factories vecchie
- `database/Migrations_old` - Directory migrazioni vecchie
- `.windsurf/` - Tool di sviluppo Windsurf
- `.cursor/` - Tool di sviluppo Cursor

## Verifica Conformità

Per verificare la conformità di tutti i moduli:

```bash
cd /var/www/html/_bases/base_ptvx_fila5_mono/laravel/Modules

# Verifica pattern critici
for module in */; do
    if [[ -f "${module}.gitignore" ]]; then
        module_name="${module%/}"
        zone_check=$(grep -q '\*:Zone.Identifier' "${module}.gitignore" && echo 'OK' || echo 'MANCANTE')
        database_check=$(grep -q 'database/Factories_' "${module}.gitignore" && echo 'OK' || echo 'MANCANTE')
        dev_tools_check=$(grep -q '\.windsurf/' "${module}.gitignore" && echo 'OK' || echo 'MANCANTE')
        
        if [[ "$zone_check" == "OK" && "$database_check" == "OK" && "$dev_tools_check" == "OK" ]]; then
            echo "✅ $module_name: CONFORME"
        else
            echo "❌ $module_name: Zone=$zone_check Database=$database_check DevTools=$dev_tools_check"
        fi
    fi
done
```

## Storia degli Aggiornamenti

- **3 Gennaio 2025**: Creazione prototipo standardizzato
- **16 Settembre 2025**: Prima standardizzazione completa (100% conformità)
- **16 Settembre 2025**: Aggiunta pattern database (database/Factories_, database/Factories_old, database/Migrations_old)

## Regole di Manutenzione

1. **Aggiornamenti**: Tutti gli aggiornamenti al prototipo devono essere documentati
2. **Verifica**: Sempre verificare la conformità al 100% dopo ogni modifica
3. **Backup**: Creare backup prima di modifiche massive
4. **Documentazione**: Aggiornare sempre la documentazione in `Modules/Xot/docs/gitignore-prototype.md`

---

**Nota**: Questi script seguono le regole di organizzazione Laraxot per bashscripts. Tutti gli script devono essere categorizzati e posizionati nelle sottocartelle appropriate di `bashscripts/`.
