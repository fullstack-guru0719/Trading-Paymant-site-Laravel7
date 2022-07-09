<ul class="custom-pagination">
    @if ($paginator->onFirstPage())

    @else
        <li>
            <a href="{{ $paginator->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
        </li>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <li>
                <a href="javascript:void(0)">{{ $element }}</a>
            </li>
        @endif

        @if (is_array($element))
            @if(count($element) < 2)
                @foreach ($element as $page => $url)

                @endforeach
            @else
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <a href="javascript:void(0)" class="active">{{ $page }}</a>
                        </li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
        </li>
    @else
    @endif

</ul>
