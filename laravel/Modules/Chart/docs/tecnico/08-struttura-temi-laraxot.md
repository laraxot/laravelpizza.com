# Struttura dei Temi in Laraxot (il progetto)

## Introduzione

Questo documento descrive la corretta organizzazione dei temi nell'architettura il progetto, chiarendo la distinzione fondamentale tra moduli e temi nel contesto dell'organizzazione delle directory del progetto.

## Separazione tra Moduli e Temi

### Moduli vs Temi

Nell'ecosistema Laraxot, esiste una netta separazione concettuale e organizzativa tra:

1. **Moduli**: Componenti funzionali che implementano logica di business, funzionalità specifiche e strutture dati
2. **Temi**: Componenti di presentazione che definiscono l'aspetto visivo, i layout e l'esperienza utente dell'applicazione

### Struttura delle Directory

La corretta organizzazione delle directory riflette questa separazione:

```
/var/www/html/<nome progetto>/laravel/
├── Modules/           # Directory per i moduli funzionali
│   ├── Xot/
│   ├── Lang/
│   ├── User/
│   ├── Tenant/
│   └── ...
│
└── Themes/            # Directory per i temi dell'applicazione
    ├── One/           # ThemeOne (tema principale)
    └── ...
```

## Posizionamento Corretto dei Temi

Il tema principale utilizzato in il progetto, denominato "ThemeOne", deve essere posizionato correttamente in:

```
/var/www/html/<nome progetto>/laravel/Themes/One/
```

### Installazione Corretta

Per installare correttamente il tema, il comando git subtree deve specificare il percorso corretto:

```bash
git subtree add --prefix laravel/Themes/One git@github.com:laraxot/theme_one_fila3.git dev --squash
```

**NON utilizzare** il comando seguente (errato):
```bash
git subtree add --prefix laravel/Modules/ThemeOne git@github.com:laraxot/theme_one_fila3.git dev --squash
```

## Motivazioni della Separazione

### Facilità di Manutenzione

La separazione tra moduli e temi consente:
- Sviluppo parallelo di funzionalità e aspetto visivo
- Sostituzione dei temi senza modificare la logica di business
- Migliore organizzazione del codice

### Compatibilità con il Framework

L'organizzazione rispetta le convenzioni di Laravel e dei pacchetti utilizzati:
- `nwidart/laravel-modules` gestisce i moduli nella directory `Modules/`
- I temi seguono una struttura separata nella directory `Themes/`

### Caricamento e Discovery

La separazione garantisce il corretto caricamento e discovery di moduli e temi:
- Il service provider dei moduli cerca nella directory `Modules/`
- I temi vengono caricati separatamente dalla directory `Themes/`

## Struttura Interna di un Tema

Un tema Laraxot (come ThemeOne) contiene tipicamente:

- `resources/views/`: Template Blade, layout e componenti visivi
- `resources/css/`: File CSS e SCSS
- `resources/js/`: Script JavaScript e asset frontend
- `public/`: Asset statici (immagini, font, ecc.)
- `src/`: Codice PHP specifico del tema (provider, helper, ecc.)

## Integrazione con Filament

ThemeOne è specificamente progettato per integrarsi con Filament 4, fornendo:

- Pannelli di amministrazione personalizzati
- Componenti Filament personalizzati
- Temi di colori e stili coerenti
- Layout responsivi ottimizzati

## Conclusioni

La corretta organizzazione dei temi in il progetto è fondamentale per garantire una struttura coerente e manutenibile del progetto. Il rispetto della separazione tra `Modules/` e `Themes/` facilita lo sviluppo, la manutenzione e l'espansione futura dell'applicazione.
