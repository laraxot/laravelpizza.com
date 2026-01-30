# Collegamenti tra Documenti e Immagini in il progetto

Questo documento mappa i collegamenti bidirezionali tra il documento di presentazione e le immagini correlate nella cartella `/var/www/html/<nome progetto>/docs/images/`.

## Struttura dei File per Ogni Immagine

Per ogni immagine nella presentazione, esistono diversi file correlati:

1. **File immagine (.png)**: L'immagine effettiva utilizzata nella presentazione
2. **File descrittivo (.md)**: Contiene una descrizione dettagliata dell'immagine, utile per l'accessibilità e la comprensione
3. **File HTML (.html)**: Versione HTML dell'immagine, utilizzabile per la visualizzazione web
4. **File Blade (.blade.php)**: Template Blade per l'integrazione con Laravel

## Collegamenti Principali

### Homepage (Immagine 2)

- **Immagine**: [/var/www/html/<nome progetto>/docs/images/2.png](/var/www/html/<nome progetto>/docs/images/2.png)
- **Descrizione**: [/var/www/html/<nome progetto>/docs/images/2.md](/var/www/html/<nome progetto>/docs/images/2.md)
- **HTML**: [/var/www/html/<nome progetto>/docs/images/2.html](/var/www/html/<nome progetto>/docs/images/2.html)
- **Blade**: [/var/www/html/<nome progetto>/docs/images/2.blade.php](/var/www/html/<nome progetto>/docs/images/2.blade.php)
- **Riferimento nella presentazione**: [/var/www/html/<nome progetto>/docs/presentazione.md](/var/www/html/<nome progetto>/docs/presentazione.md) (Sezione "Homepage")
- **Riferimento nella presentazione PDF**: [/var/www/html/<nome progetto>/docs/12.10, Presentazione del portale Salute Orale.md](/var/www/html/<nome progetto>/docs/12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md)

### Contenuto della Homepage

L'immagine 2 mostra la homepage del portale il progetto con il seguente testo:

```
Benvenuta su Salute Orale,

il portale che vuole garantire alle pazienti vulnerabili in
stato di gravidanza la possibilità di accedere a servizi
odontoiatrici di prevenzione a titolo completamente
gratuito.

Se sei una donna in stato di gravidanza residente in
Italia o in attesa di permesso di soggiorno, con un
valore ISEE pari a euro 20,000 o inferiore, e vuoi
partecipare a questa iniziativa clicca il pulsante qui
sotto:
```

Questo testo è documentato in dettaglio nel file [/var/www/html/<nome progetto>/docs/homepage-contenuti.md](/var/www/html/<nome progetto>/docs/homepage-contenuti.md).

## Come Utilizzare Questi Collegamenti

1. **Per gli sviluppatori**:
   - Utilizzare i file .blade.php per implementare le interfacce utente
   - Consultare i file .md per comprendere il contesto e i requisiti di accessibilità

2. **Per i content manager**:
   - Utilizzare i file .md come riferimento per il contenuto testuale
   - Verificare che il contenuto implementato corrisponda alle specifiche nei file .md

3. **Per i tester**:
   - Confrontare l'implementazione con le immagini .png di riferimento
   - Verificare che il testo visualizzato corrisponda esattamente a quello specificato

## Note Importanti

- Le immagini e le descrizioni sono la fonte primaria di verità per l'implementazione
- In caso di discrepanza tra il codice e le specifiche nelle immagini, le specifiche hanno la precedenza
- Mantenere aggiornati questi collegamenti quando vengono apportate modifiche alla documentazione o alle immagini
