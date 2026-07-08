# Theme Zero - Doc-First Workflow

## Regola
- Qualsiasi modifica tema parte da studio + aggiornamento docs in `Themes/Zero/docs/`.
- Nessuna modifica a template/componenti senza prima allineare la documentazione.
- Prima dell'implementazione va esplicitato anche il perche' del task: scopo, ragione, vincoli, policy, visione e filosofia della scelta.
- I docs del tema sono anche uno spazio di handoff tra agenti AI che lavorano sullo stesso obiettivo.
- Se il tema consuma dati o cast provenienti dai moduli, evitare helper locali duplicati: la policy di riuso va verificata prima in `Modules/Xot/app/Actions/`.

## Checklist rapida
1. Leggere docs tema pertinenti.
2. Scrivere nei docs tema il contesto intenzionale del task e la motivazione della direzione scelta.
3. Aggiornare docs tema con vincoli/scelte e note di handoff per altri agenti.
4. Modificare codice tema.
5. Verificare output UI/PDF.
6. Valutare Issue/Discussion GitHub se il cambiamento impatta governance o architettura, sempre dopo `git remote -v`.
