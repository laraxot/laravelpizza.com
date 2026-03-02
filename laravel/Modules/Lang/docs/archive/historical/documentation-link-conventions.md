# Convenzioni per i Link nella Documentazione

## Collegamenti correlati
- [Composer merge plugin](composer-merge-plugin.md)

## Regole Fondamentali per i Link Markdown

### 1. Utilizzare Sempre Percorsi Relativi

I collegamenti nei file di documentazione devono **sempre** utilizzare percorsi relativi, mai percorsi assoluti.

✅ **CORRETTO**:
```markdown
[Regole Generali](../../xot/project_docs/translations.md)
[Best Practices](../translation_keys_best_practices.md)
```

❌ **ERRATO**:
```markdown
[Regole Generali](modules/xot/project_docs/translations.md)
[Best Practices](modules/lang/project_docs/translation_keys_best_practices.md)
```

### 2. Navigazione Tra Cartelle

Per navigare nella struttura delle cartelle, utilizzare:
- `../` per salire di un livello
- `../../` per salire di due livelli
- E così via...

Esempi:
- Per collegare a un file nello stesso modulo: `[File](./altro_file.md)` o `[File](altro_file.md)`
- Per collegare a un file in un altro modulo: `[File](../../altromodulo/project_docs/file.md)`

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
[Link a ModuloB](../../modulob/project_docs/file.md)

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
[Convenzioni Notify](../../notify/project_docs/translation_conventions.md)
```

### Da Modules/Lang/project_docs/ a docs/ nella root
```markdown
[Documentazione Principale](../../../project_docs/readme.md)
```

### Da Modules/Lang/project_docs/ a un altro file nella stessa cartella
```markdown
[Best Practices](translation_keys_best_practices.md)
```

## Vantaggi dei Percorsi Relativi

1. **Portabilità**: La documentazione funziona in qualsiasi ambiente
2. **Manutenibilità**: Se la struttura cambia, sono necessarie meno modifiche
3. **Collaborazione**: Facilita il lavoro di più sviluppatori
4. **Coerenza**: Rispetta gli standard del progetto
# Convenzioni per i Link nella Documentazione

## Regole Fondamentali per i Link Markdown

### 1. Utilizzare Sempre Percorsi Relativi

I collegamenti nei file di documentazione devono **sempre** utilizzare percorsi relativi, mai percorsi assoluti.

✅ **CORRETTO**:
```markdown
[Regole Generali](../../xot/docs/translations.md)
[Best Practices](../translation_keys_best_practices.md)
```

❌ **ERRATO**:
```markdown
[Regole Generali](modules/xot/docs/translations.md)
[Best Practices](modules/lang/docs/translation_keys_best_practices.md)
```

### 2. Navigazione Tra Cartelle

Per navigare nella struttura delle cartelle, utilizzare:
- `../` per salire di un livello
- `../../` per salire di due livelli
- E così via...

Esempi:
- Per collegare a un file nello stesso modulo: `[File](./altro_file.md)` o `[File](altro_file.md)`
- Per collegare a un file in un altro modulo: `[File](../../altromodulo/docs/file.md)`

### 3. Struttura della Documentazione

Quando si creano collegamenti, considerare la struttura standard dei moduli <nome progetto>:

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
<!-- Da Modules/ModuloA/docs/file.md a Modules/ModuloB/docs/file.md -->
[Link a ModuloB](../../modulob/docs/file.md)

<!-- Da Modules/ModuloA/docs/file.md a docs/file.md nella root -->
[Link a docs root](../../../../../../docs/file.md)
```

### 5. Verificare Sempre i Link

Prima di fare commit dei documenti:
1. Verificare che tutti i link siano relativi
2. Testare i link per assicurarsi che puntino al file corretto
3. Evitare link circolari o riferimenti a file inesistenti

## Esempi Pratici

### Da Modules/Lang/docs/ a Modules/Notify/docs/
```markdown
[Convenzioni Notify](../../notify/docs/translation_conventions.md)
```

### Da Modules/Lang/docs/ a docs/ nella root
```markdown
[Documentazione Principale](../../../../../../docs/readme.md)
```

### Da Modules/Lang/docs/ a un altro file nella stessa cartella
```markdown
[Best Practices](translation_keys_best_practices.md)
```

## Vantaggi dei Percorsi Relativi

1. **Portabilità**: La documentazione funziona in qualsiasi ambiente
2. **Manutenibilità**: Se la struttura cambia, sono necessarie meno modifiche
3. **Collaborazione**: Facilita il lavoro di più sviluppatori
4. **Coerenza**: Rispetta gli standard del progetto <nome progetto>
