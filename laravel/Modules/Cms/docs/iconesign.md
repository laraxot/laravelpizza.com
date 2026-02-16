# CMS Module - Icon Design

## Concetto Design
L'icona del modulo CMS rappresenta la gestione dei contenuti attraverso un documento con strumenti di editing.

## Elementi Visivi
- **Documento principale**: Container per i contenuti
- **Header del documento**: Sezione di intestazione
- **Linee di testo**: Rappresentano il contenuto testuale
- **Icona di modifica**: Strumenti per l'editing
- **Indicatori di sezione**: Punti di navigazione

## Animazioni

### slideIn (2s, infinite alternate)
- **Effetto**: Il documento scivola leggermente da sinistra
- **Tecnica**: `translateX` da `-2px` a `0px`
- **Scopo**: Simula il caricamento dinamico del contenuto

### typewriter (3s, infinite)
- **Effetto**: Le linee di testo appaiono come una macchina da scrivere
- **Tecnica**: `opacity` che varia da `0.6` a `1`
- **Scopo**: Indica la creazione di contenuto in tempo reale

### editPulse (1.5s, infinite)
- **Effetto**: L'icona di modifica pulsa delicatamente
- **Tecnica**: `opacity` da `0.7` a `1`
- **Scopo**: Evidenzia la possibilità di editing

## Accessibilità
- Supporto `prefers-reduced-motion` per disabilitare animazioni
- Uso di `currentColor` per adattamento automatico ai temi
- Opacità variabile per creare gerarchia visiva

## Utilizzo
```php
// Nel ServiceProvider del modulo CMS
FilamentIcon::register([
    'cms-icon' => 'cms-icon',
]);
```

## Collegamenti
- [Design System Globale](../../../../docs/module-icons-design-system.md)
- [CMS Module Documentation](./README.md)

*Creato: Agosto 2025*
