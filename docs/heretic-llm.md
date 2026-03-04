# heretic llm e tema meetup

## contesto

Heretic (`https://github.com/p-e-w/heretic`) è un tool Python per modificare modelli LLM (directional ablation) con l’obiettivo di ridurre i *refusal* su prompt “harmful” mantenendo il più possibile intatte le capacità del modello.

Nel contesto del tema `Meetup`:

- non viene eseguito né integrato a runtime
- non influisce direttamente su Blade/Volt/Tailwind o sul rendering del frontoffice
- è solo un riferimento concettuale su come i modelli possono essere analizzati e modificati “fuori banda”

## regole per l’uso concettuale

- non usare Heretic per:
  - alterare la safety dei modelli che supportano gli strumenti AI usati sul progetto
  - generare o consigliare contenuti che violano le policy di sicurezza
- usarlo solo come:
  - esempio di ricerca avanzata su residui e direzioni semantiche nei transformer
  - reminder che ogni scelta UX/testo nel tema deve comunque rispettare:
    - scopo del progetto (community Laravel)
    - regole di sicurezza e di contenuto dell’ambiente in cui gira l’agente

## collegamenti interni

- metodo di lavoro AI‑assistito: `bmad-method.md`
- panoramica architettura tema: `architecture-folio-volt-filament.md`
- regole critiche tema: `critical-rules-and-patterns.md`
- documento centrale su Heretic in Laraxot: `../../Modules/Xot/docs/heretic-llm.md`

