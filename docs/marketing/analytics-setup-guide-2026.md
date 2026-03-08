# 📊 Analytics Setup Guide 2026 - LaravelPizza Marketing

## 🎯 Panoramica Analytics Setup

Questo documento fornisce una guida completa per implementare il sistema di analytics completo per il marketing virale di LaravelPizza, con focus su tracking performance, ottimizzazione e decision making basato sui dati.

## 📊 Analytics Architecture

### Sistema Analytics Completo
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Google        │    │   TikTok        │    │   Instagram     │
│   Analytics     │    │   Analytics     │    │   Insights      │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         └───────────────────────┼───────────────────────┘
                                 │
                    ┌─────────────────┐
                    │   Facebook      │
                    │   Analytics     │
                    └─────────────────┘
                                 │
                    ┌─────────────────┐
                    │   LinkedIn      │
                    │   Analytics     │
                    └─────────────────┘
                                 │
                    ┌─────────────────┐
                    │   Data Lake     │
                    │   (Google Cloud)│
                    └─────────────────┘
                                 │
                    ┌─────────────────┐
                    │   Data Studio   │
                    │   (Google)      │
                    └─────────────────┘
                                 │
                    ┌─────────────────┐
                    │   Dashboard     │
                    │   (Custom)      │
                    └─────────────────┘
```

---

## 🛠️ Setup Strumenti Analytics

### 1. Google Analytics 4 (GA4)

#### Setup Iniziale
```bash
# Creare account GA4
# 1. Accedere a Google Analytics
# 2. Cliccare su "Crea account"
# 3. Selezionare "Google Analytics 4"
# 4. Inserire dettagli account

# Aggiungere proprietà
# 1. Cliccare su "Proprietà"
# 2. Selezionare "Crea proprietà"
# 3. Inserire nome sito e dominio

# Ottenere codice tracking
# 1. Cliccare su "Configurazione"
# 2. Selezionare "Codice di tracciamento"
# 3. Copiare codice tracking
```

#### Codice Tracking GA4
```html
<!-- Aggiungere nel <head> del sito -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'GA_MEASUREMENT_ID');
</script>
```

#### Eventi Personalizzati GA4
```javascript
// Eventi Marketing
gtag('event', 'user_registration', {
  'event_category': 'conversion',
  'event_label': 'registration_complete'
});

gtag('event', 'event_creation', {
  'event_category': 'engagement',
  'event_label': 'event_created'
});

gtag('event', 'content_share', {
  'event_category': 'engagement',
  'event_label': 'content_shared'
});

// Eventi Social Media
gtag('event', 'social_click', {
  'event_category': 'social',
  'event_label': 'tiktok_click'
});

gtag('event', 'social_share', {
  'event_category': 'social',
  'event_label': 'instagram_share'
});
```

### 2. TikTok Analytics

#### Setup TikTok Business Account
```bash
# 1. Accedere a TikTok Business Center
# 2. Cliccare su "Setup"
# 3. Selezionare "Add a business account"
# 4. Inserire dettagli account

# Aggiungere pixel TikTok
# 1. Cliccare su "Pixels"
# 2. Selezionare "Create pixel"
# 3. Copiare codice pixel
```

#### Codice TikTok Pixel
```html
<!-- Aggiungere nel <head> del sito -->
<script>
!function (w, d) {
  if (!w.tiktok) {
    var t = w.tiktok = function () { t.ttq = t.ttq || []; t.ttq.push(arguments); };
    t.ttq.version = '1.0';
  }
}(window, document);

tiktok('init', 'TIKTOK_PIXEL_ID');
</script>

<!-- Eventi TikTok -->
<script>
tiktok('track', 'CompleteRegistration');
tiktok('track', 'PageView');
tiktok('track', 'ViewContent');
tiktok('track', 'AddToCart');
tiktok('track', 'Purchase');
</script>
```

### 3. Instagram Insights

#### Setup Instagram Business Account
```bash
# 1. Accedere a Instagram Business
# 2. Cliccare su "Insights"
# 3. Selezionare "Analytics"

