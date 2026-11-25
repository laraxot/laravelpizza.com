---
title: "Graphify Knowledge Graph"
type: note
qmd: "graphify knowledge graph"
---
# Graphify Knowledge Graph

## Overview

This directory contains the knowledge graph for the **Rating** module, generated using [Graphify](https://graphify.dev/). The graph provides a comprehensive visualization of code dependencies, architecture, and relationships within the module.

## Quick Start

### View the Graph

1. **Open in Graphify Visualizer**
   ```bash
   cd graphify-out
   graphify visualize .
   ```

2. **Analyze Graph Statistics**
   - **Nodes**: 472 (code entities: classes, functions, types)
   - **Edges**: 583 (dependencies and relationships)
   - **Communities**: 59 (logical clusters of related code)

### Key Files

- **graph.json** — Full knowledge graph in JSON format
- **.graphify_analysis.json** — Analysis metadata and statistics
- **GRAPH_REPORT.md** — Generated community names and cluster analysis

## Graph Interpretation

The knowledge graph represents:

- **Nodes**: Classes, interfaces, functions, exports, and other code entities
- **Edges**: Import statements, function calls, type references, and dependencies
- **Communities**: Automatically detected clusters of related functionality

## Use Cases

- **Dependency Analysis**: Understand what each component depends on
- **Architecture Discovery**: Identify logical module boundaries and communication patterns
- **Refactoring**: Find high-coupling areas for potential optimization
- **Onboarding**: Quickly grasp the module's code structure and relationships
- **Impact Analysis**: Trace how changes propagate through the codebase

## Generating Updated Graphs

To regenerate the knowledge graph after code changes:

```bash
graphify . --code-only --output docs/graphify/graphify-out
```

To generate community analysis and GRAPH_REPORT.md:

```bash
graphify cluster-only docs/graphify/graphify-out
```

## Documentation Integration

For more information about this module, see:
- Module documentation in the main README
- Architecture decisions in docs/architecture/
- API specifications in docs/api/

## References

- [Graphify Documentation](https://graphify.dev/)
- [Module Structure Guidelines](../../../../docs/wiki/rules/module-structure.md)

