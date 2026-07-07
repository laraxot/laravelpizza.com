# User Flow: [Flow Name]

**Project:** [Project Name]
**Date:** [YYYY-MM-DD]
**Designer:** [Designer Name]

---

## Flow Overview

**Flow Name:** [Name of the flow - e.g., "User Registration", "Checkout Process"]

**Goal:** [What the user wants to accomplish - e.g., "Create an account to access premium features"]

**User Persona:** [Primary persona this flow is designed for]

**Entry Points:**
- [Entry point 1 - e.g., "Homepage 'Sign Up' button"]
- [Entry point 2 - e.g., "Prompted when trying to access gated content"]
- [Entry point 3 - e.g., "Direct link from marketing email"]

**Success Criteria:** [How we know the flow completed successfully - e.g., "User has verified email and can access dashboard"]

**Estimated Time:** [Expected time to complete - e.g., "2-3 minutes"]

---

## Flow Diagram

### Happy Path (Success Flow)

```
[Start: Landing Page]
         |
         v
[User Action: Click "Sign Up" button]
         |
         v
[Screen: Registration Form]
  • Email input
  • Password input
  • First name input
  • Last name input
  • Terms checkbox
         |
         v
[User Action: Fill form and click "Create Account"]
         |
         v
[System: Validate input]
         |
         v
[Screen: Email Verification]
  • "Check your email" message
  • Email address shown
  • "Didn't receive email?" link
         |
         v
[External: User checks email inbox]
         |
         v
[User Action: Click verification link in email]
         |
         v
[Screen: Success Page]
  • "Account verified!" message
  • Welcome text
  • "Continue to Dashboard" button
         |
         v
[End: Dashboard]
```

---

## Alternate Paths & Decision Points

### Path 1: Email Already Exists

```
[Registration Form]
         |
         v
[User submits form]
         |
         v
[System checks: Email exists?]
         |
        Yes
         |
         v
[Error State: Email in use]
  • Error message: "This email is already registered"
  • Link: "Log in instead?"
  • Option: "Use different email"
         |
    User choice?
         |
    [Log in]  or  [Different email]
         |              |
         v              v
   [Login Flow]   [Back to form]
```

---

### Path 2: Invalid Input

```
[Registration Form]
         |
         v
[User submits form]
         |
         v
[System validates input]
         |
    Invalid?
         |
        Yes
         |
         v
[Error State: Validation failed]
  • Highlight invalid fields (red border)
  • Show specific error messages:
    - "Email format is invalid"
    - "Password must be 8+ characters"
    - "You must accept the terms"
         |
         v
[User corrects errors]
         |
         v
[Back to form validation]
```

---

### Path 3: Verification Email Not Received

```
[Email Verification Screen]
         |
         v
[User waits for email]
         |
    Email received?
         |
        No
         |
         v
[User Action: Click "Resend email"]
         |
         v
[System: Send new verification email]
         |
         v
[Confirmation: "Email sent again"]
         |
         v
[User checks email]
         |
         v
[Continue to verification]
```

---

### Path 4: Verification Link Expired

```
[User clicks verification link]
         |
         v
[System checks: Link valid?]
         |
        No (expired)
         |
         v
[Error Page: Link expired]
  • Message: "This link has expired"
  • Explanation: "Links expire after 24 hours"
  • Button: "Request new verification email"
         |
         v
[User clicks button]
         |
         v
[System: Send new email]
         |
         v
[Back to verification flow]
```

---

### Path 5: Network Error

```
[Any step with network request]
         |
         v
[System makes request]
         |
    Network error?
         |
        Yes
         |
         v
[Error State: Connection failed]
  • Message: "Connection error. Please try again."
  • Icon: Warning/error icon
  • Button: "Retry"
  • Button: "Cancel"
         |
    User choice?
         |
   [Retry]  or  [Cancel]
         |             |
         v             v
  [Retry request]  [Back to previous screen]
```

---

## Complete Flow Map

### All Paths Combined

