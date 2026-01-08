# Strategia di Popolamento Metatag - <main module>

## Panoramica

I file metatag in `config/local/<directory progetto>/lang/{locale}/metatag.php` sono stati popolati basandosi sui contenuti delle traduzioni presenti nel tema (`Themes/One/lang/{locale}/`), seguendo una strategia di SEO e social media optimization.

## Fonti Utilizzate

### Traduzioni Tema Analizzate
- `Themes/One/lang/it/navigation.php` - Contenuti hero e navigazione
- `Themes/One/lang/it/landing.php` - Contenuti landing page
- `Themes/One/lang/en/navigation.php` - Versione inglese
- `Themes/One/lang/en/landing.php` - Versione inglese  
- `Themes/One/lang/de/navigation.php` - Versione tedesca

### Contenuti Chiave Estratti

#### Titolo Principale (title)
- **IT**: "<main module> - <slogan> per Gestanti"
- **EN**: "<main module> - Oral Health for Pregnant Women"
- **DE**: "<main module> - Mundgesundheit für Schwangere"

Basato su: `navigation.hero.welcome_title.label`

#### Descrizione (description)
- **IT**: "Il portale che vuole garantire alle pazienti vulnerabili in stato di gravidanza la possibilità di accedere a servizi odontoiatrici di prevenzione a titolo completamente gratuito."
- **EN**: "The portal that aims to guarantee vulnerable pregnant patients the opportunity to access preventive dental services completely free of charge."
- **DE**: "Das Portal, das schwangeren Patientinnen in vulnerablen Situationen die Möglichkeit geben möchte, auf vollständig kostenlose zahnärztliche Präventionsdienste zuzugreifen."

Basato su: `navigation.hero.welcome_subtitle.label`

## Strategia SEO Keywords



### Keywords Inglesi
```
oral health, pregnancy, pregnant women, dentist, prevention, dentistry, 
free visits, ISEE, mother baby health, cavities, dental hygiene, 
dental checkup, first trimester
```

### Keywords Tedesche
```
mundgesundheit, schwangerschaft, schwangere, zahnarzt, prävention, 
zahnmedizin, kostenlose besuche, ISEE, mutter baby gesundheit, karies, 
zahnhygiene, zahnkontrolle, erstes trimester
```

## Metadati Social Media

### Open Graph
- **og_type**: "website"
- **og_site_name**: Nome completo del progetto localizzato
- **og_locale**: Locale specifico (it_IT, en_US, de_DE)

### Twitter Cards
- **twitter_card**: "summary_large_image"
- **twitter_site**: "@<nome progetto>"
- **twitter_creator**: "@<nome progetto>"

### Immagini
- **image**: "/img/logo.png" - Logo del progetto

## Informazioni Progetto

### Autore (author)
- **IT**: "Progetto <main module> - ANDI, INMP, COI"
- **EN**: "<main module> Project - ANDI, INMP, COI"  
- **DE**: "<main module> Projekt - ANDI, INMP, COI"

Basato sui partner del progetto identificati nelle traduzioni.


## Configurazioni Tecniche

### Robots
- **robots**: "index, follow" - Permette indicizzazione completa

### Localizzazione
- **locale**: Locale specifico per ogni lingua
- **canonical**: Vuoto (da popolare dinamicamente)

### Tipo Contenuto
- **type**: "website" - Tipo di contenuto principale
- **sitename**: "<main module>" - Nome breve del sito

## Utilizzo nei Template

I metatag vengono utilizzati nel componente `Modules\Cms\app\View\Components\Metatags.php` che li rende disponibili nei template Blade:

```blade
<meta name="description" content="{{ $metatags['description'] }}">
<meta name="keywords" content="{{ $metatags['keywords'] }}">
<meta name="author" content="{{ $metatags['author'] }}">
<meta property="og:title" content="{{ $metatags['title'] }}">
<meta property="og:description" content="{{ $metatags['description'] }}">
```

## Best Practices Applicate

### SEO
1. **Titoli descrittivi** con parole chiave principali
2. **Descrizioni accattivanti** che spiegano il valore del servizio
3. **Keywords strategiche** basate sul target e contenuto
4. **Localizzazione completa** per ogni mercato

### Social Media
1. **Open Graph completo** per Facebook/LinkedIn
2. **Twitter Cards** per condivisioni Twitter
3. **Immagini appropriate** per preview social
4. **Contenuti localizzati** per ogni lingua

### Accessibilità
1. **Contenuti chiari** e comprensibili
2. **Descrizioni complete** del servizio
3. **Informazioni di contesto** sui partner

## Manutenzione

### Aggiornamenti Necessari
- Aggiornare keywords se cambiano i servizi
- Modificare descrizioni se cambia il focus del progetto  
- Aggiungere nuove lingue se necessario
- Aggiornare informazioni partner se cambiano

### Monitoraggio
- Verificare performance SEO con Google Search Console
- Monitorare condivisioni social media
- Controllare preview dei link sui vari social network

## Collegamenti
- [Componente Metatags](../app/View/Components/Metatags.php)
- [Template Metatags](../resources/views/components/metatags.blade.php)
- [Traduzioni Tema IT](../../../Themes/One/lang/it/)
- [Traduzioni Tema EN](../../../Themes/One/lang/en/)
- [Traduzioni Tema DE](../../../Themes/One/lang/de/)

*Implementazione completata: gennaio 2025*
