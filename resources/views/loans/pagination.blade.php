@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <div class="d-flex flex-column align-items-center">
            <ul class="pagination mb-2">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">« 上一頁</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">« 上一頁</a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled">
                            <span class="page-link">{{ $element }}</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">下一頁 »</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">下一頁 »</span>
                    </li>
                @endif
            </ul>

            <div class="pagination-info">
                @php
                    $from = $paginator->firstItem();
                    $to = $paginator->lastItem();
                    $total = $paginator->total();
                @endphp
                <span>顯示 {{ $from }} 到 {{ $to }} ，總共 {{ $total }} 筆</span>
            </div>
        </div>
    </nav>
@endif