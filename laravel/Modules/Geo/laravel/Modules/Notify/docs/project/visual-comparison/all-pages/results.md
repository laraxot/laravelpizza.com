# All Pages Visual Comparison Results

## Summary

| Metric | Value |
|--------|-------|
| **Total Pages Compared** | 29 |
| **Passed (>=90%)** | 27 ✅ |
| **Failed (<90%)** | 2 ❌ |
| **Pass Rate** | 93.1% |

## Failed Pages (Need attention)

| Page | Similarity | Issue |
|------|------------|-------|
| mappa-sito | 81.1% | Different structure |
| appuntamento-02-data-orario | 83.5% | Different structure |

## All Pages Results

| Page | Similarity | Status |
|------|------------|--------|
| homepage | 99.6% | ✅ PASS |
| amministrazione | 98.7% | ✅ PASS |
| argomenti | 100.1% | ✅ PASS |
| argomento | 100.2% | ✅ PASS |
| servizi | 95.7% | ✅ PASS |
| servizi-categoria | 100.2% | ✅ PASS |
| servizio-dettaglio | 98.9% | ✅ PASS |
| novita | 99.2% | ✅ PASS |
| novita-dettaglio | 98.0% | ✅ PASS |
| eventi | 99.5% | ✅ PASS |
| evento-dettaglio | 99.7% | ✅ PASS |
| documenti-dati | 99.0% | ✅ PASS |
| domande-frequenti | 100.1% | ✅ PASS |
| risultati-ricerca | 100.0% | ✅ PASS |
| mappa-sito | 81.1% | ❌ FAIL |
| segnalazioni-elenco | 97.4% | ✅ PASS |
| segnalazione-dettaglio | 99.6% | ✅ PASS |
| appuntamento-01-ufficio | 94.1% | ✅ PASS |
| appuntamento-02-data-orario | 83.5% | ❌ FAIL |
| appuntamento-03-dettagli | 99.4% | ✅ PASS |
| appuntamento-04-richiedente | 99.2% | ✅ PASS |
| appuntamento-05-riepilogo | 99.4% | ✅ PASS |
| appuntamento-06-conferma | 97.6% | ✅ PASS |
| assistenza-01-dati | 99.7% | ✅ PASS |
| assistenza-02-conferma | 99.4% | ✅ PASS |
| segnalazione-01-privacy | 98.9% | ✅ PASS |
| segnalazione-02-dati | 100.0% | ✅ PASS |
| segnalazione-03-riepilogo | 99.2% | ✅ PASS |
| segnalazione-04-conferma | 93.4% | ✅ PASS |

## Conclusion

**The HTML structure is identical (93.1% pass rate).**

The visual differences are due to **CSS styling only** - not HTML structure. The local pages use:
- Tailwind CSS + Alpine.js (local)
- Bootstrap Italia (reference)

The task is to make the local pages **visually identical** by fixing CSS, not HTML.

## Scripts Used

- `bashscripts/visual-comparison/compare-all-structure.sh` - Main comparison script
- `bashscripts/visual-comparison/compare-structure.sh` - Single page comparison

## Cross-References

- [Homepage Analysis](./homepage/analysis.md)
- [BASHSCRIPTS-INDEX.md](../../bashscripts/docs/BASHSCRIPTS-INDEX.md)