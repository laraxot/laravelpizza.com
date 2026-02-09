<footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 pt-16 pb-8" role="contentinfo" aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">{{ __('Footer') }}</h2>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            <!-- Brand -->
            <div class="space-y-8 xl:col-span-1">
                <a href="{{ url('/') }}" class="flex items-center space-x-2 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-lg p-1" aria-label="{{ config('app.name') }} - {{ __('Home') }}">
                    <x-filament::icon
                        icon="meetup-logo"
                        class="h-10 w-10 text-red-600"
                    />
                    <span class="text-xl font-bold text-slate-900 dark:text-white">{{ config('app.name') }}</span>
                </a>
                <p class="text-base text-slate-500 dark:text-slate-400 max-w-sm">
                    {{ __('Piattaforma per la gestione delle segnalazioni cittadine.') }}
                    {{ __('Miglioriamo insieme la nostra città.') }}
                </p>
                <div class="flex space-x-6">
                    <!-- Social Links -->
                    @php
                        $socials = [
                            ['name' => 'Facebook', 'url' => 'https://facebook.com/fixcity', 'path' => 'M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z'],
                            ['name' => 'Twitter', 'url' => 'https://twitter.com/fixcity', 'path' => 'M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84'],
                            ['name' => 'Instagram', 'url' => 'https://instagram.com/fixcity', 'path' => 'M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.451 4.63c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z'],
                            ['name' => 'LinkedIn', 'url' => 'https://linkedin.com/company/fixcity', 'path' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z']
                        ];
                    @endphp

                    @foreach($socials as $social)
                        <a href="{{ $social['url'] }}" 
                           class="text-slate-400 hover:text-slate-500 dark:hover:text-slate-300 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-lg p-1"
                           target="_blank" 
                           rel="noopener noreferrer"
                           aria-label="{{ $social['name'] }} - {{ __('Apre in nuova finestra') }}">
                            <span class="sr-only">{{ $social['name'] }}</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="{{ $social['path'] }}" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-400 tracking-wider uppercase">
                            {{ __('Link Utili') }}
                        </h3>
                        <ul role="list" class="mt-4 space-y-4">
                            @foreach(['Amministrazione Trasparente', 'Privacy Policy', 'Note Legali', 'Cookie Policy', 'Dichiarazione di Accessibilità', 'Mappa del Sito'] as $link)
                                <li>
                                    <a href="#" class="text-base text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white focus:outline-none focus:text-red-600 dark:focus:text-red-400 focus:underline">
                                        {{ __($link) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-12 md:mt-0">
                        <h3 class="text-sm font-semibold text-slate-400 tracking-wider uppercase">
                            {{ __('Contatti') }}
                        </h3>
                        <ul role="list" class="mt-4 space-y-4">
                           <li>
                                <p class="text-base text-slate-500 dark:text-slate-400">
                                    Via Example, 123<br>
                                    00100 Roma (RM)
                                </p>
                           </li>
                           <li>
                                <a href="mailto:info@fixcity.it" class="text-base text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white focus:outline-none focus:text-red-600 dark:focus:text-red-400">
                                    info@fixcity.it
                                </a>
                           </li>
                           <li>
                                <a href="tel:+390612345678" class="text-base text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white focus:outline-none focus:text-red-600 dark:focus:text-red-400">
                                    +39 06 1234 5678
                                </a>
                           </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-12 border-t border-slate-200 dark:border-slate-800 pt-8">
            <p class="text-base text-slate-400 xl:text-center">
                &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('Tutti i diritti riservati.') }}
            </p>
        </div>
    </div>
</footer>
