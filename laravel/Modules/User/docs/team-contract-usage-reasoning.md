---
title: "TeamContract Usage Reasoning"
type: note
status: draft
updated: 2026-10-26
tags: [docs, user]
qmd: "teamcontract usage reasoning user"
---
# TeamContract Usage Reasoning

## Overview
This document explains the rationale behind using `TeamContract` instead of `Team` in the `HasTeams` trait within the User module. The purpose is to ensure that the codebase adheres to best practices for dependency management and future-proofing.

## Reasoning for Using TeamContract

1. **Dependency Inversion Principle**: By referencing `TeamContract` (likely an interface or abstract class), the `HasTeams` trait is not tightly coupled to a specific `Team` class implementation. This allows for multiple implementations of team functionality without requiring changes to the trait itself.

2. **Flexibility and Maintainability**: Using an interface or contract enables the system to support different team models or structures in the future. For instance, if a new type of team entity is introduced, as long as it implements `TeamContract`, the `HasTeams` trait will work seamlessly with it.

3. **Testing and Mocking**: During unit testing, it's easier to mock or stub an interface (`TeamContract`) than a concrete class (`Team`). This improves the testability of components that rely on team-related functionality.

4. **Consistency Across Modules**: Following this pattern ensures consistency across different modules or components that interact with team entities, promoting a unified approach to dependency management in the project.

## Implications
- **Code Changes**: All references to `Team` in method signatures, type hints, and docblocks within the `HasTeams` trait should be updated to `TeamContract` where applicable.
- **Documentation**: This change should be reflected in related documentation to maintain clarity for developers working on or with this trait.

## Conclusion
The shift to using `TeamContract` over `Team` in the `HasTeams` trait aligns with software engineering best practices, enhancing the flexibility, maintainability, and testability of the codebase. This approach prepares the system for future expansions or modifications to team-related functionalities without necessitating significant refactoring.

*Last Updated: 16 May 2025*
---
module: theme
topic: team-contract-usage-reasoning
canonical: ../../../Themes/docs/shared-components/team-contract-usage-reasoning.md
related:
  - "./00-index.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/team-contract-usage-reasoning.md
---
title: "TeamContract: perché il contratto (e la nullability)"
type: concept
module: User
status: active
updated: 2026-10-20
tags: [docs, user, teams, teamcontract]
qmd: "teamcontract usage reasoning hasteams nullability personalTeam test tipizzazione"
related:
  - ./contracts/teamcontract.md
  - ./scopo.md
  - ./00-INDEX.md
  - ./stories/phpstan-test-wave-user-b.story.md
---

# TeamContract: perché il contratto (e la nullability)

Indice: [00-INDEX.md](./00-index.md) · API: [contracts/teamcontract.md](./contracts/teamcontract.md) · scopo: [scopo.md](./scopo.md).

## Perché `TeamContract` e non `Team`

1. **Inversion**: `HasTeams` non deve conoscere la classe concreta del tenant/progetto.
2. **Foglie STI**: i `User` concreti possono vivere fuori dal modulo; il team resta tipizzato sul contratto.
3. **Test**: fixture/mock del contratto senza bootstrap Eloquent completo del modello `Team`.

## Perché i test devono tipizzare

`personalTeam(): ?TeamContract` e `belongsToTeam(?TeamContract)` modellano la realtà: utente senza team. Errori tipici da evitare:

- `belongsToTeam(5)`: l'ID non è un team
- `$this->user->personalTeam()->id` senza guard: il ritorno è nullable
- `shouldReceive` su un model Eloquent reale al posto di una fixture `TeamContract`

Evidence lane: [stories/phpstan-test-wave-user-b.story.md](./stories/phpstan-test-wave-user-b.story.md).

## Variante underscore

`team_contract_usage_reasoning.md` è superseded: usa questo file.