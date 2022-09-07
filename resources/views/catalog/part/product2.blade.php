<div class="card w-100"
     onmouseover="$(this).addClass('shadow p-0');"
     onmouseout="$(this).removeClass('shadow p-0');">
    <div class="row">
        <div class="col-10" onclick="return location.href = '{{ route('catalog.product', ['product' => $product->slug]) }}'" onmouseover="this.style.cursor='pointer'">
            <div class="row">
                <div class="col-sm-2">
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
                        <span class="badge badge-danger ml-1">Скидка</span>
                    @endif
                    @if($product->discount<0)
                        <span class="badge badge-dark ml-1">Подорожание {{ abs($product->discount) }}%</span>
                    @endif
                    </div>
                    @if($product->image)
                        @php $url = url('storage/catalog/product/thumb/' . $product->image) @endphp
                        <img height="80%" src="{{ $product->image }}" class="img-thumbnail" alt="">
                    @else
                        <img height=80% src="https://via.placeholder.com/300x150" class="img-thumbnail" alt="">
                    @endif
                </div>
                <div class="col-sm-8">
                    <div class="row align-items-center" style="height: 100%">
                        <span class="text-md">{{ $product->name }}</span>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="row align-items-center text-right" style="height: 100%">
                        @if($product->discount>0) <span class="text-danger font-weight-bold"><s>{{ $product->price }}</s>  {{ number_format($product->price*(100-$product->discount)/100,2) }} {{$product->valuta->vnazva}}</span>
                        @elseif ($product->discount<0) <span class="bg-dark text-light font-weight-bold"><s>{{ $product->price }}</s>  {{ number_format($product->price*(100-$product->discount)/100,2) }} {{$product->valuta->vnazva}}</span>
                        @else  <span class="font-weight-bold">{{ $product->price }} {{$product->valuta->vnazva}}</span> @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col align-self-center">
                <!-- Форма для добавления товара в корзину -->
             <form action="{{ route('basket.add', ['id' => $product->id]) }}"
                   method="post" class="d-inline add-to-basket">
                   @csrf
                 <button type="submit" class="btn btn-success">В корзину</button>
             </form>
        </div>
    </div>
</div>
<div class="row" style="padding: 5px;"></div>
