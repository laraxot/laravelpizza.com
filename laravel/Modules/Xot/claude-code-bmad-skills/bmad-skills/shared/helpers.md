# BMAD Shared Helpers

Reusable patterns for all BMAD skills. Reference specific sections to avoid repetition.

## Config Operations

### Load-Project-Config
```
Path: bmad/config.yaml
Purpose: Load project-specific BMAD configuration

Steps:
1. Read bmad/config.yaml
2. Parse YAML to extract:
   - project.name
   - project.type
   - project.level
   - paths.output_folder
   - workflow settings
3. Return config object or null if not found
```

### Load-Workflow-Status
```
Path: {output_folder}/bmm-workflow-status.yaml
Purpose: Get current workflow progress

Steps:
1. Read status file from paths.status_file
2. Parse YAML to extract:
   - current_phase
   - current_workflow
   - phase completion status
   - workflow outputs
3. Return status object
```

### Update-Workflow-Status
```
Purpose: Mark workflow as complete

Steps:
1. Load current status file
2. Find workflow in appropriate phase
3. Update:
   - completed: true
   - output_file: "{path}"
   - completed_at: "{timestamp}"
4. Update phase status if all required workflows complete
5. Update metrics
6. Save file
```

## Subagent Operations

### Launch-Parallel-Agents
```
Purpose: Launch multiple subagents for parallel work

Pattern:
1. Prepare shared context file (bmad/context/current-task.md)
2. For each task:
   - Create agent prompt with:
     * Task objective
     * Context file reference
     * Output location
     * Constraints
   - Launch with Task tool, run_in_background: true
3. Store agent IDs for tracking
4. Return agent ID list
```

### Collect-Agent-Results
```
Purpose: Gather results from parallel agents

Pattern:
1. For each agent ID:
   - Call TaskOutput with block: false
   - If not ready, add to pending list
2. If pending agents exist:
   - Continue other work or
   - Call TaskOutput with block: true
3. Read output files from each agent
4. Return collected results
```

### Synthesize-Results
```
Purpose: Combine outputs from multiple agents

Pattern:
1. Load all agent output files
2. Identify overlaps and conflicts
3. Merge into unified document
4. Resolve conflicts (prefer more detailed)
5. Write synthesized output
```

## Document Operations

### Load-Template
```
Purpose: Load document template for workflow

Steps:
1. Determine template path:
   - Skill templates: {skill}/templates/{name}.template.md
   - Shared templates: shared/{name}.template.yaml
2. Read template file
3. Extract {{variable}} placeholders
4. Return template content and variables list
```

### Apply-Variables
```
Purpose: Substitute {{variables}} with values

Standard Variables:
- {{project_name}} → config.project.name
- {{project_type}} → config.project.type
- {{project_level}} → config.project.level
- {{date}} → YYYY-MM-DD
- {{timestamp}} → ISO 8601
- {{user_name}} → from global config or "User"

Steps:
1. For each {{variable}} in template:
   - Look up value in config or provided values
   - Replace placeholder with value
2. Return completed content
```

### Save-Document
```
Purpose: Save generated document

Steps:
1. Determine output path:
   - {output_folder}/{workflow}-{project_name}-{date}.md
2. Write content to file
3. Return file path for status update
```

## Phase Logic

### Determine-Requirements
```
Purpose: Set workflow requirements based on level

Level 0 (1 story):
- product_brief: skip
- prd: skip
- tech_spec: required
- architecture: skip

Level 1 (1-10 stories):
- product_brief: recommended
- prd: recommended
- tech_spec: required
- architecture: optional

Level 2+ (5+ stories):
- product_brief: required
- prd: required
- tech_spec: optional
- architecture: required
```

### Determine-Next-Workflow
```
Purpose: Recommend next workflow based on status

Logic:
1. Check Phase 1:
   - If product_brief required and not complete → /product-brief
2. Check Phase 2:
   - If PRD required and not complete → /prd
   - If tech_spec required and not complete → /tech-spec
3. Check Phase 3:
   - If architecture required and not complete → /architecture
4. Check Phase 4:
   - If sprint_planning not complete → /sprint-planning
   - If stories exist → /dev-story {next-story}
5. Return recommendation with rationale
```

### Display-Status
```
Purpose: Format status for user display

Symbols:
- ✓ = Completed
- ⚠ = Required, not started
- → = Current phase/workflow
- - = Optional
- ○ = In progress

Format:
Phase {n}: {name} [{STATUS}]
  {symbol} {workflow} ({status}) [output if complete]
```

## Validation Operations

### Validate-YAML
```
Purpose: Check YAML file validity

Steps:
1. Attempt to parse file
2. If error:
   - Return error message with line number
   - Suggest fixes
3. If valid:
   - Return parsed content
```

### Validate-Document-Sections
```
Purpose: Check document completeness

Steps:
1. Load expected sections for document type
2. Parse document headings
3. Compare against expected
4. Return:
   - Missing sections
   - Empty sections
   - Completeness percentage
```

## Token Optimization

### Reference-Pattern
```
Instead of embedding full instructions:
✓ Good: "Follow helpers.md#Load-Project-Config"
✗ Bad: [Full 50-line config loading instructions]

Instead of repeating patterns:
✓ Good: "Use standard subagent prompt from SUBAGENT-PATTERNS.md"
✗ Bad: [Full subagent prompt template repeated]
```

### Lazy-Loading
```
Load content only when needed:
1. Start with SKILL.md only (~2-3K tokens)
2. Load REFERENCE.md when detailed info needed
3. Load resources/ files for specific lookups
4. Run scripts for deterministic operations
```

## Error Handling

### Config-Not-Found
```
If bmad/config.yaml missing:
1. Inform user: "BMAD not initialized in this project"
2. Offer: "Run /workflow-init to set up BMAD"
3. Provide quick setup option
```

### Status-File-Missing
```
If workflow status file missing:
1. Check if config exists
2. If config exists: Recreate status file from template
3. If no config: Direct to initialization
```

### Agent-Failure
```
If subagent fails or times out:
1. Log failure with agent ID
2. Check partial output
3. Retry with simplified prompt or
4. Fall back to sequential processing
```
