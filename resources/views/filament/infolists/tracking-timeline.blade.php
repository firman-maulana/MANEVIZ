@php
    $history = $getRecord()->tracking_history ?? [];
@endphp

@if(!empty($history) && is_array($history))
<div class="space-y-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
    @foreach($history as $index => $item)
    <div class="flex gap-4">
        <!-- Timeline Indicator -->
        <div class="relative flex flex-col items-center">
            <div class="w-3 h-3 rounded-full {{ $index === 0 ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }} z-10"></div>
            @if($index !== count($history) - 1)
            <div class="w-0.5 h-full bg-gray-300 dark:bg-gray-600 absolute top-3"></div>
            @endif
        </div>

        <!-- Content -->
        <div class="flex-1 pb-8 {{ $index === count($history) - 1 ? 'pb-0' : '' }}">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex justify-between items-start mb-2 gap-3">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $item['description'] ?? 'No description' }}
                    </p>
                    @if($index === 0)
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 whitespace-nowrap">
                        Latest
                    </span>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                    @if(!empty($item['date']))
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $item['date'] }}
                    </span>
                    @endif

                    @if(!empty($item['time']))
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $item['time'] }}
                    </span>
                    @endif

                    @if(!empty($item['location']))
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $item['location'] }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-8 text-gray-500 dark:text-gray-400">
    <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    <p class="text-sm">No tracking information available</p>
</div>
@endif
