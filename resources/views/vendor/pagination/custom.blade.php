@if ($paginator->hasPages())
    <nav class="custom-pagination" style="display: flex; justify-content: center; margin-top: 1rem;">
        <ul style="display: flex; list-style: none; padding: 0; margin: 0; gap: 0.25rem;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" style="opacity: 0.5; cursor: not-allowed;">
                    <span class="page-link" style="padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: 6px; background: var(--surface);">&laquo; Sebelumnya</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: 6px; background: var(--surface); text-decoration: none; color: var(--primary); transition: 0.2s;">&laquo; Sebelumnya</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link" style="padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: 6px; background: var(--surface);">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link" style="padding: 0.5rem 1rem; border: 1px solid var(--primary); border-radius: 6px; background: var(--primary); color: white; font-weight: bold;">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}" style="padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: 6px; background: var(--surface); text-decoration: none; color: var(--text-main); transition: 0.2s;">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: 6px; background: var(--surface); text-decoration: none; color: var(--primary); transition: 0.2s;">Selanjutnya &raquo;</a>
                </li>
            @else
                <li class="page-item disabled" style="opacity: 0.5; cursor: not-allowed;">
                    <span class="page-link" style="padding: 0.5rem 1rem; border: 1px solid var(--border); border-radius: 6px; background: var(--surface);">Selanjutnya &raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
    <style>
        .page-item:not(.disabled):not(.active) .page-link:hover {
            background-color: #F3F4F6 !important;
        }
    </style>
@endif
