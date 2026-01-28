@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center mt-8 animate-fade-in-up delay-200">
        {{-- The "Bubble Bar" Container --}}
        <div class="flex items-center gap-1 bg-brand-white/10 backdrop-blur-md border border-brand-white/20 p-2 rounded-full shadow-xl">
            
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="flex items-center justify-center w-10 h-10 rounded-full text-brand-light/30 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-full text-brand-light hover:bg-brand-white/20 hover:text-brand-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-2 text-brand-light/50 font-bold text-sm">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- Active Bubble --}}
                            <span aria-current="page">
                                <span class="flex items-center justify-center w-10 h-10 rounded-full bg-brand-medium text-brand-dark font-extrabold shadow-lg scale-110">
                                    {{ $page }}
                                </span>
                            </span>
                        @else
                            {{-- Inactive Bubble --}}
                            <a href="{{ $url }}" class="flex items-center justify-center w-10 h-10 rounded-full text-brand-white font-bold hover:bg-brand-white/20 hover:scale-105 transition-all duration-300">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-full text-brand-light hover:bg-brand-white/20 hover:text-brand-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <span class="flex items-center justify-center w-10 h-10 rounded-full text-brand-light/30 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif