# Regole per i Collegamenti nella Documentazione

## Utilizzo Esclusivo di Collegamenti Relativi

Nella documentazione di il progetto, **tutti i collegamenti devono essere relativi** e mai assoluti. Questo è un requisito fondamentale per garantire la portabilità e la manutenibilità della documentazione.

### Motivazione

1. **Portabilità**: I collegamenti relativi funzionano indipendentemente dall'ambiente in cui la documentazione viene distribuita (localhost, server di sviluppo, produzione)
2. **Manutenibilità**: Se il dominio o la struttura dei percorsi cambia, i collegamenti relativi rimangono validi
3. **Compatibilità**: I collegamenti relativi funzionano correttamente in tutti i contesti (GitHub, GitLab, documentazione offline)
4. **Indipendenza dall'ambiente**: Non si fa affidamento su URL basati su dominio che potrebbero cambiare nel tempo

### Formati Corretti

#### Per Documenti nello Stesso Livello

```markdown
[Documento di esempio](altro-documento.md)
```

#### Per Documenti in una Sottodirectory

```markdown
[Documento in sottodirectory](sottodirectory/documento.md)
```

#### Per Documenti in una Directory Superiore

```markdown
[Documento in directory superiore](../documento.md)
```

#### Per Documenti in Altre Parti del Progetto

```markdown
[Documento in altro modulo](../../laravel/Modules/User/project_docs/documento.md)
```

### Formati Errati da Evitare

❌ **Collegamenti assoluti basati su dominio**:
```markdown
[Documento errato](https://<nome progetto>.org/project_docs/documento.md)
```

❌ **Collegamenti assoluti basati su percorso**:
```markdown
[Documento errato](/var/www/html/<nome progetto>/project_docs/documento.md)
```

❌ **Collegamenti senza estensione**:
```markdown
[Documento errato](documento)
```

### Risorse e Immagini

Anche per le risorse e le immagini, è necessario utilizzare percorsi relativi:

```markdown
![Logo](../assets/images/logo.png)
```

### Verifica dei Collegamenti

È consigliabile verificare regolarmente che tutti i collegamenti relativi siano validi utilizzando strumenti di controllo dei link come `markdown-link-check` o validatori integrati negli editor Markdown.

## Integrazione con il Sistema di Documentazione

Questa regola si integra con il sistema di documentazione centralizzato descritto in [Collegamenti alla Documentazione](../collegamenti-documentazione.md), che fornisce una mappa dei collegamenti tra i vari documenti e moduli del progetto. 

## Collegamenti tra versioni di collegamenti-relativi.md
* [collegamenti-relativi.md](docs/regole/collegamenti-relativi.md)
* [collegamenti-relativi.md](../../../Xot/project_docs/rules/collegamenti-relativi.md)

