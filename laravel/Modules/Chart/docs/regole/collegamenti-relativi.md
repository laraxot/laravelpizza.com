# Regole per i Collegamenti Relativi nella Documentazione

## Regola Fondamentale

**Tutti i collegamenti nei file markdown devono utilizzare percorsi relativi, mai percorsi assoluti.**

## Motivazione

L'utilizzo di percorsi relativi garantisce:

1. **Portabilità**: La documentazione funziona indipendentemente dalla posizione di installazione del progetto
2. **Manutenibilità**: Più facile aggiornare i percorsi in caso di ristrutturazione del progetto
3. **Compatibilità**: Funziona su tutti i sistemi operativi e ambienti di sviluppo
4. **Coerenza**: Approccio uniforme in tutto il progetto

## Esempi

### Corretto ✅

```markdown
<!-- Da un file in /laravel/Modules/Xot/docs/ a un file in /docs/ -->
[Documento nella root](../../../docs/file.md)

<!-- Da un file in /docs/ a un file in /laravel/Modules/Xot/docs/ -->
[Documento nel modulo Xot](../laravel/Modules/Xot/docs/file.md)

<!-- Da un file in /laravel/Modules/Xot/docs/ a un altro file nello stesso modulo -->
[Altro documento Xot](./altro_file.md)

<!-- Da un file in /laravel/Modules/Xot/docs/ a un file in un altro modulo -->
[Documento nel modulo UI](../../UI/docs/file.md)
```

### Errato ❌

```markdown
<!-- Mai usare percorsi assoluti -->
[Documento errato](../documento.md)

<!-- Mai usare percorsi assoluti, anche se abbreviati -->
[Documento errato](/docs/documento.md)
```

## Come Calcolare i Percorsi Relativi

1. **Identifica la posizione del file corrente**
2. **Identifica la posizione del file di destinazione**
3. **Calcola il percorso relativo**:
   - `./` per file nella stessa directory
   - `../` per salire di un livello
   - Concatena i livelli necessari

## Verifica Automatica

Utilizza lo script di verifica per identificare collegamenti assoluti:

```bash
./bashscripts/check_absolute_paths.sh
```

## Collegamenti Correlati

- [Regole di Documentazione](../regole-documentazione.md)
- [Convenzioni di Naming](../convenzioni-naming-campi.md)

## Collegamenti tra versioni di collegamenti-relativi.md
* [collegamenti-relativi.md](docs/regole/collegamenti-relativi.md)
* [collegamenti-relativi.md](laravel/Modules/Xot/docs/rules/collegamenti-relativi.md)