```
                    [Landing Page]
                          |
                          v
                   [Click Sign Up]
                          |
                          v
                 [Registration Form]
                          |
                          v
                  [Submit Form]
                          |
            +-------------+-------------+
            |             |             |
         Valid?        Email         Other
                      exists?        error?
            |             |             |
           Yes           Yes           Yes
            |             |             |
            v             v             v
    [Send email]    [Show error]  [Show error]
            |       [Log in link]  [Corrections]
            |             |             |
            +-------------+-------------+
                          |
                          v
              [Email Verification Screen]
                          |
            +-------------+-------------+
            |                           |
     [Check email]              [Didn't receive?]
            |                           |
            v                           v
    [Click link]                  [Resend email]
            |                           |
      Link valid?                       |
            |                           |
    +-------+-------+                   |
    |               |                   |
   Yes             No                   |
    |               |                   |
    v               v                   |
[Success]    [Link expired]             |
    |               |                   |
    |       [Request new link] ---------+
    |
    v
[Dashboard]
```

---

## Screen Details

### Screen 1: Registration Form

**Purpose:** Collect user information to create account

**Components:**
- Form with 5 fields (email, password, first name, last name, terms)
- Primary button: "Create Account"
- Link: "Already have an account? Log in"

**Validation:**
- Email: Valid format, not empty
- Password: 8+ characters, includes number and letter
- First/Last name: Not empty, 2+ characters
- Terms: Must be checked

**Error Messages:**
- Email: "Please enter a valid email address"
- Password: "Password must be at least 8 characters with letters and numbers"
- Names: "Please enter your [first/last] name"
- Terms: "You must accept the terms of service to continue"

**Accessibility:**
- All inputs have labels
- Error messages use role="alert"
- Focus moves to first error on submit
- Clear focus indicators

---

### Screen 2: Email Verification

**Purpose:** Inform user to check email and provide resend option

**Components:**
- Heading: "Check your email"
- Message: "We sent a verification link to [email]"
- Icon: Email illustration
- Link: "Didn't receive the email? Send again"
- Secondary text: "Check spam folder"

**Behaviors:**
- Show user's email address
- Resend button has 60-second cooldown
- Automatically check if email verified (polling every 5s)

**Accessibility:**
- Clear headings
- Email address announced by screen readers
- Success message announced when verified

---

### Screen 3: Success Page

**Purpose:** Confirm successful verification and guide to next step

**Components:**
- Heading: "Account verified!"
- Success icon (checkmark)
- Welcome message
- Primary button: "Continue to Dashboard"

**Behaviors:**
- Auto-redirect after 3 seconds (with option to cancel)
- Show countdown timer

**Accessibility:**
- Success announced to screen readers
- Clear focus on continue button
- Skip countdown option

---

## Error States

### Error 1: Invalid Email Format

**Trigger:** Email doesn't match valid pattern

**Display:**
- Red border on email input
- Error icon next to input
- Error message below: "Please enter a valid email address"
- Example shown: "example@domain.com"

**Recovery:** User corrects email format

---

### Error 2: Password Too Weak

**Trigger:** Password less than 8 characters or missing requirements

**Display:**
- Red border on password input
- Checklist of requirements (with X or ✓):
  - At least 8 characters
  - Includes letters and numbers
  - Includes uppercase and lowercase

**Recovery:** User strengthens password

---

### Error 3: Email Already Registered

**Trigger:** Email exists in database

**Display:**
- Alert banner at top of form (yellow/warning)
- Message: "This email is already registered"
- Link: "Log in instead"
- Alternative: "Use a different email"

**Recovery:** User logs in or uses different email

---

### Error 4: Terms Not Accepted

**Trigger:** User submits without checking terms checkbox

**Display:**
- Red border around checkbox
- Error message: "You must accept the terms of service to continue"
- Focus moves to checkbox

**Recovery:** User checks the checkbox

---

### Error 5: Network/Server Error

**Trigger:** API request fails

**Display:**
- Modal overlay or banner
- Error icon
- Message: "Something went wrong. Please try again."
- Technical details (collapsed, for debugging)
- Buttons: "Retry" and "Cancel"

**Recovery:** User retries or cancels

---

### Error 6: Verification Link Expired

**Trigger:** User clicks link after 24 hours

**Display:**
- Full-page error state
- Warning icon
- Heading: "This link has expired"
- Message: "Verification links are valid for 24 hours"
- Button: "Request new verification email"

**Recovery:** User requests new link

---

## Loading States

### State 1: Form Submission

