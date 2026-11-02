@if ($paginator->hasPages())
<ul class="pg" role="navigation" aria-label="Pagination">
    @if ($paginator->onFirstPage())
        <li class="disabled"><span>&laquo; Sebelumnya</span></li>
    @else
        <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Sebelumnya</a></li>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="disabled"><span>{{ $element }}</span></li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya &raquo;</a></li>
    @else
        <li class="disabled"><span>Berikutnya &raquo;</span></li>
    @endif
</ul>
@endif
