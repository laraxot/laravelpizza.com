# 🧠 Schema.org Model Enhancement Analysis

## Observation
The current models in `User` and other modules are functional but could reach a higher level of "Semantic Zen" by aligning more closely with Schema.org.

## Proposed Enhancements

### 1. Model: `User` / `Profile` -> [Schema.org/Person](https://schema.org/Person)
**Missing Fields/Logic:**
- `honorificPrefix` / `honorificSuffix`: For professional titles (Dr., Eng., etc.).
- `jobTitle`: Essential for business context.
- `knowsLanguage`: More semantic than just a `lang` code.
- `gender`: For better CRM segmentation.
- `birthDate`: For age-related logic/verifications.
- `url`: Personal website or LinkedIn profile.

### 2. Model: `BaseTeam` -> [Schema.org/Organization](https://schema.org/Organization)
**Missing Fields/Logic:**
- `legalName`: Official name of the entity.
- `taxID` / `vatID`: Critical for Italy (Codice Fiscale / Partita IVA).
- `telephone`: Official contact for the organization.
- `logo`: [ImageObject](https://schema.org/ImageObject) link.
- `address`: [PostalAddress](https://schema.org/PostalAddress) relation.

### 3. Proposed New Models (The "Missing Links")

#### **[ContactPoint](https://schema.org/ContactPoint)**
A separate model for managing multiple contact methods (Technical support, Billing, Sales) instead of just having one email/phone on the Organization/Person.

#### **[PostalAddress](https://schema.org/PostalAddress)**
We have `AddressSection` in Filament, but a dedicated `Address` model (already partly present in `Geo` module maybe?) that strictly follows Schema.org properties (`streetAddress`, `addressLocality`, `addressRegion`, `postalCode`, `addressCountry`) is superior.

## The "Super Mucca" Rationale
By aligning with Schema.org, we don't just "add fields"; we enable the application to "speak the language of the web". This makes the data more robust, interoperable, and ready for advanced integrations (AI, SEO, external APIs).

---
**🔄 Zen Status**: Expanding
**🐄 Methodology**: Super Mucca ✅
