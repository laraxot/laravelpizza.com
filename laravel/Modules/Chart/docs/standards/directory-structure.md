# Struttura Directory del Progetto

## Convenzioni di Nomenclatura

### Directory Resources
- **CORRETTO**: `resources` (tutto minuscolo)
- **ERRATO**: `Resources` (con la R maiuscola)

### Percorsi Standard

1. **Moduli**
   ```
   /laravel/Modules/
   ├── UI/
   │   └── resources/          # CORRETTO
   │       ├── css/
   │       ├── js/
   │       └── views/
   └── [Altri Moduli]/
       └── resources/          # CORRETTO
   ```

2. **Temi**
   ```
   /laravel/Themes/
   ├── One/
   │   └── resources/          # CORRETTO
   └── [Altri Temi]/
       └── resources/          # CORRETTO
   ```

## Best Practices

1. **Nomenclatura Directory**
   - Utilizzare sempre lettere minuscole
   - Separare le parole con trattini se necessario
   - Mantenere nomi descrittivi e brevi

2. **Struttura Consistente**
   - Seguire lo stesso pattern in tutti i moduli
   - Mantenere la stessa profondità di directory
   - Usare percorsi relativi quando possibile

3. **Esempi Corretti**
   ```php
   // CORRETTO
   resource_path('Modules/UI/resources/views');
   theme_path('One/resources/css');
   
   // ERRATO
   resource_path('Modules/UI/Resources/views');
   theme_path('One/Resources/css');
   ```

## Regole di Validazione

1. **Verifica Percorsi**
   - Controllare la nomenclatura delle directory
   - Verificare la coerenza tra moduli
   - Assicurarsi che i percorsi siano accessibili

2. **Documentazione**
   - Aggiornare i percorsi nei commenti
   - Mantenere la coerenza nella documentazione
   - Segnalare eventuali discrepanze

## Troubleshooting

1. **Problemi Comuni**
   - Percorsi non trovati
   - Incoerenza nella nomenclatura
   - Errori di accesso alle risorse

2. **Soluzioni**
   - Verificare la nomenclatura corretta
   - Controllare i permessi delle directory
   - Aggiornare i riferimenti nei file

## Strumenti di Verifica

1. **Script di Validazione**
   ```bash
   # Verifica la struttura delle directory
   find . -type d -name "Resources" -not -path "*/vendor/*"
   
   # Corregge la nomenclatura
   find . -type d -name "Resources" -not -path "*/vendor/*" -exec rename 's/Resources/resources/' {} +
   ```

2. **Comandi Utili**
   ```bash
   # Lista directory con problemi
   ls -la | grep -i "resources"
   
   # Verifica permessi
   find . -type d -name "resources" -exec ls -ld {} \;
   ``` 
