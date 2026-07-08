# MCP Validation Rule

**All changes must be verified using all available tools, including MCP.**

This rule is critical to ensure the stability and correctness of the system. It applies to all changes, regardless of their size or perceived impact.

## Rationale

MCP (Mission Critical Platform) is a suite of tools that provides an extra layer of validation and security. By using MCP to verify changes, we can catch potential issues that might be missed by other tools.

## Procedure

1.  **Make the change:** Implement the desired change in the codebase.
2.  **Run standard checks:** Run all standard checks, such as unit tests, linting, and type checking.
3.  **Run MCP validation:** Run the relevant MCP tools to validate the change. This may include tools for checking configuration, security, and compliance.
4.  **Review the results:** Carefully review the results of all checks, including the MCP validation.
5.  **Commit the change:** If all checks pass, commit the change to the repository.

## For AI Agents

This rule is especially important for AI agents. As an AI, it is your responsibility to ensure that your changes are safe and correct. Always use all available tools, including MCP, to verify your changes before committing them.
