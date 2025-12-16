<x-filament-panels::page>
    <div class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
            {{ $this->calendar }}
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Stats cards -->
            <div class="bg-white rounded-xl shadow p-4">
                <div class="text-2xl font-bold text-pizza-red">{{ \Modules\Meetup\Models\Event::count() }}</div>
                <div class="text-gray-500">Total Events</div>
            </div>
            
            <div class="bg-white rounded-xl shadow p-4">
                <div class="text-2xl font-bold text-pizza-gold">{{ \Modules\Meetup\Models\Event::where('status', 'published')->count() }}</div>
                <div class="text-gray-500">Published Events</div>
            </div>
            
            <div class="bg-white rounded-xl shadow p-4">
                <div class="text-2xl font-bold text-green-500">{{ \Modules\Meetup\Models\Event::where('start_date', '>', now())->count() }}</div>
                <div class="text-gray-500">Upcoming Events</div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="text-lg font-medium mb-4">Recent Events</h3>
            <div class="space-y-2">
                @foreach(\Modules\Meetup\Models\Event::latest()->limit(5)->get() as $event)
                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <div class="font-medium">{{ $event->title }}</div>
                            <div class="text-sm text-gray-500">{{ $event->start_date->format('M d, Y H:i') }} - {{ $event->location }}</div>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($event->status === 'published') bg-green-100 text-green-800 
                            @elseif($event->status === 'draft') bg-yellow-100 text-yellow-800 
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-filament-panels::page>