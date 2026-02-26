# Regole Struttura Directory

## Struttura Base del Progetto

La struttura corretta del progetto il progetto segue questo schema:

```
/var/www/html/base_<nome progetto>/
├── laravel/               # Directory principale per il codice Laravel
│   ├── Modules/          # Moduli dell'applicazione
│   │   ├── Xot/
│   │   ├── Patient/
│   │   └── ...
│   └── Themes/           # Temi dell'applicazione
│       └── One/          # Tema principale
│           ├── resources/
│           │   └── views/
│           └── ...
├── docs/                 # Documentazione generale
└── ...
```

## Regole Fondamentali

1. **Directory Laravel**
   - Tutto il codice Laravel DEVE essere nella directory `laravel/`
   - I percorsi relativi partono da questa directory
   - Non utilizzare mai percorsi che saltano questa directory

2. **Moduli**
   - Tutti i moduli DEVONO essere in `laravel/Modules/`
   - Ogni modulo ha la propria struttura interna
   - I namespace riflettono questa struttura

3. **Temi**
   - Tutti i temi DEVONO essere in `laravel/Themes/`
   - Ogni tema ha la propria struttura di risorse
   - Le views sono in `resources/views/`

## Errori Comuni

### 1. Percorso Errato dei Temi
❌ Errore riscontrato:
```
/var/www/html/base_<nome progetto>/Themes/One/resources/views/pages/auth/register.blade.php
```

✅ Percorso corretto:
```
/var/www/html/base_<nome progetto>/laravel/Themes/One/resources/views/pages/auth/register.blade.php
```

**Causa dell'errore**: Omissione della directory `laravel/` nel percorso.

**Impatto**:
- File non trovati
- Namespace non corretti
- Errori di caricamento delle view
- Problemi con l'autoloader

**Prevenzione**:
1. Verificare sempre che il percorso inizi con `laravel/`
2. Utilizzare gli helper di Laravel per i percorsi
3. Seguire la struttura standard dei namespace
4. Utilizzare i tool di validazione percorsi

## Best Practices

1. **Uso dei Helper**
```php
resource_path('views/pages/auth/register.blade.php');
```

2. **Namespace Corretti**
```php
namespace Themes\One\View\Components;
```

3. **Validazione Percorsi**
- Utilizzare PHPStan per verificare i percorsi
- Implementare test per il caricamento delle view
- Verificare la struttura delle directory con tool automatici

## Checklist Verifica

Prima di ogni commit, verificare:
- [ ] I percorsi iniziano con `laravel/`
- [ ] La struttura delle directory è corretta
- [ ] I namespace corrispondono ai percorsi
- [ ] Le view sono nel percorso corretto
- [ ] I test validano i percorsi

## Note Importanti

1. La directory `laravel/` è OBBLIGATORIA per tutti i file del framework
2. Non creare mai file fuori dalla struttura standard
3. Mantenere la coerenza tra percorsi e namespace
4. Documentare eventuali eccezioni alla regola

## Collegamenti

- [Struttura Moduli](module-structure.md)
- [Convenzioni Namespace](namespace-rules.md)
- [Best Practices](best-practices.md)
- [PHPStan Configuration](phpstan/configuration.md) 