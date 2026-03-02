# Convenzioni per i Collegamenti nei File Markdown

## Regola Fondamentale

, **tutti i collegamenti nei file Markdown devono utilizzare percorsi relativi** e non percorsi assoluti.

## Esempi Corretti e Incorretti

### ❌ ERRATO: Percorsi Assoluti

```markdown
[Convenzioni di Naming per le Interfacce](modules/notify/docs/interface_naming_convention.md)
[Chiarimento sulla Struttura delle Interfacce](modules/notify/docs/interface_structure_clarification.md)
[Architettura dei Contratti](modules/notify/docs/contracts_architecture.md)
```

### ✅ CORRETTO: Percorsi Relativi

```markdown
[Convenzioni di Naming per le Interfacce](./interface_naming_convention.md)
[Chiarimento sulla Struttura delle Interfacce](./interface_structure_clarification.md)
[Architettura dei Contratti](./contracts_architecture.md)
```

Per collegamenti a documenti in altre directory:

```markdown
[Regole Generali per le Chiavi di Traduzione](../../lang/docs/translation_keys_rules.md)
[Best Practices per le Chiavi di Traduzione](../../lang/docs/translation_keys_best_practices.md)
```

## Motivazione

1. **Portabilità**: I percorsi relativi funzionano indipendentemente dalla posizione di installazione del progetto
2. **Compatibilità tra ambienti**: I percorsi assoluti potrebbero non funzionare in ambienti diversi
3. **Manutenibilità**: I percorsi relativi sono più facili da mantenere quando la struttura del progetto cambia
4. **Standard del progetto**: <nome progetto> segue lo standard di utilizzare percorsi relativi in tutti i documenti Markdown

## Regole per i Collegamenti Relativi

1. **File nella stessa directory**: Utilizzare `./nome-file.md`
2. **File in una sottodirectory**: Utilizzare `./sottodirectory/nome-file.md`
3. **File in una directory superiore**: Utilizzare `../nome-file.md`
4. **File in una directory parallela**: Utilizzare `../directory-parallela/nome-file.md`

## Verifica dei Collegamenti

Prima di committare un file Markdown, verificare sempre che tutti i collegamenti utilizzino percorsi relativi e non assoluti. È possibile utilizzare questo comando per trovare collegamenti assoluti nei file Markdown:

```bash
grep -r "\[.*\](/var" --include="*.md" /percorso/al/progetto
```

## Collegamenti Correlati

- [Convenzioni di Documentazione](../../../../../../docs/documentation-conventions.md)
- [Markdown Best Practices](../../../../../../docs/markdown-best-practices.md)