**Display:**
- Submit button shows spinner
- Button text: "Creating account..."
- Button disabled
- Form disabled (can't edit)

**Duration:** 1-3 seconds typically

---

### State 2: Sending Verification Email

**Display:**
- Loading spinner overlay
- Text: "Sending verification email..."

**Duration:** 1-2 seconds

---

### State 3: Verifying Link

**Display:**
- Full-page spinner
- Text: "Verifying your account..."

**Duration:** 1-2 seconds

---

## Edge Cases

### Edge Case 1: User Already Logged In

**Scenario:** Logged-in user navigates to registration page

**Behavior:** Redirect immediately to dashboard with message: "You're already logged in"

---

### Edge Case 2: Multiple Browser Tabs

**Scenario:** User opens verification link in different tab while waiting

**Behavior:**
- Original tab detects verification (polling)
- Shows success message
- Redirects to dashboard

---

### Edge Case 3: Third-Party Email Clients

**Scenario:** Email client modifies verification link

**Behavior:**
- Show clear error if link malformed
- Provide manual code entry option as fallback

---

### Edge Case 4: Spam Folder

**Scenario:** Email goes to spam

**Behavior:**
- Verification screen mentions checking spam
- Resend option available after 60 seconds
- Option to change email if persistently failing

---

### Edge Case 5: Browser Back Button

**Scenario:** User clicks back after submitting form

**Behavior:**
- Show confirmation: "Are you sure you want to leave? Your registration is in progress"
- If confirmed, return to form (data preserved if possible)

---

## Success Metrics

**Completion Rate:**
- Target: >80% of users who start complete the flow
- Measure: Users who reach dashboard / Users who click sign up

**Time to Complete:**
- Target: <3 minutes average
- Measure: Time from start to verified dashboard

**Error Rate:**
- Target: <20% of submissions have errors
- Measure: Forms with validation errors / Total submissions

**Drop-off Points:**
- Monitor: Where users abandon the flow
- Common: Registration form, email verification waiting

**Support Tickets:**
- Target: <5% of users need help
- Measure: Support requests related to registration / Total registrations

---

## Testing Checklist

**Happy Path:**
- [ ] Complete registration with valid data
- [ ] Receive email within 1 minute
- [ ] Click verification link successfully
- [ ] Arrive at dashboard as new user

**Error Paths:**
- [ ] Submit with invalid email
- [ ] Submit with weak password
- [ ] Submit without accepting terms
- [ ] Try to register with existing email
- [ ] Test resend email function
- [ ] Test expired verification link
- [ ] Test malformed verification link
- [ ] Test network error handling

**Edge Cases:**
- [ ] Registration while logged in
- [ ] Multiple tabs during verification
- [ ] Browser back button behavior
- [ ] Form data persistence on errors
- [ ] Email in spam folder

**Accessibility:**
- [ ] Complete with keyboard only
- [ ] Complete with screen reader
- [ ] All errors announced properly
- [ ] Focus management correct
- [ ] Color contrast sufficient

**Devices:**
- [ ] Mobile (portrait)
- [ ] Mobile (landscape)
- [ ] Tablet
- [ ] Desktop

---

## Technical Requirements

**Frontend:**
- Form validation (client-side)
- Email format validation (regex)
- Password strength indicator
- Error message display
- Loading states
- Success states
- Focus management

**Backend:**
- User creation endpoint
- Email uniqueness check
- Password hashing
- Email sending service
- Verification token generation
- Token validation endpoint
- Token expiration (24 hours)

**Email:**
- Verification email template
- Clear subject line
- Prominent verification button/link
- Plain text alternative
- Company branding

---

## Notes & Considerations

**Security:**
- Passwords must be hashed (bcrypt/argon2)
- Verification tokens must be cryptographically secure
- Rate limiting on registration attempts
- CAPTCHA if spam becomes issue

**Privacy:**
- Clear privacy policy link
- Explain how data will be used
- GDPR/CCPA compliance if applicable
- Option to delete account later

**UX Improvements:**
- Social login options (Google, GitHub, etc.)
- Password strength meter (visual)
- Show password toggle
- "Remember me" option (if applicable)
- Welcome email after verification

**Localization:**
- All text should be translatable
- Date/time formats locale-appropriate
- Email in user's language

---

**Related Flows:**
- [Login Flow]
- [Password Reset Flow]
- [Profile Setup Flow]

**Dependencies:**
- Email service configured
- User database schema
- Authentication system

**Last Updated:** [Date]
