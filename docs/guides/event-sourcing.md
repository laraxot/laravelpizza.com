# event sourcing comprehensive guide

## introduction to event sourcing

event sourcing is an architectural approach where every change to application state is captured in an event object. these events are stored in sequence, representing the complete history of changes, unlike the traditional crud approach where only the final state is saved.

### advantages
- **complete traceability**: every action is recorded as an event, providing detailed audit trail
- **flexibility**: new features can be added by replaying events on new projectors without modifying existing data
- **state reconstruction**: events allow reconstructing past states for debugging or analysis

### challenges
- **complexity**: managing events and projections is more complex than crud
- **performance**: replaying many events can be slow, requiring snapshots
- **versioning**: events must be versioned to handle changes in data structure

## fundamental concepts

### 1. event-oriented design
event-oriented design focuses on modeling around events rather than final state. for example, instead of updating a "balance" field, events like `deposit_made` or `withdrawal_made` are recorded.

### 2. events
events represent something that happened in the system (e.g., `activity_logged`, `user_registered`). they must be specific and contain relevant data.

### 3. aggregate roots
aggregate roots encapsulate business logic for a specific entity, ensuring state consistency. for example, an `activity_aggregate_root` could handle events like `activity_started` and `activity_completed`.

**aggregate root example in laravel**:
```php
namespace modules\activity\aggregates;

class activity_aggregate_root
{
    private $uuid;
    private $activities = [];
    
    public static function start(string $uuid): self
    {
        $aggregate = new self();
        $aggregate->record_that(new activity_started($uuid));
        return $aggregate;
    }
    
    public function log_activity(string $type, array $data)
    {
        $this->record_that(new activity_logged($this->uuid, $type, $data));
    }
    
    protected function apply_activity_started(activity_started $event)
    {
        $this->uuid = $event->uuid;
    }
    
    protected function apply_activity_logged(activity_logged $event)
    {
        $this->activities[] = ['type' => $event->type, 'data' => $event->data];
    }
    
    private function record_that($event)
    {
        // logic to record the event
    }
}
```

### 4. projectors
projectors create read views based on events. for example, a projector can update an `activity_logs` table with activity counts.

**projector example**:
```php
namespace modules\activity\projectors;

class activity_log_projector
{
    public function on_activity_logged(activity_logged $event, string $uuid)
    {
        $log = activity_log::find_or_create($uuid);
        $log->increment('count');
        $log->save();
    }
}
```

## advanced patterns

### 1. state management
use state machines to manage complex transitions. for example, an activity might transition from "started" to "completed" with specific rules.

### 2. cqrs (command query responsibility segregation)
separate write operations (commands) from read operations (queries). commands generate events, while queries read from projected models.

## challenges and solutions

### 1. event versioning
use converters to transform old events into new formats during replay.

### 2. snapshotting
periodically save the current state of an aggregate to reduce the number of events to replay.

## use cases in activity module

1. **user activity logging**:
   - **event**: `user_activity_logged`
   - **description**: records each significant user action (e.g., login, profile update)
   - **projection**: updates a `user_activities` table for quick reports

2. **change monitoring**:
   - **event**: `entity_updated`
   - **description**: records changes to critical entities (e.g., patients, appointments)
   - **projection**: creates historical log for audit

## practical examples

**activity logging**:
```php
$activity_aggregate = activity_aggregate_root::start($user->uuid);
$activity_aggregate->log_activity('login', ['timestamp' => now(), 'ip' => request()->ip()]);
```

**report projection**:
```php
class user_activity_report_projector
{
    public function on_user_activity_logged(user_activity_logged $event, string $uuid)
    {
        $report = user_activity_report::find_or_create($uuid);
        $report->last_login = $event->data['timestamp'];
        $report->save();
    }
}
```

## code improvement recommendations

1. **existing class refactoring**:
   - identify state-handling classes (e.g., `activity_controller`) and transform them into aggregate roots to separate business logic
   - example: move activity registration logic from controller to `activity_aggregate_root`

2. **projector addition**:
   - create projectors for specific read views (e.g., `activity_summary_projector` for dashboards)
   - ensure idempotency in projectors to avoid duplication

3. **snapshot implementation**:
   - for aggregates with many events, implement snapshots to improve performance
   - example: save `activity_aggregate_root` state every 100 events

4. **versioning**:
   - prepare event migration system (e.g., script to convert `activity_logged_v1` to `activity_logged_v2`)

5. **testing**:
   - follow roose's approach, creating test factories for events (e.g., `activity_logged_factory`)
   - test each projector and reactor separately

## conclusion

event sourcing offers a powerful approach to manage complexity in the `activity` module, ensuring traceability and flexibility. by implementing aggregate roots, projectors, and strategies like snapshotting, existing code robustness and scalability can be improved. following the described patterns and recommendations, the module can evolve to support future requirements without compromising data consistency.