# Ollama Optimization Guide

## Hardware Analysis

### Current System (2026-03-13)

| Component | Specification | Status |
|-----------|--------------|--------|
| **CPU** | Intel i5-8400 @ 2.80GHz (6 core) | 4 thread in WSL2 |
| **RAM** | 30GB totale | 16GB disponibile |
| **Swap** | 16GB | 15GB libera |
| **Disk** | 1TB SSD | 828GB liberi |
| **GPU** | None detected | CPU-only inference |

### Installed Models

| Model | Size | Last Used |
|-------|------|-----------|
| codellama:latest | 3.8 GB | 4 months ago |
| qwen2.5-coder:latest | 4.7 GB | 6 months ago |
| llama3:8b | 4.7 GB | 11 months ago |

---

## Optimizations Applied

### 1. Service Configuration (`/etc/systemd/system/ollama.service`)

```ini
[Unit]
Description=Ollama Service
After=network-online.target

[Service]
ExecStart=/usr/local/bin/ollama serve
User=ollama
Group=ollama
Restart=always
RestartSec=3

# CPU Optimization - i5-8400 6 cores
Environment="OLLAMA_NUM_THREAD=6"

# RAM Management - 16GB available
Environment="OLLAMA_KEEP_ALIVE=30m"
Environment="OLLAMA_MAX_LOADED_MODELS=3"

# Parallel Requests
Environment="OLLAMA_NUM_PARALLEL=4"

# Flash Attention (if supported)
Environment="OLLAMA_FLASH_ATTENTION=1"

# Context Window
Environment="OLLAMA_CONTEXT_LENGTH=8192"

# Network
Environment="OLLAMA_HOST=0.0.0.0:11434"

# Memory Limit (prevent OOM)
Environment="OLLAMA_MAX_VRAM=14GB"

[Install]
WantedBy=default.target
```

### 2. Recommended Models for This Hardware

#### Best Performance/Quality Balance

| Model | VRAM | Context | Use Case |
|-------|------|---------|----------|
| **llama3.2:3b** | 2GB | 8K | Fast responses, coding |
| **llama3.2:1b** | 1GB | 8K | Ultra-fast, simple tasks |
| **qwen2.5:7b** | 4GB | 32K | Coding, reasoning |
| **mistral:7b** | 4GB | 8K | General purpose |
| **codellama:7b** | 4GB | 16K | Code generation |

#### Models to Avoid (Too Heavy)

- ❌ llama3:70b (requires 40GB+ VRAM)
- ❌ mixtral:8x7b (requires 26GB+ VRAM)
- ❌ codellama:34b (requires 20GB+ VRAM)

### 3. Installation Commands

```bash
# Install optimized models
ollama pull llama3.2:3b
ollama pull qwen2.5:7b
ollama pull mistral:7b

# Remove old/unused models
ollama rm codellama:latest
ollama rm qwen2.5-coder:latest
ollama rm llama3:8b

# Verify installation
ollama list
```

### 4. Performance Tuning

#### For Maximum Speed (Development)

```bash
export OLLAMA_NUM_THREAD=6
export OLLAMA_NUM_PARALLEL=4
export OLLAMA_KEEP_ALIVE=5m
ollama serve
```

#### For Maximum Quality (Production)

```bash
export OLLAMA_NUM_THREAD=6
export OLLAMA_NUM_PARALLEL=2
export OLLAMA_KEEP_ALIVE=1h
export OLLAMA_CONTEXT_LENGTH=16384
ollama serve
```

### 5. Monitoring

#### Check Memory Usage

```bash
# Real-time monitoring
watch -n 1 'cat /proc/meminfo | grep -E "MemTotal|MemFree|MemAvailable"'

# Ollama process memory
ps aux | grep ollama | awk '{print $6/1024 " MB"}'
```

#### Check Model Performance

```bash
# Test inference speed
time ollama run llama3.2:3b "Write a hello world in PHP"

# Check active models
curl http://localhost:11434/api/tags
```

### 6. WSL2 Specific Optimizations

#### `.wslconfig` Configuration

Create/edit `C:\Users\YourUser\.wslconfig`:

```ini
[wsl2]
memory=24GB
processors=6
swap=16GB
pageReporting=true
dynamicMemory=true
```

#### Apply Changes

```powershell
# In PowerShell (Admin)
wsl --shutdown
wsl
```

---

## Expected Performance

### Inference Speed (tokens/second)

| Model | Speed | Quality |
|-------|-------|---------|
| llama3.2:1b | ~50 t/s | Basic |
| llama3.2:3b | ~25 t/s | Good |
| qwen2.5:7b | ~15 t/s | Very Good |
| mistral:7b | ~15 t/s | Very Good |
| codellama:7b | ~12 t/s | Excellent (code) |

### Concurrent Users

| Configuration | Max Users | Response Time |
|---------------|-----------|---------------|
| 1 model, 4 parallel | 4 | <2s |
| 2 models, 2 parallel each | 4 | <3s |
| 3 models, 1 parallel each | 3 | <5s |

---

## Troubleshooting

### Out of Memory

```bash
# Reduce max models
Environment="OLLAMA_MAX_LOADED_MODELS=1"

# Reduce context length
Environment="OLLAMA_CONTEXT_LENGTH=4096"

# Reduce VRAM limit
Environment="OLLAMA_MAX_VRAM=8GB"
```

### Slow Inference

```bash
# Use smaller model
ollama pull llama3.2:3b

# Reduce context
export OLLAMA_CONTEXT_LENGTH=2048

# Close other models
ollama rm <unused-model>
```

### Service Won't Start

```bash
# Check logs
journalctl -u ollama -f

# Restart service
sudo systemctl daemon-reload
sudo systemctl restart ollama

# Check status
systemctl status ollama
```

---

## Maintenance

### Weekly Tasks

- [ ] Clear old conversations: `ollama prune`
- [ ] Check for model updates: `ollama pull --all`
- [ ] Monitor disk usage: `du -sh ~/ollama/models`

### Monthly Tasks

- [ ] Remove unused models
- [ ] Update Ollama: `curl -fsSL https://ollama.com/install.sh | sh`
- [ ] Review performance metrics

---

## Links

- [Ollama Documentation](https://ollama.com/docs)
- [Ollama GitHub](https://github.com/ollama/ollama)
- [Open WebUI](https://openwebui.com/) - Recommended UI
- [LM Studio](https://lmstudio.ai/) - Alternative local UI

---

*Last updated: 2026-03-13*