# Aggiungere Meta Pixel
# 1. Accedere a Meta Business Suite
# 2. Cliccare su "Pixels"
# 3. Selezionare "Create pixel"
# 4. Copiare codice pixel
```

#### Codice Meta Pixel
```html
<!-- Aggiungere nel <head> del sito -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', 'FACEBOOK_PIXEL_ID');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=FACEBOOK_PIXEL_ID&ev=PageView&noscript=1"
/></noscript>
```

### 4. Facebook Analytics

#### Setup Facebook Business Manager
```bash
# 1. Accedere a Facebook Business Manager
# 2. Cliccare su "Analytics"
# 3. Selezionare "Setup"

# Aggiungere Facebook Pixel
# 1. Accedere a Meta Business Suite
# 2. Cliccare su "Pixels"
# 3. Selezionare "Create pixel"
# 4. Copiare codice pixel
```

#### Eventi Facebook Pixel
```javascript
// Eventi Conversion
fbq('track', 'CompleteRegistration');
fbq('track', 'Purchase');
fbq('track', 'AddToCart');
fbq('track', 'ViewContent');

// Eventi Social Media
fbq('track', 'PageView');
fbq('track', 'Search');
fbq('track', 'Contact');
```

### 5. LinkedIn Analytics

#### Setup LinkedIn Campaign Manager
```bash
# 1. Accedere a LinkedIn Campaign Manager
# 2. Cliccare su "Setup"
# 3. Selezionare "Add a company"

# Aggiungere LinkedIn Insight Tag
# 1. Accedere a LinkedIn Campaign Manager
# 2. Cliccare su "Setup"
# 3. Copiare codice insight tag
```

#### Codice LinkedIn Insight Tag
```html
<!-- Aggiungere nel <head> del sito -->
<script type="text/javascript" src="https://platform.linkedin.com/badges/js/profile.min.js" async defer></script>

<script type="IN/CompanyInsightTag" data-lead-gen-form-id="LINKEDIN_LEAD_GEN_ID"></script>
```

---

## 📈 Dashboard Analytics

### Google Data Studio Dashboard

#### Setup Data Studio
```bash
# 1. Accedere a Google Data Studio
# 2. Cliccare su "Crea"
# 3. Selezionare "Report"

# Aggiungere data source
# 1. Cliccare su "Risorsa dati"
# 2. Selezionare "Google Analytics"
# 3. Selezionare account e proprietà
```

#### Dashboard Layout
```
┌─────────────────────────────────────────────────────────┐
│                    HEADER SECTION                         │
│  LaravelPizza Marketing Analytics Dashboard              │
│  Data Range: [Date Range Picker]                         │
└─────────────────────────────────────────────────────────┘

┌─────────────────┬─────────────────┬─────────────────┬─────────────────┐
│   REACH METRICS │  ENGAGEMENT     │  CONVERSION     │  REVENUE        │
│                 │   METRICS       │   METRICS       │   METRICS       │
├─────────────────┼─────────────────┼─────────────────┼─────────────────┤
│                 │                 │                 │                 │
│                 │                 │                 │                 │
└─────────────────┴─────────────────┴─────────────────┴─────────────────┘

