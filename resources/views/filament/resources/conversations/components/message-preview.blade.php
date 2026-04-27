@php
    $role = $get('role');
    $message = $get('message') ?? '...';
    $isUser = $role === 'user';
    $time = $getRecord()?->created_at?->format('H:i') ?? now()->format('H:i');
@endphp

<div class="flex flex-col w-full p-4 bg-[#E5DDD5] rounded-xl border border-gray-200 shadow-inner overflow-hidden font-sans">
    <div @class([
        'relative flex flex-col p-2 px-3 rounded-lg shadow-sm max-w-[90%] break-words min-w-[120px]',
        'bg-white self-start rounded-tl-none text-left' => !$isUser,
        'bg-[#DCF8C6] self-end rounded-tr-none text-left' => $isUser,
    ])>
        {{-- Tail triangle for bubble effect --}}
        @if(!$isUser)
            <div class="absolute top-0 -left-2 w-0 h-0 border-t-[10px] border-t-white border-l-[10px] border-l-transparent"></div>
        @else
            <div class="absolute top-0 -right-2 w-0 h-0 border-t-[10px] border-t-[#DCF8C6] border-r-[10px] border-r-transparent"></div>
        @endif

        <div @class([
            'text-[12.8px] font-medium mb-0.5',
            'text-[#128C7E]' => !$isUser,
            'text-blue-700' => $isUser,
        ])>
            {{ $isUser ? 'Usuario' : 'Sistema' }}
        </div>

        <div class="text-[14.2px] text-[#111b21] leading-[19px] break-words">
            <span>{{ $message }}</span>
            <span @class([
                'float-right ml-2.5 mt-1 text-[11px] font-normal flex items-center gap-0.5',
                'text-[#667781]' => !$isUser,
                'text-gray-600' => $isUser,
            ])>
                {{ $time }}
                @if($isUser)
                    <svg class="w-3.5 h-3.5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                    </svg>
                @endif
            </span>
        </div>
    </div>
</div>
