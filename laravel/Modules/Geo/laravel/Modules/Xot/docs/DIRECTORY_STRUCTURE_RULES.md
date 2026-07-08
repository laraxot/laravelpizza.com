# Directory Structure Rules - No Duplications (DRY)

## Regola Fondamentale

**NESSUNA DUPLICAZIONE DI CARTELLE** - Principio DRY (Don't Repeat Yourself)

## Caso Specifico: lang/lang/

### ❌ ERRATO (Duplicazione)
```
Modules/Xot/
└── lang/
    └── lang/          # ❌ DUPLICAZIONE!
        ├── it/
        ├── en/
        └── ...
```

### ✅ CORRETTO (DRY)
```
Modules/Xot/
└── lang/
    ├── it/
    ├── en/
    └── ...
```

## Rationale

1. **DRY**: Non ripetere strutture di cartelle
2. **KISS**: Struttura semplice e diretta
3. **Manutenibilità**: Una sola fonte di verità
4. **Laravel Convention**: Le traduzioni stanno in `lang/`, non in `lang/lang/`

## Pattern da Evitare

```
❌ /path/to/dir/dir/        # Duplicazione
❌ /modules/module/module/  # Duplicazione
❌ /config/config/          # Duplicazione
```

## Verifica

Cercare duplicazioni con:

```bash
# Trova tutte le cartelle duplicate
find laravel/Modules -type d -name "*/*" | awk -F/ '{print $NF}' | sort | uniq -d

# Trova specificamente lang/lang
find laravel/Modules -path "*/lang/lang" -type d
```

## Fix Applicato

- ✅ Rimosso `laravel/Modules/Xot/lang/lang/`
- ✅ File rimangono in `laravel/Modules/Xot/lang/`
- ✅ Nessuna perdita di dati
- ✅ Verificato con PHPStan

## Related

- GitHub Issue: #11
- GitHub Discussion: #12
- Skill: `.opencode/skills/directory-structure/SKILL.md`
- Docs: `Modules/Xot/docs/DRY_PRINCIPLES.md`

## Reference Projects

- `/var/www/_bases/base_quaeris_fila5_mono/laravel/Modules/Xot/lang/`
- `/var/www/_bases/base_laravelpizza/laravel/Modules/Xot/lang/`

Entrambi hanno struttura corretta senza duplicazioni.
