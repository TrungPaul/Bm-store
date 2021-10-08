@if ($paginator->hasPages())
    <ul class="pagination pagination-sm m-0 float-right">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><a href="#" class="page-link">&laquo;</a></li>
        @else
            <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">&laquo;</a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><a href="#" class="page-link">{{ $element }}</a></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a href="#" class="page-link">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}"  class="page-link" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><a href="#" class="page-link">&raquo;</a></li>
        @endif
    </ul>
@endif
