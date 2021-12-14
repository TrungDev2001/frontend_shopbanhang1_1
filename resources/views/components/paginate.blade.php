@if ($products->hasPages())
    <ul class="pagination pagination">
        {{-- Previous Page Link --}}
        @if ($products->onFirstPage())
            <li class="disabled"><span>«</span></li>
        @else
            <li><a class="paginate_url_item" data-url="{{ $products->previousPageUrl() }}" rel="prev">«</a></li>
        @endif

        @if($products->currentPage() > 3)
            <li class="hidden-xs"><a class="paginate_url_item" data-url="{{ $products->url(1) }}">1</a></li>
        @endif
        @if($products->currentPage() > 4)
            <li><span>...</span></li>
        @endif
        @foreach(range(1, $products->lastPage()) as $i)
            @if($i >= $products->currentPage() - 2 && $i <= $products->currentPage() + 2)
                @if ($i == $products->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a class="paginate_url_item" data-url="{{ $products->url($i) }}" data-id="{{ $i }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($products->currentPage() < $products->lastPage() - 3)
            <li><span>...</span></li>
        @endif
        @if($products->currentPage() < $products->lastPage() - 2)
            <li class="hidden-xs"><a class="paginate_url_item" data-url="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($products->hasMorePages())
            <li><a class="paginate_url_item"  data-url="{{ $products->nextPageUrl() }}" rel="next">»</a></li>
        @else
            <li class="disabled"><span>»</span></li>
        @endif
    </ul>
@endif