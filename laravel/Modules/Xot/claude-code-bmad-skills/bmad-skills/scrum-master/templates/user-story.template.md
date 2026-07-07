# {Story Title}

**ID:** STORY-{number}
**Epic:** {Epic ID or Epic Name}
**Priority:** {Must Have | Should Have | Could Have | Won't Have}
**Story Points:** {1 | 2 | 3 | 5 | 8}
**Status:** {Not Started | In Progress | In Review | Completed}

## User Story

As a **{user type/role}**
I want to **{capability or feature}**
So that **{business value or benefit}**

## Acceptance Criteria

Define clear, testable criteria. Each criterion should be independently verifiable.

- [ ] **Criterion 1:** {Specific, measurable outcome}
- [ ] **Criterion 2:** {Specific, measurable outcome}
- [ ] **Criterion 3:** {Specific, measurable outcome}
- [ ] **Criterion 4:** {Specific, measurable outcome}
- [ ] **Criterion 5:** {Specific, measurable outcome}

**Tip:** Keep acceptance criteria between 3-7 items. If more than 7, consider breaking down the story.

## Technical Notes

### Implementation Approach
{Brief description of technical approach, architecture components, patterns to use}

### Files/Modules Affected
- `{file/module 1}` - {what changes}
- `{file/module 2}` - {what changes}
- `{file/module 3}` - {what changes}

### Data Model Changes
{Describe any database schema changes, new tables, fields, indexes}

### API Changes
{Describe any new endpoints, request/response formats, authentication requirements}

### Edge Cases
- **{Edge case 1}:** {How to handle}
- **{Edge case 2}:** {How to handle}
- **{Edge case 3}:** {How to handle}

### Performance Considerations
{Any performance requirements, optimization needs, scalability concerns}

### Security Considerations
{Authentication, authorization, data validation, sanitization needs}

## Dependencies

### Story Dependencies
- **Blocked by:** {STORY-XXX} - {Brief description}
- **Blocks:** {STORY-XXX} - {Brief description}

### Technical Dependencies
- {External API, library, service, infrastructure requirement}
- {Configuration, environment variable, deployment requirement}

### Open Questions
- [ ] {Question 1 that needs clarification}
- [ ] {Question 2 that needs clarification}

## Testing Requirements

### Unit Tests
- [ ] {Test case 1}
- [ ] {Test case 2}
- [ ] {Test case 3}

### Integration Tests
- [ ] {Integration test case 1}
- [ ] {Integration test case 2}

### Manual Testing
- [ ] {Manual test scenario 1}
- [ ] {Manual test scenario 2}

## Definition of Done

This story is considered complete when:

- [ ] Code is written and follows project coding standards
- [ ] All acceptance criteria are met and verified
- [ ] Unit tests are written and passing (>80% coverage for new code)
- [ ] Integration tests are written and passing (if applicable)
- [ ] Code has been reviewed and approved by at least one team member
- [ ] No critical or high-priority bugs remain
- [ ] Documentation is updated (README, API docs, inline comments)
- [ ] Changes are merged to main/development branch
- [ ] Deployed to {staging/production} environment
- [ ] Product owner has reviewed and accepted the story

## Notes

{Any additional context, links to designs, mockups, related tickets, discussions, or decisions}

---

## Usage Instructions

### For Story Creation:
1. Replace all `{placeholders}` with actual values
2. Remove any sections not applicable to this story
3. Ensure acceptance criteria are specific and testable
4. Verify story points align with complexity (use sizing guide)
5. Identify all dependencies before starting work

### For Story Estimation:
- **1 point:** Trivial change (1-2 hours)
- **2 points:** Simple implementation (2-4 hours)
- **3 points:** Moderate complexity (4-8 hours)
- **5 points:** Complex feature (1-2 days)
- **8 points:** Very complex, maximum size (2-3 days)
- **13+ points:** Too large - break into smaller stories

### Priority Definitions:
- **Must Have:** Core functionality, critical for release
- **Should Have:** Important, but not critical
- **Could Have:** Nice to have, low priority
- **Won't Have:** Explicitly out of scope for this sprint/release

### Status Values:
- **Not Started:** Story is in backlog, not yet begun
- **In Progress:** Actively being worked on
- **In Review:** Code review or testing in progress
- **Completed:** All acceptance criteria met, deployed, accepted
