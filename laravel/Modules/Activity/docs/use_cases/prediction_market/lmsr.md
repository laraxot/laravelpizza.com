# LMSR – Logarithmic Market Scoring Rule nei Prediction Market

## Cos'è LMSR?
LMSR (Logarithmic Market Scoring Rule) è un algoritmo di market making ideato da Robin Hanson per prediction market. Permette di fornire liquidità automatica e prezzi sempre aggiornati per ogni possibile esito, senza necessità di una controparte umana.

### Formula e Funzionamento
- **Funzione di costo**: `C(q) = b * ln(∑_i exp(q_i / b))`
  - `q_i`: quantità totale di azioni/outcome i acquistate
  - `b`: parametro di liquidità
- **Prezzo di ciascun outcome**: `p_i = exp(q_i / b) / ∑_j exp(q_j / b)`

### Proprietà e Vantaggi
- Prezzi dinamici e sempre disponibili
- Liquidità garantita anche con pochi utenti
- Perdita massima limitata per il market maker
- Incentiva la partecipazione e la scoperta del prezzo

## Integrazione LMSR nel modulo Prediction Market

### Dove si inserisce LMSR
- **Calcolo quote**: sostituisce il calcolo statico delle quote con uno dinamico e reattivo.
- **Eventi coinvolti**: `BetPlaced`, `MarketCreated` aggiornano lo stato delle quantità `q_i`.
- **Proiezioni**: le proiezioni di mercato e quote devono usare la formula LMSR per mostrare prezzi aggiornati.

### Flusso Utente con LMSR
1. L'utente visualizza le quote attuali (calcolate LMSR)
2. Piazza una scommessa → aggiorna `q_i` dell’outcome scelto
3. Il sistema aggiorna i prezzi/quote in tempo reale

### Best Practice di Implementazione
- Incapsulare la logica LMSR in una classe dedicata (es: `LmsrQuoteCalculator`)
- Separare la logica di market making da quella di business (aggregate root)
- Fornire test unitari e documentazione d’uso
- Documentare il parametro `b` e le sue implicazioni

## Esempio pratico (PHP pseudocode)
```php
$lmsr = new LmsrQuoteCalculator(b: 100);
// Stato attuale del mercato: outcome A: 10, B: 5, C: 0
$quantities = ['A' => 10, 'B' => 5, 'C' => 0];
$prices = $lmsr->getPrices($quantities);
// $prices['A'], $prices['B'], $prices['C']
```

## Glossario Aggiornato
- **LMSR**: Algoritmo per market making che garantisce liquidità automatica e prezzi dinamici.
- **Parametro b**: Controlla la liquidità e la sensibilità dei prezzi.
- **Funzione di costo**: Formula matematica che determina il costo totale delle scommesse nel mercato.

---

> **Nota:** L’integrazione di LMSR rende il modulo Prediction Market più robusto, liquido e trasparente, allineandolo alle migliori piattaforme internazionali. Per dettagli matematici e implementativi, consultare la sezione "Best Practice" e gli esempi pratici.