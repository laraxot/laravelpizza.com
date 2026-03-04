# Grafica vs laravelpizza.com

## Obiettivo
L'obiettivo è raggiungere la parità visiva (Pixel Parity) con il sito di riferimento `laravelpizza.com`.  

## Metodologia
Utilizziamo il sistema di screenshot per confrontare l'ambiente di sviluppo locale con il sito di produzione.  

### Screenshot di Confronto
Gli screenshot sono organizzati nella cartella `screenshots/grafica-confronto/`:

1.  **Sito Target (Produzione)**: [target-prod.png](./screenshots/grafica-confronto/target-prod.png)
2.  **Sito Locale (Sviluppo)**: [local-dev.png](./screenshots/grafica-confronto/local-dev.png)

## Workflow di Analisi
1.  **Cattura**: Utilizzo degli strumenti MCP per generare screenshot aggiornati.
2.  **Confronto**: Analisi delle discrepanze in header, hero, componenti e footer.
3.  **Documentazione**: Registrazione delle differenze in `differenze-grafica-e-miglioramenti.md`.
4.  **Implementazione**: Modifica dei file Blade, CSS e JS nel tema.
5.  **Verifica**: Nuovo ciclo di screenshot per confermare l'allineamento.

---
**Riferimenti**:
- [Differenze grafica e miglioramenti](./differenze-grafica-e-miglioramenti.md)
- [Evidenzia differenze](./evidenzia-differenze.md)
