# Gestione dei Namespace nei Componenti a Blocchi

Questo documento spiega come gestire correttamente i namespace nei componenti a blocchi in il progetto, con un focus particolare sulla risoluzione di problemi comuni.

## Namespace pub_theme vs one

In il progetto, il tema pubblico viene referenziato con il namespace `pub_theme::` nei file di configurazione e nei file JSON, indipendentemente dal nome effettivo del tema (che può essere "One" o altro).

### Percorsi corretti per i componenti blocchi

- Il formato corretto è: `pub_theme::components.blocks.tipo_blocco.variante`
- Esempio: `pub_theme::components.blocks.hero.simple`

### Corrispondenza tra Namespace e File Fisici

Il namespace `pub_theme::components.blocks.hero.simple` corrisponde fisicamente al file:
```
/var/www/html/_bases/<directory progetto>/laravel/Themes/One/resources/views/components/blocks/hero/simple.blade.php
```

Se il file fisico non esiste, il sistema genererà un errore del tipo:
```
deprecated view not exists [pub_theme::components.blocks.hero.simple]
```

## Risoluzione dei Problemi

### 1. Errore "view not exists"

Se incontri un errore "view not exists" per un componente blocco, verifica:

1. **L'esistenza del file fisico**: assicurati che il file `.blade.php` esista nella posizione corretta
2. **L'estensione del file**: il file deve avere estensione `.blade.php` e non `.balde.php` o altre varianti
3. **La struttura delle directory**: controlla che le cartelle siano organizzate correttamente

### 2. Struttura corretta delle directory

Per un corretto funzionamento, la struttura delle directory deve riflettere il namespace:

```
laravel/Themes/One/resources/views/components/blocks/
├── hero/
│   └── simple.blade.php
├── feature_sections/
│   └── simple.blade.php
├── cta/
│   └── centered.blade.php
├── sidebar/
│   ├── contact_info.blade.php
│   ├── info_card.blade.php
│   └── emergency_info.blade.php
└── ... altri componenti ...
```

### 3. Creazione di nuovi componenti

Quando crei un nuovo componente:

1. Crea le directory necessarie se non esistono:
   ```bash
   mkdir -p laravel/Themes/One/resources/views/components/blocks/nuovo_blocco
   ```

2. Crea il file `.blade.php` nella posizione corretta:
   ```bash
   touch laravel/Themes/One/resources/views/components/blocks/nuovo_blocco/variante.blade.php
   ```

3. Referenzia il componente nel JSON utilizzando il namespace `pub_theme::`:
   ```json
   {
       "type": "nuovo_blocco",
       "data": {
           "view": "pub_theme::components.blocks.nuovo_blocco.variante",
           // altri dati...
       }
   }
   ```

## Componenti Comuni

Ecco l'elenco dei componenti blocchi comuni e i loro percorsi:

| Tipo di Blocco | Variante | Namespace | File Fisico |
|----------------|----------|-----------|-------------|
| hero | simple | `pub_theme::components.blocks.hero.simple` | `Themes/One/resources/views/components/blocks/hero/simple.blade.php` |
| feature_sections | simple | `pub_theme::components.blocks.feature_sections.simple` | `Themes/One/resources/views/components/blocks/feature_sections/simple.blade.php` |
| cta | centered | `pub_theme::components.blocks.cta.centered` | `Themes/One/resources/views/components/blocks/cta/centered.blade.php` |
| paragraph | simple | `pub_theme::components.blocks.paragraph.simple` | `Themes/One/resources/views/components/blocks/paragraph/simple.blade.php` |
| booking_form | multi_step | `pub_theme::components.blocks.booking_form.multi_step` | `Themes/One/resources/views/components/blocks/booking_form/multi_step.blade.php` |
| faq_accordion | simple | `pub_theme::components.blocks.faq_accordion.simple` | `Themes/One/resources/views/components/blocks/faq_accordion/simple.blade.php` |
| testimonial_carousel | simple | `pub_theme::components.blocks.testimonial_carousel.simple` | `Themes/One/resources/views/components/blocks/testimonial_carousel/simple.blade.php` |

## Componenti Sidebar

| Tipo di Blocco | Namespace | File Fisico |
|----------------|-----------|-------------|
| contact_info | `pub_theme::components.blocks.sidebar.contact_info` | `Themes/One/resources/views/components/blocks/sidebar/contact_info.blade.php` |
| info_card | `pub_theme::components.blocks.sidebar.info_card` | `Themes/One/resources/views/components/blocks/sidebar/info_card.blade.php` |
| emergency_info | `pub_theme::components.blocks.sidebar.emergency_info` | `Themes/One/resources/views/components/blocks/sidebar/emergency_info.blade.php` |

## Componenti Footer

| Tipo di Blocco | Namespace | File Fisico |
|----------------|-----------|-------------|
| related_services | `pub_theme::components.blocks.footer.related_services` | `Themes/One/resources/views/components/blocks/footer/related_services.blade.php` |
| privacy_notice | `pub_theme::components.blocks.footer.privacy_notice` | `Themes/One/resources/views/components/blocks/footer/privacy_notice.blade.php` |

## Best Practices

1. **Organizzazione dei File**: Mantenere una struttura organizzata delle directory per i componenti
2. **Namespace Coerenti**: Usare sempre `pub_theme::` come namespace e non il nome effettivo del tema
3. **Estensioni Corrette**: Assicurarsi che i file abbiano l'estensione `.blade.php`
4. **Proprietà Props**: Definire chiaramente le props accettate dal componente usando la direttiva `@props`
