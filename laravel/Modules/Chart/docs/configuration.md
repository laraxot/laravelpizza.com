# Configurazione del Progetto

## Prerequisiti
- Laravel 12.x
- PHP 8.2+
- Composer 2.x

## Introduzione
Questo documento fornisce una panoramica delle configurazioni del progetto, con particolare attenzione alla gestione dei domini e delle risorse.

## Indice

### Configurazione Dominio
- [Configurazione Basata sul Dominio](../laravel/Modules/Xot/docs/DOMAIN_CONFIGURATION.md)
  - Meccanismo di risoluzione del dominio
  - Struttura delle configurazioni
  - Gestione dei loghi
  - Best practices

### Configurazioni Specifiche per Modulo
- [Configurazione Xot](../laravel/Modules/Xot/docs/CONFIGURATION.md)
- [Configurazione UI](../laravel/Modules/UI/docs/configuration.md)
- [Configurazione Moduli](../laravel/Modules/Xot/docs/MODULE_CONFIGURATION.md)

### Asset e Risorse
- [Gestione Asset](../laravel/Modules/Xot/docs/assets.md)
- [Gestione Temi](../laravel/Modules/Xot/docs/themes.md)
- [Gestione Media](../laravel/Modules/Media/docs/README.md)

## Struttura delle Configurazioni

### 1. Configurazione per Dominio
```
laravel/config/
└── [dominio]/
    └── [sottodominio]/
        ├── metatag.php      # Configurazioni metatag e loghi
        └── config.php       # Configurazioni specifiche
```

### 2. Configurazione dei Moduli
```
laravel/Modules/
└── [NomeModulo]/
    ├── config/
    │   └── config.php       # Configurazione modulo
    └── resources/
        └── images/          # Risorse del modulo
            └── logo.svg
```

## Best Practices
1. Seguire la struttura di configurazione definita nel [modulo Xot](../laravel/Modules/Xot/docs/DOMAIN_CONFIGURATION.md)
2. Mantenere le configurazioni specifiche nei rispettivi moduli
3. Utilizzare i percorsi relativi per le risorse
4. Documentare ogni modifica alle configurazioni
5. Mantenere la compatibilità con Laravel 12.x e PHP 8.2+

## Gestione Multi-dominio
- Ogni dominio ha la propria configurazione in `config/[dominio]/`
- I moduli sono riutilizzabili tra diversi domini
- Le configurazioni specifiche per dominio sovrascrivono quelle dei moduli

## Collegamenti Utili
- [Documentazione Sviluppo](development.md)
- [Guida all'Installazione](installation.md)
- [Troubleshooting](troubleshooting.md) 
## Collegamenti tra versioni di configuration.md
* [configuration.md](docs/configuration.md)
* [configuration.md](laravel/Modules/Xot/docs/configuration.md)
* [configuration.md](laravel/Modules/Cms/docs/configuration.md)

