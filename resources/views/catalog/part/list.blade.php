<div class="row">
    @foreach ($products as $product)
        @php $viewMode = session('viewMode') @endphp
        @if ($viewMode==0)
            @include('catalog.part.product', ['product' => $product])
        @else
            @include('catalog.part.product2', ['product' => $product])
        @endif
    @endforeach
</div>
{{ $products->links() }}
