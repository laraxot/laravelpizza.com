# Best Practices – Cms

## Principi DRY/KISS
- **DRY**: Centralizza parsing pagine in `CmsService`. Usa cache per output renderizzato.
- **KISS**: Mantieni template semplici; evita logica complessa nelle view.
- **Clean Code**: Segui struttura `Model -> Repository -> Controller`.

## Componenti
- Usa `PageRepository` per query ricorrenti.
- Usa `BlockRenderer` per componenti modulari.

## Test
- Testa endpoint CMS con snapshot testing.
- Copri edge case per permessi pagina (draft vs published).

## Documentazione
- Aggiorna `docs/INDEX.md` con nuovi blocchi disponibili.
- Documenta flusso approvazione contenuti.
