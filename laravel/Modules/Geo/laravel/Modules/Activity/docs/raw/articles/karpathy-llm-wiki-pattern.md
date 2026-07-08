# Karpathy LLM Wiki Pattern

**Source:** Andrej Karpathy's GitHub gist and social media posts  
**Date:** 2026-04-07  
**Type:** Architecture Pattern

## Summary

Andrej Karpathy shared a simple but powerful pattern for maintaining LLM knowledge: a `raw/` folder for unorganized source material and a `wiki/` folder where the LLM synthesizes structured markdown. This eliminates the need for vector databases at moderate scale (~100-500 sources).

## Core Insight

> "The raw folder has one rule: nothing in it needs to be organized. You throw things in, and the LLM organizes them later."

### Why This Works

1. **Humans are bad at organizing** — we drop files, forget to categorize
2. **LLMs are great at synthesizing** — they can read chaos and create structure
3. **Git handles versioning** — no need for complex databases
4. **Markdown is universal** — portable, readable, LLM-friendly

## Three Operations

### 1. Ingest
- Drop raw file in `raw/`
- Tell LLM: "Ingest docs/raw/articles/{filename}"
- LLM reads, synthesizes wiki pages, updates index

### 2. Query
- Ask LLM: "Based on the wiki, {question}"
- LLM reads index, finds relevant pages, synthesizes answer
- High-value insights get filed as new wiki pages

### 3. Lint
- Tell LLM: "Lint the wiki — find contradictions and orphans"
- LLM scans for broken links, missing concepts, contradictions
- Maintains knowledge quality over time

## Application to PTVX

This pattern is perfect for PTVX because:

- **35 modules** with scattered documentation
- **Multiple AI agents** working simultaneously
- **Cross-project reuse** — knowledge must be portable
- **Long-term maintenance** — git tracks knowledge evolution

## Implementation

Each module gets:
```
docs/
├── wiki/          # LLM-owned knowledge
│   ├── index.md   # Content catalog
│   ├── log.md     # Activity log
│   ├── concepts/  # Synthesized topics
│   ├── entities/  # Named things (models, people)
│   ├── sources/   # Raw file summaries
│   └── comparisons/ # Analyses
├── raw/           # Human-owned chaos
│   ├── articles/
│   ├── papers/
│   ├── code-examples/
│   └── decisions/
└── schema.md      # Rules for this module
```

## Tools

- **qmd** — Local markdown search engine (Shopify CEO)
  - Hybrid search: BM25 + vector + LLM re-ranking
  - On-device via node-llama-cpp
  - MCP server for AI agent integration
- **Git** — Version control for knowledge
- **Obsidian** — Optional visual interface

## Performance

- Direct file reading handles ~200k tokens per session
- qmd kicks in at ~100 sources per module
- MCP servers allow parallel queries across modules
- No vector database needed until 1000+ sources

---

**Tags:** #knowledge-management #llm #architecture #karpathy #documentation
**Related:** [[docs/wiki/overview.md]], [[docs/llm-wiki-architecture.md]]
