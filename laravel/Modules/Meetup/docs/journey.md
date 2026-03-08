# Meetup Journey: Super Mucca Edition

This document tracks the implementation of the core user journey for meetups.

## 1. Event Proposal & Approval
- [x] Add \`pending\` status to \`Event\` model.
- [x] Implement \`scopeVisibleTo(?User \$user)\` for privacy during approval.
- [ ] Add "Propose Meetup" form for users.
- [ ] Add "Approve" action in Filament \`EventResource\`.
- [ ] Implement notifications for staff upon new proposal.

## 2. GDPR-Compliant Registration
- [ ] Integrate \`Gdpr\` module treatments into \`RegisterComponent\`.
- [ ] Validation of mandatory consents.
- [ ] Persistence of optional choices.

## 3. User Profile
- [ ] Profile edit page.
- [ ] Privacy settings (GDPR update).
- [ ] Password change with security validation.

## 4. RSVP & Community
- [x] Backend RSVP actions (\`RegisterAttendeeToEventAction\`).
- [ ] Real-time attendee counter on frontend.
- [ ] Public comments on approved meetups.

## Progress Log
- **2026-03-08**: Initialized journey. Consolidated modules. Fixed \`BaseUser\` conflicts. Implemented \`Feedback\` model and \`CreateFeedbackAction\`.
- **2026-03-08**: Added \`scopeVisibleTo\` and \`scopePublished\` to \`Event\` model. Verified with Pest tests.
