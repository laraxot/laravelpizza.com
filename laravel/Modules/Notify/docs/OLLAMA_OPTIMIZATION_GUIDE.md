# Ollama Optimization Guide - Intel i5-8400 (32GB RAM)

**Date**: 2026-03-13  
**Status**: ✅ Optimized  
**Hardware**: CPU-only (No GPU)

---

## 🖥️ Hardware Profile

| Component | Specification |
|-----------|--------------|
| **CPU** | Intel Core i5-8400 @ 2.80GHz |
| **Cores** | 4 physical cores, 4 threads |
| **RAM** | 32GB (20GB used, 9.3GB available) |
| **Swap** | 16GB |
| **GPU** | None detected (CPU-only mode) |
| **Storage** | 1TB SSD (826GB available) |

---

## ✅ Applied Optimizations

### 1. Environment Variables (`/etc/ollama/ollama.env`)

```bash
OLLAMA_MAX_QUEUE=4              # Match physical cores
OLLAMA_KEEP_ALIVE=5m            # Keep models warm
OLLAMA_HOST=0.0.0.0:11434       # Listen on all interfaces
OPENBLAS_NUM_THREADS=4          # BLAS thread count
MKL_NUM_THREADS=4               # Intel MKL threads
OMP_NUM_THREADS=4               # OpenMP threads
```

### 2. Systemd Service Override (`/etc/systemd/system/ollama.service.d/override.conf`)

```ini
[Service]
EnvironmentFile=/etc/ollama/ollama.env
IOSchedulingClass=best-effort
LimitNOFILE=65536
LimitNPROC=4096
Restart=always
RestartSec=10
TimeoutStartSec=120
```

### 3. System Memory Tuning (`/etc/sysctl.conf`)

```bash
vm.overcommit_memory=1          # Allow memory overcommit
vm.swappiness=10                # Reduce swap usage
vm.dirty_ratio=10               # Limit dirty pages
vm.dirty_background_ratio=5     # Background writeback threshold
```

---

## 📊 Model Recommendations

### ✅ Excellent Performance (Fast - Recommended)

| Model | Size | Speed | Use Case |
|-------|------|-------|----------|
| `llama3.2:1b` | 1.3GB | ⚡⚡⚡⚡⚡ | Simple tasks, very fast |
| `llama3.2:3b` | 2GB | ⚡⚡⚡⚡ | Good balance |
| `qwen2.5:1.5b` | 1GB | ⚡⚡⚡⚡⚡ | Coding, very fast |
| `qwen2.5:3b` | 2GB | ⚡⚡⚡⚡ | Coding, excellent |
| `phi3:mini` | 2GB | ⚡⚡⚡⚡ | Reasoning, fast |

**Install Commands**:
```bash
ollama pull llama3.2:3b
ollama pull qwen2.5:3b
ollama pull phi3:mini
```

### ✅ Good Performance (Moderate Speed)

| Model | Size | Speed | Use Case |
|-------|------|-------|----------|
| `llama3.2:7b` | 4GB | ⚡⚡⚡ | Best balance |
| `qwen2.5:7b` | 4.7GB | ⚡⚡⚡ | Coding (you have this!) |
| `codellama:7b` | 3.8GB | ⚡⚡⚡ | Code generation (you have this!) |
| `mistral:7b` | 4GB | ⚡⚡⚡ | All-rounder |
| `llama3:8b` | 4.7GB | ⚡⚡⚡ | General purpose (you have this!) |

**Install Commands**:
```bash
ollama pull llama3.2:7b
ollama pull mistral:7b
```

### ⚠️ Acceptable Performance (Slower but Usable)

| Model | Size | Speed | RAM Usage | Use Case |
|-------|------|-------|-----------|----------|
| `llama3.1:8b` | 4.7GB | ⚡⚡ | ~6GB | Better quality |
| `gemma2:9b` | 5.5GB | ⚡⚡ | ~7GB | Good quality |
| `qwen2.5:14b` | 9GB | ⚡ | ~12GB | Complex tasks |

**Note**: Use `OLLAMA_NUM_PARALLEL=1` for models >10B

### ❌ Not Recommended (Too Slow for CPU-only)

- Models > 20B parameters (e.g., `llama3:70b`, `qwen2.5:72b`)
- Unquantized models - Always use quantized versions!

---

## 🔧 Quantization Guide

**Always prefer quantized models for CPU-only inference:**

| Quantization | Quality | Speed | RAM Usage | Recommendation |
|--------------|---------|-------|-----------|----------------|
| Q4_K_M | Good | ⚡⚡⚡⚡⚡ | Lowest | ✅ **Best balance** |
| Q5_K_M | Better | ⚡⚡⚡⚡ | Low | ✅ Good quality |
| Q6_K | Very Good | ⚡⚡⚡ | Medium | Acceptable |
| Q8_0 | Near-lossless | ⚡⚡ | High | Slow |
| F16 | Lossless | ⚡ | Very High | ❌ Avoid |

