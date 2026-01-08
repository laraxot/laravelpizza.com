<div>
	<button data-dropdown-toggle="dropdown-language" class="grid py-3 text-sm font-semibold transition rounded-lg place-items-center">
		<div class="flex items-center space-x-1">
			<x-heroicon-o-language class="size-5"/>
			<span class="hidden sm:block">English</span>
			<x-heroicon-o-chevron-down class="hidden size-4 sm:block"/>
		</div>
	</button>
	<div id="dropdown-language" class="absolute z-[45] hidden p-2 overflow-hidden text-sm border border-white rounded-lg bg-gray-50/85 backdrop-blur w-[240px] max-w-sm">
		<ul>
			<li>
				<button class="flex items-center w-full px-2 py-3 space-x-2 transition rounded hover:bg-white">
					<svg xmlns="http://www.w3.org/2000/svg" class="size-5" id="flag-icons-us" viewBox="0 0 640 480">
						<path fill="#bd3d44" d="M0 0h640v480H0"/> <path stroke="#fff" stroke-width="37" d="M0 55.3h640M0 129h640M0 203h640M0 277h640M0 351h640M0 425h640"/> <path fill="#192f5d" d="M0 0h364.8v258.5H0"/> <marker id="us-a" markerHeight="30" markerWidth="30"> <path fill="#fff" d="m14 0 9 27L0 10h28L5 27z"/> </marker> <path fill="none" marker-mid="url(#us-a)" d="m0 0 16 11h61 61 61 61 60L47 37h61 61 60 61L16 63h61 61 61 61 60L47 89h61 61 60 61L16 115h61 61 61 61 60L47 141h61 61 60 61L16 166h61 61 61 61 60L47 192h61 61 60 61L16 218h61 61 61 61 60z"/>
					</svg>
					<div>English</div>
				</button>
			</li>
			<li>
				<button class="flex items-center w-full px-2 py-3 space-x-2 transition rounded hover:bg-white">
					<svg xmlns="http://www.w3.org/2000/svg" class="size-5" id="flag-icons-it" viewBox="0 0 640 480">
						<g fill-rule="evenodd" stroke-width="1pt"> <path fill="#fff" d="M0 0h640v480H0z"/> <path fill="#009246" d="M0 0h213.3v480H0z"/> <path fill="#ce2b37" d="M426.7 0H640v480H426.7z"/> </g>
					</svg>

					<div>Italiano</div>
				</button>
			</li>
		</ul>
	</div>
</div>
