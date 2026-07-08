# fix_docs_case.sh

## Descrizione
Script per la standardizzazione dei nomi di file e cartelle nella documentazione del progetto Laraxot PTVX.
Converte automaticamente in minuscolo tutti i nomi di file e cartelle nelle directory `docs`, mantenendo solo `README.md` in maiuscolo.

## Logica e Filosofia
Lo script implementa i seguenti principi:
- Consistenza: nomi file uniformi in tutto il progetto
- Compatibilità: evita problemi di case-sensitivity tra sistemi operativi
- Convenzioni Unix: segue le best practice di naming Unix/Linux
- Eccezioni gestite: preserva README.md come unica eccezione in maiuscolo

## Utilizzo
```bash
./bashscripts/docs/fix_docs_case.sh
```

## Funzionamento
1. Cerca ricorsivamente tutte le directory `docs`
2. Per ogni directory trovata:
   - Converte in minuscolo i nomi dei file (escludendo README.md)
   - Converte in minuscolo i nomi delle sottocartelle
   - Mantiene la struttura delle directory intatta

## Output
Lo script mostra:
- File convertiti con percorso originale e nuovo nome
- Directory convertite con percorso originale e nuovo nome

## Note
- Non richiede parametri
- Esegue le conversioni in modo sicuro
- Non modifica il contenuto dei file
- Preserva i permessi originali

## Manutenzione
Per modifiche future, assicurarsi di:
1. Mantenere l'eccezione per README.md
2. Testare su sistemi case-sensitive
3. Aggiornare questa documentazione
4. Verificare la compatibilità con la struttura del progetto
