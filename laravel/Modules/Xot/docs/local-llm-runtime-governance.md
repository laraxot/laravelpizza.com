# Local LLM Runtime Governance

## Perche' esiste

Gli agenti AI che lavorano su questo progetto possono usare Ollama locale. Se la GPU AMD non viene usata davvero, il tempo perso in attese e diagnosi aumenta molto.

## Regola chiave

In ambiente WSL non bisogna confondere:

- pacchetti installati nel guest;
- runtime GPU realmente inizializzato;
- supporto del driver AMD lato Windows host.

## Policy

- Prima di installare o reinstallare pacchetti, verificare:
  - `/dev/dxg`;
  - `rocminfo`;
  - log di Ollama;
  - presenza delle librerie ROCm.
- Se `rocminfo` fallisce ma ROCm e Ollama sono gia' presenti, trattare il problema come mismatch WSL/driver finche' non si prova il contrario.
- Non descrivere il sistema come "non configurato" se il guest e' gia' all'80% del percorso e manca solo l'inizializzazione reale GPU.

## Obiettivo

Portare l'inferenza locale da:

- stato attuale: 100% CPU;

a:

- stato target: uso GPU verificato, ripetibile e documentato.
