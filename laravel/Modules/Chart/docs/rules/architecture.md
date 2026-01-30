# Regole per la Gestione dell'Architettura

## Tecnologie Utilizzate

### Stack Principale
- **Laravel 12**: Framework principale
- **Volt**: Gestione delle routes
- **Folio**: Gestione delle pagine
- **Livewire**: Componenti reattivi
- **Filament**: Amministrazione
- **Laraxot**: Personalizzazioni
- **Tailwind CSS**: Gestione degli stili

### Struttura del Progetto
- `/laravel`: Core dell'applicazione
- `/laravel/Modules`: Moduli dell'applicazione
- `/laravel/Modules/{ModuleName}/app`: Codice specifico del modulo
- `/laravel/Themes`: Temi dell'applicazione
- `/laravel/Themes/One`: Tema principale
- `/laravel/Themes/One/resources/views`: Viste del tema
- `/laravel/Themes/One/resources/views/pages`: Pagine del tema
- `/laravel/Themes/One/resources/views/components`: Componenti del tema

## Struttura Moduli
1. **Percorsi**:
   - Componenti Filament: `/Modules/{ModuleName}/app/Filament`
   - Widget: `/Modules/{ModuleName}/app/Filament/Widgets`
   - Resources: `/Modules/{ModuleName}/app/Filament/Resources`
   - Pages: `/Modules/{ModuleName}/app/Filament/Pages`

2. **Namespace**:
   - Utilizzare il namespace del modulo
   - Esempio: `Modules\User\Filament\Widgets`
   - Evitare namespace duplicati

3. **Best Practices**:
   - Verificare sempre la struttura del modulo target
   - Controllare i namespace corretti
   - Documentare le modifiche
   - Mantenere la coerenza

## Componenti Filament
1. **Widget**:
   - Utilizzare widget per funzionalità complesse
   - Sfruttare i componenti predefiniti
   - Evitare duplicazione di logica
   - Mantenere coerenza con design system

2. **Form**:
   - Utilizzare i form di Filament
   - Sfruttare la validazione integrata
   - Implementare wizard per processi multi-step
   - Utilizzare componenti predefiniti

3. **Best Practices**:
   - Creare widget dedicati
   - Separare le responsabilità
   - Mantenere la coerenza
   - Documentare le implementazioni

## Gestione Filament
1. **Provider**:
   - Non modificare mai i provider del core
   - Creare provider dedicati per ogni modulo
   - Utilizzare l'estensione invece della modifica
   - Seguire il pattern di configurazione modulare

2. **Registrazione Componenti**:
   - Registrare i componenti nel provider del modulo
   - Utilizzare i meccanismi di estensione
   - Mantenere la separazione delle responsabilità
   - Documentare le configurazioni

3. **Best Practices**:
   - Creare provider dedicati
   - Estendere invece di modificare
   - Mantenere la coerenza
   - Documentare le implementazioni

## Gestione ServiceProvider
1. **Analisi Preventiva**:
   - Verificare sempre la struttura esistente
   - Comprendere l'ereditarietà
   - Analizzare i metodi disponibili

2. **Estensione vs Modifica**:
   - Utilizzare i metodi esistenti
   - Estendere invece di modificare
   - Mantenere la coerenza

3. **Best Practices**:
   - Non modificare mai i provider esistenti
   - Utilizzare i metodi ereditati
   - Documentare le estensioni

## Processo di Sviluppo

### 1. Analisi
- Verificare la struttura del modulo
- Controllare i namespace
- Analizzare le dipendenze

### 2. Implementazione
- Creare provider dedicati
- Utilizzare meccanismi di estensione
- Documentare le modifiche

### 3. Validazione
- Controllare la coerenza
- Verificare le dipendenze
- Testare le funzionalità

## Best Practices

### 1. Struttura
- Mantenere la gerarchia dei temi
- Utilizzare i componenti appropriati
- Seguire le convenzioni

### 2. Tecnologie
- Utilizzare Volt per le routes
- Implementare Folio per le pagine
- Sfruttare Livewire per i componenti
- Integrare Filament per l'admin
- Personalizzare con Laraxot
- Utilizzare Tailwind CSS per la gestione degli stili

### 3. Documentazione
- Mantenere aggiornata la documentazione
- Documentare la struttura
- Creare esempi di utilizzo

## Checklist di Verifica

### Prima dello Sviluppo
- [ ] Verificare la struttura del modulo
- [ ] Controllare i namespace
- [ ] Analizzare le dipendenze

### Durante lo Sviluppo
- [ ] Seguire la struttura corretta
- [ ] Utilizzare le tecnologie appropriate
- [ ] Verificare la compatibilità

### Dopo lo Sviluppo
- [ ] Testare le funzionalità
- [ ] Verificare la struttura
- [ ] Aggiornare la documentazione

## Esempi Pratici

### Gestione Routes
1. Utilizzare Volt per le routes
2. Seguire la struttura dei temi
3. Verificare le convenzioni

### Componenti
1. Implementare con Livewire
2. Utilizzare i componenti esistenti
3. Verificare la compatibilità

### Pagine
1. Creare con Folio
2. Seguire la struttura dei temi
3. Testare le funzionalità

### Stili
1. Utilizzare classi tema
2. Nessun tag `<style>` nei file Blade
3. Coerenza con il sistema di design
4. Utilizzo di Tailwind CSS
5. Componenti Filament predefiniti

## Monitoraggio e Manutenzione
- Revisione periodica della struttura
- Aggiornamento della documentazione
- Verifica delle convenzioni
- Analisi degli errori

## Monitoraggio
- Verifica periodica della struttura
- Analisi delle dipendenze
- Controllo dei namespace
- Valutazione della coerenza

- Verifica delle estensioni
- Analisi dei provider
- Controllo delle configurazioni
- Valutazione della coerenza 
## Collegamenti tra versioni di architecture.md
* [architecture.md](docs/tecnico/filament/architecture.md)
* [architecture.md](docs/rules/architecture.md)
* [architecture.md](laravel/Modules/Gdpr/docs/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/frontoffice/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/architecture.md)
* [architecture.md](laravel/Themes/One/docs/roadmap/inspiration/architecture.md)

