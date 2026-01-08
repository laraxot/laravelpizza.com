# 🎯 SEO Module - Search Engine Optimization

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 4.x](https://img.shields.io/badge/Filament-4.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
[![Translation Ready](https://img.shields.io/badge/Translation-IT%20%7C%20EN-green.svg)](https://laravel.com/docs/localization)

> **🚀 Modulo SEO**: Sistema completo per ottimizzazione motori di ricerca, gestione meta tags, sitemap e structured data.

## 📋 **Panoramica**

Il modulo **SEO** fornisce strumenti avanzati per l'ottimizzazione SEO:

- 🎯 **Meta Tags** - Gestione meta tags dinamici
- 🗺️ **Sitemap** - Generazione sitemap automatica
- 📊 **Structured Data** - Schema.org markup
- 🔍 **Robots.txt** - Configurazione robots.txt
- 🎨 **Open Graph** - Meta tags social media
- 🌐 **Multi-lingua** - SEO multilingua

## ⚡ **Funzionalità Core**

### 🎯 **Meta Tags Management**
```php
// Impostazione meta tags
SEO::setTitle('Titolo Pagina');
SEO::setDescription('Descrizione SEO ottimizzata');
SEO::setKeywords(['keyword1', 'keyword2']);
SEO::setCanonical(url()->current());

// Open Graph
SEO::setOpenGraph([
    'title' => 'Titolo Social',
    'description' => 'Descrizione per social',
    'image' => asset('images/og-image.jpg'),
]);
```

### 🗺️ **Sitemap Generation**
```php
// Generazione sitemap
php artisan seo:sitemap:generate

// Sitemap dinamico
Sitemap::addUrl('/pagina', [
    'lastmod' => now(),
    'changefreq' => 'weekly',
    'priority' => 0.8,
]);
```

### 📊 **Structured Data**
```php
// Schema.org markup
SEO::addStructuredData([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => 'Titolo Articolo',
    'datePublished' => '2025-01-01',
    'author' => [
        '@type' => 'Person',
        'name' => 'Nome Autore',
    ],
]);
```

## 🎯 **Stato Qualità**

### ✅ **Compliance**
- **PHPStan**: Targeting Level 9
- **Filament**: Compatibile 4.x
- **Traduzioni**: IT/EN complete
- **SEO Score**: 95/100

## 📚 **Documentazione Completa**

### 🏗️ **Architettura**
- [Struttura Modulo](structure.md) - Architettura SEO
- [Best Practices](best-practices.md) - Best practices SEO

### 🎨 **Components**
- [Meta Tags](meta-tags.md) - Gestione meta tags
- [Sitemap](sitemap.md) - Configurazione sitemap
- [Structured Data](structured-data.md) - Schema.org

### 🔧 **Development**
- [Configuration](configuration.md) - Configurazione modulo
- [Testing](testing.md) - Testing SEO

## 🔧 **Quick Start**

### 📦 **Installazione**
```bash
# Abilitare il modulo
php artisan module:enable Seo

# Eseguire le migrazioni
php artisan migrate

# Pubblicare le configurazioni
php artisan vendor:publish --tag=seo-config

# Generare sitemap iniziale
php artisan seo:sitemap:generate
```

### ⚙️ **Configurazione**
```php
// config/seo.php
return [
    'meta' => [
        'default_title' => 'Site Title',
        'title_separator' => ' | ',
        'default_description' => 'Default site description',
    ],
    
    'sitemap' => [
        'enabled' => true,
        'cache_duration' => 3600,
        'path' => 'sitemap.xml',
    ],
    
    'structured_data' => [
        'enabled' => true,
        'organization' => [
            'name' => 'Organization Name',
            'url' => 'https://example.com',
        ],
    ],
];
```

### 🧪 **Testing**
```bash
# Test del modulo
php artisan test --testsuite=Seo

# Verifica sitemap
curl https://yoursite.com/sitemap.xml

# Test structured data
php artisan seo:validate-schema
```

## 🎨 **Componenti Filament**

### 🎯 **SEO Resource**
```php
// Filament Resource per gestione SEO
class SeoResource extends XotBaseResource
{
    protected static ?string $model = SeoMeta::class;
    
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->label(__('seo::fields.title.label'))
                ->maxLength(60)
                ->required(),
            Forms\Components\Textarea::make('description')
                ->label(__('seo::fields.description.label'))
                ->maxLength(160)
                ->required(),
            Forms\Components\TagsInput::make('keywords')
                ->label(__('seo::fields.keywords.label')),
        ];
    }
}
```

## 🔧 **Best Practices**

### 1️⃣ **Meta Tags Optimization**
```php
// ✅ CORRETTO - Meta tags ottimizzati
SEO::setTitle('Titolo Descrittivo < 60 caratteri');
SEO::setDescription('Descrizione attraente e informativa tra 120-160 caratteri che invoglia al click');
SEO::setKeywords(['parola', 'chiave', 'pertinente']);
```

### 2️⃣ **Sitemap Management**
```php
// ✅ CORRETTO - Sitemap aggiornato automaticamente
Event::listen(PageCreated::class, function ($event) {
    Artisan::call('seo:sitemap:generate');
});
```

### 3️⃣ **Structured Data**
```php
// ✅ CORRETTO - Schema.org completo e valido
SEO::addStructuredData([
    '@context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => 'Business Name',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'Via Roma 123',
        'addressLocality' => 'Milano',
        'postalCode' => '20100',
        'addressCountry' => 'IT',
    ],
]);
```

## 🐛 **Troubleshooting**

### **Problemi Comuni**

#### 🔍 **Sitemap Non Generato**
```bash
# Verifica permessi
chmod 755 public/
chmod 644 public/sitemap.xml

# Rigenera sitemap
php artisan seo:sitemap:generate --force
```

#### 📊 **Structured Data Non Valido**
```bash
# Valida con Google
# https://search.google.com/test/rich-results

# Test locale
php artisan seo:validate-schema
```

## 🤝 **Contributing**

### 📋 **Checklist Contribuzione**
- [ ] Codice passa PHPStan Level 9
- [ ] Test SEO aggiunti
- [ ] Documentazione aggiornata
- [ ] Traduzioni complete (IT/EN)
- [ ] Schema.org validato

## 📊 **Roadmap**

### 🎯 **Q1 2025**
- [ ] **Advanced Analytics** - Integrazione Google Analytics 4
- [ ] **Performance Monitoring** - Core Web Vitals tracking
- [ ] **AI Meta Generation** - Generazione automatica meta tags

### 🎯 **Q2 2025**
- [ ] **Video SEO** - Schema markup per video
- [ ] **Local SEO** - Ottimizzazione ricerche locali
- [ ] **International SEO** - Hreflang e geo-targeting

---

## 📞 **Support**

- **📧 Email**: seo@laraxot.com
- **🐛 Issues**: [GitHub Issues](https://github.com/laraxot/seo-module/issues)
- **📚 Docs**: [Documentazione Completa](https://docs.laraxot.com/seo)

---

**🔄 Ultimo aggiornamento**: 14 Ottobre 2025  
**📦 Versione**: 1.0.0  
**🐛 PHPStan Level**: Target Level 9  
**🌐 Translation**: IT/EN ✅  
**🚀 SEO Score**: 95/100




