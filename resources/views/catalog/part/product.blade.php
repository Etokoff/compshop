<div class="col-md-4 mb-4">
    <div class="card list-item" style="margin-left: -10px; margin-right: -10px;"
         onmouseover="$(this).addClass('shadow p-0');"
         onmouseout="$(this).removeClass('shadow p-0');">
        <div class="card-header" onclick="return location.href = '{{ route('catalog.product', ['product' => $product->slug]) }}'" onmouseover="this.style.cursor='pointer'">
            <span class="text-lg-center">{{ $product->name }}</span>
        </div>
        <div class="card-body p-0 position-relative">
            <div class="position-absolute">
                @if($product->new)
                    <span class="badge badge-info text-white ml-1">Новинка</span>
                @endif
                @if($product->hit)
                    <span class="badge badge-warning ml-1">Лидер продаж</span>
                @endif
                @if($product->sale)
                    <span class="badge badge-success ml-1">Распродажа</span>
                @endif
                @if($product->discount>0)
                    <span class="badge badge-danger ml-1">Скидка {{ $product->discount }}%</span>
                @endif
                @if($product->discount<0)
                    <span class="badge badge-dark ml-1">Подорожание {{ abs($product->discount) }}%</span>
                @endif
            </div>
            @if($product->image)
                @php $url = url('storage/catalog/product/thumb/' . $product->image) @endphp
                <img style="height: 200px; display: block; margin-left: auto; margin-right: auto" src="{{ $product->image }}" class="img-fluid center-block" alt=""
                     onclick="return location.href = '{{ route('catalog.product', ['product' => $product->slug]) }}'" onmouseover="this.style.cursor='pointer'">
            @else
                <img src="https://via.placeholder.com/300x150" class="img-fluid" alt=""
                     onclick="return location.href = '{{ route('catalog.product', ['product' => $product->slug]) }}'" onmouseover="this.style.cursor='pointer'">
            @endif
        </div>
        <div class="card-body p-1 text-md-right"
             onclick="return location.href = '{{ route('catalog.product', ['product' => $product->slug]) }}'" onmouseover="this.style.cursor='pointer'">
            @if($product->discount>0) <span class="text-danger font-weight-bold"><s>{{ $product->price }}</s>  {{ number_format($product->price*(100-$product->discount)/100,2) }} {{$product->valuta->vnazva}}</span>
            @elseif ($product->discount<0) <span class="bg-dark text-light font-weight-bold"><s>{{ $product->price }}</s>  {{ number_format($product->price*(100-$product->discount)/100,2) }} {{$product->valuta->vnazva}}</span>
            @else  <span class="font-weight-bold">{{ $product->price }} {{$product->valuta->vnazva}}</span> @endif
        </div>
        <div class="card-footer">
            <!-- Форма для добавления товара в корзину -->
            <form action="{{ route('basket.add', ['id' => $product->id]) }}"
                  method="post" class="d-inline add-to-basket">
                @csrf
                <button type="submit" class="btn btn-success">В корзину</button>
            </form>
            <a href="{{ route('catalog.product', ['product' => $product->slug]) }}"
               class="btn btn-dark float-right">Подробнее</a>
        </div>
    </div>
</div>
