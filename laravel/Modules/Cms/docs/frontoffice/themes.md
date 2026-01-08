# Gestione Temi - Linee Guida e Riflessioni

## Introduzione

Questa sezione descrive come gestire, compilare e pubblicare i temi del CMS, con particolare attenzione al tema One.

## Verifica Tema Attivo

### Configurazione Corretta
```php
// config/localhost/xra.php
return [
    'pub_theme' => 'One', // Tema attualmente in uso
];
```

### Struttura del Tema One
```
laravel/Themes/One/
├── assets/          # Assets del tema
├── resources/       # Risorse (views, components)
├── layouts/         # Layouts del tema
├── livewire/        # Componenti Livewire
├── routes/          # Route specifiche del tema
├── app/             # Logica applicativa
├── config/          # Configurazioni specifiche
├── docs/            # Documentazione del tema
└── package.json     # Dipendenze e script
```

## Compilazione e Pubblicazione

### Comandi Corretti
```bash
# Compilazione
npm run build

# Pubblicazione
npm run copy
```

## Riflessioni e Linee Guida

### Errori da Evitare

1. **Non assumere mai la struttura standard**
   - Ogni progetto ha la sua organizzazione
   - Verificare sempre la struttura effettiva
   - Documentare le peculiarità

2. **Non generalizzare i comandi**
   - Ogni tema può avere comandi specifici
   - Verificare sempre il package.json
   - Testare i comandi in locale

3. **Non ignorare la configurazione locale**
   - Controllare i file di configurazione specifici
   - Verificare le variabili d'ambiente
   - Documentare le dipendenze

### Best Practices

1. **Verifica Struttura**
   ```bash
   # Prima di qualsiasi modifica
   ls -la /path/to/theme
   cat package.json
   ```

2. **Documentazione**
   - Mantenere aggiornato il README.md
   - Documentare le dipendenze
   - Annotare i comandi specifici

3. **Versionamento**
   - Usare git per tracciare le modifiche
   - Mantenere un changelog
   - Tag le versioni importanti

### Filosofia del Tema

1. **Modularità**
   - Ogni tema è un ecosistema autonomo
   - Mantenere le dipendenze locali
   - Isolare le configurazioni

2. **Manutenibilità**
   - Struttura chiara e documentata
   - Codice pulito e commentato
   - Test automatizzati

3. **Performance**
   - Ottimizzare gli assets
   - Utilizzare cache appropriata
   - Monitorare i tempi di compilazione

## Troubleshooting Avanzato

### Errori Comuni e Soluzioni

1. **Problemi di Compilazione**
   ```bash
   # Verifica dipendenze
   npm list
   
   # Pulizia cache
   npm cache clean --force
   
   # Reinstallazione
   rm -rf node_modules
   npm install
   ```

2. **Problemi di Pubblicazione**
   ```bash
   # Verifica permessi
   ls -la public/themes/One
   
   # Forza copia
   npm run copy -- --force
   ```

3. **Problemi di Cache**
   ```bash
   # Pulizia cache Laravel
   php artisan cache:clear
   php artisan view:clear
   php artisan config:clear
   ```

## Zen del Tema

1. **Principio di Responsabilità Unica**
   - Ogni file ha un solo scopo
   - Ogni cartella ha una sola responsabilità
   - Ogni tema è indipendente

2. **Principio di Trasparenza**
   - Struttura chiara e intuitiva
   - Documentazione completa
   - Logging dettagliato

3. **Principio di Evoluzione**
   - Adattarsi ai cambiamenti
   - Migliorare continuamente
   - Mantenere la compatibilità

## Risorse Utili

- [Documentazione Tema One](laravel/Themes/One/docs)
- [Tailwind CSS](https://tailwindcss.com/)
- [Vite](https://vitejs.dev/)
- [Laravel Mix](https://laravel-mix.com/)

## Collegamenti tra versioni di themes.md
* [themes.md](docs/rules/themes.md)
* [themes.md](laravel/Modules/Xot/docs/themes.md)
* [themes.md](laravel/Modules/Cms/docs/frontoffice/themes.md)

