<?php

declare(strict_types=1);

?>
@props(['events' => [], 'config' => []])

<div
    x-data="calendar({
        events: @js($events),
        config: @js(array_merge([
            'locale' => 'it',
            'firstDay' => 1,
            'businessHours' => [
                'daysOfWeek' => [ 1, 2, 3, 4, 5 ],
                'startTime' => '09:00',
                'endTime' => '18:00',
            ],
            'slotMinTime' => '08:00:00',
            'slotMaxTime' => '20:00:00',
            'slotDuration' => '00:30:00',
            'weekends' => true,
            'editable' => false,
            'selectable' => false,
        ], $config))
    })"
    x-init="init()"
    class="w-full"
>
    <div x-ref="calendar" class="w-full"></div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('calendar', ({ events, config }) => ({
        calendar: null,

        init() {
            this.calendar = new FullCalendar.Calendar(this.$refs.calendar, {
                ...config,
                events: events,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Oggi',
                    month: 'Mese',
                    week: 'Settimana',
                    day: 'Giorno'
                },
                allDayText: 'Tutto il giorno',
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                }
            });

            this.calendar.render();
        }
    }));
});
</script>
@endpush
