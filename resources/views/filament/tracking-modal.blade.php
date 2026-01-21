<div class="p-6">
    @if($order->tracking_history && count($order->tracking_history) > 0)
        <div class="space-y-4">
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Courier</p>
                        <p class="text-lg font-semibold">{{ strtoupper($order->courier_code) }} - {{ $order->courier_service }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Waybill Number</p>
                        <p class="text-lg font-semibold">{{ $order->waybill_number }}</p>
                    </div>
                </div>

                @if($order->last_tracking_update)
                <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Last updated: {{ $order->last_tracking_update->format('d M Y H:i') }}
                    </p>
                </div>
                @endif
            </div>

            <div class="relative">
                @foreach($order->tracking_history as $index => $history)
                <div class="flex gap-4 pb-8 {{ $index === count($order->tracking_history) - 1 ? 'pb-0' : '' }}">
                    <div class="relative flex flex-col items-center">
                        <div class="w-4 h-4 rounded-full {{ $index === 0 ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }} z-10"></div>
                        @if($index !== count($order->tracking_history) - 1)
                        <div class="w-0.5 h-full bg-gray-300 dark:bg-gray-600 absolute top-4"></div>
                        @endif
                    </div>

                    <div class="flex-1 {{ $index === 0 ? 'pb-2' : 'pb-0' }}">
                        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <div class="flex justify-between items-start mb-2">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $history['description'] ?? 'No description' }}
                                </p>
                                @if($index === 0)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Latest
                                </span>
                                @endif
                            </div>

                            <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                @if(!empty($history['date']))
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $history['date'] }}
                                </span>
                                @endif

                                @if(!empty($history['time']))
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $history['time'] }}
                                </span>
                                @endif

                                @if(!empty($history['location']))
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $history['location'] }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No tracking data</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Tracking information is not available yet. Please sync the tracking to get the latest updates.
            </p>
        </div>
    @endif
</div>
