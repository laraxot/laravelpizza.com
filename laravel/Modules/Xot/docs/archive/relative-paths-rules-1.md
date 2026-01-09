# Regole per i Percorsi Relativi nella Documentazione

> **Collegamenti correlati**
> - [README.md documentazione generale](../../../../docs/README.md)
> - [Struttura dei Prompt](./prompts.md)
> - [Regole per i Prompt](./PROMPT_RULES.md)
> - [README.md toolkit bashscripts](../../../../bashscripts/docs/README.md)

## Regola Fondamentale

**MAI UTILIZZARE PERCORSI ASSOLUTI NEI LINK DELLA DOCUMENTAZIONE. SEMPRE UTILIZZARE PERCORSI RELATIVI.**

Questa regola è fondamentale per garantire la portabilità della documentazione e il corretto funzionamento dei link indipendentemente dall'ambiente di installazione.

## Percorsi Corretti

### Da un file nella root del progetto verso un modulo

```markdown
[Modulo Xot](./laravel/Modules/Xot/docs/README.md)
```

### Da un file in un modulo verso un altro modulo

```markdown
[Altro Modulo](../../../AltroModulo/docs/README.md)
```

### Da un file in un modulo verso la root

```markdown
[Documentazione Root](../../../../docs/README.md)
```

## Errori Comuni da Evitare

1. **MAI utilizzare percorsi assoluti** come:
   ```markdown
   [ERRATO](/var/www/html/<nome progetto>/laravel/Modules/Xot/docs/README.md)
   ```

2. **MAI utilizzare percorsi che iniziano con /**:
   ```markdown
   [ERRATO](/docs/README.md)
   [ERRATO](/laravel/Modules/Xot/docs/README.md)
   ```

3. **MAI utilizzare percorsi che non tengono conto della posizione relativa del file sorgente**:
   ```markdown
   [ERRATO](Modules/Xot/docs/README.md) <!-- Da un file nella root -->
   [ERRATO](../Xot/docs/README.md) <!-- Da un file in un modulo, senza contare correttamente i livelli -->
   ```

## Come Calcolare Correttamente i Percorsi Relativi

1. **Identifica la posizione del file sorgente** (il file che contiene il link)
2. **Identifica la posizione del file destinazione** (il file a cui vuoi linkare)
3. **Calcola il percorso relativo** contando i livelli di directory da attraversare:
   - Usa `../` per salire di un livello
   - Concatena i nomi delle directory da attraversare

### Esempi Pratici

| Posizione File Sorgente | Posizione File Destinazione | Percorso Relativo Corretto |
|-------------------------|------------------------------|----------------------------|
| `/docs/README.md` | `/laravel/Modules/Xot/docs/README.md` | `./laravel/Modules/Xot/docs/README.md` |
| `/laravel/Modules/Xot/docs/README.md` | `/docs/README.md` | `../../../../docs/README.md` |
| `/laravel/Modules/Xot/docs/README.md` | `/laravel/Modules/User/docs/README.md` | `../../../User/docs/README.md` |
| `/laravel/Modules/Xot/docs/structure.md` | `/laravel/Modules/Xot/docs/README.md` | `./README.md` |

## Verifica dei Link

Prima di committare modifiche alla documentazione:

1. **Verifica manualmente** che i link relativi siano corretti
2. **Conta attentamente i livelli di directory** quando crei link tra moduli
3. **Testa i link** in un ambiente locale per assicurarti che funzionino correttamente

## Importanza della Portabilità

L'uso di percorsi relativi garantisce che la documentazione funzioni correttamente:
- In ambienti di sviluppo diversi
- In installazioni con path di base diversi
- In repository clonati in posizioni diverse
- In sistemi operativi diversi

## Riferimenti

- [Markdown Link Syntax](https://www.markdownguide.org/basic-syntax/#links)
- [Relative vs Absolute URLs](https://www.w3.org/TR/WD-html40-970917/htmlweb.html#h-5.1.2)
