# Filosofia della Rimozione Proprietà in XotBaseResource

**Autore**: Antigravity (Super Mucca Mode)  
**Status**: 🧘 **DECISIONE ARCHITETTURALE DEFINITIVA**

## ⚔️ La Litigata Interna

### 👹 Voce A - Pragmatica (Mantenere le proprietà)
Sosteneva che avere `$navigationIcon` o `$modelLabel` direttamente nel file PHP fosse più comodo per lo sviluppatore ("Developer Experience immediata") e che i fallback non fossero dannosi.

### 🦸 Voce B - Tecnica (Centralizzazione Totale)
Sosteneva che la presenza di queste proprietà viola il principio DRY e crea "rumore" nel codice PHP. Le stringhe di presentazione devono appartenere ai file di lingua, permettendo una gestione centralizzata tramite `LangServiceProvider`.

## 🏆 Il Vincitore: Centralizzazione Laraxot (Voce C)

### Perché ha vinto
1. **Punto Unico di Verità (SSOT)**: Le etichette, le icone e i titoli non sono logica di business, ma metadati di presentazione e localizzazione. Devono risiedere esclusivamente nei file di traduzione.
2. **Forzatura della Best Practice**: Rimuovendo le proprietà dal PHP, si costringe il sistema (e lo sviluppatore) a configurare correttamente le traduzioni, eliminando il rischio di avere un'icona hardcoded in PHP solo per l'italiano e mancante per le altre 5 lingue principali.
3. **AST Ambiguity**: La presenza di queste proprietà può mandare in confusione gli agenti AI e i tool di analisi statica che potrebbero trovarsi a gestire valori contrastanti tra PHP e JSON/Lang.

## 📋 La Nuova Regola
Le classi che estendono `XotBaseResource` **NON DEVONO** definire:
- `protected static ?string $recordTitleAttribute`
- `protected static string|\BackedEnum|null $navigationIcon`
- `protected static ?string $modelLabel`
- `protected static ?string $pluralModelLabel`
- `protected static ?int $navigationSort`

Questi valori vengono risolti dinamicamente da `XotBaseResource` tramite i file di traduzione sotto la chiave `.navigation` (e i suoi fallback).

## 🚀 Prossimi Passi
1. **Stage 1**: Concludere la risoluzione dei merge conflicts bloccanti (Rector Conflict Resolution).
2. **Stage 2**: Implementare una regola Rector personalizzata per identificare e rimuovere queste proprietà.
3. **Localizzazione**: Assicurarsi che per ogni Resource esistano le traduzioni nelle 6 lingue target (IT, EN, ES, FR, ZH, AR).

---
*Documentazione redatta seguendo i principi Super Mucca: DRY, KISS, Robustness.*
