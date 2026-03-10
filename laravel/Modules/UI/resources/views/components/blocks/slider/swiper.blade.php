<?php

declare(strict_types=1);

?>
<section class="container p-6 mx-auto">
	<div id="heroslider" x-data="heroslider" class="relative w-full">
		<button type="button" @click="swiper.slidePrev()" class="absolute z-10 grid rounded-full place-items-center start-6 top-[40%] size-10 bg-white/50 hover:bg-white/60">
			<x-heroicon-o-chevron-left class="size-6"/>
		</button>
		<div class="overflow-hidden rounded-xl">
			<div x-ref="swiper" class="swiper [--swiper-pagination-bullet-inactive-color:#c2ced1] [--swiper-pagination-color:#ffffff]">
				<div class="swiper-wrapper">
					@foreach ($_theme->getMethodData($method) as $data)
					<div class="swiper-slide">
						<a href="{{ $data->link }}" class="block">
							<article class="banner h-[400px] relative p-6">
								<div>
									<img src="{{ $data->mobile_thumbnail_webp ?: 'https://placehold.co/900x320' }}" class="absolute inset-0 z-0 object-cover w-full h-full" alt="{{ $data->title }}" title="{{ $data->title }}" />
									<div class="absolute inset-0 z-1 bg-gradient-to-t from-black/80 to-transparent"></div>
								</div>
								<div class="relative z-10 flex flex-col justify-end h-full">
									<div class="px-10 mb-6 space-y-2 text-center">
										<span class="inline-block py-1.5 px-4 font-semibold bg-white/25 backdrop-blur text-white rounded-full text-sm w-max">{{ $data->title }}</span>
										<p class="text-3xl font-bold text-white lg:text-4xl xl:text-5xl">{{ $data->short_description }}</p>
										<button type="button" class="inline-flex items-center justify-center px-4 py-1 space-x-2 font-semibold text-white text-blue-400">
											<span>{{ $data->action_text }}</span>
											<x-heroicon-o-arrow-right class="size-4"/>
										</button>
									</div>
								</div>
							</article>
						</a>
					</div>
					@endforeach
				</div>
				<div class="swiper-pagination"></div>
			</div>
		</div>
		<button type="button" @click="swiper.slideNext()" class="absolute z-10 grid rounded-full place-items-center end-6 top-[40%] size-10 bg-white/50 hover:bg-white/60">
			<x-heroicon-o-chevron-right class="size-6"/>
		</button>
	</div>
</section>
