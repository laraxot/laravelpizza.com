# Seo Module

The **Seo Module** provides a comprehensive search engine optimization toolkit for Laravel applications, integrating advanced metadata management, sitemaps, structured data, and AI-powered content analysis.

## 🚀 Features

### ✅ Completed
- **Meta Tag Management**: Dynamic control over title, description, keywords, canonical URLs, and robots tags.
- **Sitemap Generation**: Automatic XML sitemap creation with multi-sitemap support and search engine pinging.
- **OpenGraph & Twitter Cards**: dedicated support for social media previews and image optimization.
- **Schema.org Integration**: JSON-LD structured data for Local Business, Articles, Products, and more.
- **SEO Analytics**: Real-time content analysis and performance tracking.
- **Filament Integration**: Seamless management via the Filament admin panel.

### 🔄 In Progress / Planned
- **AI-Powered Optimization**: Content quality scoring and readability suggestions (via OpenAI).
- **Keyword Tracking**: Rank tracking, history, and competition analysis.
- **Competitor Analysis**: Gap identification and market comparison.
- **Reporting**: Automated PDF SEO reports.

## 📦 Installation

```bash
composer require laraxot/module-seo
php artisan module:enable Seo
php artisan migrate
```

## ⚙️ Configuration

Publish the configuration file to set up API keys (e.g., OpenAI) and defaults:

```bash
php artisan vendor:publish --provider="Modules\Seo\Providers\SeoServiceProvider" --tag="config"
```

## 📖 Documentation

- [Roadmap](roadmap.md): Detailed development status and future plans.
- [Rules Index](rules-index.md): Coding standards and architectural rules.
- [PHPStan Guide](phpstan.md): Static analysis configuration (Level 10).

## 🛠 Usage

The module automatically injects SEO tags into your layout if configured. You can also manually manage tags via the facade or helper functions:

```php
use Modules\Seo\Facades\Seo;

Seo::setTitle('My Amazing Page');
Seo::setDescription('The best page on the internet.');
```

For Filament resources, use the provided SEO trait to add configuration fields to your forms.

## 🤝 Contribution

Please verify all changes with:
- `phpstan analyse Modules/Seo` (Level 10)
- `pest` (Test Suite)
