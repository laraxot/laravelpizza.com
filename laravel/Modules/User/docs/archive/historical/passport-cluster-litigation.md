# 🤜 Furious Litigation: The Passport Cluster Debate

## The Contenders

### 🦸 The Progressive "Super Mucca" (Advocate for Cluster)
"We must unify the Passport resources! Currently, `OauthAccessTokenResource`, `OauthClientResource`, etc., are scattered in the 'User' group, making the sidebar long and messy. A `PassportCluster` in Filament groups these logically. It follows the principle of **High Cohesion**. It makes the administration of OAuth tokens, clients, and codes a first-class citizen with its own dedicated space."

### 🛡️ The Pragmatic "Laraxot" (Advocate for Simplicity)
"Wait! Clusters add another abstract layer. We already have enough complexity with multi-tenancy and multiple providers. If we hide them in a cluster, they might be harder to find for a quick check. And what about the PHPStan error? We are trying to build a cluster on top of a broken provider! Let's fix the foundation first."

## The Battle

**Super Mucca:** "The PHPStan error is exactly why we need better structure! By moving these to a cluster, we are forced to re-examine each resource and its relationship to the Passport models. It's not just a UI change; it's a mental model shift. We are defining the 'Oauth System' as a sub-domain of 'User'."

**Laraxot:** "But the user docs themselves are confused! One part says 'NO separate provider', another says 'advisable to add dedicated providers'. If we add a Cluster AND keep a separate Provider, aren't we overcomplicating?"

**Super Mucca:** "No, we are being **Robust**. The Provider handles the *infrastructure* (tokens, scopes, models), while the Cluster handles the *UI/UX in Filament*. They are complementary, not redundant."

## The Verdict

**Winner: The Progressive "Super Mucca"**

### Why he won:
1. **Clean UI**: Long sidebars are the enemy of Zen.
2. **Logical Grouping**: OAuth components are a specialized part of User management.
3. **Alignment with Filament 4**: Clusters are a native way to manage sub-systems.
4. **Methodology**: It's more 'Super Mucca' to organize properly than to settle for a flattened list.

### Implementation Plan (Post-Victory):
1. Fix `PassportServiceProvider` (remove/fix `useDeviceCodeModel`).
2. Create `Modules/User/app/Filament/Clusters/PassportCluster.php`.
3. Update all OAuth Resources to use `PassportCluster::class`.
4. Run full static analysis to ensure Zero Errors.

---
**🔄 Zen Status**: Refined
**🐄 Methodology**: Super Mucca ✅
