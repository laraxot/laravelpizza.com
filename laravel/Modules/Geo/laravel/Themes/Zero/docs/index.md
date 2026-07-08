# Indice della Documentazione - Tema Zero

## Panoramica
Questo documento serve come indice centrale per il tema Zero, fornendo una guida per la personalizzazione e l'utilizzo del tema all'interno dell'applicazione Laravel. Il tema Zero è un tema basato su TailwindCSS con supporto per Vite e componenti Blade moderni.

## Principi Chiave
1. **Semplicità**: Il tema Zero è progettato per essere semplice e leggero
2. **Personalizzabilità**: Consente facile personalizzazione attraverso configurazioni e sovrascrittura di componenti
3. **Performance**: Ottimizzato per prestazioni elevate con asset minimizzati
4. **Responsive**: Completamente responsive per tutti i dispositivi

## Funzionalità Principali
- **TailwindCSS**: Framework CSS utility-first per uno styling moderno e coerente
- **Vite**: Bundler moderno per la compilazione degli assets
- **Componenti Blade**: Libreria di componenti riutilizzabili per l'interfaccia frontend
- **Layout Flessibili**: Sistema di layout adattivo per diverse tipologie di pagina
- **Traduzioni**: Supporto multilingua integrato
- **Temi Personalizzabili**: Sistema di estensione per creare varianti del tema
- **Integrazione Filament**: Compatibilità completa con i componenti Filament

## Collegamenti Correlati
- [AI Methodologies](./ai-methodologies.md)
- [Documentazione Generale Progetto](../../../docs/README.md) (docs: replace project-specific references with generic placeholders across documentation)
- [Collegamenti Documentazione](../../../docs/collegamenti-documentazione.md)
- [Standard di Documentazione](../../../docs/DOCUMENTATION_STANDARDS.md)
- [Modulo UI](../../Modules/UI/docs/README.md)
- [Modulo Xot](../../Modules/Xot/docs/README.md)

### Moduli Integrati
- [Performance Actions Reference](./performance-actions-reference.md) - Riferimento action calcolo performance

## Categorie Principali

### Architettura e Struttura
- [README](./README.md) - Panoramica generale del tema
- [Architettura](./architecture.md) - Architettura generale del tema
- [Struttura](./layouts.md) - Struttura delle directory e dei layout
- [Componenti](./components.md) - Componenti Blade disponibili

### Personalizzazione
- [Personalizzazione](./customization.md) - Guida alla personalizzazione del tema
- [Readonly Field Styling](./readonly-field-styling.md) - Pattern UI/UX per campi readonly/calcolati
- [Esempi](./examples.md) - Esempi pratici di personalizzazione
- [Autenticazione](./authentication.md) - Componenti di autenticazione
- [Esempi Autenticazione](./auth_examples.md) - Esempi di pagine di autenticazione

### Sviluppo e Configurazione
- [Configurazione](./configuration.md) - Configurazione del tema
- [Compilazione Assets](./asset-compilation.md) - Guida alla compilazione degli assets
- [TailwindCSS](./tailwind.md) - Configurazione e personalizzazione Tailwind
- [Vite](./vite.md) - Configurazione e ottimizzazione Vite

### Traduzioni
- [Sistema Traduzioni](./translations.md) - Sistema di traduzioni del tema
- [File Lingua](./language-files.md) - Gestione dei file di traduzione
- [Localizzazione](./localization.md) - Localizzazione del tema

### Testing e Qualità
- [Testing](./testing.md) - Strategie e approcci per il testing del tema
- [Performance](./performance.md) - Ottimizzazioni e analisi performance
- [Accessibilità](./accessibility.md) - Linee guida per l'accessibilità

## Linee Guida per l'Implementazione

### 1. Struttura del Tema
Il tema Zero segue una struttura standard con directory per componenti, risorse e configurazioni:

```
Zero/
├── app/
│   ├── View/
│   │   └── Components/
├── lang/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── components/
│       ├── layouts/
│       └── pages/
└── docs/
```

### 2. Personalizzazione del Tema
Per personalizzare il tema Zero:

1. **Sovrascrivere i componenti**:
   ```bash
   # Copiare un componente esistente
   cp resources/views/components/button.blade.php resources/views/components/custom-button.blade.php
   ```

2. **Modificare i layout**:
   ```bash
   # Creare un layout personalizzato
   cp resources/views/layouts/app.blade.php resources/views/layouts/custom.blade.php
   ```

3. **Aggiungere stili personalizzati**:
   ```css
   /* resources/css/custom.css */
   .custom-class {
       @apply bg-blue-500 text-white rounded-lg;
   }
   ```

### 3. Compilazione Assets
```bash
# Sviluppo
npm run dev

# Produzione
npm run build

# Watch mode
npm run watch
```

### 4. Configurazione Tailwind
```javascript
// tailwind.config.js
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#3B82F6',
                secondary: '#10B981',
            },
        },
    },
    plugins: [],
}
```

## Problemi Comuni e Soluzioni
- **Assets non caricati**: Verificare che `npm run build` sia stato eseguito
- **Stili non applicati**: Controllare la configurazione di TailwindCSS
- **Componenti mancanti**: Verificare la registrazione corretta dei componenti Blade
- **Traduzioni mancanti**: Controllare la presenza dei file di traduzione

## Documentazione e Aggiornamenti
- Documentare qualsiasi personalizzazione o modifica al tema nella cartella di documentazione
- Aggiornare questo indice se vengono introdotte nuove funzionalità o modifiche significative al tema Zero

## Collegamenti alla Documentazione Correlata
- [Panoramica Architettura](./architecture.md)
- [Personalizzazione](./customization.md)
- [Componenti](./components.md)
- [Esempi](./examples.md)
- [Troubleshooting](./troubleshooting.md)

## Note sulla Manutenzione
Questa documentazione viene aggiornata regolarmente. Prima di apportare modifiche al tema, consultare la documentazione pertinente e aggiornare i documenti correlati.

## Risoluzione Conflitti e Standard
- **Gennaio 2025**: Risoluzione sistematica di tutti i conflitti Git nei file di documentazione
- Il file `lang/it/zero_theme.php` è stato risolto manualmente mantenendo PSR-12, strict_types, array short syntax e solo chiavi effettive, come richiesto dagli standard PHPStan livello 10
- **Filosofia di risoluzione**: Approccio olistico con analisi manuale approfondita, mantenimento integrità architetturale, documentazione bidirezionale aggiornata
- Vedi anche: [../../../docs/README.md](../../../docs/README.md)
- Per dettagli sulle scelte architetturali e funzionali, consultare la doc globale e la sezione "Standard e Traduzioni".

- **Aggiunto**: Sistema di documentazione automatica moduli
- **Integrato**: Refresh intelligente form reattivi
- **Migliorato**: Sistema di tracking e audit trail