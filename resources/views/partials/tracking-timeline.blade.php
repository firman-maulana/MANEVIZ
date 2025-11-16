<div style="position: relative;">
    @foreach($history as $index => $item)
    <div style="display: flex; gap: 16px; margin-bottom: {{ $index === count($history) - 1 ? '0' : '24px' }};">
        <!-- Timeline Dot & Line -->
        <div style="position: relative; display: flex; flex-direction: column; align-items: center;">
            <div style="width: 16px; height: 16px; border-radius: 50%; background: {{ $index === 0 ? '#10b981' : '#cbd5e1' }}; z-index: 10;"></div>
            @if($index !== count($history) - 1)
            <div style="width: 2px; height: 100%; background: #cbd5e1; position: absolute; top: 16px;"></div>
            @endif
        </div>

        <!-- Content -->
        <div style="flex: 1; padding-bottom: {{ $index === count($history) - 1 ? '0' : '8px' }};">
            <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px; gap: 12px;">
                    <p style="font-weight: 600; color: #1e293b; font-size: 14px; line-height: 1.4; flex: 1;">
                        {{ $item['description'] ?? 'No description' }}
                    </p>
                    @if($index === 0)
                    <span style="background: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; white-space: nowrap;">
                        LATEST
                    </span>
                    @endif
                </div>

                <div style="display: flex; gap: 16px; flex-wrap: wrap; font-size: 12px; color: #64748b;">
                    @if(!empty($item['date']))
                    <span style="display: flex; align-items: center; gap: 4px;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $item['date'] }}
                    </span>
                    @endif

                    @if(!empty($item['time']))
                    <span style="display: flex; align-items: center; gap: 4px;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $item['time'] }}
                    </span>
                    @endif

                    @if(!empty($item['location']))
                    <span style="display: flex; align-items: center; gap: 4px;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
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
