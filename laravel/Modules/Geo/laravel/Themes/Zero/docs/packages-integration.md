# Integrazione Pacchetti nel Tema Zero

Il tema Zero utilizza le ultime tecnologie dell'ecosistema Laravel per offrire un'esperienza utente moderna e accessibile.

## 1. UI & Componenti
- **Flux UI**: La libreria principale per i componenti frontend. Garantisce che tutti gli elementi (bottoni, form, modali) siano accessibili e seguano lo stile del progetto.
- **Livewire Volt**: Utilizzato per rendere i componenti del tema reattivi senza la necessità di classi PHP separate quando non necessario.

## 2. Asset Management
- **Vite & Tailwind v4**: Il build system è ottimizzato per Tailwind CSS v4, eliminando la necessità di configurazioni JS complesse e migliorando le performance di caricamento.

## 3. Media & Grafici
- **Spatie MediaLibrary**: Gestisce gli asset del tema (loghi, background, immagini di profilo).
- **JpGraph 4.4.2**: Utilizzato server-side per generare grafici statici da includere nei report PDF generati dal tema.