┌─────────────────────────────────────────────────────────┐
│                    CHART SECTION                         │
│  [Line Chart - Reach Trend]  [Bar Chart - Engagement]   │
│  [Pie Chart - Conversion Sources]  [Line Chart - Revenue]│
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                    TABLE SECTION                         │
│  [Detailed Metrics Table]  [Performance Comparison]     │
└─────────────────────────────────────────────────────────┘
```

---

## 🎯 KPI & Metrics Tracking

### Key Performance Indicators

#### Reach KPIs
| Metric | Target | Current | Trend |
|--------|--------|---------|-------|
| TikTok Reach | 100K/week | - | - |
| Instagram Reach | 50K/week | - | - |
| LinkedIn Reach | 5K/week | - | - |
| Facebook Reach | 10K/week | - | - |
| **Total Reach** | 165K/week | - | - |

#### Engagement KPIs
| Metric | Target | Current | Trend |
|--------|--------|---------|-------|
| TikTok Engagement | 15% | - | - |
| Instagram Engagement | 12% | - | - |
| LinkedIn Engagement | 20% | - | - |
| Facebook Engagement | 10% | - | - |
| **Average Engagement** | 14.25% | - | - |

#### Conversion KPIs
| Metric | Target | Current | Trend |
|--------|--------|---------|-------|
| TikTok Conversion | 5% | - | - |
| Instagram Conversion | 8% | - | - |
| LinkedIn Conversion | 10% | - | - |
| Facebook Conversion | 6% | - | - |
| **Average Conversion** | 7% | - | - |

#### Community KPIs
| Metric | Target | Current | Trend |
|--------|--------|---------|-------|
| New Members | 500/week | - | - |
| Active Members | 200/week | - | - |
| Member Growth | 500/week | - | - |
| Community Engagement | 10K/week | - | - |

---

## 📊 Advanced Analytics Features

### 1. A/B Testing Setup

#### Google Optimize
```bash
# 1. Accedere a Google Optimize
# 2. Cliccare su "Crea test"
# 3. Selezionare pagina target
# 4. Configurare varianti

# Aggiungere codice Optimize
<script src="https://www.googleoptimize.com/optimize.js?id=GOOGLE_OPTIMIZE_ID"></script>
```

#### Test Variants
```javascript
// Test Variante A (Controllo)
// Test Variante B (Variante)
// Test Variante C (Variante)
```

### 2. Event Tracking

#### Custom Events GA4
```javascript
// Event Tracking Complete
gtag('event', 'event_tracking', {
  'event_category': 'engagement',
  'event_label': 'event_tracked',
  'value': 1
});

// Event Tracking Share
gtag('event', 'share_tracking', {
  'event_category': 'engagement',
  'event_label': 'share_tracked',
  'value': 1
});

// Event Tracking Registration
gtag('event', 'registration_tracking', {
  'event_category': 'conversion',
  'event_label': 'registration_tracked',
  'value': 1
});
```

### 3. Conversion Tracking

#### E-commerce Events
```javascript
// E-commerce Events
gtag('event', 'begin_checkout', {
  'currency': 'EUR',
  'value': 29.99,
  'items': [{
    'item_id': 'SKU123',
    'item_name': 'Product Name',
    'quantity': 1,
    'price': 29.99
  }]
});

gtag('event', 'purchase', {
  'transaction_id': 'TRANSACTION_ID',
  'currency': 'EUR',
  'value': 29.99,
  'items': [{
    'item_id': 'SKU123',
    'item_name': 'Product Name',
    'quantity': 1,
    'price': 29.99
  }]
});
```

---

## 🔧 Data Pipeline Setup

### 1. Google Cloud Storage

#### Setup Cloud Storage
```bash
# 1. Accedere a Google Cloud Console
# 2. Cliccare su "Storage"
# 3. Selezionare "Creare bucket"

# Creare bucket per analytics data
gsutil mb gs://laravelpizza-analytics-2026
```

#### Data Export Setup
```bash
# Export GA4 data
gcloud bigquery query --destination_table=laravelpizza.analytics.ga4_data \
"SELECT * FROM \`laravelpizza.analytics.ga4_events\`"

# Export TikTok data
gcloud bigquery query --destination_table=laravelpizza.analytics.tiktok_data \
"SELECT * FROM \`laravelpizza.analytics.tiktok_events\`"
```

### 2. BigQuery Setup

#### Create BigQuery Dataset
```bash
# Creare dataset per analytics
bq mk laravelpizza_analytics

