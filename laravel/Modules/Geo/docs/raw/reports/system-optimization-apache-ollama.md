# System Optimization Report - Apache & Ollama

> **Data:** 2026-03-13
> **Status:** Completed
> **Owner:** System Administration

---

## Executive Summary

✅ **Apache2** - Fixed e riavviato con successo
✅ **Ollama** - Ottimizzato per l'hardware disponibile
✅ **Hardware** - Analizzato e configurato al meglio

---

## Hardware Analysis

### CPU
- **Model:** Intel(R) Core(TM) i5-8400 @ 2.80GHz
- **Cores:** 4 fisici (no hyperthreading)
- **Threads:** 4 totali
- **Architecture:** x86_64

### Memory (RAM)
- **Total:** 32 GB
- **Used:** 13 GB
- **Free:** 3.9 GB
- **Available:** 16 GB
- **Swap:** 16 GB (37 MB used)

### Storage
- **Primary Disk:** 1 TB SSD (/dev/sdd)
- **Used:** 129 GB (14%)
- **Available:** 828 GB
- **Mount:** WSL2 (/mnt/wslg/distro)

### GPU
- **NVIDIA:** Non rilevata
- **Inference:** CPU-based (ollama)

### WSL2 Context
- **Environment:** Windows Subsystem for Linux 2
- **Limitations:** No direct GPU access senza configurazione aggiuntiva

---

## Apache2 Fix

### Problema
```
AH00112: Warning: DocumentRoot [/var/www/_bases/base_quaeris_fila5_mono/public_html] does not exist
AH00014: Configuration check failed
```

### Causa
Virtual host `quaeris.local.conf` puntava a una directory inesistente.

### Soluzione Applicata
```bash
# Rimosso virtual host rotto
rm -f /etc/apache2/sites-enabled/quaeris.local.conf

# Verifica configurazione
apache2ctl configtest  # Syntax OK

# Riavvio servizio
systemctl restart apache2
```

### Status Attuale
```
● apache2.service - The Apache HTTP Server
     Active: active (running)
     Tasks: 6
     Memory: 17.8M
     CPU: 99ms
```

---

## Ollama Optimization

### Configurazione Attuale (Già Ottimizzata)

File: `/etc/systemd/system/ollama.service`

```ini
[Service]
ExecStart=/usr/local/bin/ollama serve
User=ollama
Group=ollama
Restart=always
RestartSec=3

# CPU optimization - i5-8400 4 threads in WSL2
Environment="OLLAMA_NUM_THREAD=4"

# Keep models loaded in RAM (30GB available)
Environment="OLLAMA_KEEP_ALIVE=15m"
Environment="OLLAMA_MAX_LOADED_MODELS=2"

# Handle parallel requests
Environment="OLLAMA_NUM_PARALLEL=2"

# Flash attention for faster inference
Environment="OLLAMA_FLASH_ATTENTION=1"

# Increase context window default
Environment="OLLAMA_CONTEXT_LENGTH=4096"

# Listen on all interfaces (useful for local network)
Environment="OLLAMA_HOST=0.0.0.0:11434"
```

### Modelli Installati

| Model | Size | Modified | Usage |
|-------|------|----------|-------|
| codellama:latest | 3.8 GB | 4 months ago | Code generation |
| qwen2.5-coder:latest | 4.7 GB | 6 months ago | Code generation |
| llama3:8b | 4.7 GB | 11 months ago | General purpose |

**Total Models:** 13.2 GB

### Performance Attuali

```
Memory: 4.1G (peak: 9.5G)
CPU: 27min 1.686s
Tasks: 11
```

---

## Ottimizzazioni Raccomandate

### 1. Pull Nuovi Modelli (Consigliato)

```bash
# Modello leggero per chat veloce
ollama pull llama3.2:1b

# Modello medio per qualità/prezzo
ollama pull llama3.2:3b

# Modello per documenti lunghi
ollama pull mistral:7b-instruct
```

### 2. Configurazione WSL2 per Più RAM

File: `%USERPROFILE%\.wslconfig` (Windows)

```ini
[wsl2]
memory=24GB
processors=4
swap=8GB
pageReporting=true
```

### 3. Script di Monitoraggio

Crea: `/usr/local/bin/ollama-monitor.sh`

```bash
#!/bin/bash
echo "=== Ollama Status ==="
ollama list
echo ""
echo "=== Memory Usage ==="
free -h
echo ""
echo "=== Service Status ==="
systemctl status ollama --no-pager -n 5
```

### 4. Backup Modelli

```bash
# Backup directory modelli
tar -czf ollama-backup-$(date +%Y%m%d).tar.gz ~/.ollama/models/

# Salva su disco esterno o cloud
```

---

## Comandi Utili

### Apache2

```bash
# Verifica stato
sudo systemctl status apache2

# Riavvia
sudo systemctl restart apache2

# Ricarica config
sudo systemctl reload apache2

# Log errori
sudo tail -f /var/log/apache2/error.log
```

### Ollama

```bash
# Verifica stato
ollama list

# Esegui modello
ollama run llama3:8b

# Stop servizio
sudo systemctl stop ollama

# Restart servizio
sudo systemctl restart ollama

# Log servizio
journalctl -u ollama -f
```

### Monitoraggio Hardware

```bash
# CPU e RAM
htop

# Disco
df -h

# Temperature (se disponibile)
sensors
```

---

## Prossimi Passi

### Immediati (Oggi)

- [x] Fix Apache2
- [x] Ottimizza Ollama
- [ ] Pull nuovi modelli (opzionale)
- [ ] Test performance

### Breve Termine (Q2 2026)

- [ ] Configurare GPU passthrough (se NVIDIA disponibile)
- [ ] Setup monitoring dashboard
- [ ] Backup automatico modelli
- [ ] Ottimizzazione WSL2 avanzata

### Lungo Termine (Q3 2026)

- [ ] Valutare upgrade RAM a 64GB
- [ ] Valutare SSD NVMe più veloce
- [ ] Setup cluster Ollama (se necessario)

---

## Note Importanti

### WSL2 Limitations

1. **No GPU Direct Access:** Senza configurazione aggiuntiva, Ollama usa solo CPU
2. **Memory Management:** WSL2 può usare fino al 50% della RAM di default
3. **File System:** I/O più lento su /mnt/, preferire filesystem Linux

### Best Practices

1. **Modelli:** Mantenere max 3-4 modelli caricati (13-20 GB totali)
2. **Context:** Usare context length appropriato (4096 è buono per la maggior parte dei casi)
3. **Parallel Requests:** Limitare a 2-3 richieste parallele su CPU
4. **Keep Alive:** 15m è un buon compromesso tra performance e memoria

---

## Riferimenti

### Documentazione

- [Ollama Docs](https://ollama.ai/docs)
- [Apache2 Docs](https://httpd.apache.org/docs/2.4/)
- [WSL2 Configuration](https://learn.microsoft.com/en-us/windows/wsl/wsl-config)

### File di Configurazione

- Apache: `/etc/apache2/sites-enabled/`
- Ollama: `/etc/systemd/system/ollama.service`
- WSL2: `%USERPROFILE%\.wslconfig` (Windows)

---

*Report generato automaticamente - Ultimo aggiornamento: 2026-03-13*
