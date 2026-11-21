---
title: "zen of reuse"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "zen of reuse"
issues: []
discussions: []
---

# 🧘 The Zen of Reuse (Filament Components)

## 🕉️ Philosophy: Centralized Composition
In the religion of Laraxot, simplicity (KISS) and avoidance of repetition (DRY) are achieved through **Centralized Composition**. Instead of defining form fields inline, we create specialized, reusable components that encapsulate both the layout and the data logic.

## 🛠️ The Religious Pattern
When a form field is used in multiple places (or even just once but has complex logic), it should be promoted to a **First-Class Component** in `Modules/Notify/app/Filament/Forms/Components`.

### 📿 Component: MailTemplateSelect
Encapsulates the logic for selecting a `MailTemplate`. It knows how to fetch the templates, order them, and format the labels.

### 📿 Component: ChannelCheckboxList
Encapsulates the choices for notification channels. It knows about `ChannelEnum`, how to format enum labels, and the preferred layout (e.g., 3 columns).

## 📈 Reasons for This Strategy
1. **DRY**: Logic for "Notification Channels" is defined in exactly one place. If a new channel is added, we update the component, not every action.
2. **KISS**: The `SendRecordsNotificationBulkAction` becomes thinner and easier to read.
3. **Robustness**: Typing and validation logic are centralized.
4. **Maintenance**: Easier to test and update.

## 🐄 Mu-uu! Clean Code!
By moving towards a component-based architecture, we achieve a higher state of modularity and maintainability.
