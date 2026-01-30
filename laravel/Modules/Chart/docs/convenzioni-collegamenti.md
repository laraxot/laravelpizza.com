# Convenzioni e Esempi per i Collegamenti nella Documentazione

## Regola Fondamentale

**Nella documentazione, è obbligatorio utilizzare SEMPRE e SOLO collegamenti relativi, mai assoluti.**

Questa regola si applica a:
- Collegamenti tra file di documentazione
- Collegamenti a immagini
- Collegamenti a file di codice sorgente
- Qualsiasi altro tipo di riferimento a file nel progetto

## Motivazioni

L'utilizzo di collegamenti relativi offre numerosi vantaggi:

1. **Portabilità**: La documentazione funziona correttamente indipendentemente da dove viene clonato il repository
2. **Manutenibilità**: Più facile aggiornare i collegamenti quando la struttura del progetto cambia
3. **Compatibilità**: Funziona su tutti i sistemi operativi (Windows, Linux, macOS)
4. **Indipendenza dal percorso di installazione**: Nessun riferimento a percorsi specifici della macchina
5. **Compatibilità con GitHub/GitLab**: I collegamenti funzionano anche quando visualizzati su piattaforme Git

## Esempi Corretti

### Collegamenti nella stessa directory

```markdown
[Guida all'installazione](installazione.md)
```

### Collegamenti a directory superiori

```markdown
[Documentazione principale](../../docs/README.md)
```

### Collegamenti a sottodirectory

```markdown
[Configurazione del database](config/database.md)
```

### Collegamenti tra moduli e documentazione principale

Da un file in `/docs/` a un file in un modulo:
```markdown
[Documentazione User](../User/docs/user_profile_models.md)
```

Da un file in un modulo a un file in `/docs/`:
```markdown
[Architettura generale](../architettura.md)
```

### Collegamenti a immagini

```markdown
![Diagramma ER](../images/er_diagram.png)
```

## Esempi Errati

I seguenti esempi mostrano collegamenti **NON CORRETTI** che non devono essere utilizzati:

```markdown
[Documentazione User](/var/www/html/base_<nome progetto>/laravel/Modules/User/docs/user_profile_models.md)
```

```markdown
[Architettura generale](/var/www/html/base_<nome progetto>/docs/architettura.md)
```

```markdown
![Diagramma ER](/var/www/html/base_<nome progetto>/docs/images/er_diagram.png)
```

## Casi Speciali

### Collegamenti tra Repository Diversi

Per collegamenti a repository esterni, utilizzare URL completi:

```markdown
[Laravel Documentation](https://laravel.com/docs)
```

### Collegamenti ad Ancore nella Stessa Pagina

Per collegamenti a sezioni nella stessa pagina, utilizzare ancore:

```markdown
[Vedi la sezione Esempi](#esempi-corretti)
```

### Collegamenti a File di Grandi Dimensioni

Per file di grandi dimensioni, è consigliabile utilizzare collegamenti a specifiche sezioni:

```markdown
[Configurazione del database](config/database.md#mysql-configuration)
```

## Strumenti Utili

### Verifica dei Collegamenti

Per verificare che tutti i collegamenti nella documentazione siano relativi, è possibile utilizzare il seguente comando:

```bash
grep -r "\/var\/www\/html\/base_<nome progetto>\/" --include="*.md" /var/www/html/base_<nome progetto>/docs/
grep -r "\/var\/www\/html\/base_<nome progetto>\/" --include="*.md" /var/www/html/base_<nome progetto>/laravel/Modules/*/docs/
```

Se il comando restituisce risultati, significa che ci sono collegamenti assoluti da correggere.

### Conversione da Assoluti a Relativi

Per convertire collegamenti assoluti in relativi, considerare il percorso base del file corrente e calcolare il percorso relativo al file di destinazione.

Esempio di conversione:
- Da: `/var/www/html/base_<nome progetto>/docs/file.md`
- A: `./file.md` (se nella stessa directory)
- A: `../laravel/Modules/User/docs/file.md` (se in un modulo)

## Conclusione

Seguire queste convenzioni garantisce che la documentazione rimanga coerente, portabile e manutenibile nel tempo. Tutti i contributori sono tenuti a rispettare queste regole per mantenere alta la qualità della documentazione. 
