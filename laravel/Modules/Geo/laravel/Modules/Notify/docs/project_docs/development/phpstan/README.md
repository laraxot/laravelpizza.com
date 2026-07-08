# PHPStan Configuration - Progetto Base FixCity Fila3 Mono

## Panoramica
Questa sezione contiene la documentazione per la configurazione e l'utilizzo di PHPStan nel progetto Laraxot.

## Configurazione Attuale

### File di Configurazione
- **phpstan.neon**: Configurazione principale (NON MODIFICABILE)
- **phpstan-baseline.neon**: Baseline per errori noti
- **phpstan_constants.php**: File di costanti per PHPStan

### Livello di Analisi
- **Livello attuale**: 9 (molto alto)
- **Obiettivo**: Livello 10 (massimo)
- **Percorsi analizzati**: `./Modules`

### Estensioni Attive
- **Larastan**: Estensione per Laravel
- **Safe Rule**: Regole per funzioni Safe
- **Bleeding Edge**: Funzionalità sperimentali

## Regole e Convenzioni

### Errori Ignorati
- `Unsafe usage of new static`
- `PHPDoc tag @mixin contains unknown class`
- `Static call to instance method Nwidart`
- `is used zero times and is not analysed`
- `A facade root has not been set`
- `Vite manifest not found`
- `ViteManifestNotFoundException`

### Percorsi Esclusi
- `./*/vendor/*`
- `./*/build/*`
- `./*/docs/*`
- `./*/Tests/*`
- `./*/tests/*`
- `./*/packages/*`
- `./*/*.blade.php`

### File di Bootstrap
- `./phpstan_constants.php`
- `./Modules/Xot/Helpers/Helper.php`

## Processo di Analisi

### 1. Esecuzione
```bash
cd laravel
./vendor/bin/phpstan analyse Modules
```

### 2. Analisi Parallela
- **Processi massimi**: 32
- **Dimensione job**: 20
- **Job minimi per processo**: 2

### 3. Cache
- **Directory temporanea**: `/tmp/phpstan`
- **Cache abilitata**: Sì

## Best Practices

### 1. Type Hints
- Utilizzare sempre type hints espliciti
- Evitare `mixed` quando possibile
- Utilizzare union types per casi specifici

### 2. PHPDoc
- Documentare tutti i metodi pubblici
- Utilizzare `@param` e `@return` corretti
- Evitare `@mixin` con classi sconosciute

### 3. Namespace
- Seguire la struttura modulare
- Utilizzare namespace corretti
- Evitare import non utilizzati

### 4. Laravel Specifico
- Utilizzare Facade correttamente
- Evitare chiamate `env()` fuori da config
- Utilizzare Service Container

## Risoluzione Errori Comuni

### 1. Type Errors
```php
// PRIMA (errore)
public function getData() {
    return $this->data;
}

// DOPO (corretto)
public function getData(): array {
    return $this->data;
}
```

### 2. Nullable Types
```php
// PRIMA (errore)
public function getUser(): User {
    return $this->user;
}

// DOPO (corretto)
public function getUser(): ?User {
    return $this->user;
}
```

### 3. Array Shapes
```php
// PRIMA (errore)
public function getConfig(): array {
    return ['name' => 'test', 'value' => 123];
}

// DOPO (corretto)
/**
 * @return array{name: string, value: int}
 */
public function getConfig(): array {
    return ['name' => 'test', 'value' => 123];
}
```

## Moduli Specifici

### Moduli Esclusi (Temporaneamente)
- Activity
- AI
- Blog
- Seo

### Moduli da Analizzare
- Xot (core)
- User
- Cms
- Media
- Notify
- Geo
- Lang
- Comment
- Gdpr
- FormBuilder
- Job
- Rating
- Tenant
- UI

## Aggiornamenti Recenti

### Gennaio 2025
- **Configurazione PHPStan**: Livello 9 attivo
- **Analisi Moduli**: Tutti i moduli in analisi
- **Baseline**: Aggiornata per errori noti
- **Performance**: Analisi parallela ottimizzata

### Collegamenti Correlati
- [Best Practices Filament](../filament/README.md)
- [Troubleshooting](../../troubleshooting/README.md)
- [Architettura Moduli](../../architecture/modules/README.md)

---

*Ultimo aggiornamento: Gennaio 2025*
*Responsabile: AI Assistant con poteri supermucca*
