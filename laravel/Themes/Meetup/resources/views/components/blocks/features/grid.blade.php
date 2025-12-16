@props(['data'])

{{-- Features Section - Laravel Pizza Meetups Style --}}
<section class="py-20 bg-slate-800/30">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $data['title'] ?? 'Why Join Our Community?' }}</h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                {{ $data['description'] ?? 'More than just pizza - it\'s about building lasting connections with developers who share your passion' }}
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($data['features'] ?? [] as $feature)
                <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-xl p-8 hover:border-red-500/50 transition-colors">
                    <div class="bg-red-500/10 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        @php
                            $iconName = $feature['icon'] ?? 'heroicon-o-check';
                            // Map icon names to SVG paths
                            $iconMap = [
                                'heroicon-o-calendar' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                'heroicon-o-users' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                                'heroicon-o-map-pin' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                                'heroicon-o-chat-bubble-left-right' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
                            ];
                            $iconPath = $iconMap[$iconName] ?? $iconMap['heroicon-o-check'];
                        @endphp
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ $feature['title'] ?? 'Feature Title' }}</h3>
                    <p class="text-gray-400">{{ $feature['description'] ?? 'Feature description' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
