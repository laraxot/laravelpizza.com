# Telemetry Implementation Spec (Sprint 1 Completion)

## Goal
Rendere affidabili i KPI show-up e UGC con eventi tracciati in modo nativo.

## Required events

1. `event_viewed`
- payload: event_id, user_id/null, source, utm

2. `event_rsvp_created`
- payload: event_id, user_id, channel

3. `event_checkin_completed`
- payload: event_id, user_id, checkin_at

4. `ugc_submitted`
- payload: event_id, user_id, platform, url, created_at

5. `referral_invite_sent`
- payload: event_id, inviter_user_id, channel

6. `referral_rsvp_converted`
- payload: event_id, inviter_user_id, invitee_user_id

## Storage proposal

- table `event_growth_metrics` (fact log append-only)
- table `event_growth_daily_rollups` (aggregates)

## Minimal API/actions

- action `TrackEventMetricAction`
- action `RollupEventMetricsAction`
- read action `GetWeeklyGrowthKpiAction`

## Done criteria

- weekly report can compute show-up and UGC rates from native telemetry data.