# Creare tabelle per ogni canale
bq mk laravelpizza_analytics.ga4_events
bq mk laravelpizza_analytics.tiktok_events
bq mk laravelpizza_analytics.instagram_events
bq mk laravelpizza_analytics.facebook_events
bq mk laravelpizza_analytics.linkedin_events
```

---

## 📊 Reporting Automation

### 1. Automated Reports

#### Google Sheets Automation
```javascript
// Script per generare report settimanali
function generateWeeklyReport() {
  const sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
  const data = getAnalyticsData();
  sheet.getRange('A1').setValue('Weekly Analytics Report');
  sheet.getRange('A2').setValue(new Date());
  // Aggiungere dati e formattazione
}
```

#### Scheduled Reports
```bash
# Creare script per report settimanali
# 1. Accedere a Google Apps Script
# 2. Creare nuovo script
# 3. Configurare trigger giornaliero
```

### 2. Email Reports

#### Email Automation Script
```javascript
function sendWeeklyEmailReport() {
  const recipient = 'marketing@laravelpizza.com';
  const subject = 'Weekly Analytics Report - LaravelPizza';
  const body = generateReportHTML();
  MailApp.sendEmail(recipient, subject, body);
}
```

---

## 🛡️ Data Privacy & Security

### 1. GDPR Compliance

#### Data Collection Consent
```javascript
// GDPR Consent Script
function checkGDPRConsent() {
  const consent = localStorage.getItem('gdpr_consent');
  if (!consent) {
    showGDPRConsentBanner();
  }
}

function acceptGDPRConsent() {
  localStorage.setItem('gdpr_consent', 'true');
  trackConsent('accepted');
}
```

#### Data Anonymization
```javascript
// Anonymize User Data
function anonymizeUserData(userId) {
  return crypto.createHash('sha256').update(userId).digest('hex');
}
```

### 2. Data Security

#### API Key Management
```bash
# Store API keys securely
# 1. Accedere a Google Cloud Console
# 2. Cliccare su "IAM & Admin"
# 3. Selezionare "Service accounts"
# 4. Creare e configurare service account
```

---

## 🎯 Implementation Checklist

### Setup Phase
- [ ] Google Analytics 4 Account Created
- [ ] TikTok Pixel Implemented
- [ ] Instagram Meta Pixel Implemented
- [ ] Facebook Pixel Implemented
- [ ] LinkedIn Insight Tag Implemented
- [ ] Google Data Studio Dashboard Created
- [ ] BigQuery Dataset Created
- [ ] Cloud Storage Bucket Configured

### Configuration Phase
- [ ] Event Tracking Configured
- [ ] Conversion Tracking Set Up
- [ ] A/B Testing Configured
- [ ] Automated Reports Created
- [ ] Email Notifications Set Up
- [ ] Data Privacy Compliance Verified
- [ ] Security Measures Implemented

### Testing Phase
- [ ] All Analytics Tags Verified
- [ ] Data Flow Tested
- [ ] Reports Validated
- [ ] Performance Optimized
- [ ] Team Trained
- [ ] Documentation Completed

---

## 📞 Support & Troubleshooting

### Common Issues

#### Analytics Not Tracking
```bash
# Check if tags are firing
# 1. Accedere a Google Tag Assistant
# 2. Verificare se i tag sono attivi
# 3. Debuggare eventuali errori
```

#### Data Delay
```bash
# Check data processing delay
# 1. Accedere a Google Analytics
# 2. Verificare data processing delay
# 3. Configurare data retention
```

#### Performance Issues
```bash
# Optimize tracking performance
# 1. Minimize number of tracking calls
# 2. Use async loading
# 3. Implement data layer optimization
```

---

**Note**: Questo setup analytics è progettato per essere scalabile e adattabile. Regolare i parametri e le metriche in base alle esigenze specifiche del progetto e ai risultati ottenuti.