{{-- Footer Section v1 - Laravel Pizza Meetups --}}
<footer class="bg-slate-900 border-t border-slate-800">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- About --}}
            <div>
                <h3 class="text-white font-bold mb-4">Laravel Pizza Meetups</h3>
                <p class="text-gray-400 text-sm">
                    La community italiana di Laravel che si incontra davanti ad una pizza per condividere conoscenze e passioni.
                </p>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Links</h4>
                <ul class="space-y-2">
                    <li><a href="/" class="text-gray-400 hover:text-white text-sm transition-colors">Home</a></li>
                    <li><a href="/events" class="text-gray-400 hover:text-white text-sm transition-colors">Eventi</a></li>
                    <li><a href="/dashboard" class="text-gray-400 hover:text-white text-sm transition-colors">Dashboard</a></li>
                </ul>
            </div>

            {{-- Community --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Community</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">GitHub</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Discord</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Twitter</a></li>
                </ul>
            </div>

            {{-- Legal --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Legal</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-800 mt-8 pt-8 text-center">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} Laravel Pizza Meetups. Made with ❤️ and Laravel.
            </p>
        </div>
    </div>
</footer>
