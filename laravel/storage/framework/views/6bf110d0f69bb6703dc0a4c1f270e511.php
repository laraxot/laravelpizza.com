<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;

?>

<div class="min-h-screen bg-slate-50 dark:bg-slate-900 overflow-x-hidden relative">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event): ?>

        
        <div class="relative bg-slate-900 h-[400px] md:h-[500px] z-0">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->cover_image): ?>
                <img
                    src="<?php echo e($event->cover_image); ?>"
                    alt="<?php echo e($event->title); ?>"
                    class="w-full h-full object-cover opacity-70"
                />
            <?php else: ?>
                <div class="w-full h-full bg-gradient-to-br from-red-600 via-red-700 to-slate-900 flex items-center justify-center">
                    <svg class="w-32 h-32 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent flex items-end">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
                    <a href="<?php echo e($eventsUrl); ?>"
                       class="inline-flex items-center text-white/80 hover:text-white mb-4 transition-colors focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 rounded">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <?php echo e(__('pub_theme::event.back_to_events.label')); ?>

                    </a>

                    <span class="inline-block <?php echo e($badgeClass); ?> text-white px-4 py-1 rounded-full text-sm font-semibold mb-4">
                        <?php echo e($statusLabel); ?>

                    </span>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white"><?php echo e($event->title); ?></h1>
                </div>
            </div>
        </div>

        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div
                class="grid lg:grid-cols-3 gap-8"
                x-data="{ showBooking: false, showShare: false, name: '', email: '' }">

                
                <div class="lg:col-span-2 space-y-8">

                    
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                        <div class="grid md:grid-cols-3 gap-6">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Date</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white"><?php echo e($dateLabel); ?></p>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($timeLabel): ?>
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Time</p>
                                    <p class="text-base font-semibold text-slate-900 dark:text-white"><?php echo e($timeLabel); ?></p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div>
                                <p class="text-sm font-medium text-slate-500">Location</p>
                                <p class="text-base font-semibold text-slate-900 dark:text-white"><?php echo e($event->location ?? 'TBA'); ?></p>
                            </div>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->description): ?>
                        <section class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-8 border border-slate-200 dark:border-slate-700">
                            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">About</h2>
                            <div class="prose dark:prose-invert max-w-none"><?php echo nl2br(e($event->description)); ?></div>
                        </section>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>

                
                <div class="lg:col-span-1 space-y-4">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isUpcoming): ?>
                        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-slate-200 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Join Event</h3>
                            <p class="text-4xl font-bold text-red-600 mb-1"><?php echo e($availableSpots); ?></p>
                            <p class="text-sm text-slate-500 mb-4">spots left</p>
                            <button
                                @click="showBooking = true"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition-colors focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2">
                                Book Now
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                        <button
                            @click="showShare = true"
                            class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2 rounded-lg transition-colors focus-visible:ring-2 focus-visible:ring-sky-400 focus-visible:ring-offset-2">
                            Share Event
                        </button>
                    </div>

                    
                    <div
                        x-show="showBooking"
                        x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                        @keydown.escape.window="showBooking = false"
                        role="dialog"
                        aria-modal="true"
                        aria-label="Book your spot">
                        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4 shadow-xl">
                            <h3 class="text-lg font-bold mb-4">Book Your Spot</h3>
                            <input
                                x-model="name"
                                type="text"
                                placeholder="Your name"
                                class="w-full mb-3 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" />
                            <input
                                x-model="email"
                                type="email"
                                placeholder="Your email"
                                class="w-full mb-4 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" />
                            <div class="flex gap-2">
                                <button
                                    @click="showBooking = false"
                                    class="flex-1 bg-red-600 text-white py-2 rounded hover:bg-red-700 transition-colors">
                                    Confirm
                                </button>
                                <button
                                    @click="showBooking = false"
                                    class="flex-1 bg-gray-200 text-gray-700 py-2 rounded hover:bg-gray-300 transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>

                    
                    <div
                        x-show="showShare"
                        x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                        @keydown.escape.window="showShare = false"
                        role="dialog"
                        aria-modal="true"
                        aria-label="Share event">
                        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4 shadow-xl">
                            <h3 class="text-lg font-bold mb-4">Share This Event</h3>
                            <input
                                type="text"
                                value="<?php echo e($shareUrl); ?>"
                                readonly
                                class="w-full border rounded px-3 py-2 bg-gray-50 text-sm mb-4" />
                            <button
                                @click="showShare = false"
                                class="w-full bg-gray-200 text-gray-700 py-2 rounded hover:bg-gray-300 transition-colors">
                                Close
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    <?php else: ?>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
            <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-4">Event not found</h1>
            <a href="<?php echo e($eventsUrl); ?>"
               class="inline-block mt-4 bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-3 rounded-lg transition-colors">
                Back to Events
            </a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div><?php /**PATH /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/resources/views/components/blocks/events/detail.blade.php ENDPATH**/ ?>