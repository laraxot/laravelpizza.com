# Skill Operativa: PHP Quality Gate

## Trigger

Usare questa skill ogni volta che viene modificato un file PHP.

## Procedura

1. Identificare il file PHP toccato e il modulo/tema di appartenenza.
2. Eseguire `phpstan` sul file o sul perimetro minimo corretto.
3. Eseguire `phpmd` sul file o sul perimetro minimo corretto.
4. Eseguire `phpinsights` sul file o sul perimetro minimo corretto.
5. Valutare se il comportamento e' testabile con Pest.
6. Cercare il test esistente piu' vicino.
7. Se manca, creare o aggiornare il test Pest.
8. Eseguire il test pertinente.
9. Riportare con precisione esiti e blocchi.

## Checklist

- [ ] File PHP identificato
- [ ] `phpstan` eseguito
- [ ] `phpmd` eseguito
- [ ] `phpinsights` eseguito
- [ ] Valutazione esplicita della testabilita'
- [ ] Test Pest esistente cercato
- [ ] Test Pest creato/aggiornato se necessario
- [ ] Test Pest eseguito
- [ ] Esiti riportati nel messaggio finale
