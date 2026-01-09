# Convenzioni per i Link nella Documentazione

## Regole Fondamentali per i Link Markdown

### 1. Utilizzare Sempre Percorsi Relativi

I collegamenti nei file di documentazione devono **sempre** utilizzare percorsi relativi, mai percorsi assoluti.

✅ **CORRETTO**:
```markdown
[Regole Generali](../../Xot/project_docs/translations.md)
[Best Practices](../TRANSLATION_KEYS_BEST_PRACTICES.md)
```

❌ **ERRATO**:
```markdown
[Regole Generali](/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Xot/project_docs/translations.md)
[Best Practices](/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Lang/project_docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
```

### 2. Navigazione Tra Cartelle

Per navigare nella struttura delle cartelle, utilizzare:
- `../` per salire di un livello
- `../../` per salire di due livelli
- E così via...

Esempi:
- Per collegare a un file nello stesso modulo: `[File](./altro_file.md)` o `[File](altro_file.md)`
- Per collegare a un file in un altro modulo: `[File](../../AltroModulo/project_docs/file.md)`

### 3. Struttura della Documentazione

Quando si creano collegamenti, considerare la struttura standard dei moduli :

```
laravel/
├── Modules/
│   ├── ModuloA/
│   │   ├── docs/
│   │   │   └── file.md
│   ├── ModuloB/
│   │   ├── docs/
│   │   │   └── file.md
├── docs/
│   └── file.md
```

### 4. Collegamenti Tra Moduli

Per collegare documenti tra moduli diversi:

```markdown
<!-- Da Modules/ModuloA/project_docs/file.md a Modules/ModuloB/project_docs/file.md -->
[Link a ModuloB](../../ModuloB/project_docs/file.md)

<!-- Da Modules/ModuloA/project_docs/file.md a docs/file.md nella root -->
[Link a docs root](../../../project_docs/file.md)
```

### 5. Verificare Sempre i Link

Prima di fare commit dei documenti:
1. Verificare che tutti i link siano relativi
2. Testare i link per assicurarsi che puntino al file corretto
3. Evitare link circolari o riferimenti a file inesistenti

## Esempi Pratici

### Da Modules/Lang/project_docs/ a Modules/Notify/project_docs/
```markdown
[Convenzioni Notify](../../Notify/project_docs/TRANSLATION_CONVENTIONS.md)
```

### Da Modules/Lang/project_docs/ a docs/ nella root
```markdown
[Documentazione Principale](../../../project_docs/README.md)
```

### Da Modules/Lang/project_docs/ a un altro file nella stessa cartella
```markdown
[Best Practices](TRANSLATION_KEYS_BEST_PRACTICES.md)
```

## Vantaggi dei Percorsi Relativi

1. **Portabilità**: La documentazione funziona in qualsiasi ambiente
2. **Manutenibilità**: Se la struttura cambia, sono necessarie meno modifiche
3. **Collaborazione**: Facilita il lavoro di più sviluppatori
4. **Coerenza**: Rispetta gli standard del progetto 
