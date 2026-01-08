# Media - Filosofia Completa: Logica, Religione, Politica, Zen

**Data Creazione**: 2025-12-23  
**Status**: Documentazione Filosofica Completa  
**Versione**: 1.0.0

## 📋 Indice Filosofico

1. [Logica (Logic)](#logica-logic)
2. [Religione (Religion)](#religione-religion)
3. [Politica (Politics)](#politica-politics)
4. [Zen (Zen)](#zen-zen)
5. [Manifestazioni Pratiche](#manifestazioni-pratiche)

---

## 🧠 Logica (Logic)

### Principio Fondamentale

**Media gestisce tutti i file e asset multimediali. Upload sicuro, storage intelligente, processing automatico.**

### Dominio di Business

Il modulo fornisce **gestione completa file** per:
- Upload sicuro con validazione
- Storage multi-disk (locale, S3, CDN)
- Processing automatico (immagini, video)
- Collections organizzate
- Conversions on-demand
- Access control e signed URLs

### Entità Core

```
Media (File Registrato)
├── Model (Associato a) - Relazione polimorfa
├── Collection (Tipo) - String
├── Disk (Storage) - String
├── Path (Percorso) - String
├── Conversions (Versioni) - JSON
└── Custom Properties (Metadati) - JSON
```

### Business Workflow Principale

1. **Upload**
   - Validazione file (tipo, dimensione)
   - Upload sicuro con scanning
   - Storage su disk appropriato
   - Generazione conversions automatiche

2. **Processing**
   - Image optimization automatica
   - Video transcoding (se configurato)
   - Thumbnail generation
   - Metadata extraction

3. **Delivery**
   - Signed URLs per file privati
   - CDN integration per performance
   - Lazy loading per ottimizzazione
   - Access control per sicurezza

### Manifestazione nel Codice

```php
// Media model (presumibilmente Spatie Media Library)
class Media extends BaseModel
{
    // Polimorphic relation a qualsiasi model
    public function model(): MorphTo
    
    // Collections per organizzazione
    public string $collection_name;
    
    // Storage
    public string $disk;
    public string $file_name;
    
    // Conversions
    public array $conversions;
}
```

---

## 📜 Religione (Religion)

### Comandamenti Sacri

1. **Spatie Media Library è la Base** - Utilizzare sempre Spatie come foundation
2. **Collections Organizzate** - Ogni file appartiene a una collection logica
3. **Conversions Automatiche** - Immagini devono avere thumbnails automatici
4. **Storage Intelligente** - File pubblici su CDN, privati su storage sicuro
5. **Validation Obbligatoria** - Ogni upload deve essere validato (tipo, dimensione, contenuto)
6. **Access Control** - File privati richiedono signed URLs o auth

### Best Practices

- Usare **Trait `HasMedia`** per modelli che hanno file
- **Collections** per organizzare file (es. 'avatars', 'documents', 'gallery')
- **Conversions** per ottimizzazione automatica immagini
- **Custom Properties** per metadata estesi
- **Signed URLs** per file privati con scadenza

### Integrazione Moduli

Il modulo Media **è utilizzato da** tutti i moduli che gestiscono file:
- **User**: Avatar, documenti profilo
- **TechPlanner**: Documenti clienti, certificazioni dispositivi
- **Cms**: Immagini contenuti, media gallery
- **Employee**: Documenti dipendenti, foto profilo

**Filosofia**: Media è il "magazzino digitale" centralizzato e organizzato.

---

## 🏛️ Politica (Politics)

### Decisioni Architetturali

1. **Spatie Media Library** - Foundation solida e testata
2. **Multi-Disk Storage** - Supporto locale, S3, CDN
3. **Lazy Processing** - Conversions on-demand per performance
4. **Security First** - Access control e validation rigorosi

### Governance del Modulo

- **File Validation**: Tipo, dimensione, contenuto sempre validati
- **Storage Policies**: Pubblici vs privati su storage diversi
- **Retention Policies**: Gestione lifecycle file (archiviazione, eliminazione)
- **Cost Optimization**: CDN per file pubblici, storage economico per archivi

### Pattern Implementativi

```php
// Pattern: HasMedia Trait
class User extends BaseModel
{
    use HasMedia;
    
    // Collections organizzate
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')
            ->singleFile();
            
        $this->addMediaCollection('documents')
            ->acceptsMimeTypes(['application/pdf']);
    }
}

// Pattern: Upload con Conversions
$user->addMediaFromRequest('avatar')
    ->withCustomProperties(['uploaded_by' => auth()->id()])
    ->usingName('profile-avatar')
    ->toMediaCollection('avatars');
```

---

## 🧘 Zen (Zen)

### Il Vuoto dello Storage

Apprezziamo il concetto zen del **"vuoto che contiene tutto"**:

- **Invisible Storage**: File salvati senza preoccupare developer
- **Automatic Processing**: Conversions e ottimizzazioni automatiche
- **Smart Delivery**: Sistema "sa" quale file servire (originale vs conversion)
- **Self-Organization**: Collections organizzano automaticamente file

### Flusso Naturale

La gestione file deve essere **trasparente e semplice**:

1. Upload file → Validazione automatica → Storage intelligente
2. Richiesta file → Sistema serve versione ottimale (conversion o originale)
3. Accesso privato → Signed URL generato automaticamente
4. Cleanup → File orfani gestiti automaticamente

### Semplicità nella Complessità

Il modulo gestisce complessità (multi-disk, conversions, CDN) ma:
- **Simple API**: `addMedia()` per upload
- **Auto-Discovery**: Collections registrate automaticamente
- **Smart Defaults**: Configurazioni sensate out-of-the-box
- **Transparent Access**: `getFirstMediaUrl()` nasconde complessità

---

## 🎯 Manifestazioni Pratiche

### 1. HasMedia Trait - Integrazione Modelli

```php
// Modello con supporto media
class Client extends BaseModel
{
    use HasMedia;
    
    // Collections per organizzazione
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents');
        $this->addMediaCollection('certificates')
            ->singleFile();
    }
}
```

### 2. Media Collections - Organizzazione

```php
// Upload organizzato
$client->addMedia($file)
    ->toMediaCollection('documents');

// Access semplice
$documentUrl = $client->getFirstMediaUrl('documents');
$certificate = $client->getFirstMedia('certificates');
```

### 3. Conversions - Ottimizzazione Automatica

```php
// Conversions configurate in ServiceProvider
Media::registerMediaConversions(function ($media) {
    $this->addMediaConversion('thumb')
        ->width(100)
        ->height(100)
        ->performOnCollections('avatars');
});
```

---

## 🔗 Collegamenti

- [File Management Architecture](./file-management-architecture.md)
- [Business Logic Overview](./business-logic-overview.md)
- [Xot Module Foundation](../../Xot/docs/philosophy-complete.md)

---

**Filosofia**: Secure Upload, Smart Storage, Automatic Processing, Simple Access