**Example**:
```bash
# Good choice
ollama pull llama3.2:7b          # Usually Q4_K_M

# Better quality
ollama pull llama3.2:7b-q5_k_m

# Check available tags
ollama show llama3.2:7b --modelfile
```

---

## 📋 Useful Commands

### Service Management
```bash
# Check status
sudo systemctl status ollama

# Restart service
sudo systemctl restart ollama

# View logs
journalctl -u ollama -f

# Check if running
systemctl is-active ollama
```

### Model Management
```bash
# List installed models
ollama list

# Pull a model
ollama pull llama3.2:7b

# Run a model
ollama run llama3.2:7b

# Remove a model
ollama rm llama3:8b

# Show model info
ollama show llama3.2:7b
```

### Performance Monitoring
```bash
# Check Ollama status
ollama ps

# Monitor memory
watch -n 1 'free -h'

# Check active models
curl http://localhost:11434/api/ps
```

---

## 🚀 Performance Tips

### 1. Keep Models Warm
Models unload from memory after 5 minutes. Keep them warm:
```bash
# Run periodically to keep model loaded
ollama run llama3.2:7b "Hello" > /dev/null 2>&1
```

### 2. Use Single Thread for Large Models
For models >10B, reduce parallel requests:
```bash
OLLAMA_NUM_PARALLEL=1 ollama run qwen2.5:14b
```

### 3. Close Other Applications
Free up RAM before running large models:
```bash
# Check memory usage
free -h

# Close unnecessary applications
```

### 4. Use Swap if Needed
With 32GB RAM + 16GB swap, you can run larger models:
```bash
# Check swap usage
swapon --show
```

---

## 📈 Expected Performance

### Token Generation Speed (Tokens/second)

| Model Size | Speed (tokens/s) | Use Case |
|------------|------------------|----------|
| 1-3B | 20-40 t/s | Real-time chat |
| 7-8B | 8-15 t/s | Good for most tasks |
| 14B | 3-6 t/s | Acceptable for complex tasks |
| 20B+ | 1-2 t/s | Too slow for interactive |

### Memory Usage by Model Size

| Model Size | RAM Usage | Can Run? |
|------------|-----------|----------|
| 1-3B | 2-4GB | ✅ Yes, very fast |
| 7-8B | 6-8GB | ✅ Yes, good speed |
| 14B | 12-14GB | ✅ Yes, moderate |
| 20B | 18-20GB | ⚠️ Possible, slow |
| 30B+ | 24GB+ | ❌ Not recommended |

---

## 🔍 Troubleshooting

### Ollama Won't Start
```bash
# Check logs
journalctl -u ollama -n 50

# Check if port is in use
sudo lsof -i :11434

# Restart service
sudo systemctl restart ollama
```

### Out of Memory
```bash
# Check memory usage
free -h

# Close other applications
# Use smaller model
ollama run llama3.2:3b
```

### Slow Performance
```bash
# Check if model is quantized
ollama show <model-name>

# Use smaller model
ollama pull llama3.2:3b

# Reduce parallel requests
export OLLAMA_NUM_PARALLEL=1
```

### Model Loading Slowly
```bash
# Increase timeout
sudo systemctl edit ollama
# Set TimeoutStartSec=120

# Use SSD storage (you have this!)
# Close other disk-intensive applications
```

---

## 📚 Additional Resources

- **Ollama Documentation**: https://ollama.ai/docs
- **Model Library**: https://ollama.ai/library
- **OpenBLAS**: https://www.openblas.net/
- **Intel MKL**: https://www.intel.com/content/www/us/en/developer/tools/oneapi/onemkl.html

---

## 🎯 Quick Start Guide

### For Beginners
```bash
# 1. Install fast model
ollama pull llama3.2:3b

# 2. Run it
ollama run llama3.2:3b

# 3. Ask questions!
>>> "Explain quantum computing in simple terms"
```

### For Developers
```bash
# 1. Install coding model
ollama pull qwen2.5-coder:7b

# 2. Use for code completion
ollama run qwen2.5-coder:7b

# 3. Or use API
curl http://localhost:11434/api/generate -d '{
  "model": "qwen2.5-coder:7b",
  "prompt": "def fibonacci(n):",
  "stream": false
}'
```

### For Production
```bash
# 1. Use stable model
ollama pull llama3.2:7b

# 2. Set up monitoring
watch -n 5 'curl http://localhost:11434/api/ps'

# 3. Configure backup
# (Models are in ~/.ollama/models)
```

---

**Status**: ✅ Optimized and Running  
**Last Updated**: 2026-03-13  
**Next Review**: 2026-04-13
