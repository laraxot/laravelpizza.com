# Guida al Modern Tech Stack - Laraxot PTVX

Questa guida delinea come utilizzare al meglio i pacchetti installati per mantenere l'architettura pulita e performante.

## 1. Gestione Logica di Business
- **Spatie Laravel Data**: Usare per TUTTI i passaggi di dati complessi. Sostituisce gli array associativi generici.
  - *Best Practice*: Creare un DTO per ogni input di form o risposta API complessa.
- **Spatie Queueable Action**: Usare per logica riutilizzabile. Preferire alle Classi Service.
  - *Vantaggio*: Facilmente testabili e integrabili con le code.

## 2. UI & Frontend (Filament 5 + Livewire 4)
- **Flux UI**: Utilizzare i componenti Flux per interfacce coerenti.
- **Volt**: Usare per piccoli componenti Livewire funzionali dove la classe separata sarebbe overkill.
- **Filament Charts**: Utilizzare `XotBaseChartWidget` per grafici interattivi.

## 3. Database & Eloquent
- **HasManyDeep / Adjacency List**: Usare queste librerie per relazioni complesse o gerarchiche (es. organigrammi, categorie nidificate).
- **Safe Functions**: Usare `Safe\file_get_contents` ecc. per evitare controlli manuali di errore su funzioni core PHP.
- **Parental**: Usare per implementare il polimorfismo Single Table Inheritance quando più modelli condividono la stessa tabella.

## 4. Media & Documenti
- **Intervention Image v3**: Usare per elaborazione immagini (resize, watermark).
- **Spatie MediaLibrary**: Usare per associare file ai modelli.
- **Html2Pdf**: Usare per la generazione di report PDF legacy o semplici.

## 5. Qualità e Analisi
- **PHPStan Livello 10**: Obbligatorio per tutti i nuovi moduli.
- **Laravel Pulse**: Usare la dashboard Pulse (`/pulse`) per identificare query lente e colli di bottiglia in tempo reale.
