@extends('layout.admin', ['title' => 'Просмотр товара'])

@section('content')
    <h1>Просмотр товара</h1>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Код:</strong> {{ $product->kod }}</p>
            <p><strong>Артикул:</strong> {{ $product->artikul }}</p>
            <p><strong>Название:</strong> {{ $product->name }}</p>
            <p><strong>ЧПУ (англ):</strong> {{ $product->slug }}</p>
            <p class="d-none"><strong>Бренд:</strong> {{ $product->brand->name }}</p>
            <p><strong>Категория: </strong><a href="{{ route('admin.product.category', [$product->category->id]) }}">{{ $product->category->name }}</a></p>
            <p><strong>Цена:</strong> @if($product->discount>0) <span class="text-danger font-weight-bold"><s>{{ $product->price }}</s>  {{ number_format($product->price*(100-$product->discount)/100,2) }} {{$product->valuta->vnazva}}</span>
                @elseif ($product->discount<0) <span class="bg-dark text-light font-weight-bold"><s>{{ $product->price }}</s>  {{ number_format($product->price*(100-$product->discount)/100,2) }} {{$product->valuta->vnazva}}</span>
                @else  <span class="font-weight-bold">{{ $product->price }} {{$product->valuta->vnazva}}</span> @endif</p>
            <p><strong>Цена опт:</strong> {{ $product->price_opt }} {{$product->valuta->vnazva}}</p>
        </div>
        <div class="col-md-6">
            @php
                if ($product->image) {
                    $url = url($product->image);
                } else {
                    $url = url('storage/catalog/product/image/default.jpg');
                }
            @endphp
            <div class="position-relative">
                <div class="position-absolute">
                    @if($product->new)
                        <span class="badge badge-info text-white ml-1">Новинка</span>
                    @endif
                    @if($product->hit)
                        <span class="badge badge-danger ml-1">Лидер продаж</span>
                    @endif
                    @if($product->sale)
                        <span class="badge badge-success ml-1">Распродажа</span>
                    @endif
                    @if($product->discount>0)
                        <span class="badge badge-danger ml-1">Скидка {{ $product->discount }}%</span>
                    @endif
                </div>
                <img src="{{ $url }}" alt="" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p><strong>Описание</strong></p>
            @isset($product->content)
                <p>{!! $product->content !!}</p>
            @else
                <p>Описание отсутствует</p>
            @endisset
            <a href="{{ route('admin.product.edit', ['product' => $product->id]) }}"
               class="btn btn-success">
                Редактировать товар
            </a>
            <form method="post" class="d-inline" onsubmit="return confirm('Удалить этот товар?')"
                  action="{{ route('admin.product.destroy', ['product' => $product->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Удалить товар
                </button>
            </form>
        </div>
    </div>
@endsection
