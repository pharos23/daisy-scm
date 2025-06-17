@if ($paginator->hasPages())
    <nav class="flex justify-center mt-6">
        <div class="join">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button class="join-item btn btn-outline btn-disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    &lsaquo;
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   rel="prev"
                   class="join-item btn btn-outline"
                   aria-label="@lang('pagination.previous')">
                    &lsaquo;
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="join-item btn btn-outline btn-disabled">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="join-item btn btn-primary">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="join-item btn btn-outline">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   rel="next"
                   class="join-item btn btn-outline"
                   aria-label="@lang('pagination.next')">
                    &rsaquo;
                </a>
            @else
                <button class="join-item btn btn-outline btn-disabled"
                        aria-disabled="true"
                        aria-label="@lang('pagination.next')">
                    &rsaquo;
                </button>
            @endif
        </div>
    </nav>
@endif
