# Checklist Pre-Implementazione

Questa checklist deve essere consultata prima di iniziare qualsiasi attività di sviluppo nel progetto <nome progetto> per garantire il rispetto delle regole e delle convenzioni.

- [ ] Ho letto e compreso le regole fondamentali del progetto in `PROJECT_RULES.md`.
- [ ] Ho verificato la documentazione esistente nella directory `/docs` relativa all'area di lavoro.
- [ ] Ho controllato le convenzioni di nomenclatura e struttura per file, namespace e directory.
- [ ] Ho assicurato che non sto utilizzando `->label()` nei componenti Filament.
- [ ] Ho utilizzato ENUM per opzioni fisse invece di array hardcoded.
- [ ] Ho seguito il pattern Action-based con `spatie/laravel-queueable-action` per la business logic asincrona.
- [ ] Ho utilizzato Widget di Filament per form e UI, evitando componenti Livewire diretti.
- [ ] Ho separato configurazioni generiche e specifiche nei file di configurazione.
- [ ] Ho evitato valori predefiniti per parametri critici nelle variabili d'ambiente.
- [ ] Ho documentato ogni modifica o nuova implementazione con riferimenti ai file di codice.

Assicurati di spuntare tutte le voci prima di procedere con lo sviluppo.
