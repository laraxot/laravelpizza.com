<?php

declare(strict_types=1);

?>
<div
    x-data="{
        selectedDate: $wire.entangle('{{ $getStatePath() }}').defer,
        calendar: @js($getCalendarData()),
        highlightColor: @js($getHighlightColor()),
        showWeekNumbers: @js($showWeekNumbers),
        daysOfWeek: @js($getDaysOfWeek()),
        
        init() {
            // Initialize with selected date if any - no more Livewire listeners needed
            console.log('InlineDatePicker initialized with frontend-only navigation');
        },
        
        selectDate(date) {
            this.selectedDate = date;
            this.$wire.set('{{ $getStatePath() }}', date, false);
            
            // Aggiorna lo stato visuale localmente senza chiamate Livewire
            this.updateSelectedState();
        },
        
        updateSelectedState() {
            // Aggiorna lo stato di selezione in tutto il calendario
            this.calendar.weeks.forEach(week => {
                week.forEach(day => {
                    day.isSelected = this.selectedDate === day.date;
                });
            });
        },
        
        navigateToPreviousMonth() {
            // Navigazione puramente frontend - NESSUNA chiamata Livewire
            this.navigateToMonth('prev');
        },
        
        navigateToNextMonth() {
            // Navigazione puramente frontend - NESSUNA chiamata Livewire  
            this.navigateToMonth('next');
        },
        
        navigateToMonth(direction) {
            // Calcola il nuovo mese
            const currentDate = new Date(this.calendar.year, this.calendar.month - 1, 1);
            
            if (direction === 'prev') {
                currentDate.setMonth(currentDate.getMonth() - 1);
            } else if (direction === 'next') {
                currentDate.setMonth(currentDate.getMonth() + 1);
            }
            
            // Aggiorna il calendario frontend
            this.updateCalendarForMonth(currentDate);
        },
        
        updateCalendarForMonth(date) {
            const year = date.getFullYear();
            const month = date.getMonth() + 1; // JavaScript month is 0-based
            
            // Genera nuovi dati calendario
            this.calendar = this.generateCalendarForMonth(year, month);
        },
        
        generateCalendarForMonth(year, month) {
            const firstDay = new Date(year, month - 1, 1);
            const lastDay = new Date(year, month, 0);
            const startDate = new Date(firstDay);
            
            // Calcola il primo lunedì da visualizzare
            const dayOfWeek = firstDay.getDay();
            const mondayOffset = dayOfWeek === 0 ? 6 : dayOfWeek - 1;
            startDate.setDate(startDate.getDate() - mondayOffset);
            
            const weeks = [];
            const currentDate = new Date(startDate);
            
            // Genera 6 settimane (42 giorni)
            for (let week = 0; week < 6; week++) {
                const days = [];
                for (let day = 0; day < 7; day++) {
                    const dateString = currentDate.toISOString().split('T')[0];
                    const isCurrentMonth = currentDate.getMonth() === month - 1;
                    const isToday = this.isToday(currentDate);
                    const isSelected = this.selectedDate === dateString;
                    
                    days.push({
                        date: dateString,
                        day: currentDate.getDate(),
                        isCurrentMonth: isCurrentMonth,
                        isToday: isToday,
                        isSelected: isSelected,
                        isEnabled: isCurrentMonth // Semplificato per ora
                    });
                    
                    currentDate.setDate(currentDate.getDate() + 1);
                }
                weeks.push(days);
            }
            
            return {
                weeks: weeks,
                month: firstDay.toLocaleDateString('it-IT', { month: 'long' }),
                year: year,
                hasPreviousMonth: true, // Semplificato per ora
                hasNextMonth: true // Semplificato per ora
            };
        },
        
        isToday(date) {
            const today = new Date();
            return date.toDateString() === today.toDateString();
        },
        
        getDayClasses(day) {
            return [
                'relative p-2 text-center rounded-full transition-colors',
                day.isSelected ? 'text-white font-semibold' : 'hover:bg-gray-100',
                day.isEnabled ? 'cursor-pointer' : 'opacity-30 cursor-not-allowed',
                day.isToday && !day.isSelected ? 'font-semibold text-blue-600' : '',
                !day.isCurrentMonth ? 'opacity-40' : '',
                day.isSelected ? `${this.highlightColor} text-white` : '',
            ].join(' ');
        },
        
        getDayAriaLabel(day) {
            const date = new Date(day.date);
            return date.toLocaleDateString('{{ app()->getLocale() }}', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        }
    }"
    class="inline-block w-full max-w-md p-4 bg-white rounded-lg shadow"
>
    <div class="flex items-center justify-between mb-4">
        <button
            type="button"
            x-on:click="navigateToPreviousMonth()"
            x-bind:disabled="!calendar.hasPreviousMonth"
            x-bind:class="{ 'opacity-30 cursor-not-allowed': !calendar.hasPreviousMonth }"
            class="p-1 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            aria-label="{{ __('ui::datepicker.previous_month') }}"
        >
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        
        <h2 class="text-lg font-semibold text-gray-900">
            <span x-text="calendar.month"></span>
            <span x-text="calendar.year" class="ml-1"></span>
        </h2>
        
        <button
            type="button"
            x-on:click="navigateToNextMonth()"
            x-bind:disabled="!calendar.hasNextMonth"
            x-bind:class="{ 'opacity-30 cursor-not-allowed': !calendar.hasNextMonth }"
            class="p-1 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            aria-label="{{ __('ui::datepicker.next_month') }}"
        >
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
    
    <div class="grid grid-cols-7 gap-1 text-xs text-center text-gray-500">
        <template x-for="(day, index) in daysOfWeek" :key="index">
            <div class="py-2 font-medium" x-text="day"></div>
        </template>
    </div>
    
    <div class="grid grid-cols-7 gap-1 mt-1 text-sm">
        <template x-for="(week, weekIndex) in calendar.weeks" :key="weekIndex">
            <template x-for="(day, dayIndex) in week" :key="`${weekIndex}-${dayIndex}`">
                <button
                    type="button"
                    x-on:click="if(day.isEnabled) selectDate(day.date)"
                    x-bind:class="getDayClasses(day)"
                    x-bind:aria-label="getDayAriaLabel(day)"
                    x-bind:aria-selected="day.isSelected"
                    x-bind:aria-disabled="!day.isEnabled"
                    x-bind:disabled="!day.isEnabled"
                >
                    <span x-text="day.day"></span>
                    <span 
                        x-show="day.isToday && !day.isSelected" 
                        class="absolute bottom-0 left-1/2 w-1 h-1 transform -translate-x-1/2 rounded-full bg-blue-600"
                    ></span>
                </button>
            </template>
        </template>
    </div>
    
    @if ($isInline())
        <input
            type="hidden"
            x-model="selectedDate"
            name="{{ $getName() }}"
            id="{{ $getId() }}"
            {{ $applyStateBindingModifiers('defer') }}
        />
    @endif
    
    @if ($hasDescription())
        <p class="mt-2 text-sm text-gray-500">
            {{ $getDescription() }}
        </p>
    @endif
</div>
