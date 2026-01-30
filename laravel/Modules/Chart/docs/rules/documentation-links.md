# Regole per i Collegamenti nella Documentazione

## Regola Fondamentale
Utilizzare SEMPRE percorsi RELATIVI, MAI percorsi ASSOLUTI nei link della documentazione.

## Pattern Corretti per i Link

1. **Stesso modulo, stessa cartella**:
   ```markdown
   [Link File](./ALTRO_FILE.md)
   ```

2. **Stesso modulo, sottocartella**:
   ```markdown
   [Link File](./subcartella/ALTRO_FILE.md)
   ```

3. **Stesso modulo, cartella superiore**:
   ```markdown
   [Link File](../ALTRO_FILE.md)
   ```

4. **Da un modulo ad un altro modulo**:
   ```markdown
   [Link File](../../../AltroModulo/docs/FILE.md)
   ```

5. **Da un modulo alla root docs**:
   ```markdown
   [Link File](../../../../docs/FILE.md)
   ```

6. **Dalla root docs a un modulo**:
   ```markdown
   [Link File](../laravel/Modules/NomeModulo/docs/FILE.md)
   ```

## Esempi Errati da Evitare

❌ **NON CORRETTO**:
```markdown
[Convenzioni di Naming](/var/www/html/<nome progetto>/laravel/Modules/Notify/docs/NAMING_CONVENTIONS.md)
```

✅ **CORRETTO**:
```markdown
[Convenzioni di Naming](./NAMING_CONVENTIONS.md)
```

## Motivazione

1. **Portabilità**: I percorsi relativi funzionano indipendentemente dalla posizione di installazione
2. **Compatibilità**: I percorsi assoluti potrebbero non funzionare in ambienti diversi
3. **Manutenibilità**: I percorsi relativi sono più facili da mantenere quando la struttura cambia
4. **Standard del progetto**: <nome progetto> richiede percorsi relativi in tutti i documenti Markdown

## Procedura prima di committare

1. Verificare che tutti i link utilizzino percorsi relativi
2. Testare i link per verificare che funzionino
3. Documentare le convenzioni di percorso nella documentazione più vicina
4. Garantire collegamenti bidirezionali tra documenti correlati
