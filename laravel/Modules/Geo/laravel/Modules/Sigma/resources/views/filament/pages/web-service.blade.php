<x-filament::page>
	<div class="relative overflow-x-auto m-auto">
		<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 align-top " border="1">
			<tr class="align-top">
				<td class="inline-block  align-top" style="border-right:1px solid green;margin-right:10px;" width="40%">
					@foreach($tbls as $tbl)
					<br/><button wire:click="import('{{$tbl}}')">{{$tbl}}</button>
					@endforeach
				</td>
				<td class="inline-block  align-top" style="height: 100%;">
					<div wire:loading>
						<div
							class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
							role="status">
							<span
								class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
								>Loading...</span
								>
						</div>
					</div>
					<div class="align-top">{!! $msg !!}</div>
				</td>
			</tr>
		</table>
	</div>
</x-filament::page>